<?php
 /**

 * product actions.

 *

 * @package    yozoa

 * @subpackage product

 * @author     Falcon

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class manageProductActions extends sfActions

{



  /**

   * Executes index action

   *

   * @param sfRequest $request A request object

   */
   public function executeList(sfWebRequest $request) { 
   }
  public function executeIndex(sfWebRequest $request)

  {

    //Doctrine::getTable('Category')->fixLftRgt();

    //return sfView::NONE;

  }



  public function checkProductUserPermission(sfWebRequest $request)

  {

    $product = Doctrine::getTable('Product')->getProductUserAndId($this->getUser()->getId(), $request->getParameter('id'));

    $this->forward404Unless($product);

    return $product;

  }



  /**

   * Get product info

   */

  public function executeProductInfo(sfWebRequest $request)

  {

    $context = $this->getContext();

    $context->getConfiguration()->loadHelpers(array('Global'), $context->getModuleName());



    $product = $this->checkProductUserPermission($request);

    $data = array('title' => getProductName($product, $this->getUser()->getCulture()), 'id' => $product->getId());

    return $this->renderText(json_encode($data));

  }



  /**

   * Extend product duration

   */

  public function executeExtendProduct(sfWebRequest $request)
  {
    if ($request->getParameter('id')) {
		$duration = $request->getParameter('duration');
		$values = myConstants::getExtendDuration();
		if (!in_array($duration, array_keys($values)))
		  $duration = 30;
		// ...
		$q = Doctrine_Query::create()
		->update('Product')
		->set('duration', $duration)
		->set('status', 0)
		->where('user_id = ?', $this->getUser()->getId())
		->andWhere('id = ?', $request->getParameter('id'));
		// ...
		$rows = $q->execute();
		return $this->renderText('success');
	} else {
		return $this->renderText('success');
	}	
	
   

  }



  /**

   * My Products

   * @param sfWebRequest $request

   */

  public function executeMyProduct(sfWebRequest $request)

  {

    if (!$request->isXmlHttpRequest())

    {

      //inactive

      $query1 = Doctrine::getTable("Product")->getUserProductQuery($this->getUser()->getId(), 2);

      $this->pager1 = new sfDoctrinePager('Product', sfConfig::get("app_max_per_page", 10));

      $this->pager1->setQuery($query1);

      $this->pager1->setPage(1);

      $this->pager1->init();



      //pending

      $query2 = Doctrine::getTable("Product")->getUserProductQuery($this->getUser()->getId(), 0);

      $this->pager2 = new sfDoctrinePager('Product', sfConfig::get("app_max_per_page", 10));

      $this->pager2->setQuery($query2);

      $this->pager2->setPage(1);

      $this->pager2->init();



      //active

      $query3 = Doctrine::getTable("Product")->getUserProductQuery($this->getUser()->getId(), 1);

      $this->pager3 = new sfDoctrinePager('Product', sfConfig::get("app_max_per_page", 10));

      $this->pager3->setQuery($query3);

      $this->pager3->setPage(1);

      $this->pager3->init();



      //denied

      $query4 = Doctrine::getTable("Product")->getUserProductQuery($this->getUser()->getId(), 3);

      $this->pager4 = new sfDoctrinePager('Product', sfConfig::get("app_max_per_page", 10));

      $this->pager4->setQuery($query4);

      $this->pager4->setPage(1);

      $this->pager4->init();

    } else //AJAX REQUEST

    {

      //inactive

      $query = Doctrine::getTable("Product")->getUserProductQuery($this->getUser()->getId(), $request->getParameter('status'));

      $pager = new sfDoctrinePager('Product', sfConfig::get("app_max_per_page", 10));

      $pager->setQuery($query);

      $pager->setPage($request->getParameter('page', 1));

      $pager->init();



      return $this->renderPartial('products', array('pager' => $pager, 'divId' => $request->getParameter('divId'), 'status' => $request->getParameter('status')));

    }

  }



  /**

   * Add Doping

   */

  public function executeAddDoping(sfWebRequest $request)

  {

    $product = $this->checkProductUserPermission($request);



    $unique_id = sha1($request->getParameter('id'));

    $data = $this->getUser()->getAttribute('tmp_product', array());



    $store_id = 0;

    $storeProduct = Doctrine::getTable('StoreProduct')->getByProductId($product->getId());

    if ($storeProduct)

    {

      $store_id = $storeProduct->getStoreId();

    }



    $data = $this->generetaSessionData($data, $unique_id, $product);

    //}

    $this->getUser()->setAttribute('tmp_product', $data);



    return $this->redirect('manageProduct/step4?unique_id=' . $unique_id);

  }



  /**

   * Oruulsan buteegdhuunee zasax

   */

  public function executeEdit(sfWebRequest $request)

  {

    $product = $this->checkProductUserPermission($request);



    $unique_id = sha1($request->getParameter('id'));

    $data = $this->getUser()->getAttribute('tmp_product', array());

    $job_data = $this->getUser()->getAttribute('tmp_job', array());



    $data = $this->generetaSessionData($data, $unique_id, $product);

    $job_data = $this->jobSessionData($job_data, $unique_id, $product);

    //}

    $this->getUser()->setAttribute('tmp_product', $data);

    $this->getUser()->setAttribute('tmp_job', $job_data);



    return $this->redirect('manageProduct/step2?unique_id=' . $unique_id);

  }



  /**

   *

   * @param sfWebRequest $request

   */

  public function executeDelete(sfWebRequest $request)

  {

    $product = $this->checkProductUserPermission($request);

    $product_id = $product->getId();

    //deleting product

    $product->delete();



    return $this->redirect("manageProduct/myProduct");

  }



  /**

   * Delete Image

   * @param sfWebRequest $request

   */

  public function executeDeleteImage(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $index = $request->getParameter('index', 0);

    $data = $this->getUser()->getAttribute('tmp_product', array());



    if (isset($data[$unique_id]['images'][$index]))

    {

      $productImage = $data[$unique_id]['images'][$index];

      if ($productImage instanceof ProductImage)

      {

        //removing big image

        @unlink(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename());

        //removing small images

        @unlink(sfConfig::get('sf_web_dir') . $productImage->getFolder() . "t_" . $productImage->getFilename());

        @unlink(sfConfig::get('sf_web_dir') . $productImage->getFolder() . "s_" . $productImage->getFilename());

        @unlink(sfConfig::get('sf_web_dir') . $productImage->getFolder() . "m_" . $productImage->getFilename());

        //delete method

        if (!$productImage->isNew())

        {

          $productImage->delete();

        }

      }

      //writing in session

      $data[$unique_id]['images'][$index] = new ProductImage();



      //is product is old

      if (!$data[$unique_id]['product']->isNew())

      {

        foreach ($data[$unique_id]['images'] as $index => $productImage)

        {

          if (is_file(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename()))

          {

            $data[$unique_id]['product']->setImage(serialize(array('folder' => $productImage->getFolder(), 'filename' => $productImage->getFilename())));

            $data[$unique_id]['product']->save();

            break;

          }

        }

      }



      //writing in session

      $this->getUser()->setAttribute('tmp_product', $data);

    }

    exit();

  }



     /**

   *

   * @uses rental add Agreement

   */

  public function executeAddAgreement(sfWebRequest $request)

  {

      $this->form = new RentalAgreementForm();

      if($request->isMethod('post')){

        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

        if ($this->form->isValid())

        {

          $agreement = $request->getFiles('rental_agreement');

          $types = array('application/pdf', 'application/msword');

          if(in_array($agreement['file']['type'], $types))

          {

          $agreement = $this->form->save();

          $id = $agreement->getId();

          $title = $agreement->getTitle();

          $str = <<<EOF

         <script type="text/javascript">

            jQuery("#agreement_form_container").html("<div align='center'>Send successfully</div>");

            jQuery("#product_rental_rental_agreement_id").append('<option value="$id" selected="selected">$title</option>');

            setTimeout(function(){jQuery('#agreement_form_container').dialog('close')}, 2000);

         </script>

EOF;

      return $this->renderText($str);

          }else{

          $str = <<<EOF

         <script type="text/javascript">

            jQuery("#agreement_form").append("<ul class='error_list'><li>Your provided an incorrect file type. Only doc (word)( and pdf (acrobat) files are accepted. </li></ul>");

         </script>

EOF;
      return $this->renderText($str);

          }
        }
      }

      $this->setLayout(false);

  }



  public function jobSessionData($data, $unique_id, $product = null)

  {

    if (!$product)

    {

      $product = new Product();

    }

    //product

    $data[$unique_id]['product'] = $product;



    if ($data[$unique_id]['product']->isNew())

      {

        $folder = sfConfig::get('app_product_tmp_upload_dir', '/uploads/tmp_images/');

      } else

      {

        $folder_id = ceil($data[$unique_id]['product']->getId() / 200);

        $folder = sprintf(sfConfig::get('app_product_upload_dir', "/uploads/product-image-%s/"), $folder_id);

      }



    //images

    $logo = $product->getJob()->getLogo();



      if (isset($logo))

      {

        $data[$unique_id]['logo'] = $logo;  

      }else{

        $data[$unique_id]['logo'] = '';

      }

      $data[$unique_id]['folder'] = $folder;



    return $data;

  }

    /**

   * Delete Job Logo Image

   * @param sfWebRequest $request

   */

  public function executeDeleteJobLogo(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $data = $this->getUser()->getAttribute('tmp_job', array());

    $folder = $data[$unique_id]['folder'];

        //removing big image

        @unlink(sfConfig::get('sf_web_dir') . $folder . $data[$unique_id]['logo']);

        //removing small images

        @unlink(sfConfig::get('sf_web_dir') . $folder . "t_" . $data[$unique_id]['logo']);

        @unlink(sfConfig::get('sf_web_dir') . $folder . "s_" . $data[$unique_id]['logo']);

        @unlink(sfConfig::get('sf_web_dir') . $folder . "m_" . $data[$unique_id]['logo']);

    $data[$unique_id]['logo'] =  "";

    $this->getUser()->setAttribute('tmp_job', $data);

    exit();

  }



  /**

   * Upload Image

   * @param sfWebRequest $request

   */

  public function executeUploadJobLogo(sfWebRequest $request)

  {

    $allowed_mime_types = array(

      'image/jpeg',

      'image/pjpeg',

      'image/png',

      'image/x-png',

      'image/gif');



    $uploaded_data = $request->getFiles('userfile');



    //retreiving user session

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $data = $this->getUser()->getAttribute('tmp_job', array());



        //generating session data

    if (!isset($data[$unique_id]))

    {

      $data = $this->jobSessionData($data, $unique_id, null);

    }

    $json_data = array();

    if (!isset($data[$unique_id]))

    {

      $json_data['error'] = true;

      $json_data['msg'] = 'Error has occurred, please inform our administrator.';

    }

    //is has error

    elseif ($uploaded_data['error'])

    {

      $json_data['error'] = true;

      $json_data['msg'] = 'Error has occurred during sending file';

    }

    //checking file types

    elseif (!in_array($uploaded_data['type'], $allowed_mime_types))

    {

      $json_data['error'] = true;

      $json_data['msg'] = 'Only (png, jpg, gif) files allowed.';

    }

    //upload success

    else

    {

      $filename = md5(uniqid(rand(), true)) . '.jpg';

      if ($data[$unique_id]['product']->isNew())

      {

        $folder = sfConfig::get('app_product_tmp_upload_dir', '/uploads/tmp_images/');

      } else

      {

        $folder_id = ceil($data[$unique_id]['product']->getId() / 200);

        $folder = sprintf(sfConfig::get('app_product_upload_dir', "/uploads/product-image-%s/"), $folder_id);

      }

      ////////////////////

      // resizing image //

      ////////////////////



      try

      {
	  	//Orignal image image
			list($width, $height, $type, $attr) = getimagesize($uploaded_data_file['tmp_name']);
		//$thumbnail = new sfThumbnail(2000, 1500, true, false, 75, '');
			$thumbnail = new sfThumbnail($width, $height, true, false, 75, '');
			$thumbnail->loadFile($uploaded_data_file['tmp_name']);
			$thumbnail->save(sfConfig::get('sf_web_dir') . $folder[$index] ."org_". $filename[$index], 'image/jpeg');
			unset($thumbnail);

        //big image

        $thumbnail = new sfThumbnail(640, 480, true, false, 75, '');

        $thumbnail->loadFile($uploaded_data['tmp_name']);

        $thumbnail->save(sfConfig::get('sf_web_dir') . $folder . $filename, 'image/jpeg');

        unset($thumbnail);



        //medium image

        $thumbnail = new sfThumbnail(300, 225, true, false, 75, '');

        $thumbnail->loadFile($uploaded_data['tmp_name']);

        $thumbnail->save(sfConfig::get('sf_web_dir') . $folder . "m_" . $filename, 'image/jpeg');

        unset($thumbnail);



        //small image

        $thumbnail = new sfThumbnail(150, 112, false, true, 75, '', array('method' => 'shave_all'));

        $thumbnail->loadFile($uploaded_data['tmp_name']);

        $thumbnail->save(sfConfig::get('sf_web_dir') . $folder . "s_" . $filename, 'image/jpeg');

        unset($thumbnail);



        //thumbnail image

        $thumbnail = new sfThumbnail(65, 49, false, true, 75, '', array('method' => 'shave_all'));

        $thumbnail->loadFile($uploaded_data['tmp_name']);

        $thumbnail->save(sfConfig::get('sf_web_dir') . $folder . "t_" . $filename, 'image/jpeg');

        unset($thumbnail);



        @unlink($uploaded_data['tmp_name']);

      } catch (Exception $e)

      {

        @unlink($uploaded_data['tmp_name']);



        $json_data['error'] = true;

        $json_data['msg'] = 'Error has occurred during converting.';// . $e->getMessage();;



        echo json_encode($json_data);

        exit ();

      }

      $this->getUser()->setAttribute('tmp_job', array());

      $data[$unique_id]['logo'] =  $filename;

      $this->getUser()->setAttribute('tmp_job', $data);

      

      $json_data['error'] = false;

      $json_data['msg'] = 'Send successfully';

      $json_data['folder'] = $folder;

      $json_data['image'] = $filename;

    }

    echo json_encode($json_data);

    exit ();

  }



  /**

   * Get child area by parent_id

   * @param sfWebRequest $request

   * @return <type>

   */

  public function executeChildArea(sfWebRequest $request)
  {

    $parent_id = $request->getParameter('id');

    if (!$request->isXmlHttpRequest())

    {

      return $this->forward404();

    }

    if ($parent_id != 0)

    {
	 $this->ltype = $request->getParameter('ltype');
	 if($this->ltype == 0)
	 	$this->ltype = 1;
	 else if($this->ltype == 2)
	 	$this->ltype = 2;
	 else
	 	$this->ltype = 0;	

      $this->x_areas = Doctrine::getTable('XArea')->getChildren($parent_id);

      if ($this->x_areas)
      {
		 if(count($this->x_areas)==0){
			$this->x_area_locations = Doctrine::getTable('XAreaLocation')->getChildrens($parent_id);
			if(count($this->x_area_locations) > 0)
				return $this->renderPartial('manageProduct/childArea', array('x_areas' => $this->x_area_locations, 'selected_id' => $parent_id,'isXAreaLocations'=>1));
		 }
         return $this->renderPartial('manageProduct/childArea', array('x_areas' => $this->x_areas, 'selected_id' => $parent_id,'ltype'=>$this->ltype));
      }
      $this->setLayout(false);
    }
  }



  /**

   * Search image from google

   * @param sfWebRequest $request

   * @return <type>

   */

  public function executeSearchGoogleImage(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $q = urlencode($request->getParameter('q'));

    $data = $this->getUser()->getAttribute('tmp_product', array());



    if (!isset($data[$unique_id]))

    {

      return $this->renderText(json_encode(array()));

    }



    $url = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&as_filetype=jpg&imgsz=medium|large|xlarge&q=" . $q;



    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_REFERER, "http://yozoa.mn/");

    $body = curl_exec($ch);

    curl_close($ch);





    $json = json_decode($body);

    $searchData = array();

    foreach ($json->responseData->results as $result)

    {

      $searchData[$result->imageId] = $result->unescapedUrl;

    }



    $data[$unique_id]['googleImages'] = $searchData;

    $this->getUser()->setAttribute('tmp_product', $data);



    return $this->renderText($body);

  }



  /**

   * Upload GOOGLE IMAGE

   *

   */

  public function executeUploadGoogleImage(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $imageId = $request->getParameter('imageId');

    $data = $this->getUser()->getAttribute('tmp_product', array());

    $index = $request->getParameter('index', 0);



    if (!isset($data[$unique_id]['googleImages'][$imageId]))

    {

      return $this->renderText(json_encode(array('error' => true, 'msg' => __('Error has occurred in server, please inform system administrator.'))));

    }



    $url = $data[$unique_id]['googleImages'][$imageId];



    $tmpUploadFolder = sfConfig::get('app_product_tmp_upload_dir', '/uploads/tmp_images/');

    $tmpFile = sfConfig::get('sf_web_dir') . $tmpUploadFolder . md5(uniqid(rand(), true)) . '.jpg';



    $curl = curl_init();

    $fp = fopen($tmpFile, "w");

    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_FILE, $fp);

    curl_setopt($curl, CURLOPT_TIMEOUT, 30);

    curl_exec($curl);

    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    fclose($fp);



    if ($httpcode != 200)

    {

      unlink($tmpFile);

      return $this->renderText(json_encode(array('error' => true, 'msg' => __('Error has occurred, choose different file .'))));

    }



    $filename = md5(uniqid(rand(), true)) . '.jpg';

    if ($data[$unique_id]['product']->isNew())

    {

      $folder = sfConfig::get('app_product_tmp_upload_dir', '/uploads/tmp_images/');

    } else

    {

      $folder_id = ceil($data[$unique_id]['product']->getId() / 200);

      $folder = sprintf(sfConfig::get('app_product_upload_dir', "/uploads/product-image-%s/"), $folder_id);

    }



    $json_data = array();



    try

    {
//Orignal image image
			list($width, $height, $type, $attr) = getimagesize($uploaded_data_file['tmp_name']);
		//$thumbnail = new sfThumbnail(2000, 1500, true, false, 75, '');
			$thumbnail = new sfThumbnail($width, $height, true, false, 75, '');
			$thumbnail->loadFile($uploaded_data_file['tmp_name']);
			$thumbnail->save(sfConfig::get('sf_web_dir') . $folder[$index] ."org_". $filename[$index], 'image/jpeg');
			unset($thumbnail);

      //big image

      $thumbnail = new sfThumbnail(640, 480, true, false, 75, '');

      $thumbnail->loadFile($tmpFile);

      $thumbnail->save(sfConfig::get('sf_web_dir') . $folder . $filename, 'image/jpeg');

      unset($thumbnail);



      //medium image

      $thumbnail = new sfThumbnail(300, 225, true, false, 75, '');

      $thumbnail->loadFile($tmpFile);

      $thumbnail->save(sfConfig::get('sf_web_dir') . $folder . "m_" . $filename, 'image/jpeg');

      unset($thumbnail);



      //small image

      $thumbnail = new sfThumbnail(150, 112, false, true, 75, '', array('method' => 'shave_all'));

      $thumbnail->loadFile($tmpFile);

      $thumbnail->save(sfConfig::get('sf_web_dir') . $folder . "s_" . $filename, 'image/jpeg');

      unset($thumbnail);



      //thumbnail image

      $thumbnail = new sfThumbnail(65, 49, false, true, 75, '', array('method' => 'shave_all'));

      $thumbnail->loadFile($tmpFile);

      $thumbnail->save(sfConfig::get('sf_web_dir') . $folder . "t_" . $filename, 'image/jpeg');

      unset($thumbnail);

    } catch (Exception $e)

    {

      $json_data['error'] = true;

      $json_data['msg'] = __('Error has occurred during converting your image.');



      echo json_encode($json_data);

      exit ();

    }



    //////////////////////////

    // writing user session //

    //////////////////////////

    //$data[$unique_id]['images'][$index] = new ProductImage();

    $data[$unique_id]['images'][$index]->setFolder($folder);

    $data[$unique_id]['images'][$index]->setFilename($filename);



    //is product is old

    if (!$data[$unique_id]['product']->isNew())

    {

      $data[$unique_id]['images'][$index]->setProductId($data[$unique_id]['product']->getId());

      $data[$unique_id]['images'][$index]->save();



      foreach ($data[$unique_id]['images'] as $index => $productImage)

      {

        if (is_file(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename()))

        {

          $data[$unique_id]['product']->setImage(serialize(array('folder' => $productImage->getFolder(), 'filename' => $productImage->getFilename())));

          $data[$unique_id]['product']->save();

          break;

        }

      }

    }



    $this->getUser()->setAttribute('tmp_product', $data);



    $json_data['error'] = false;

    $json_data['msg'] = 'Send successfully';

    $json_data['folder'] = $folder;

    $json_data['image'] = $filename;



    echo json_encode($json_data);

    exit ();

  }



  /**

   * Get number of uploaded images

   */

  public function executeGetNbImage(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $data = $this->getUser()->getAttribute('tmp_product', array());



    $counter = 0;

    //moving images from tmp folder to web upload folder

    foreach ($data[$unique_id]['images'] as $index => $productImage)

    {

      if (is_file(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename()))

      {

        $counter++;

      }

    }

    return $this->renderText(json_encode(array("nb_image" => $counter)));

  }



  /**

   * Upload Image

   * @param sfWebRequest $request

   */

  public function executeUploadImage(sfWebRequest $request)

  {

    $allowed_mime_types = array(

      'image/jpeg',

      'image/pjpeg',

      'image/png',

      'image/gif');

    $uploaded_data = $request->getFiles('userfile');

    //retreiving user session

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $index = $request->getParameter('index', 0);
	
	if(count($uploaded_data)+$index >48)
	{
		$no = (count($uploaded_data)+$index) - 48;
		$countArr = count($uploaded_data);
		for($i = 1 ; $i < $no ; $i++ )
			unset($uploaded_data[$countArr - $i]);
	}

	$index_no = $index;

    $data = $this->getUser()->getAttribute('tmp_product', array());

    $json_data = array();

    if (!isset($data[$unique_id])) {

      $json_data['error'] = true;

      $json_data['msg'] = __('Error has occurred in server, please inform system administrator.');

    } elseif (isset($uploaded_data['error'])) {		//is has error

      $json_data['error'] = true;

      $json_data['msg'] = __('Error has occurred while sending file');

    } elseif (isset($uploaded_data['type'])) {        //checking file types
	
		if(!in_array($uploaded_data['type'], $allowed_mime_types)) {
		  $json_data['error'] = true;
	
		  $json_data['msg'] = 'Only allowed (png, jpg, gif) file formats.'; // __('Only allowed (png, jpg, gif) file formats.');
		}
		
    } else {     //upload success
		 
	   $json_data['file_type_error'] = '';
	   foreach($uploaded_data as $uploaded_data_file) {
			
		  if(!in_array($uploaded_data_file['type'], $allowed_mime_types)) {
			  
			  if($json_data['file_type_error'] != '')
				  $json_data['file_type_error'] = $uploaded_data_file['name'].', '.$json_data['file_type_error'];
			  else
				  $json_data['file_type_error'] = $uploaded_data_file['name'].' files could not uploaded due to incorrect file type .';
			 
			  continue;
		  }
		  
		  $filename[$index] = md5(uniqid(rand(), true)) . '.jpg';
		  $folder[$index] = sfConfig::get('app_product_tmp_upload_dir', '/uploads/tmp_images/');
		  
		  // move orignal file
			// move_uploaded_file($uploaded_data['tmp_name'], sfConfig::get('sf_web_dir').$folder . "org_" . $filename);

		  ////////////////////

		  // resizing image //

		  ////////////////////

		  try
		  {  
		  
            //Orignal image
			
			list($width, $height, $type, $attr) = getimagesize($uploaded_data_file['tmp_name']);
			$thumbnail = new sfThumbnail($width, $height, true, false, 75, '');
			$thumbnail->loadFile($uploaded_data_file['tmp_name']);
			$thumbnail->save(sfConfig::get('sf_web_dir') . $folder[$index] ."org_". $filename[$index], 'image/jpeg');
			unset($thumbnail);
			
			
			//big image

			//$thumbnail = new sfThumbnail(640, 480, true, false, 75, '');
			$thumbnail = new sfThumbnail(640, 480, true, false, 75, '');

			$thumbnail->loadFile($uploaded_data_file['tmp_name']);

			$thumbnail->save(sfConfig::get('sf_web_dir') . $folder[$index] . $filename[$index], 'image/jpeg');

			unset($thumbnail);

			//medium image

			//$thumbnail = new sfThumbnail(300, 225, true, false, 75, '');
			$thumbnail = new sfThumbnail(300, 225, true, false, 75, '');

			$thumbnail->loadFile($uploaded_data_file['tmp_name']);

			$thumbnail->save(sfConfig::get('sf_web_dir') . $folder[$index] . "m_" . $filename[$index], 'image/jpeg');

			unset($thumbnail);

			//small image

			//$thumbnail = new sfThumbnail(150, 112, false, true, 75, '', array('method' => 'shave_all'));
			$thumbnail = new sfThumbnail(150, 112, false, true, 75, '', array('method' => 'shave_all'));

			$thumbnail->loadFile($uploaded_data_file['tmp_name']);

			$thumbnail->save(sfConfig::get('sf_web_dir') . $folder[$index] . "s_" . $filename[$index], 'image/jpeg');

			unset($thumbnail);

			//thumbnail image

			//$thumbnail = new sfThumbnail(65, 49, false, true, 75, '', array('method' => 'shave_all'));
			$thumbnail = new sfThumbnail(65, 49, false, true, 75, '', array('method' => 'shave_all'));

			$thumbnail->loadFile($uploaded_data_file['tmp_name']);

			$thumbnail->save(sfConfig::get('sf_web_dir') . $folder[$index] . "t_" . $filename[$index], 'image/jpeg');

			unset($thumbnail);
			
			@unlink($uploaded_data_file['tmp_name']);

		  } catch (Exception $e)
		  {

			@unlink($uploaded_data_file['tmp_name']);

			$json_data['error'] = true;

			$json_data['msg'] = 'Error has occurred while converting image.';

			//echo json_encode($json_data);
			exit ();

		  }

		  //////////////////////////

		  // writing user session //

		  //////////////////////////

		  //$data[$unique_id]['images'][$index] = new ProductImage();

		  $data[$unique_id]['images'][$index]->setFolder($folder[$index]);

		  $data[$unique_id]['images'][$index]->setFilename($filename[$index]);

		  $index++;
	   }
	
	   $this->getUser()->setAttribute('tmp_product', $data);
	   $json_data['error'] = false;
	   $json_data['msg'] = 'Send successfully';
		
	   $json_data['index_no'] = $index_no;
	   $json_data['count'] = $index - $index_no;
	   for($i = $index_no; $i < $index ; $i++) {
		
		 $json_data['folder'.$i] = $folder[$i];
		 $json_data['image'.$i] = $filename[$i];	 
	   }
	}

	echo json_encode($json_data);
    exit ();

  }



  /**

   *

   */

  public function generetaSessionData($data, $unique_id, $product = null)

  {

    if (!$product)

    {

      $product = new Product();

    }

    //product

    $data[$unique_id]['product'] = $product;

    //images

    $images = $product->getImages(); 

    for ($i = 0; $i < 49; $i++)

    {

      if (isset($images[$i]))

      {

        $data[$unique_id]['images'][$i] = $images[$i];

      } else

      {

        $data[$unique_id]['images'][$i] = new ProductImage();

      }

    }

    $user_id = $this->getUser()->getId();



    /////////////////////

    //removing temp files

    /////////////////////



    $tmp_folder = sfConfig::get('sf_web_dir') . sfConfig::get('app_product_tmp_upload_dir', '/uploads/tmp_images/');

   /* $d = dir($tmp_folder);

    while ($name = $d->read())

    {

      if (!is_file($tmp_folder . $name))

      {

        continue;

      }

      // 24 honogin umnu

      $time = time() - 24 * 60 * 60 * 24;

      $lastmod = filemtime($tmp_folder . $name);

      if ($lastmod < $time)

      {

        unlink($tmp_folder . $name);

      }

    }

    $d->close();


*/


    return $data;

  }



  /**

   * Step 1

   * @param sfWebRequest $request

   */

  public function executeStep1(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $data = $this->getUser()->getAttribute('tmp_product', array());

    //$job_data = $this->getUser()->getAttribute('tmp_job', array());



    //generating session data

    if (!isset($data[$unique_id]))

    {

      $data = $this->generetaSessionData($data, $unique_id, null);

    }

      $this->getUser()->setAttribute('tmp_product', $data);

    //job session data

    /*if (!isset($job_data[$unique_id]))

    {

      $job_data = $this->jobSessionData($job_data, $unique_id, null);

    }

    $this->getUser()->setAttribute('tmp_job', $job_data);
*/


    $child_id = (int) $data[$unique_id]['product']->getCategoryId();


	
    $this->unique_id = $unique_id;

    $this->category_table = Doctrine::getTable('Category');

    $this->categories = $this->category_table->getParentCategories($child_id, 1, $this->getUser()->getCulture());

  }



  /**

   * Step 2

   * @param sfWebRequest $request

   */

  public function executeStep2(sfWebRequest $request)

  {
	//ini_set('memory_limit', '128M');
	//ini_set('max_execution_time', 2147483647);
    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $data = $this->getUser()->getAttribute('tmp_product', array());

    

    $this->forward404Unless(isset($data[$unique_id]));

    $this->forward404Unless($data[$unique_id]['product']->getCategoryId());



    $this->unique_id = $unique_id;

    $root_category = Doctrine::getTable('Category')->getRootCategory($data[$unique_id]['product']->getCategoryId());

    $this->xType = myConstants::getCategoryType($root_category->getId());

    

    $this->form = new CustomProductForm($data[$unique_id]['product']);

    //print_r($this->form);
	//exit;
    $this->images = $data[$unique_id]['images'];



    if($this->xType == 'jobs'){

      //job session image data

      $job_data = $this->getUser()->getAttribute('tmp_job', array());

      $this->job_data = $job_data[$unique_id];

    }





    //select XArea

    $this->xarea_table = Doctrine::getTable('XArea');

    $x_area_id = (int) $data[$unique_id]['product']->getXAreaId();

    if($this->form->isNew()){

        $x_area_id = (int) $this->getUser()->getPreffXArea();

    }
	

    $this->areas = null;
	$this->x_area_locations = null;

    if ($x_area_id){
        
		$this->areas = $this->xarea_table->getParentAreas($x_area_id);		
		$this->x_area_locations = Doctrine::getTable('XAreaLocation')->getChildrens($x_area_id);
	}

    /////////////

    // IS POST //

    /////////////





    if ($request->isMethod('post'))

    {

      $taintedValues = $request->getParameter($this->form->getName());

      $taintedValues['category_id'] = $data[$unique_id]['product']->getCategoryId();

      $this->form->bind($taintedValues, $request->getFiles($this->form->getName()));



      if ($this->form->isValid())

      {		
        //$product = $this->form->getObject();

        $product = $this->form->save();
		
		if($request->getParameter("searchTextField")!= ''){
			//saving location selected by user using google autocomplete api.
			$xAreaLocation = new XAreaLocation();
			$locationDetails = $request->getParameter("product");
			$xAreaLocation->parent_id = $locationDetails['x_area_id'];
			$xAreaLocation->name = $request->getParameter("searchTextField");
			$locationDetails = $locationDetails['realestate'];
			$xAreaLocation->map_lat = round($locationDetails['map_lat'],7);
			$xAreaLocation->map_lng = round($locationDetails['map_lng'],7);
			$xAreaLocation->save();
			$x_area_location_id = $xAreaLocation->getId();
			$q = Doctrine_Query::create()
				->update('Product p')
				->set('p.x_area_location_id', '?', $x_area_location_id)
				->where('p.id = ?', $product->getId());
			$q->execute();
		}

        // $this->convertToUtf($product);

        ///////////////////

        // saving images //

        ///////////////////



        $folder_id = ceil($product->getId() / 200);

        $folder = sprintf(sfConfig::get('app_product_upload_dir', "/uploads/product-image-%s/"), $folder_id);



        if (!file_exists(sfConfig::get('sf_web_dir') . $folder))

        {

          mkdir(sfConfig::get('sf_web_dir') . $folder, 0777, true);

        }



        //moving images from tmp folder to web upload folder

        foreach ($data[$unique_id]['images'] as $index => $productImage)

        {

          if (is_file(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename()))

          {

            //moving images

            @rename(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename(), sfConfig::get('sf_web_dir') . $folder . $productImage->getFilename());

            @rename(sfConfig::get('sf_web_dir') . $productImage->getFolder() . "m_" . $productImage->getFilename(), sfConfig::get('sf_web_dir') . $folder . "m_" . $productImage->getFilename());

            @rename(sfConfig::get('sf_web_dir') . $productImage->getFolder() . "s_" . $productImage->getFilename(), sfConfig::get('sf_web_dir') . $folder . "s_" . $productImage->getFilename());

            @rename(sfConfig::get('sf_web_dir') . $productImage->getFolder() . "t_" . $productImage->getFilename(), sfConfig::get('sf_web_dir') . $folder . "t_" . $productImage->getFilename());

            @rename(sfConfig::get('sf_web_dir') . $productImage->getFolder() . "org_" . $productImage->getFilename(), sfConfig::get('sf_web_dir') . $folder . "org_" . $productImage->getFilename());


            $productImage->setProductId($product->getId());

            $productImage->setFolder($folder);

            $productImage->save();

            $data[$unique_id]['images'][$index] = $productImage;

          }

        }

        foreach ($data[$unique_id]['images'] as $index => $productImage)

        {

          if (is_file(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename()))

          {

            $product->setImage(serialize(array('folder' => $productImage->getFolder(), 'filename' => $productImage->getFilename())));



            $product->save();

            break;

          }

        }



        $data[$unique_id]['product'] = $product;

        //saving user session

        $this->getUser()->setAttribute('tmp_product', $data);

        

        if($this->xType == 'jobs'){

            $job_data = $this->getUser()->getAttribute('tmp_job', array());

            //moving images

            @rename(sfConfig::get('sf_web_dir') . $job_data[$unique_id]['folder'] . $job_data[$unique_id]['logo'], sfConfig::get('sf_web_dir') . $folder . $job_data[$unique_id]['logo']);

            @rename(sfConfig::get('sf_web_dir') . $job_data[$unique_id]['folder'] . "m_" . $job_data[$unique_id]['logo'], sfConfig::get('sf_web_dir') . $folder . "m_" . $job_data[$unique_id]['logo']);

            @rename(sfConfig::get('sf_web_dir') . $job_data[$unique_id]['folder'] . "s_" . $job_data[$unique_id]['logo'], sfConfig::get('sf_web_dir') . $folder . "s_" . $job_data[$unique_id]['logo']);

            @rename(sfConfig::get('sf_web_dir') . $job_data[$unique_id]['folder'] . "t_" . $job_data[$unique_id]['logo'], sfConfig::get('sf_web_dir') . $folder . "t_" . $job_data[$unique_id]['logo']);

            $job = $product->getJob();

            if(isset($job_data[$unique_id]['logo'])){

//               $job->setLogo($job_data[$unique_id]['logo']);

               $job->save();

            }

          $job_data[$unique_id]['folder'] = $folder;

          $job_data[$unique_id]['product'] = $product;

          //saving user session

          $this->getUser()->setAttribute('tmp_job', $job_data);

        }

        //redirecting

        return $this->redirect('manageProduct/step3?unique_id=' . $unique_id);

      }
    }
  }



  /**

   * product Step3

   * @param sfWebRequest $request

   */

  public function executeStep3(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $data = $this->getUser()->getAttribute('tmp_product', array());



    $this->forward404Unless(isset($data[$unique_id]));



    $this->unique_id = $unique_id;

    $this->product = $data[$unique_id]['product'];

    $xType = Doctrine::getTable('Category')->getRootCategory($data[$unique_id]['product']->getCategoryId());

    $this->xType = myConstants::getCategoryType($xType->getId());

  }



  /**

   * product Step4

   * @param sfWebRequest $request

   */

  public function executeStep4(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $data = $this->getUser()->getAttribute('tmp_product', array());



    $this->forward404Unless(isset($data[$unique_id]));

    $this->unique_id = $unique_id;

    $this->product = $data[$unique_id]['product'];

    if ($request->isMethod('post'))

    {

      $product_id = $data[$unique_id]['product']->getId();

      $values = $request->getParameter('doping');

      if (isset($values['id']))

      {

        $ids = $values['id'];

        $timestamp = time();

        $date_from = date("Y-m-d H:i:s", time());



        foreach ($ids as $dopingId => $id)

        {

          $nb_day = $values['duration'][$dopingId];

          if (!in_array($nb_day, array(7, 14, 28)))

          {

            continue;

          }

          try //adding to basket

          {

            //$this->getUser()->getShoppingCart()->addProduct($dopingId, 1, $product_id, $nb_day);

          } catch (Exception $e)

          {



          }

        }

      }

      //ActivityTools::logNewProduct($this->getUser()->getInstance(), $this->product);

      return $this->redirect('manageProduct/step5?unique_id=' . $unique_id);

    }

  }



  /**

   * product Step5

   * @param sfWebRequest $request

   */

  public function executeStep5(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id', md5(uniqid(rand(), true)));

    $data = $this->getUser()->getAttribute('tmp_product', array());



    $this->forward404Unless(isset($data[$unique_id]));

    $this->unique_id = $unique_id;

    $product = $data[$unique_id]['product'];

    if (($product->getStatus() == -1) || ($product->getStatus() == 3)) // new or denied

    {

      $product->setStatus(0); // make pending

      $product->save();

    }



    $this->product = $product;

    $xType = Doctrine::getTable('Category')->getRootCategory($product->getCategoryId());

    $this->xType = myConstants::getCategoryType($xType->getId());



    unset($data[$unique_id]);

    //saving user session

    $this->getUser()->setAttribute('tmp_product', $data);

  }



  /**

   * Show Child Categories

   * @param sfWebRequest $request

   * @return <type>

   */

  public function executeShowChildCategory(sfWebRequest $request)

  {

    $unique_id = $request->getParameter('unique_id');

    $data = $this->getUser()->getAttribute('tmp_product', array());



    //checking

    $this->forward404Unless(isset($data[$unique_id]));



    $category_id = $request->getParameter('id');

    $categories = Doctrine::getTable('Category')->getChildren($category_id, false, 1, $this->getUser()->getCulture());



    return $this->renderPartial('category', array('categories' => $categories));

  }



  /**

   * Select Leaf Category

   * @param sfWebRequest $request

   * @return <type>

   */

  public function executeSelectLeafCategory(sfWebRequest $request)

  {

    $category_id = $request->getParameter('id');

    $unique_id = $request->getParameter('unique_id');

    $data = $this->getUser()->getAttribute('tmp_product', array());



    $this->forward404Unless(isset($data[$unique_id]));



    $data[$unique_id]['product']->setCategoryId($category_id);

    $data[$unique_id]['product']->setCategory(Doctrine::getTable('category')->find($category_id));



    $this->getUser()->setAttribute('tmp_product', $data);



    return sfView::NONE;

  }



  /*

    protected function convertToUtf($product)

    {

    $product->setName(myTools::cp1251_utf8($product->getName()));

    $product->setDescription(myTools::cp1251_utf8($product->getDescription()));

    $product->setSurname(myTools::cp1251_utf8($product->getSurname()));

    $product->save();

    } */

}