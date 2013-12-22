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

    // CurrencyTable::getInstance()->getCurrOptions();
	//$this->setLanguageAndCurrancy();
    if (!$request->getParameter('sf_culture'))
    { 
	  $this->setLanguageAndCurrancy();
      if ($this->getUser()->isFirstRequest())
      {

        $culture = $request->getPreferredCulture(array('en', 'no'));
        //$this->getUser()->setCulture($culture);
		//$this->setLanguageAndCurrancy();
        $this->getUser()->isFirstRequest(false);

      } else
      {

        $culture = $this->getUser()->getCulture();

      }

      $this->redirect('localized_homepage');

    }



// go to yozoa homepage

    $this->products = Doctrine::getTable('Product')->getHomePageProducts(0, 25);

  }



  /**

   * Product View

   * @param sfWebRequest $request

   */

  public function executeShow(sfWebRequest $request)

  {

	$product_id = $request->getParameter('id');

    $this->forward404Unless($this->product = Doctrine::getTable('Product')->find($product_id));

    sfConfig::set('category_id', $this->product->getCategoryId());

    $this->xType = $this->product->getCategoryType();



    if (!$request->getParameter('has_layout', true))

    {

      $this->setLayout('layoutContent');

    }

    // increase statistic

    $this->productStat = Doctrine::getTable('ProductStat')->increaseReadCount($product_id);

    $categories = Doctrine::getTable('Category')->getParentCategories($this->product->getCategoryId(), false, $this->getUser()->getCulture());



    // setup SEO title

    $title = array();

    foreach ($categories as $c)

    {

      if ($c->getId() > 0)

      {

        $title[] = $c->getName();

      }

    }



    $this->getResponse()->setTitle($this->product->getName() . ' | ' . join(" | ", array_reverse($title)));

    $this->getResponse()->addMeta('description', myTools::utf8_substr(trim(strip_tags($this->product->getDescription())), 0, 255));



  }



    /**

   *

   * @uses realestateMapa autocomplete

   */

  public function executeAutocomplete(sfWebRequest $request)

  {

    $keyword = mysql_escape_string($request->getParameter('query'));

    $params = array(

      'keyword' =>   $keyword,

      'is_many' => true,

    );

    $suggestions = Doctrine::getTable('XArea')->getRealEstateSearch($params);

    $json = array();

    $json['query'] = $keyword;

    $suggs= array();

    foreach($suggestions as $xarea){

        $suggs[] = $xarea->getName();

    }

    $json['suggestions'] = $suggs;

    return $this->renderText(json_encode($json));

  }



  /**

   * Compare products

   * @param sfWebRequest $request

   */

  public function executeCompare(sfWebRequest $request)

  {

    $limit = 5;

    $ids = explode("-", $request->getParameter('ids', array()), $limit);



    $this->productAttributes = array();

    $this->products = Doctrine::getTable('Product')->findByPrimaryKeys($ids, $limit);

    //

    $this->forward404Unless(count($this->products) > 1);



    foreach ($this->products as $product)

    {

      //$product_id, $is_main = -1, $is_column = -1, $is_filter = -1, $culture = ""

      $this->productAttributes[$product->getId()] = Doctrine::getTable('ProductAttribute')->getProductAttributes($product->getId(), -1, -1, -1, $this->getUser()->getCulture());

    }

    $this->attributes = Doctrine::getTable('Attribute')->getAttributesByProductIds($ids, $this->getUser()->getCulture());



    $this->parent_categories = Doctrine::getTable('Category')->getParentCategories($this->products[0]->getCategoryId(), false, $this->getUser()->getCulture());

  }



  /**

   * Category Home

   * @param sfWebRequest $request

   */

  public function executeCategoryHome(sfWebRequest $request)

  {

    $category_id = (int) $request->getParameter('categoryId', 0);

    $this->xType = $request->getParameter('xType');

    if ($category_id == 0)

    {

      $category_id = myConstants::getCategoryId($this->xType);

    }



    sfConfig::set('category_id', $category_id);

    $this->category = Doctrine::getTable('Category')->findWithCulture($category_id, $this->getUser()->getCulture());

    $this->products = Doctrine::getTable('Product')->getSubPageProducts($category_id, 25);



    // setup SEO title

    $this->getResponse()->setTitle($this->category->getName());

  }



  /**

   * Search products

   * @param sfWebRequest $request

   */

  public function executeSearch(sfWebRequest $request)

  {



    $xType = $request->getParameter('xType');

    if($xType){

        $categoryId = myConstants::getCategoryId($xType);

    }elseif($request->getParameter('categoryId')){

        $categoryId = $request->getParameter('categoryId');

    }



    $categoryIds = (array) $request->getParameter('categoryIds');

    $this->xAreaId = (array) $request->getParameter('xarea_id', 0);

    $this->xType = $request->getParameter('xType');

    //square Range

    $squareRange = (int) $request->getParameter('minS') ;

    $squareRange .= $squareRange != 0 ? '-' . (int) $request->getParameter('maxS'): '';

	//$category = Doctrine::getTable('Category')->find($categoryId);

    $this->forward404Unless($category = Doctrine::getTable('Category')->find($categoryId));

	//print_r($category);die;

    $this->category = $category;



    $rAttributeValueIds = array_map(create_function('$v', 'return preg_match("/^[A-Za-z]*\d+$/", $v) ? $v : "";'), $rAttributeValueIds);

    $rAttributeValueIds = array_filter((array) $request->getParameter('av', array()));



    $keyword = $request->getParameter('keyword');

    $keywords = array_map("mysql_escape_string", preg_split("/[\s,]+/", $keyword, -1, PREG_SPLIT_NO_EMPTY));



    $oAttributeValueIds = Doctrine::getTable('AttributeValues')->getIdsByKeywords($keywords);



    // view type

    $viewType = strtolower($request->getParameter('viewType', $this->getUser()->getAttribute('viewType', 'grid')));

    if (!in_array($viewType, array('list', 'grid'), true))

      $viewType = 'grid';

    $this->getUser()->setAttribute('viewType', $viewType);



    // sort type

    $sortType = strtolower($request->getParameter('sortType', $this->getUser()->getAttribute('sortType', 'date_asc')));

    if (!in_array($sortType, array('date_asc', 'date_desc', 'price_asc', 'price_desc'))



      )$sortType = 'date_asc';

    $this->getUser()->setAttribute('sortType', $sortType);



    //query string

    $query_string = array();

    $query_string['keyword'] = "keyword=" . $keyword;



    //price range

    $priceRange = $request->getParameter('priceRange');

    //from advanced search

    $priceRange = (int) $request->getParameter('min');

    $priceRange .= '-' . (int) $request->getParameter('max');



    if ($priceRange)

      $query_string['priceRange'] = "priceRange={$priceRange}";



   //square Range

   if ($squareRange)

      $query_string['squareRange'] = "squareRange={$squareRange}";



    //category

    if ($categoryId)

      $query_string['categoryId'] = "categoryId={$categoryId}";



    //required attributes

    foreach ($rAttributeValueIds as $attrValueId)

    {

      $query_string[$attrValueId] = "av[]={$attrValueId}";

    }

    $this->keyword = $keyword;

    $this->keywords = $keywords;

    $this->sortType = $sortType;

    $this->viewType = $viewType;

    $this->priceRange = $priceRange;

    $this->query_string_array = $query_string;

    $this->rAttributeValueIds = $rAttributeValueIds;

    $this->oAttributeValueIds = $oAttributeValueIds;



    //square range

    $this->squareRange = $squareRange;



    $searchParams = array(

      'categoryId' => $categoryId,

      'categoryIds' => $categoryIds,

      'xAreaId' => $this->xAreaId,

      'xType'  => $this->xType,

      'rAttributeValueIds' => $rAttributeValueIds,

      'oAttributeValueIds' => $oAttributeValueIds,

      'keywords' => $keywords,

      'sordOrder' => $sordOrder,

	  'status'    => 1,

      //'priceRange' => $priceRange,

      //'squareRange' => $squareRange

	  );

    $query = Doctrine::getTable('Product')->searchQuery($searchParams);

    //search

    $this->pager = new sfDoctrinePager('Product', 16);

    $this->pager->setQuery($query);

    $this->pager->setPage($request->getParameter('page', 1));

    $this->pager->init();



    //if nb result == 1

    if ($this->pager->getNbResults() == 1)

    {

      /*foreach ($this->pager->getResults() as $product)

      {

        return $this->redirect($this->generateUrl('product_show', $product));

        break;

      }*/

    }



    if ($categoryId)

    {

      $this->search_attributes = Doctrine::getTable('Attribute')->getSearchList($categoryId, $this->xAreaId, $rAttributeValueIds, $oAttributeValueIds, $keywords, $priceRange); //filter attributes

    }

    $this->filtered_values = Doctrine::getTable('AttributeValues')->getValuesByPrimaryKeys($rAttributeValueIds);





    //price range

    if (!$request->getParameter('priceRange'))

    {

      $this->price_values = Doctrine::getTable('Product')->getPriceOption($categoryId, $rAttributeValueIds, $oAttributeValueIds, $keywords);

    }

     if(isset($categoryIds)){

        $categoryId = $categoryIds;

    }

    $this->child_categories = Doctrine::getTable('Category')->getSearchCategories($categoryId, $rAttributeValueIds, $oAttributeValueIds, $keywords);



    // setup SEO title

    $title = array();

    foreach ($this->child_categories as $c):

      $title[] = $c->getName();

    endforeach;

    $this->getResponse()->setTitle(implode(" | ", array_reverse($title)));

  }



  /**

   * Advanced Search products

   * @param sfWebRequest $request

   */

  public function executeAdvancedSearch(sfWebRequest $request)

  {

      $xType = $request->getParameter('xType');

      switch($xType){

          case 'realestates':

              $this->forward('product', 'realestateBasicAdvancedSearch');

          default:

              $this->forward('product', substr($xType, 0, -1).'AdvancedSearch');

      }

  }



  /**

   * Advanced Search products

   * @param sfWebRequest $request

   */

  public function executeProductAdvancedSearch(sfWebRequest $request)

  {

    $this->xType = $request->getParameter('xType');

    $categoryTypeId = myConstants::getCategoryId($this->xType);

    $this->CtypeId = Doctrine::getTable('Category')->find($categoryTypeId);

    $parent_category = Doctrine::getTable('Category')->getChildrenNodes($this->CtypeId, true, $this->CtypeId->getLft(), $this->CtypeId->getRgt());

    //$categorys = Doctrine_Query::create()->from('Category c')->where('c.id <> 0')->where('c.parent_id = ?', $this->CtypeId)->orderBy('c.sort_order')->execute();

    $this->xareas = Doctrine::getTable('XArea')->getChildren(0);

    $areas = Doctrine_Query::create()->from('XArea x')->where('x.id <> 0')->execute();

    $this->nested_areas = $this->_nestedCategories($areas);

    $this->nested_categories = $this->_nestedCategories($parent_category);

  }



    /**

   * Advanced Search products

   * @param sfWebRequest $request

   */

  public function executeRealestateMapAdvancedSearch(sfWebRequest $request)
  {
		
		ini_set('display_errors', '0');
		
		//echo "test".$queryString = str_replace("$","=",str_replace("*","&",$request->getParameter('queryString', 0)));
		//echo "arr".$queryString = explode("&",$queryString);
		//print_r($queryString);
		// Parameters of Refine search.
		/*$attribute_value_ids = (array) $request->getParameter('av', array());
		$attribute_value_ids = explode("|", $request->getParameter('av'));
		
		$category_id = $request->getParameter('categoryId', 0);
		$categoryId  = $category_id;
		$xAreaId     = $request->getParameter('xAreaId',215);
		$user_id     = (int) $request->getParameter('userId');
		$xType       = $request->getParameter('xType');
		$priceRange  = $request->getParameter('priceRange');
		$viewType    = strtolower($request->getParameter('viewType', $this->getUser()->getAttribute('viewType', 'grid')));
		$sortType    = strtolower($request->getParameter('sortType', $this->getUser()->getAttribute('sortType', 'date_desc')));
		$lastPosting = $request->getParameter('lastPosting');*/



		
		$parent_id = myConstants::getCategoryId('realestates');
		
		$category_id = myConstants::getCategoryId('category_id');
		
		$xarea_id = $request->getParameter('xarea_id');
		
		$this->categories = Doctrine::getTable('Category')->getRealEstateCategory($parent_id, true, 1, $this->getUser()->getCulture());
		
		$params = array(
		
		  'xAreaId' => 0,//$xarea_id,
		
		  'categoryId' => 1205,////0,
		
		  'is_raw'  => true,
		  
		  'xType'  => 'realestates'//$xType
		
		);
		
		
		
		//get xType
		
		$rootCategory = Doctrine::getTable('category')->getRootCategory($category_id);
		
		$xType = myConstants::getCategoryType($rootCategory['id']);
		
		
		
		$boundaries = Doctrine::getTable('Product')->getMapBoundaries($params);
		
		$this->avr_lat = ($boundaries['max_lat'] + $boundaries['min_lat'])/2;
		
		$this->avr_lng = ($boundaries['max_lng'] + $boundaries['min_lng'])/2;
		
		
		
		$this->min_lat = $boundaries['min_lat'];
		
		$this->min_lng = $boundaries['min_lng'];
		
		$this->max_lat = $boundaries['max_lat'];
		
		$this->max_lng = $boundaries['max_lng'];
		
		$this->initial_data = $this->returnRealEstateJSON($params);
		
		$paramsJSON = array(
		
		  'xAreaId' => 0,
		
		  'xType' => 'realestates',//$xType,
		
		  'categoryId' => 1205,//0,
		
		  'is_raw'  => true,
		
		);
		
		$this->xareas = Doctrine::getTable('XArea')->getRealEstateArea($paramsJSON);
		
		$this->setLayout('layoutMap');
	
  }



      /**

   * Real estate map advanced search

   * @param sfWebRequest $request

   */

  public function executeBoundsOnChanged(sfWebRequest $request)

  {

        $params = $request->getParameter('params');

        $array_params = array(

            'xAreaId'=> 0,

            'categoryId'=> 0,

            'minLat' => $params[0],

            'minLng' => $params[1],

            'maxLat' => $params[2],

            'maxLng' => $params[3],

        );



        $products = Doctrine::getTable('Product')->getWhitinBoundaries($array_params);

        if($products){

            $array = null;

            foreach($products as $product){

                $realEstate = $product->getRealEstate();

                $array[] = array(

                          'id' => $product->getId(),

                          'lat' => $realEstate->getMapLat(),

                          'name' => $realEstate->getAddress(),

                          'lng' => $realEstate->getMapLng(),

                          'image'  =>'/images/house.png',

                          );

                }

          }



            if(isset($array)){

              //json array

                return $this->renderText(json_encode($array));

              }else{

                return $this->renderText(json_encode(null));

              }

  }



    /**

   * Real estate map advanced search

   * @param sfWebRequest $request

   */

  public function executeRealestateBasicAdvancedSearch(sfWebRequest $request)

  {

        $this->xareas = Doctrine::getTable('XArea')->getChildren(0);

        $category_id = myConstants::getCategoryId('realestates');

        $this->categories = Doctrine::getTable('Category')->getChildren($category_id);

        $this->attributes  = Doctrine::getTable('Attribute')->getFilterableAttributeByCategoryId($category_id, $this->getUser()->getCulture());

  }



  public function executeGetRealEstateArea(sfWebRequest $request)

  {

      $array = array();

      $data = array();

      $main = array();

      $param = $request->getParameter('params');

      //square Range

      $squareRange = (int) $param[2] ;

      $squareRange .= $squareRange != 0 ? '-' . (int) $param[3]: '';

      //from advanced search

      $priceRange = (int) $param[0];

      $priceRange .= '-' . (int) $param[1];



      $params = array('xAreaId' => $request->getParameter('id'),

                      'categoryId' => 0,

                      'priceRange' => $priceRange,

                      'squareRange' => $squareRange,

                     );

      return $this->returnRealEstateJSON($params);

  }



  public function executeGetAjax(sfWebRequest $request)

  {
ini_set('display_errors', '0');
    if ($request->isXmlHttpRequest())

    {

        $array = array();

        $data = array();

        $main = array();

        $priceRange = (int) $request->getParameter('price_from');

        $priceRange .= '-' . (int) $request->getParameter('price_to');

        $bedroomsRange = (int) $request->getParameter('bedrooms_from');

        $bedroomsRange .= '-' . (int) $request->getParameter('bedrooms_to');

		

        $dateRange = (int) $request->getParameter('date_from');

        $dateRange .= '-' . (int) $request->getParameter('date_to');

		// floor

        $floorRange = (int) $request->getParameter('floor');

		// tenure

        $tenureRange = (int) $request->getParameter('tenure');

		

        $areaRange = (int) $request->getParameter('area_from');

        $areaRange .= '-' . (int) $request->getParameter('area_to');

		

		$propertyRange = (int) $request->getParameter('propertyType');

		$constructionDate = (int) $request->getParameter('constructionDate');

		

        $catId = array();

        $catId = explode('_', $request->getParameter('searchKey'));

        $categoryId = isset($catId[3]) ? $catId[3] : '';



        //get xType

        $rootCategory = Doctrine::getTable('category')->getRootCategory($categoryId);

        $xType = 'realestate';//myConstants::getCategoryType($rootCategory['id']);



        $params = array('categoryId' => 1205,//$categoryId,

                        'xAreaId' => 0,

                        'xType' => $xType,

                        'priceRange' => $priceRange,

                        'squareRange' => $areaRange,

						'bedroomsRange' => $bedroomsRange,

						'propertyRange' => $propertyRange,

						'floorRange' => $floorRange,

						'tenureRange' => $tenureRange,

						'constructionDate' => $dateRange,

                        'minLat' => $request->getParameter('minX'),

                        'minLng' => $request->getParameter('minY'),

                        'maxLat' => $request->getParameter('maxX'),

                        'maxLng' => $request->getParameter('maxY'),

                       );



		

        $products = Doctrine::getTable('Product')->getWithinBoundaries($params);

        if($products){

            $array = null;

            foreach($products as $product){

				

                switch($xType){

                    case 'realestate':

                        $object = $product->getRealEstate();

						

                        $object_name = $object->getAddress();

                    break;

                    case 'rental':

						$object = $product->getRental();

						$object_name = $product->getName();

                    break;

                    default:

						$object = $product->getRealEstate();

						

						$object_name = $object->getAddress();

                    break;

                }



                $array[] = array(

                          'id'    => $product->getId(),

                          'lat'   => $object->getMapLat(),

                          'name'  => $object_name,

                          'lng'   => $object->getMapLng(),

                          'image' => '/images/house.png',

                          );

                }

          }



			print_r($array);die;

            if(isset($array)){

              //json array

                return $this->renderText(json_encode($array));

              }else{

                return $this->renderText(json_encode(null));

              }



    }



      return $this->returnRealEstateJSON($params);

  }



  public function returnRealEstateJSON($params){
  

      $query = Doctrine::getTable('XArea')->getRealEstateArea($params);

      $i=0; foreach ($query as $xArea){

          $param = array('xAreaId' => $xArea->getId(),

                         'categoryId' => 0,

                         'priceRange' => isset($params['priceRange']) ? $params['priceRange']: '',

                         'squareRange' => isset($params['squareRange']) ? $params['squareRange']: '', );

            $products = Doctrine::getTable('Product')->searchRealEstateByArea($param);

            if($products){

                $array = null;

                foreach($products->execute() as $product){

                $realEstate = $product->getRealEstate();

                $array[] = array(

              'id' => $product->getId(),

              'lat' => $realEstate->getMapLat(),

              'name' => $realEstate->getAddress(),

              'lng' => $realEstate->getMapLng(),

              'image'  =>'/images/house.png',

              );

            }

            }

            $main[$i] = array(

             'id'   => $xArea->getId(),

             'name' => $xArea->getName(),

             'is_leaf' => $xArea->isLeaf() ? "true" :"false",

             'total' => $xArea->getNbProduct(),

             'product' => $array,

            );

            $i++;

      }

      if(count($query)==0){

          $xAreaName =null;

      }



      if(count($query)< 1){

          $xArea = Doctrine::getTable('XArea')->find($params['xAreaId']);

          if($xArea){

            $param = array('xAreaId' => $xArea->getId(),

                         'priceRange' => isset($params['priceRange']) ? $params['priceRange']: 0,

                         'squareRange' => isset($params['squareRange'])? $params['squareRange']: 0, );

            $products = Doctrine::getTable('Product')->searchRealEstateByArea($params);

            foreach($products->execute() as $product){

                $realEstate = $product->getRealEstate();

                $array[] = array(

              'id' => $product->getId(),

              'name' => $realEstate->getAddress(),

              'lat' => $realEstate->getMapLat(),

              'lng' => $realEstate->getMapLng(),

              'image'  =>'/images/house.png',

              );

            }

            if(isset($array)){

               $main[0] = array(

             'id'   => $xArea->getId(),

             'name' => $xAreaName,

             'is_leaf' => $xArea->isLeaf(),

             'product' => $array,

            );

            }

          }

      }

      if(isset($main)){

      //get boundaries

      $boundaries = Doctrine::getTable('Product')->getMapBoundaries($params);

//      $avr_lat = ($boundaries['max_lat'] + $boundaries['min_lat'])/2;

//      $avr_lng = ($boundaries['max_lng'] + $boundaries['min_lng'])/2;

      //json array

      $data['main'] = $main;

      $data['avr'] = array(

              'max_lat' => $boundaries['max_lat'],

              'min_lat' => $boundaries['min_lat'],

              'min_lng' => $boundaries['min_lng'],

              'max_lng' => $boundaries['max_lng'],

      );

      if(isset($params['is_raw'])){

        return $data;

      }
		return $data;//json_encode($data);
        //return $this->renderText(json_encode($data));

      }else{

        return $this->renderText(json_encode(null));

      }



  }

  /*

   * keyword search in Map

   */

  public function executeGetRealEstateSearch(sfWebRequest $request)

  {

      $data = array();

      $keyword = mysql_escape_string($request->getParameter('keyword'));

      if($keyword){

        $params = array(

            'keyword' => $keyword,

            'is_many' => false,

            );

      $search_area = Doctrine::getTable('XArea')->getRealEstateSearch($params);

      if($search_area){

          $params = array(

                    'xAreaId' => $search_area->getId(),

                    'categoryId' => 0,

              );

          return $this->returnRealEstateJSON($params);

      }else{

          return $this->renderText(json_encode(null));

      }

      }else{

          return $this->renderText(json_encode(null));

      }





  }

  /*

   * realEstate infoWindow Object

   */



  public function executeGetRealEstateObject(sfWebRequest $request){

          $data = array();

          //$params = array('xAreaId' => $request->getParameter('id'));

          $product = Doctrine::getTable('Product')->find($request->getParameter('id'));



				



          $rootCategory = Doctrine::getTable('category')->getRootCategory($product->getCategoryId());

          $xType = myConstants::getCategoryType($rootCategory->getId());



          switch($xType){

              case 'realestates':

                  $object = $product->getRealEstate();

				 

				 // LNA 20.06.2011

				 

				 $attributes = array( 175, 177, 168, 195, 176);

				 // 175 - Property Type

				 // 177 - Bedrooms

				 // 168 - Construction Date

				 // 195 - Floor

				 // 176 - Tenure

				 

				 foreach ($product->getProductAttributes() as $productAttribute){

					if (in_array($productAttribute->getAttributeId(), $attributes)){

						//echo "[" . $productAttribute->getProductAttributeValues() . "]";

						if($productAttribute->getAttributeId() == 175){ // Property Type

							if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")

							{

								$property_type = $productAttribute->getAttributeValue();

							} else 	{

								$property_type = join(", ", $productAttribute->getProductAttributeValues(false));

							}

						}elseif($productAttribute->getAttributeId() == "177"){ // Bedrooms

							if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")

							{

								$bedrooms = $productAttribute->getAttributeValue();

							} else {

								$bedrooms = join(", ", $productAttribute->getProductAttributeValues(false));

							}

							if((int)$bedrooms != 0){ $bedrooms .= '&nbsp;Bedrooms';}

						}elseif($productAttribute->getAttributeId() == "168"){ // Construction Date

							if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")

							{

								$date = $productAttribute->getAttributeValue();

							} else {

								$date = join(", ", $productAttribute->getProductAttributeValues(false));

							}

						}elseif($productAttribute->getAttributeId() == "195"){ // Floor

							if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")

							{

								$floor = $productAttribute->getAttributeValue();

							} else {

								$floor = join(", ", $productAttribute->getProductAttributeValues(false));

							}

						}elseif($productAttribute->getAttributeId() == "176"){ // Tenure

							if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")

							{

								$tenure = $productAttribute->getAttributeValue();

							} else {

								$tenure = join(", ", $productAttribute->getProductAttributeValues(false));

							}

						}

					}

				 }

                  $rtarea = '<span style=\"display:block;\">'. $object->getTotalArea().'m²&nbsp;&nbsp;&nbsp;' . $property_type . "&nbsp;&nbsp;&nbsp;" . $tenure . "&nbsp;&nbsp;&nbsp;<br />" . $bedrooms . '&nbsp;&nbsp;&nbsp;' . $floor . ' floor <br />' . $date. "</span>";

                  $raddress = substr($object->getAddress(), 0, 50);

                  break;

              case 'rental':

                  $object = $product->getRental();

                  $rtarea = '<span style=\"display:block;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';

                  $raddress = substr($object->getAddress(), 0, 50);

                  break;

              default:

                  $object = $product->getRealEstate();

                  $rtarea = '<span style=\"display:block;\">'. $object->getTotalArea().'m²&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';

                  break;

          }



          

          $productImages = $product->getProductImages();

          $product_image = $product->getImagePath("s_");

          $product_name = substr($product->getName(), 0, 20);

          $url = $this->generateUrl('product_show', $product);

          

          

          $price = $product->getPrice();

		  

          

          $array = array(

          'poiValue'=> "<div class=\"iad-popup\">

                        <div style=\"display: block\" class=\"toolbar prospectframe internal_0\" id=\"popupMiniProspect_22472671\">

                        <div style=\"overflow: hidden;\">

                        <a href=\"$url\" target=\"_new\">

                        <div class=\"popup-image\"><img border=\"0\" class=\"popupProspectImage\" src=\"$product_image\" alt=\"bilde\"/>

                        </div>

                        </a>

                        <div class=\"popup-txtcontent\">

                        <span class=\"title1\">

                        <a href=\"$url\" target=\"_new\">$product_name</a>

                        </span>

                        $rtarea

                        <span>$raddress</span>

                        <span class=\"price\">

                        Price:$price&nbsp;</span>

                        </div><div style=\"clear:both\">

                        </div>

                         </div>

                         </div>

                         </div>",

          );



      return $this->renderText(json_encode($array));

  }



  /**

   * Get child area by parent_id

   * @param sfWebRequest $request

   * @return <type>

   */

  public function executeChildAreaRealEstate(sfWebRequest $request)

  {

    $parent_id = $request->getParameter('id');

    if (!$request->isXmlHttpRequest())

    {

      return $this->forward404();

    }

    if ($parent_id != 0)

    {

        $params = array(

      'xAreaId' => $parent_id,

            );

      $query = Doctrine::getTable('Product')->searchRealEstateQuery($params);

      //search



    $pager = new sfDoctrinePager('Product', 16);

    $pager->setQuery($query);

    $pager->setPage($request->getParameter('page', 1));

    $pager->init();

    $main = array();

    $sub = array();

    foreach($pager->getResults() as $product){

        $realestate = $product->getRealEstate();

        $sub[] = $product->getName();

        $sub[] = $realestate->getMapLat();

        $sub[] = $realestate->getMapLng();

        $main[] = $sub;

        unset($sub);

    }

    printf("<script type='text/javascript'>

        var response_array = ".json_encode($main)."

</script>") ;

      $this->x_areas = Doctrine::getTable('XArea')->getChildren($parent_id);

      if ($this->x_areas)

      {

        return $this->renderPartial('manageProduct/childArea', array('x_areas' => $this->x_areas, 'selected_id' => $parent_id));

      }

      $this->setLayout(false);

    }

  }



    /**

   * Advanced Search products

   * @param sfWebRequest $request

   */

  public function executeJobAdvancedSearch(sfWebRequest $request)

  {

    $this->xType = $request->getParameter('xType');

    $categoryTypeId = myConstants::getCategoryId($this->xType);

    $this->CtypeId = Doctrine::getTable('Category')->find($categoryTypeId);

    $parent_category = Doctrine::getTable('Category')->getChildrenNodes($this->CtypeId, true, $this->CtypeId->getLft(), $this->CtypeId->getRgt());

    //$categorys = Doctrine_Query::create()->from('Category c')->where('c.id <> 0')->where('c.parent_id = ?', $this->CtypeId)->orderBy('c.sort_order')->execute();

    $this->xareas = Doctrine::getTable('XArea')->getChildren(0);

    $areas = Doctrine_Query::create()->from('XArea x')->where('x.id <> 0')->execute();

    $this->nested_areas = $this->_nestedCategories($areas);

    $this->nested_categories = $this->_nestedCategories($parent_category);

  }



  /*

   * return nested categories

   */



  protected function _nestedCategories($categories)

  {

    $nested_categories = array();

    foreach ($categories as $category)

    {

      $nested_categories[$category->getParentId()][$category->getId()] = $category;

    }

    return $nested_categories;

  }
  
  // Return google map marker icon image generated by php gd library. 
  
  public function executeGetIconImage(sfWebRequest $request)
  {
  	header("Content-Type: image/png");
	$price = $request->getParameter('price');
	$symbol = $request->getParameter('symbol');
	$price = str_replace($symbol,"",$price);
	$price = trim(str_replace(",","",$price));
	if(strlen($price) > 3 && strlen($price) <= 6)
		$price = $symbol.round($price/1000,2)."k";		//$price = $symbol.substr((int)$price, 0, -3)."k";
	else if(strlen($price) > 6)
		$price = $symbol.round($price/1000000,2)."M";
	else
		$price = $symbol.$price;
	
	$width = 40;
	if(strlen($price) > 6)
		$width = 50;
	$color = $request->getParameter('color');
	$im = @imagecreate($width, 15)
		or die("Cannot Initialize new GD image stream");
	if($color == 1)
		$background_color = imagecolorallocate($im, 170, 212, 255);	// redish color : 153, 25, 25
	else if($color == 2)
		$background_color = imagecolorallocate($im, 85, 255, 127);
	else if($color == 3)
		$background_color = imagecolorallocate($im, 254, 126, 126);
	$text_color = imagecolorallocate($im, 0, 0, 0);
	imagerectangle($im, 0, 0, $width - 1, 14, $text_color);
	imagestring($im,2, 2, 0,  $price , $text_color);
	return imagepng($im);
	imagedestroy($im);
  }
  /**

   * Guided Search

   * @param sfWebRequest $request

   * @return <type>

   */

  public function executeBrowse(sfWebRequest $request)
  {
   ////////////////////////

    //Requesting parameters

    ////////////////////////
	//ini_set('memory_limit', '128M');
	$attribute_value_ids = (array) $request->getParameter('av', array());
	$attribute_value_ids = explode("|", $request->getParameter('av'));

	$category_id = $request->getParameter('categoryId', 0);
	$categoryId  = $category_id;
	$xAreaId     = $request->getParameter('xAreaId', 0);
	$user_id     = (int) $request->getParameter('userId');
	$xType       = $request->getParameter('xType');
	$priceRange  = $request->getParameter('priceRange');
	$viewType    = strtolower($request->getParameter('viewType', $this->getUser()->getAttribute('viewType', 'grid')));
	$sortType    = strtolower($request->getParameter('sortType', $this->getUser()->getAttribute('sortType', 'date_desc')));
	$lastPosting = $request->getParameter('lastPosting');
	$contentView  = $request->getParameter('contentView','listview');
    //////////////////////

    // normalizing inputs

    ///////////////////////
	
	
	
	$is_array_location = false;
	
	//if there is string of xAreaId then convert it into array.
	if(!is_array($xAreaId) ){
		if(strstr($xAreaId,'|')) {
			$xAreaId = explode('|',$xAreaId);
		}
	}
	
	if($request->getParameter('rootLocation',0) && is_array($xAreaId))
	{
		if(is_array($xAreaId))
			$xArea_Id = $xAreaId[0];
		else
			$xArea_Id = $xAreaId;
		$parentAreas = Doctrine::getTable('XArea')->getParentAreas($xArea_Id);
		foreach($parentAreas as $parentAreaId)
			$xArea_Id = $parentAreaId->getParent_id();  
		
		if($xArea_Id == 0)
			$xAreaId = $xArea_Id;
		else
			$xAreaId[0] = $xArea_Id;
	}
	
	if(is_array($xAreaId) ){
		$xArea_id = $xAreaId[0];
        if($xArea_id == 0){
           $is_array_location = false;

        } else{ 
            $is_array_location = true;
        }
	}
	$this->is_array_location = $is_array_location ;
	
	
    $attribute_value_ids = array_map(create_function('$v', 'return preg_match("/^[A-Za-z]*\d+$/", $v) ? $v : "";'), $attribute_value_ids);
    $attribute_value_ids = array_filter($attribute_value_ids);
	//Get last posting value in case of attribute filter.
	if($attribute_value_ids){
		$lastPosting = $this->getUser()->getAttribute('lastPosting')? $this->getUser()->getAttribute('lastPosting'):$lastPosting;
		$this->getUser()->setAttribute('lastPosting',null);
	}
	else
		$this->getUser()->setAttribute('lastPosting',null);
	
    $is_array_category = false;	
	//if there is string of xAreaId then convert it into array.
	if(!is_array($category_id) ){
		if(strstr($category_id,'|')) {
			$category_id = explode('|',$category_id);
		}
	}

	// check the rootCategory parameter.
 	if($request->getParameter('rootCategory',0))
	{
		if(is_array($category_id))
			$cat_Id = $category_id[0];
		else
			$cat_Id = $category_id;
		$parentCategory = Doctrine::getTable('Category')->getParentCategories($cat_Id ,1, $this->getUser()->getCulture()); 
		foreach($parentCategory as $parent_cat)
			$cat_Id = $parent_cat->getParent_id(); 
			
		if(is_array($category_id)){
			$category_id = array();
			$category_id = $cat_Id;
			$categoryId = $category_id;
		} else {
			$category_id = $cat_Id;
			$categoryId  = $cat_Id;
		}
	}
	
    if(is_array($category_id)){

        if(count($category_id) == 1){
			$category_id = $category_id[0];
			$categoryId  = $category_id[0];
			$is_array_category = false;
		} else {
			$categoryId = $category_id[0];
			if($categoryId == 0){
				$is_array_category = false;
				$this->getUser()->setAttribute('clear_parent_category', null);
			} else{ 
				$is_array_category = true;
			}
		}
    }
	
    // if null category then get the parent category
    if ($category_id == 0) {
	  // get parent category Id 	
      if (in_array($xType, myConstants::getCategoryTypes())) {
        $category_id = myConstants::getCategoryId($xType);

      } elseif (in_array($xType, myConstants::getAttributeTypes())) {   // 
	    $attribute_value_ids[] = myConstants::getAttributeId($xType);
      }
    }

  	  if (!in_array($viewType, array('list', 'grid'), true)){
      $viewType = 'list';
    }

    if (!in_array($sortType, array('date_asc', 'date_desc', 'price_asc', 'price_desc'))){
      $sortType = 'date_asc';
    }

    $this->getUser()->setAttribute('viewType', $viewType);

    $this->getUser()->setAttribute('sortType', $sortType);

 

    /////////////////////

    // Validating inputs

    /////////////////////


	
    $this->forward404Unless($this->category = Doctrine::getTable('Category')->findWithCulture($categoryId, $this->getUser()->getCulture()));
    //$this->forward404Unless(Doctrine::getTable('XArea')->find($xAreaId));
    if ($user_id){

      $this->forward404Unless($this->user = Doctrine::getTable('User')->find($user_id));

    }

    ///////////////

    //query string

    ///////////////

    $query_string = array();
    $query_string_for_attribute = array();
	$query_string_for_attribute = array();
    $query_string_for_selected_categories = array();

    if ($user_id)
      $query_string['userId'] = "userId=" . $user_id;

    if ($priceRange)
      $query_string['priceRange'] = "priceRange={$priceRange}";
	  
	// attribute
    foreach ($attribute_value_ids as $a_id => $a_value_id){
      $query_string_for_attribute[$a_value_id] = "{$a_value_id}";
    }


	// category
    if ($category_id)
        $this->query_string_for_categories = $query_string;
      if($is_array_category == true){
          foreach ($category_id as $c_id => $c_value_id) {
            $query_string[$c_value_id] = "categoryId[]={$c_value_id}"; 
          }

      }else{
          $query_string['categoryId'] = "categoryId=" . $category_id;
          $this->getUser()->setAttribute('clear_parent_category', $category_id);

      }
	  
	 // location
      if($is_array_location == true){
          foreach ($xAreaId as $a_id => $a_value_id) {
            $query_string[$a_value_id] = "xAreaId[]={$a_value_id}";
          }
      }else{
         // $query_string['xAreaId'] = "xAreaId=" . $xAreaId;
          //$this->getUser()->setAttribute('clear_parent_category', $category_id);

      } 
	 

	// Expire products

	// LNA 22.08.2011

	$browseParams = array(

      'categoryId' => $category_id,

      'xAreaId' => $xAreaId,

      'attributeValueIds' => $attribute_value_ids,

      'sortType' => $sortType,
	  
	  'lastPosting' => $lastPosting,

      'priceRange' => $priceRange,

      'currencyCode' => $this->getUser()->getPreffCurrency(),

      'userId' => $user_id,

      'culture' => $this->getUser()->getCulture(),

	  'status'  => 1,
	  
	  'contentView' => $contentView

	  );

	  

	  	// set query

	  /*	$query = Doctrine::getTable('Product')->browseQuery($browseParams);


		//pager

		$this->pager = new sfDoctrinePager('Product');

		$this->pager->setQuery($query);



		$now = strtotime("now");

		$nbResult = $this->pager->getNbResults(); //nb of product

		

			foreach ($this->pager->getResults() as $product)

      		{

				//echo "[" . $product->getDuration() . "][" . $product->getConfirmedAt() . "][" . strtotime("now") . "][" . strtotime($product->getConfirmedAt()) . "][" . $product->getId() . "]<br />"	;

				$day_diff = round(($now - strtotime($product->getConfirmedAt())) / 86400);

				if ($day_diff > $product->getDuration()){ // set to expired

					if ($product)

					{

					  $product->setStatus(2);

					  $product->setUpdatedAt(date("Y-m-d H:i:s", time()));

					  $product->save();

					}

				}

				

			}
*/
	// end expire



   /* $browseParams = array(

      'categoryId' => $category_id,

      'xAreaId' => $xAreaId,

      'attributeValueIds' => $attribute_value_ids,

      'sortType' => $sortType,
	  
	  'lastPosting' => $lastPosting,

      'priceRange' => $priceRange,

      'currencyCode' => $this->getUser()->getPreffCurrency(),

      'userId' => $user_id,

      'culture' => $this->getUser()->getCulture(),

	  'status'  => 1

	  ); */


     if ($request->isXmlHttpRequest())
     {
		if($request->getParameter('ssav')) {
			 $ssav = $request->getParameter('ssav');
		
			 $ssa_object = Doctrine::getTable('Attribute')->find($ssav);
		
			 $this->forward404Unless($ssa_object);
		
			 $ssav_attributes = Doctrine::getTable('Attribute')->getBrowseList($browseParams);
		
			 $browseParams['attributeId'] = $ssa_object->getId();
		
			 $ssav_attribute_values = Doctrine::getTable('AttributeValues')->getValues($browseParams);
		
			 $xmlParams = array(
		
						'ssav_title'            => $ssav,
		
						'savs'                  => $attribute_value_ids,
		
						'ssav_object'           => $ssa_object,
		
						'ssav_attributes'       => $ssav_attributes,
		
						'ssav_attribute_values' => $ssav_attribute_values,
		
			 );
		
		//     print_r($request->getParameter('av'));
		
		//     die;
		
				 $data = array(
		
					'savs'  => $attribute_value_ids,
		
					'_ssan'  => $ssav,
		
					'content' => $this->getPartial('choose_more', array('xmlParams' => $xmlParams)));
		
		
		
			return $this->renderText(json_encode($data));
		}
		if($request->getParameter('lastPosting')||$request->getParameter('priceRange')) {
				
			$lastPosting = $request->getParameter('lastPosting');
			$this->getUser()->setAttribute('lastPosting', $lastPosting);
			if($lastPosting == -1)
				$lastPosting = '';
			if($request->getParameter('xType'))
				$xType =  $request->getParameter('xType');
			if($request->getParameter('av')) {
				$attribute_value_ids = (array) $request->getParameter('av', array());
				$attribute_value_ids = explode("|", $request->getParameter('av'));
			}
			
			if($request->getParameter('priceRange'))
				$priceRange  = $request->getParameter('priceRange');
			
			if($request->getParameter('xAreaId'))
				$xAreaId     =  $request->getParameter('xAreaId', 0);
				
			$contentView =  $request->getParameter('contentView','listview');
			
			$browseParams = array(
		
			  'categoryId' => $category_id,
		
			  'xAreaId' => $xAreaId,
		
			  'attributeValueIds' => $attribute_value_ids,
		
			  'sortType' => $sortType,
			  
			  'lastPosting' => $lastPosting,
		
			  'priceRange' => $priceRange,
		
			  'currencyCode' => $this->getUser()->getPreffCurrency(),
		
			  'userId' => $user_id,
		
			  'culture' => $this->getUser()->getCulture(),
		
			  'status'  => 1,
	  
	 		  'contentView' => $contentView
		
			  );
			
			$query = Doctrine::getTable('Product')->browseQuery($browseParams);
			
			if($contentView == 'mapview'){
			
				$data = $this->returnMapRefineSearchData($query);
				$initial_data = $data['initial_data'];
				return $this->renderText($initial_data);
			
			}else if($contentView == 'listview'){
			
				//pager
				$this->pager = new sfDoctrinePager('Product', 16);
				$this->pager->setQuery($query);
				$this->pager->setPage($request->getParameter('page', 1));
				$this->pager->init();
			
				$nbResult = $this->pager->getNbResults(); //nb of product
				
				return $this->renderText($this->getPartial('browse', array('category' => $this->category, 'pager' => $this->pager, 'sortType' => $sortType, 'xType' => $xType, 'viewType' => $viewType, 'query_string_array' => $query_string)));
				
			} 
		}
		/*if($request->getParameter('getHtmlTemplate')){
			$productData = Doctrine::getTable('Product')->find($request->getParameter('id'));			
			return $this->renderText(trim($this->getPartial('mapInfoWindow', array('product' => $productData, 'img' => $request->getParameter('img')))));
		}*/
		if($request->getParameter('setFavorite')){
			if($this->getUser()->isAuthenticated()){
				$p_id = $request->getParameter('id');
				$user = Doctrine::getTable('User')->find($this->getUser()->getId());
				$user->getFevorite_products();
				$fevorite_product = explode(",",$user->getFevorite_products());
				if(in_array($p_id,$fevorite_product)){
					foreach($fevorite_product as $key=>$value){
						if($value == $p_id)
							unset($fevorite_product[$key]);
					}
				}else{
					$fevorite_product[] = $p_id;
				}
				$fevorite_p = implode(",",$fevorite_product);
				$q = Doctrine_Query::create()
					->update('User u')
					->set('u.fevorite_products', '?', $fevorite_p)
					->where('u.id = ?', $this->getUser()->getId());
					
				$rows = $q->execute();
			    return $this->renderText($rows);
			}
		}
     }
	 
	//query
	$query = Doctrine::getTable('Product')->browseQuery($browseParams);
	
	if($contentView == 'listview'){
	
		$this->pager = new sfDoctrinePager('Product', 16);
		$this->pager->setQuery($query);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
	
		$nbResult = $this->pager->getNbResults(); //nb of product
	
		if ($nbResult == 1) {
	
		  foreach ($this->pager->getResults() as $product){
	
			  // LNA redirect to album
			if($xType == 'realestates')  
			return $this->redirect("album/" . $product->getId());
			//else return $this->redirect($this->generateUrl('product_show', $product));
			break;
		  }
		} elseif ($nbResult == 0) {
	
		  $this->getUser()->setFlash('info', 'No product in this category. Enter your product  <a href="/manageProduct/step1">here</a>.');
	
		}

	} else if($contentView == 'mapview'){
		$data = $this->returnMapRefineSearchData($query);
		$avr_lat 	    = $data['avr_lat'];
		$avr_lng 		= $data['avr_lng'];
		if($avr_lat != 0 && $avr_lng != 0){
			$this->getUser()->setAttribute('lat', $avr_lat);
			$this->getUser()->setAttribute('lng', $avr_lng);
			$this->avr_lat = $avr_lat;
			$this->avr_lng = $avr_lng;
		}else{
			$this->avr_lat = $this->getUser()->getAttribute('lat', '34.307144');
			$this->avr_lng = $this->getUser()->getAttribute('lng', '-10.546875');
		}
		$this->initial_data = $data['initial_data'];
		$this->setLayout('fullViewMapLayout');
	}

	$pricerange = Doctrine::getTable('Product')->minmaxPriceRange();
/*	print_r($pricerange);
		exit;
	//get Max & Min price values....	
	$this->maxprice = $pricerange['max'];
	$this->minprice = $pricerange['min'];
*/	$this->symbol = CurrencyTable::getInstance()->getSymbol("NOK");
	$this->maxprice = number_format($pricerange['max'] * CurrencyTable::getInstance()->getValue("NOK"), 2, '.', '');
	$this->minprice = number_format($pricerange['min'] * CurrencyTable::getInstance()->getValue("NOK"), 2, '.', '');
/*print_r($pricerange);
		exit;	
*/

	// to render categories
	$this->child_categories  = Doctrine::getTable('Category')->getBrowseCategories($browseParams);
    $this->parent_categories = Doctrine::getTable('Category')->getParentCategories($this->getUser()->getAttribute('clear_parent_category'), false, $this->getUser()->getCulture());
    $this->filter_attributes = Doctrine::getTable('Attribute')->getBrowseList($browseParams);
    $this->filtered_values   = Doctrine::getTable('AttributeValues')->getValuesByPrimaryKeys($attribute_value_ids);
    $this->xAreas            = Doctrine::getTable('XArea')->getBrowseList($browseParams);
	
    if (!$priceRange && $this->category->isComparable() && $xType != 'jobs')
    {
      $this->price_values = Doctrine::getTable('Product')->getPriceOption($browseParams);
    }
  
	$this->contentView				  = $contentView;
    $this->viewType                   = $viewType;
    $this->sortType                   = $sortType;
	$this->lastPosting 		          = $lastPosting;
    $this->xAreaId                    = $xAreaId;
    $this->xType                      = $xType;
    $this->priceRange                 = $priceRange;
    $this->query_string_array         = $query_string;
    $this->query_string_for_attribute = $query_string_for_attribute;
    $this->attribute_value_ids        = $attribute_value_ids;
	$this->category_id                = $category_id;
	
	unset($browseParams['culture']);
	unset($browseParams['status']);
	unset($browseParams['userId']);
	unset($browseParams['currencyCode']);
	$this->browseParams  = $browseParams;

	//echo "<PRE>";
    //print_r($browseParams);
	//echo "</PRE>"; 
	
	
    $this->customSelectedCategories = Doctrine::getTable('Category')->getSelectedCategories($category_id);
	$this->customSelectedLocations  = Doctrine::getTable('XArea')->getSelectedLocations($xAreaId);
    $this->query_string_for_selected_categories = $query_string_for_selected_categories;
    $this->is_array_category = $is_array_category;
    sfConfig::set('category_id', $category_id);


    // setup SEO title
    $title = array();
    foreach ($this->parent_categories as $c):
      $title[] = $c->getName();
    endforeach;
    unset($title[0]);
    $this->getResponse()->setTitle(implode(" | ", array_reverse($title)));

  }



  /**

   * Executes index action

   *

   * @param sfRequest $request A request object

   */
  
  public function executeLatest(sfWebRequest $request)

  {

    // for biznetwork home

    $sortType = 'date_desc';



    $this->products = Doctrine::getTable('Product')->getLatest(null, 8, true);



    $this->setLayout(false);

  }

  

    public function executeLatestProducts(sfWebRequest $request)

	{

	// for biznetwork home

	$sortType = 'date_desc';

	

	$this->products = Doctrine::getTable('Product')->getLatest(null, 8, true);

	}



  public function executeNewProdComment(sfWebRequest $request)

  {

    $this->form = new ProductCommentForm();

  }



  public function executeCreateComment(sfWebRequest $request)

  {



    if ($this->getRequest()->getMethod() != sfRequest::POST)

    {

      return $this->redirect("@homepage");

    }

    if ($request->getParameter('product_comment_body'))

    {

      $comment = new ProductComment();

      $comment->setProductId($request->getParameter('id'));

      $comment->setBody(strip_tags($request->getParameter('product_comment_body')));

      $comment->setUser($this->getUser()->getId());

      $comment->setCreatedAt(date('Y-m-d H:m:s', time()));

      $comment->save();



      $product = Doctrine::getTable('Product')->find($request->getParameter('id'));

      $user = Doctrine::getTable('User')->find($product->getUserId());

      if ($user)

      {

        if ($user->getId() != $this->getUser()->getId())

        {

          $mailTo = $user->getEmail();

          $mailSubject = __('User has been asking a question in your product.');

          $mailBody = $this->getPartial("mail/sendComment", array('product_id' => $product->getId(), 'product_name' => $product->getName(), 'username' => $this->getUser()->getFirstname()));

          $message = $this->getMailer()->compose(array('info@yozoa.mn' => 'yozoa'), $mailTo, $mailSubject, $mailBody);

          $message->setContentType("text/html");

          $this->getMailer()->send($message);

        }

      }



      return $this->renderComponent('product', 'comments', array('productId' => $request->getParameter('id'), 'comment_error' => 2));

    } else

    {

      return $this->renderComponent('product', 'comments', array('productId' => $request->getParameter('id'), 'comment_error' => 0));

    }

  }



  public function executeDeleteComment(sfWebRequest $request)

  {

    $this->forward404Unless($comment = Doctrine::getTable('ProductComment')->find(array($request->getParameter('id'))), sprintf('Object attribute does not exist (%s).', $request->getParameter('id')));

    $this->forward404Unless($product = Doctrine::getTable('Product')->find($comment->getProductId()));

    $this->forward404Unless($this->getUser()->getId() == $comment->getUser() || $product->getUserId() == $this->getUser()->getId());

    $notes = Doctrine::getTable('ProductComment')->getNotes($comment->getId());

    foreach ($notes as $note)

    {

      $note = Doctrine::getTable('ProductComment')->find($note->getId());

      $note->delete();

    }



    $comment->delete();







    return $this->renderComponent('product', 'comments', array('productId' => $comment->getProductId(), 'comment_error' => 2));

  }



  public function executeReply(sfWebRequest $request)

  {

    $this->commentId = $request->getParameter('commentId');

    $this->product_id = $request->getParameter('product_id');

  }



  public function executeReplyComment(sfWebRequest $request)

  {



    if ($this->getRequest()->getMethod() != sfRequest::POST)

    {

      return $this->redirect("@homepage");

    }

    $data['error'] = true;

    $comment = new ProductComment();

    $comment->setProductId($request->getParameter('product_id'));

    $comment->setType(1);

    $comment->setParentId($request->getParameter('commentId'));

    $comment->setBody(strip_tags($request->getParameter('product_comment_body')));

    $comment->setUser($this->getUser()->getId());

    $comment->setCreatedAt(date('Y-m-d H:m:s', time()));

    $comment->save();

    $data['error'] = false;

    $data['msg'] = "<div align='center'><br/><br/>".__('Thank you for your reply')."</div>";



    $questions = Doctrine::getTable('ProductComment')->getQuestion($request->getParameter('commentId'), $this->getUser()->getId());

    foreach ($questions as $question)

    {

      $user = Doctrine::getTable('User')->find($question->getUser());

      if ($user != $this->getUser()->getId() && $user)

      {

        $mailTo = $user->getEmail();

        $mailSubject = $this->getUser()->getFirstname() . __(' user write comment your replied product .');

        $mailBody = $this->getPartial("mail/replyComment", array('productId' => $question->getProductId(), 'username' => $this->getUser()->getFirstname()));

        $message = $this->getMailer()->compose(array('info@yozoa.mn' => 'yozoa'), $mailTo, $mailSubject, $mailBody);

        $message->setContentType("text/html");

        $this->getMailer()->send($message);

      }

    }



    $comment = Doctrine::getTable('ProductComment')->find($request->getParameter('commentId'));

    if ($comment->getUser() != $this->getUser()->getId() && $comment)

    {

      $user = Doctrine::getTable('User')->find($comment->getUser());

      $product = Doctrine::getTable('Product')->find($comment->getProductId());

      $mailTo = $user->getEmail();

      $mailSubject = 'In '.$product->getName() . __(' product you have added  ') . $this->getUser()->getUsername() . __(' user left a comment.');

      $mailBody = $this->getPartial("mail/answerOwner", array('productId' => $product->getId(), 'productName' => $product->getName(), 'username' => $this->getUser()->getUsername()));

      $message = $this->getMailer()->compose(array('info@yozoa.com' => 'Yozoa'), $mailTo, $mailSubject, $mailBody);

      $message->setContentType("text/html");

      $this->getMailer()->send($message);

    }

    return $this->renderText(json_encode($data));

  }



  public function executeNote(sfWebRequest $request)

  {

    $this->commentId = $request->getParameter('commentId');

  }



  public function executeAlbum(sfWebRequest $request)

  {
//echo "Request=".$request['product_id'];
    $this->product = Doctrine::getTable('Product')->find($request->getParameter('product_id'));
	//print_r($this->product);
	//exit;
    $this->parent_categories = Doctrine::getTable('Category')->getParentCategories($this->product->getCategoryId(), false, $this->getUser() ->getCulture());

    $this->optionalProductAttributes = $this->product->getProductAttributes(0, $this->getUser()->getCulture());

    $this->xType = $this->product->getCategoryType();

  }

  public function executeDisplayFullScreenImage(sfWebRequest $request)

  {
  	$this->product = Doctrine::getTable('Product')->find($request->getParameter('product_id'));
    $this->parent_categories = Doctrine::getTable('Category')->getParentCategories($this->product->getCategoryId(), false, $this->getUser() ->getCulture());

  }


  public function executeSendEmailOfSavedSearch(sfWebRequest $request)
  {
	if ($request->isXmlHttpRequest())
    {
    	
		$queryString    = $request->getParameter('queryString');
		$xType 	        = $request->getParameter('xType');
		$saveSearchName = $request->getParameter('saveSearchName');
		$emailDaily     = $request->getParameter('emailDaily');
		
		// Replace the '#' & '*' characters from query string. 
		$queryString = str_replace("#","=",str_replace("*","&",$queryString));
		
		//$test = explode('&',$queryString); 
		
		//print_r($test); exit;
		
		// Remove xType=.. from query string.
		$queryStr = explode('&',$queryString); 
		unset($queryStr[0]); 
		$queryString = implode('&',$queryStr);
		
		$server_name = $this->getContext()->getRequest()->getHost();
		$UrlOfSavedSearch = "http://".$server_name."/en/".$xType."/?".$queryString;  //echo "<br>".$UrlOfSavedSearch;
		
		$user = Doctrine::getTable('User')->find($this->getUser()->getId());
		$userId   = $user->getId();
		$userName = $user->getName();
		$emailId  = $user->getEmail();
		
		/*if ($emailId)
        {
          $mailTo = $emailId;
		  $mailSubject = 'Your saved Refine Search.';
          $mailBody = $this->getPartial("mail/emailSavedSearch", array('link' => $UrlOfSavedSearch, 'username' => $userName));
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
        } else {
			$this->getUser()->setFlash('error', 'failed to sent email.');
		}*/
		echo "To see your saved search click <a href='".$UrlOfSavedSearch."'> here.</a>";
		exit;
	}
  }
  
  function getProductDetails($pid)
  {
  	$productData = Doctrine::getTable('Product')->find($pid);
	$mainProductAttributes = $productData->getProductAttributes(1, "en");
	$attrArray = array("175","190","171");
	$data = array();
	foreach ($mainProductAttributes as $productAttribute){
		if(!in_array($productAttribute->getAttributeId(),$attrArray)) continue;
		if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")
		{

		  if(strlen($productAttribute->getAttributeValue()) > 20)
			  $data[] = substr($productAttribute->getAttributeValue(),'0','20');
		  else
			  $data[] = $productAttribute->getAttributeValue(); 
		} else

		{

		 $data[] = join(", ", $productAttribute->getProductAttributeValues(false,"en"));

		}
	}
  	return $data;
  }
  
  
  /*

   * return filterd data for map refine search.

   */

  public function returnMapRefineSearchData($query){
  	
	$mapData = array(); $j = 0;
	$minLat = 0; $maxLat = 0;
	$minLng = 0; $maxLng = 0;
	$favoriteProduct = array();
	if($this->getUser()->isAuthenticated()){
		$user = Doctrine::getTable('User')->find($this->getUser()->getId());
		$favoriteProduct = explode(",",$user->getFevorite_products());
		//$favoriteProduct = array("290","279","287");
	} 
	foreach($query as $result)
	{
		$mapData[$j]['id']    = $result->getId();
		if(strlen($result->getName()) > 60 )
			$mapData[$j]['name']  = substr_replace($result->getName(),"...",60);
		else
			$mapData[$j]['name']  = $result->getName();
		$mapData[$j]['price'] = $result->getPrice();
		$data = $this->getProductDetails($result->getId());
		if($data){
			$mapData[$j]['attrFlag'] = 1;
			$i = 1;
			foreach($data as $value){
				$mapData[$j]['attrFlag'.$i] = $value;
				$i++;
			}
		}else{
			$mapData[$j]['attrFlag'] = 0;
		}
		$mapData[$j]['img']   = $result->getImagePath("s_");
		if(in_array($result->getId(),$favoriteProduct))
			$mapData[$j]['imgcolor']   = 1;    // for favorite Product color.
		else
			$mapData[$j]['imgcolor']   = 2;	   // for general.
		if($result['XAreaLocation']['map_lat'])
			$mapData[$j]['lat']   = $result->XAreaLocation->getMapLat();
		else
			$mapData[$j]['lat']   = $result->XArea->getMapLat();
		if($result['XAreaLocation']['map_lng'])
			$mapData[$j]['lng']   = $result->XAreaLocation->getMapLng();
		else
			$mapData[$j]['lng']   = $result->XArea->getMapLng();
		// for min lat
		if($minLat == 0)
			$minLat = $mapData[$j]['lat'];
		else if($minLat > $mapData[$j]['lat'])
			$minLat = $mapData[$j]['lat'];
		// for min lng
		if($minLng == 0)
			$minLng = $mapData[$j]['lng'];
		else if($minLng > $mapData[$j]['lng'])
			$minLng = $mapData[$j]['lng'];
		// for max lat
		if($maxLat == 0)
			$maxLat = $mapData[$j]['lat'];
		else if($maxLat < $mapData[$j]['lat'])
			$maxLat = $mapData[$j]['lat'];
		// for max lng
		if($maxLng == 0)
			$maxLng = $mapData[$j]['lng'];
		else if($maxLng < $mapData[$j]['lng'])
			$maxLng = $mapData[$j]['lng'];
			
		$j++;
	}
	$data['avr_lat'] 	  = ($maxLat + $minLat)/2; 
	$data['avr_lng'] 	  = ($maxLng + $minLng)/2;
	$data['initial_data'] = json_encode($mapData);
  	return $data;
  }
  
  public function executeSale(sfWebRequest $request)

  {

    

  }
    
  public function setLanguageAndCurrancy()
  {
    if($this->getUser()->isAuthenticated()){
		$user = Doctrine::getTable('User')->find($this->getUser()->getId()); 
		//$culture = $user->getCulture(); 
		$culture = $user->getPrefferred_language(); 
		//echo "loged in User"; exit;
		$this->getUser()->setCulture($culture);
		
		// Set the language & currency value in session value.
		//$this->getUser()->setAttribute('language', $culture);
		//$this->getUser()->setAttribute('currency', $this->getUser()->getPreffCurrency());
		$_SESSION['currency'] = $user->getPrefferred_currency(); //$this->getUser()->getPreffCurrency();
	}else{ 

		if($this->getRequest()->getCookie('setLang') && $this->getRequest()->getCookie('setCurr')){
			$currency = $this->getRequest()->getCookie('setCurr');
			$culture  = $this->getRequest()->getCookie('setLang');
		}else{
			//Fetch value of lang. & curr. on the basis of IP address of site visitor.
			$userIPAdress = $_SERVER['REMOTE_ADDR'];//'81.167.189.211';//'192.168.10.121';//'79.160.0.0';//'79.160.0.0';//'62.16.128.0';//'114.143.117.86';//$_SERVER['REMOTE_ADDR'];
			$countryCode = Doctrine::getTable('Ipcountry')->getCountryCode($userIPAdress);
			foreach($countryCode as $data){
				$countryCodeISO1 = $data->getCountry_iso1();
			}
			$countryDetails = Doctrine::getTable('CountryLangCurr')->getCountryLanguageAndCurrency($countryCodeISO1);
			foreach($countryDetails as $value){
				$culture = strtolower($value->getLanguage_code());
				$currency = $value->getCurrency_code();
			}
			
			$avalableLanguagesCode = array_keys(Doctrine::getTable('Language')->getLangOption());
			if(!in_array($culture,$avalableLanguagesCode)){
				$culture = 'en';
			}
			
			$availableCurrencyCode = array_keys(Doctrine::getTable('Currency')->getCurrOptions());
			if(!in_array($currency,$availableCurrencyCode)){
				$currency = 'USD';
			}
			$this->getUser()->setLangAndCurrInCookie($currency, $culture, 'set');
		}

		$this->getUser()->setCulture($culture);
		$_SESSION['currency'] = $currency;
		// Set the language & currency value in session value.
		//$this->getUser()->setAttribute('language', $culture);
		//$this->getUser()->setAttribute('currency', "NOK");
	}
  }

}