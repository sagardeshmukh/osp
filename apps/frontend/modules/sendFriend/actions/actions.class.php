<?php



class sendFriendActions extends sfActions

{

  public function executeNew(sfWebRequest $request)

  {

    $this->product_id = $request->getParameter('product_id');

    $this->form = new SendMailForm();



    if($request->isMethod('post')){

        $this->form->bind($request->getParameter($this->form->getName()));

    if($this->form->isValid())

    {

      //SENDING MAIL

      $news = Doctrine::getTable('Product')->find($request->getParameter('id'));

      $url    = $this->generateUrl('product_show', $news, true);

      $values = $this->form->getValues();



      $mailTo = $values['mail'];

      $mailSubject = 'New post from ' . "{$values['username']}.";

      $mailBody = $this->getPartial("mail/sendFriend", array("information"=>$values['infor'], "url"=>$url, "description"=>$news->getDescription()));

      $message = $this->getMailer()->compose(array('info@yozoa.mn'=>'yozoa'), $mailTo, $mailSubject, $mailBody);

      $message->setContentType("text/html");

      $this->getMailer()->send($message);



      // close dialog

      $str = <<<EOF

 <script type="text/javascript">

   jQuery('.sendFriend-dialog').dialog('close');

 </script>

EOF;

      echo "Send successfully";

      return $this->renderText($str);

    }

    

    }



  }

   public function executeApplyJob(sfWebRequest $request)
  {

    $this->unique_key = md5(uniqid(rand(), true));

    $this->getUser()->setAttribute('unique_key', $this->unique_key);



    if($request->getParameter('p_id')){

        $this->product = Doctrine::getTable('Product')->find($request->getParameter('p_id'));

        $categoryType = Doctrine::getTable('Category')->getRootCategory($this->product->getCategoryId());

        $this->categoryType = $categoryType->getName();

        $title = $this->product->getName();

        $this->parent_categories = Doctrine::getTable('Category')->getParentCategories($this->product->getCategoryId());

        $user = $this->product->getUser();

    }

    

    $this->form = new SendMailForm(null, array('title' => $title, 'user' => $user));



    if($request->isMethod('post')){

        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

    if($this->form->isValid())

    {

        if($this->product->getJob()){

            $job = $this->product->getJob();

            $contacts = array();

            $contacts[] = $job->getCEmail1() ?  $job->getCEmail1(): $this->product->getUser()->getEmail();

            if($job->getCEmail2()){

                $contacts[] = $job->getCEmail2();

            }            

            }else{

                $contacts = $this->product->getUser()->getEmail();

            }

      //SENDING MAIL

      $values = $this->form->getValues();

      $user = Doctrine::getTable('User')->find($values['user_id']);

      $fileName = $values['cv'];

      $fileName1 = $values['cv1'];

      $fileName2 = $values['cv2'];

      $fileName3 = $values['cv3'];



      $mailTo = $contacts;

      $mailSubject = $values['subject'];

      $mailBody = $values['infor'];

      $message = $this->getMailer()->compose(array($values['mail']=> $values['username']), $mailTo, $mailSubject, $mailBody);
	  if($fileName != '')	
      	$message->attach(Swift_Attachment::fromPath($fileName->getTempName()));

      if($fileName1 != '')
	  	$message->attach(Swift_Attachment::fromPath($fileName1->getTempName()));

	  if($fileName2 != '')
      	$message->attach(Swift_Attachment::fromPath($fileName2->getTempName()));

      if($fileName3 != '')  
	  	$message->attach(Swift_Attachment::fromPath($fileName3->getTempName()));

      $message->setContentType("text/html");

      $this->getMailer()->send($message);
      $this->getUser()->setFlash('message','Send successfully');
	  $this->redirect('sendFriend/applyJob?p_id='.$request->getParameter('p_id'));


    }



    }





  }



  /**

   * Send message or Apply now

   *

   * @param

   */

  public function executeContact(sfWebRequest $request)

  {

    $this->unique_key = md5(uniqid(rand(), true));

    $this->getUser()->setAttribute('unique_key', $this->unique_key);



    if($request->getParameter('p_id')){

        $this->product = Doctrine::getTable('Product')->find($request->getParameter('p_id'));

        $categoryType = Doctrine::getTable('Category')->getRootCategory($this->product->getCategoryId());

        $this->categoryType = $categoryType->getName();

        $title = $this->product->getName();

        $this->parent_categories = Doctrine::getTable('Category')->getParentCategories($this->product->getCategoryId());

        $user = $this->product->getUser();

    }

    

    $this->form = new SendMailForm(null, array('title' => $title, 'user' => $user));



    if($request->isMethod('post')){

        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

    if($this->form->isValid())

    {

        if($this->product->getJob()){

            $job = $this->product->getJob();

            $contacts = array();

            $contacts[] = $job->getCEmail1() ?  $job->getCEmail1(): $this->product->getUser()->getEmail();

            if($job->getCEmail2()){

                $contacts[] = $job->getCEmail2();

            }            

            }else{

                $contacts = $this->product->getUser()->getEmail();

            }

      //SENDING MAIL

      $values = $this->form->getValues();

      $user = Doctrine::getTable('User')->find($values['user_id']);

      $fileName = $values['cv'];

      $fileName1 = $values['cv1'];

      $fileName2 = $values['cv2'];

      $fileName3 = $values['cv3'];



      $mailTo = $contacts;

      $mailSubject = $values['subject'];

      $mailBody = $values['infor'];

      $message = $this->getMailer()->compose(array($values['mail']=> $values['username']), $mailTo, $mailSubject, $mailBody);

      if($fileName->getTempName() != '')
	  $message->attach(Swift_Attachment::fromPath($fileName->getTempName()));

      if($fileName1->getTempName() != '')
	  $message->attach(Swift_Attachment::fromPath($fileName1->getTempName()));

      if($fileName2->getTempName() != '')
	  $message->attach(Swift_Attachment::fromPath($fileName2->getTempName()));

      if($fileName3->getTempName() != '')
	  $message->attach(Swift_Attachment::fromPath($fileName3->getTempName()));

      $message->setContentType("text/html");

      $this->getMailer()->send($message);



      // close dialog

      $str = <<<EOF

 <script type="text/javascript">

   jQuery('.sendFriend-dialog').dialog('close');

 </script>

EOF;

      echo "Send successfully";

      return $this->renderText($str);

    }



    }





  }



  public function executeCreate(sfWebRequest $request)

  {

    $this->form = new SendMailForm();

    $this->form->bind($request->getParameter($this->form->getName()));

    if($this->form->isValid())

    {

      //SENDING MAIL

      $news = Doctrine::getTable('Product')->find($request->getParameter('product_id'));

      $url    = $this->generateUrl('product_show', $news, true);

      $values = $this->form->getValues();

      

      $mailTo = $values['mail'];

      $mailSubject = __('New post from')."{$values['username']}.";

      $mailBody = $this->getPartial("mail/sendFriend", array("information"=>$values['infor'], "url"=>$url, "description"=>$news->getDescription()));

      $message = $this->getMailer()->compose(array('info@yozoa.mn'=>'yozoa'), $mailTo, $mailSubject, $mailBody);

      $message->setContentType("text/html");

      $this->getMailer()->send($message);

      

      // close dialog  

      $str = <<<EOF

 <script type="text/javascript">

   jQuery('.sendFriend-dialog').dialog('close');

 </script>

EOF;

      echo "Send successfully";

      return $this->renderText($str);

    }

    else

    {

      return $this->renderPartial('form', array('form' => $this->form));

    }

  }



  protected function processForm(sfWebRequest $request, sfForm $form)

  {

    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid())

    {

      /*$guestbook = new Guestbook();

      $guestbook->fromArray($this->form->getValues());



      $guestbook->setBody($guestbook['body']);

      $guestbook = $form->save();*/

      $str = <<<EOF

         <script type="text/javascript">

            jQuery("#guestbook_form_container").html("<div align='center'>Send successfully, it'll activated by admin<br/> Thank you for leaving comment</div>");

            setTimeout(function(){jQuery('#guestbook_form_container').dialog('close')}, 3000);

         </script>

EOF;

      echo $str;

      return $this->renderText($str);



    }

  }

}