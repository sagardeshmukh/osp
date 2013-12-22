<?php
require_once sfConfig::get('sf_lib_dir').'/vendor/swift/lib/swift_init.php'; 
ini_set('display_errors', 'On');

/**

 * user actions.

 *

 * @package    yozoa

 * @subpackage user

 * @author     Falcon

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class userActions extends sfActions

{



  public function executeIndex(sfWebRequest $request)

  {



  }



  public function executeLoginForm(sfWebRequest $request)

  {

    $this->form = new LoginForm();

    $this->product_id = $request->getParameter('product_id','0');
	$this->mapView 	  = $request->getParameter('mapView','0');

  }



  /**

   * User Logout Action

   * @param sfWebRequest $request

   */

  public function executeLogout(sfWebRequest $request)

  {

    $this->getUser()->signOut();

    return $this->redirect("@homepage");

  }



  /**

   * User Login Action

   * @param sfWebRequest $request

   * @return <type>

   */

  public function executeLogin(sfWebRequest $request)

  {

    //action stack

    $firstActionStack = $this->getController()->getActionStack()->getFirstEntry();

    //get default referrer

    $this->referrer = $request->getParameter('referrer', $firstActionStack->getModuleName() . '/' . $firstActionStack->getActionName());



    $this->form = new LoginForm();

    if ($request->isMethod('post'))

    {

      $this->form->bind($request->getParameter($this->form->getName()));

      //checking user login action

      if ($this->form->isValid())
      {
        //sign in user
        $this->getUser()->signIn($this->form->getObject());

        if(!$request->getParameter('mapView'))
			$this->getUser()->setFlash('success', 'You connected successfully.');

		// if redirected from save_search than get back after login to save search.		
		if($this->getUser()->getAttribute('saveSearchPageUrl', 0)){
		
			$path = $this->getUser()->getAttribute('saveSearchPageUrl', 0);
			$this->getUser()->setAttribute('saveSearchPageUrl', '');
			return	$this->redirect('@product_browse'.$path);
		}

        //redirecting

        if (!$this->referrer || $this->referrer == 'user/login')

        {

          if ($request->getParameter('product_id'))
          {

            $product = ProductTable::getInstance()->find($request->getParameter('product_id'));

            return $this->redirect($this->generateUrl("product_show", $product));

          }
		  else if($request->getParameter('mapView'))
		  {
			return	$this->redirect($_SERVER['HTTP_REFERER']);
		  }
		  
          return $this->redirect('@homepage');

        }

        return $this->redirect($this->referrer);

      }

    }

  }

  public function executeProfile(sfWebRequest $request)

  {

    $this->user = Doctrine::getTable('User')->find($this->getUser()->getId());
	
  }

  public function executeTest123(sfWebRequest $request)

  {
	$this->mystr123 = 'HI ....';
	
	//if(isset($request->getParameter('user')) {

		echo "id=". $user_form = $request->getParameter('user');
	//print_r($_POST);
	//}
  }


  public function executeEdit(sfWebRequest $request)

  {

    $this->user = Doctrine::getTable('User')->find($this->getUser()->getId());

    $this->form = new UserForm($this->user);

    $this->xarea_table = Doctrine::getTable('XArea');

    $this->x_area_id = (int) $this->user->getXAreaId();

    $this->areas = null;

    if ($this->x_area_id)

    {

      $this->areas = $this->xarea_table->getParentAreas($this->x_area_id);

    }

  }



  public function executeUpdate(sfWebRequest $request)

  {

    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));

    $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object news does not exist (%s).', $request->getParameter('id')));

    $this->form = new UserForm($user);

    $this->processForm($request, $this->form);

    $this->xarea_table = Doctrine::getTable('XArea');

    $user_form = $request->getParameter('user');

    $this->x_area_id = $user_form['x_area_id'];

    $this->areas = null;

    if ($this->x_area_id)

    {

      $this->areas = $this->xarea_table->getParentAreas($this->x_area_id);

    }

    $this->setTemplate('edit');

  }

  public function executeForgotPassword(sfWebRequest $request)
  {
	$this->form = new ForgetPasswordForm();
	if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('forgetpassword'));
      if ($this->form->isValid())
      {
		$userNameArray = $request->getParameter('forgetpassword');
		$userName = $userNameArray['vUsername'];
		$this->_object = Doctrine::getTable('User')
              ->getByUsername(
                  $userName
              );
	    if (count($this->_object)) {
			$ID 	 = $this->_object['id'];
			$emailId = $this->_object['email'];
	    } 
		
		$key = base64_encode($ID."_".$emailId."_".$userName);
		//$resetPasswordUrl = "http://yozoadev/frontend_dev.php/en/user/resetPassword?key=".$key;
		$server_name = $this->getContext()->getRequest()->getHost();
		$resetPasswordUrl = "http://".$server_name."/en/user/resetPassword?key=".$key;
		
		
		if ($emailId)
        {
          $mailTo = $emailId;
		  $mailSubject = 'Reset password .';
          $mailBody = $this->getPartial("mail/resetPassword", array('link' => $resetPasswordUrl, 'username' => $userName));
		  $mailer = $this->getMailer();
		  $message = Swift_Message::newInstance();
		  $message->setSubject($mailSubject);
		  $message->setBody($mailBody );
          $message->setContentType("text/html");
		  $message->setFrom(array('support@yozoa.com'=> 'support'));
		  $message->setTo($mailTo);
          try
		  {
		  	$mailer->send($message);
		  }
		  catch(Exception $e)
		  {
		  	echo 'Message: ' .$e->getMessage();
		  }
		  $this->getUser()->setFlash('success', 'The reset password link is send on your mail id.');
        } else {
			$this->getUser()->setFlash('error', 'failed to sent email.');
		}
	  }
	}
  }
  
  public function executeResetPassword(sfWebRequest $request)
  {
	$this->form 	= new ResetPasswordForm();
	if($request->getParameter('key')) {
		$this->vKey = $request->getParameter('key') ;  
		
		$key = base64_decode($request->getParameter('key'));
		list($id, $mailId, $uName) = explode('_',$key);	
		
		$this->uName  = $uName;
		
		$this->_object = Doctrine::getTable('User')
              ->getUserDetails(
                  $id
              );
	    if (!count($this->_object)) {
			$this->getUser()->setFlash('error', 'failed to sent data.');
	    } 
	}
	
	if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('resetpassword'));
      if ($this->form->isValid())
      {
		$passwordArray = $request->getParameter('resetpassword');
		$password1 	   = md5($passwordArray['nPassword']);
		$userId 	   = $id;
		
		$q = Doctrine_Query::create()
		->update('User u')
  		->set('u.password', '?', $password1)
  		->where('u.id = ?', $userId);
		
		$rows = $q->execute();
		
		$this->getUser()->setFlash('success', 'Your password is Reset Successfully.');
		$this->redirect('user/login');
	  }
	}
  }

  public function executeNew()

  {

    $this->form = new UserForm();

    $this->xarea_table = Doctrine::getTable('XArea');

    $this->areas = null;

  }

  public function executeCreate(sfWebRequest $request)

  {

    $this->forward404Unless($request->isMethod(sfRequest::POST));



    $this->form = new UserForm();



    $this->processForm($request, $this->form);

    $this->xarea_table = Doctrine::getTable('XArea');

    $user_form = $request->getParameter('user');

    $this->x_area_id = $user_form['x_area_id'];

    $this->areas = null;

    if ($this->x_area_id)

    {

      $this->areas = $this->xarea_table->getParentAreas($this->x_area_id);

    }



    $this->setTemplate('new');

  }



  protected function processForm(sfWebRequest $request, sfForm $form)

  {



    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())

    {

      $message = $form->isNew() ? 'Registered': 'Updated';

      $user = $form->save();

      $this->getUser()->setAttribute('xarea', $user->getXAreaId());

      $this->getUser()->setFlash('success', $message.' successfully!');

      if($form->isNew()){

          $this->redirect('user/login');

      }else{

          $this->redirect('user/profile');

      }

    }

  }

  

	public function executeUpgrade()

	{

		//echo "1";

	}



	public function executeProfiles(sfWebRequest $request){

		if ($request->getParameter('id') != ''){

			$this->user = Doctrine::getTable('User')->find($request->getParameter('id'));

		}

	}

}

