<?php



/**

 * product actions.

 *

 * @package    yozoa

 * @subpackage product

 * @author     Falcon

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class productActions extends sfActions

{



  /**

   * Executes index action

   *

   * @param sfRequest $request A request object

   */

  public function executeIndex(sfWebRequest $request)

  {
	ini_set("memory_limit", "128M");
    $status = $request->getParameter('status');

    $id = $request->getParameter('id');

    $title = $request->getParameter('title');

    $category_id = $request->getParameter('category_id');



    //query string array

    $q_str_arr = array();

    $q = Doctrine::getTable('Product')->createQuery('p');



    if ($category_id)

    {

      $q_str_arr[] = 'category_id=' . $category_id;

      $q->select('p.*')

          ->from('Product AS p')

          ->innerJoin('p.Category n_c')

          ->innerJoin("p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt")

          ->addWhere('p_c.id = ?', $category_id);

    }



    switch ($status)

    {

      case "active":

        $q->andWhere('p.status=1');

        break;

      case "pending":

        $q->andWhere('p.status<=0');

        break;

      case "denied":

        $q->andWhere('p.status=3');

        break;

      case "all":

    }

    //status

    if ($status)

    {

      $q_str_arr[] = 'status=' . $status;

    }

    //id

    if ($id)

    {

      $q_str_arr[] = 'id=' . $id;

      $q->addWhere("p.id = ?", $id);

    }

    //name

    if ($title)

    {

      $q_str_arr[] = 'title=' . $title;

      $q->addWhere("p.name LIKE ?", '%' . $title . '%');

    }



    $this->q_str_arr = $q_str_arr;



    //search

    $this->pager = new sfDoctrinePager('Product', 20);

    $this->pager->setQuery($q);

    $this->pager->setPage($request->getParameter('page', 1));

    $this->pager->init();

  }



  /**

   * Buteegduuxuuniig batalgaajuulna

   * @param sfWebRequest $request

   */

  public function executeConfirmProduct(sfWebRequest $request)

  {

    $product = Doctrine::getTable('Product')->find($request->getParameter('id'));

    if ($product)

    {

      $product->setStatus(1);

      $product->setConfirmedAt(date("Y-m-d H:i:s", time()));

      $product->save();



      $flash = "";

      $user = $product->getUser();

      // business or support member

//      if (($user->getIsPaid() == 1) || ($user->getIsPaid() == 2))

//      {

        $dateFrom = date("Y-m-d");

        $dateTo = strtotime('+7 day', strtotime($dateFrom));





        $dopingText = "";



        sfContext::getInstance()->getConfiguration()->loadHelpers('Global');

        $purpose = returnDopingPurpose($dopingId);



        // update product AttributeIds

        $attributeValueIdsOld = explode(",", $product->getAttributeValueIds());

        //          $attributeValueIdsOld[] = $doping->getCategoryId();

        $array = array_unique($attributeValueIdsOld);

        $product->setAttributeValueIds(join(",", $array));

        $product->save();

//      }



      $mailTo = $user->getEmail();

      $mailSubject = 'Your product confirmed and added successfully.';

      $mailBody = $this->getPartial("mail/productAccept", array("dopingText" => $dopingText));

      $message = $this->getMailer()->compose(array('info@yozoa.mn' => 'yozoa'), $mailTo, $mailSubject, $mailBody);

      $message->setContentType("text/html");

//      $this->getMailer()->send($message);



      $this->getUser()->setFlash('success', 'Confirmed successfully' . $flash);

    }



    //redirecting page referrer

    return $this->redirect('product/index?status=pending');

  }



  /**

   * Deleting product

   */

  public function executeDelete(sfWebRequest $request)

  {

    $product = Doctrine::getTable('Product')->find($request->getParameter('id'));

    if ($product)

    {

      $mailTo = $product->getUser()->getEmail();

      $mailSubject = 'Your product has been deleted.';

      $mailBody = $this->getPartial("mail/productDelete", array("product" => $product));

      $message = $this->getMailer()->compose(array('info@yozoa.mn' => 'yozoa'), $mailTo, $mailSubject, $mailBody);

      $message->setContentType("text/html");

      $this->getMailer()->send($message);



      $product->delete();



      $this->getUser()->setFlash('success', 'Deleted successfully');

    }

    return sfView::NONE;

  }



  /**

   * Deleting product

   */

  public function executeDenyProduct(sfWebRequest $request)

  {

    $product = Doctrine::getTable('Product')->find($request->getParameter('id'));

    if ($product)

    {

      $product->setStatus(3);

      $product->save();



      $mailTo = $product->getUser()->getEmail();

      $mailSubject = "Your product has being rejected.";

      $mailBody = $this->getPartial("mail/productDeny");



      $message = $this->getMailer()->compose(array('info@yozoa.mn' => 'yozoa'), $mailTo, $mailSubject, $mailBody);

      $message->setContentType("text/html");

      $this->getMailer()->send($message);



      $this->getUser()->setFlash('success', 'Denied successfully');

    }

    return sfView::NONE;

  }


  public function executeShow(sfWebRequest $request)
  {
	
    $this->setLayout('layoutContent');

	if($request->getParameter('id')) {
		$this->product = Doctrine::getTable('Product')->find($request->getParameter('id'));
		if($this->product ) {
			if($this->product->getUserId())	{
					$userID = $this->product->getUserId();
					$this->userDetails = Doctrine::getTable('User')->find($userID);
			}
			
			$this->otherProducts = Doctrine::getTable('Product')->getOtherProducts($request->getParameter('id'));
		}else {
			$this->redirect('product/index');	
		}	
	} else {
		$this->redirect('product/index');
	}	
  }



  public function executeEdit(sfWebRequest $request)

  {

    $this->forward404Unless($this->product = Doctrine::getTable('Product')->find(array($request->getParameter('id'))), sprintf('Object product does not exist (%s).', $request->getParameter('id')));

  }



  public function executeUpdate(sfWebRequest $request)

  {

    $this->forward404Unless($product = Doctrine::getTable('Product')->find(array($request->getParameter('ssss'))), sprintf('Object product does not exist (%s).', $request->getParameter('ssss')));



    $currency_main = $request->getParameter('currency_main');

    $price_original = $request->getParameter('price_original');



    $product->setName($request->getParameter('name'));

    $product->setPriceOriginal($price_original);

    $product->setCurrencyMain($currency_main);

    $product->setPriceGlobal(CurrencyTable::convertToGlobal($currency_main, $price_original));

    $product->setDescription($request->getParameter('description'));

    $product->save();



    return $this->redirect('product/index?status=pending');

  }



}