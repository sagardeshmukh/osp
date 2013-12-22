<?php



class XAreaTable extends Doctrine_Table

{



  private $cat_options;



  public static function getInstance()

  {

    return Doctrine_Core::getTable('XArea');

  }



   /**

   * Reallocate left, right number

   */



  public static function rebuildLftRgt()

  {

    $results = Doctrine_Query::create()

            ->from('XArea x')

            ->orderBy('x.name')

            ->execute();



    $categories = array();

    foreach($results as $result)

    {

      $categories[$result->getParentId()][$result->getId()] = $result;

    }



    function reallocateLftRgt($categories, $parent_id, $number, $level)

    {

      foreach($categories[$parent_id] as $id => $category)

      {

        $category->setLft($number + 1);

        $category->setLvl($level);

        if (isset($categories[$id]))

        {

          $category->setRgt(reallocateLftRgt($categories, $id, $number + 1, $level+1));

        }

        else

        {

          $category->setRgt($number + 2);

        }

        $category->save(null, false);

        $number = $category->getRgt();

      }

      return $number + 1;

    }



    if (isset($categories[-1]))

    {

      reallocateLftRgt($categories, -1, 0, 0);

    }

  }





  public function getChildren($xAreaId)

  {

    return Doctrine_Query::create()

        ->from('XArea x')

        ->where('x.parent_id = ?', $xAreaId)

        ->andWhere('x.id <> 0')

        ->execute();

  }



  public function getChildrenOption($xAreaId)

  {

    foreach ($this->getChildren($xAreaId) as $xArea)

    {

      $data[$xArea->getId()] = $xArea->getName();

    }

    return $data;

  }



  public function getParentAreas($child_id)

  {

    $q = Doctrine_Query::create()

            ->select('parent.*')

            ->from('XArea parent')

            ->addFrom('XArea node')

            ->orderBy('parent.lft')

            ->where('node.id = ?', $child_id)

            ->andWhere('node.lft BETWEEN parent.lft AND parent.rgt');



    return $q->execute();

  }



  public function getBrowseList($params = array())

  {

     $categoryId = $params['categoryId'];

     $xAreaId = $params['xAreaId'];

     $attributeValueIds = isset($params['attributeValueIds']) ? $params['attributeValueIds'] : array();

     $priceRange = isset($params['priceRange']) ? $params['priceRange'] : '';

     $currencyCode = isset($params['currencyCode']) ? $params['currencyCode'] : 'USD';

     $userId = isset($params['userId']) ? $params['userId'] : 0;



     $q = Doctrine_Query::create()

            ->select('p_x.*, COUNT(p_x.id) AS nb_product')

            ->addFrom('XArea p_x')

            ->addFrom('XArea n_x')

            ->addFrom('Category c2')

            ->addFrom('Category c')

            ->addFrom('Product p')

            ->where('p.category_id = c.id')

            ->andWhere('p.x_area_id = n_x.id')

			->andWhereIn('p_x.parent_id', $xAreaId)

            //->andWhere('p_x.parent_id = ?', $xAreaId)

            ->andWhereIn('c2.id', $categoryId)

            ->andWhere('c.rgt=(c.lft + 1)')

            ->andWhere('n_x.lft BETWEEN p_x.lft AND p_x.rgt')

            ->andWhere('c.lft BETWEEN c2.lft AND c2.rgt')

            ->andWhere('p.status=1')

            ->groupBy('p_x.id');



  	if ($userId > 0) //from user

    {

      $q->andWhere('p.user_id = ?', $userId);

    }



    if (count($attributeValueIds))

    {

      $q->addWhere("MATCH(p.attribute_value_ids) AGAINST('".implode(" ,", $attributeValueIds)."' IN BOOLEAN MODE)");
	  //$q->addWhere("MATCH(p.attribute_value_ids) AGAINST('+".join(" +", $attributeValueIds)."' IN BOOLEAN MODE)");

    }

    //price

    if ($priceRange && strpos($priceRange, '-') !== false)

    {

      list($min_price, $max_price) = explode('-', $priceRange);



      $max_price = (int) $max_price;

      $max_price = CurrencyTable::convertToGlobal($currencyCode, $max_price);

      $min_price = (int) $min_price;

      $min_price = CurrencyTable::convertToGlobal($currencyCode, $min_price);



      if ($max_price == 0 && $min_price > 0){

        $q->addWhere("p.price_global >= ?", $min_price);

      } elseif ($max_price > 0 && $min_price == 0) {

        $q->addWhere("p.price_global <= ?", $max_price);

      } elseif ($max_price > 0 && $min_price > 0) {

        $q->addWhere("p.price_global >= ? AND p.price_global <= ?", array($min_price, $max_price));

      }

    }

    return $q->execute();

  }



  //parents string

  public function getParents($child_id)

  {

    $q = Doctrine_Query::create()

            ->select('parent.*')

            ->from('XArea parent')

            ->addFrom('XArea node')

            ->orderBy('parent.lft')

            ->where('node.id = ?', $child_id)

            ->andWhere('parent.id <> 0')

            ->andWhere('node.lft BETWEEN parent.lft AND parent.rgt');



    $parents = $q->execute();

    $data = '';

    foreach($parents as $index => $parent){



        $data .= $index <> 0 ?  ','.$parent->getName(): $parent->getName();

    }



    return $data;

  }



  //search xarea by name

  public static function searchQuery($keyword){

      $q = Doctrine_Query::create()

      ->select('p.*')

      ->from('XArea p')

      ->where('p.name LIKE ?', '%'.$keyword.'%');



      return $q->fetchOne();

  }





  public static function getRealEstateArea($params = array())

  {

    $xAreaId = isset($params['xAreaId'])? $params['xAreaId']: 0;

    $categoryId = $params['categoryId'] ? $params['categoryId']: 0;

    $xType = isset($params['xType']) ? $params['xType']: 0;

//    $xType = $params['xType'];

//    $rAttributeValueIds = isset($params['rAttributeValueIds']) ? $params['rAttributeValueIds'] : array();

//    $oAttributeValueIds = isset($params['oAttributeValueIds']) ? $params['oAttributeValueIds'] : array();

//    $keywords = isset($params['keywords']) ? $params['keywords'] : '';

//    $sordOrder = isset($params['sordOrder']) ? $params['sordOrder'] : 'date_desc';

    $priceRange = isset($params['priceRange']) ? $params['priceRange'] : '';

    $squareRange = isset($params['squareRange']) ? $params['squareRange'] : '';



      $q = Doctrine_Query::create()

            ->select('p_x.*, COUNT(p_x.id) AS nb_product')

            ->addFrom('XArea p_x')

            ->addFrom('XArea n_x')

            ->addFrom('Category c2')

            ->addFrom('Category c')

            ->addFrom('Product p')

            ->where('p.category_id = c.id')

            ->andWhere('p.x_area_id = n_x.id')

            ->andWhere('p_x.parent_id = ?', $xAreaId)

            ->andWhere('c2.id = ?', $categoryId)

            ->andWhere('c.rgt=(c.lft + 1)')

            ->andWhere('n_x.lft BETWEEN p_x.lft AND p_x.rgt')

            ->andWhere('c.lft BETWEEN c2.lft AND c2.rgt')

            ->andWhere('p.status=1')

            ->groupBy('p_x.id');



      switch($xType){

          case 'realestate':

              $q->innerJoin('p.RealEstate r_x');

              break;

          case 'rental':

              $q->innerJoin('p.Rental r_x');

              break;

          default:

              $q->innerJoin('p.RealEstate r_x');

              break;

      }



    //price range/

        if ($priceRange && strpos($priceRange, '-') !== false)

        {

            list($min_price, $max_price) = explode('-', $priceRange);

            $max_price = (int) $max_price;

            $min_price = (int) $min_price;



            if ($max_price == 0 && $min_price > 0)

            {

                $q->addWhere("p.price_global >= ?", $min_price);

            } elseif ($max_price > 0 && $min_price == 0)

            {

                $q->addWhere("p.price_global <= ?", $max_price);

            } elseif ($max_price > 0 && $min_price > 0)

            {

                $q->addWhere("p.price_global >= ? AND p.price_global <= ?", array($min_price, $max_price));

            }

        }



        //square range/

        if ($squareRange && strpos($squareRange, '-') !== false)

        {

            list($min_square, $max_square) = explode('-', $squareRange);

            $max_square = (int) $max_square;

            $min_square = (int) $min_square;



            if ($max_square == 0 && $min_square > 0)

            {

                $q->addWhere("r_x.total_area >= ?", $min_square);

            } elseif ($max_square > 0 && $min_square == 0)

            {

                $q->addWhere("r_x.total_area <= ?", $max_square);

            } elseif ($max_square > 0 && $min_square > 0)

            {

                $q->addWhere("r_x.total_area >= ? AND r_x.total_area <= ?", array($min_square, $max_square));

            }

        }



    return $q->execute();

  }



  public static function getRealEstateSearch($params = array())

  {

    $keyword = $params['keyword'];

    $is_many = $params['is_many'];

    

    $q = Doctrine_Query::create()

            ->select('p_x.*, COUNT(p_x.id) AS nb_product')

            ->addFrom('XArea p_x')

            ->addFrom('XArea n_x')

            ->addFrom('Product p')

            ->innerJoin('p.RealEstate r_x')

            ->where('p.x_area_id = n_x.id')

            ->andWhere("p_x.id <> 0")

            ->andWhere("p_x.name LIKE ?", '%'.$keyword.'%')

            ->andWhere('n_x.lft BETWEEN p_x.lft AND p_x.rgt')

            ->andWhere('p.status=1')

            ->groupBy('p_x.id');



    if($is_many == true){

        return $q->execute();

    }else{

        return $q->fetchOne();

    }

    

  }



  public function formatCategory($level, $parent_id, $nested_category)

  {

    foreach ($nested_category[$parent_id] as $id => $name)

    {

      $this->cat_options[$id] = str_repeat('&nbsp;', $level * 8) . $name;

      if (isset($nested_category[$id]))

      {

        $this->formatCategory($level + 1, $id, $nested_category);

      }

    }

  }



  /**

   * return formatted array

   * @param integer $self_ids

   * @return array

   */

  public function getParentOptions($self_ids = 0, $lvl = "")

  {

    //if (!is_array($self_ids)) $self_ids = (array) $self_ids;

    //first select categories

    $q = Doctrine_Query::create()

            ->select('x.*')

            ->from('XArea x')

            ->andWhereNotIn('x.id', (array) $self_ids);

    if($lvl){

        $q->andWhere("x.lvl = ?", $lvl);

    }

    $xareas = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);



    $nested_category = array();

    foreach ($xareas as $xarea)

    {

      //$nested_category[$category->getParentId()][$category->getId()] = $category->getName();

      $nested_category[$xarea['parent_id']][$xarea['id']] = $xarea['name'];

    }

    if (isset($nested_category[0]))

    {

      $this->formatCategory(0, 0, $nested_category);

    }



    return $this->cat_options;

  }
  
  public function getSelectedLocations($xAreaId)

  {

    $q = Doctrine_Query::create()

            ->select('x.*')

            ->addFrom('XArea x')

            ->whereIn('x.id', $xAreaId);

    return $q->execute();

  }

}