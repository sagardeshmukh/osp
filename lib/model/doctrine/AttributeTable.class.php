<?php



class AttributeTable extends Doctrine_Table

{  

  public function getTypes()

  {

    return array(

            'textbox'   => 'textbox',

            'checkbox'  => 'checkbox',

            'selectbox' => 'selectbox',

            'textarea'  => 'textarea',

    );

  }



  public function getAttributeByCategoryId($category_id, $culture = "")

  {

    $q = Doctrine_Query::create()

            ->select('a.*')

            ->addSelect('COALESCE(ia.name, a.name) AS name')

			->addSelect('COALESCE(ia.hint, a.hint) AS hint')

            ->from('Attribute a')

            ->leftJoin('a.I18nAttribute ia WITH ia.culture = ?', $culture)

            ->innerJoin('a.CategoryAttribute ca')

            ->orderBy('a.sort_order')

            ->where('ca.category_id = ?', $category_id);

    return $q->execute();

  }



  public function getAttributesByProductIds($productIds = array(), $culture = "")

  {

    $q = Doctrine_Query::create()

            ->select('a.*')

            ->addSelect('COALESCE(ia.name, a.name) AS name')

            ->from('Attribute a')

            ->leftJoin('a.I18nAttribute ia WITH ia.culture = ?', $culture)

            ->innerJoin('a.ProductAttribute p1')

            ->orderBy('a.sort_order')

            ->distinct()

            ->andWhereIn('p1.product_id', $productIds);

    return $q->execute();

  }



  /**

   *

   * @param integer $categoryId

   * @param array $keywords

   * @param array $rAttributeValueIds (required)

   * @param array $oAttributeValueIds (optional)

   * @param string $priceRange

   * @return Doctrine_Collection

   */

  public function getSearchList($categoryIds, $xAreaIds, $rAttributeValueIds = array(), $oAttributeValueIds = array(), $keywords = array(), $priceRange = '')

  {

    $categoryIds = (array) $categoryIds;

    $xAreaIds = (array) $xAreaIds;

    

    $q = Doctrine_Query::create()

            ->select('a.*')

            ->from('Attribute a')

            ->innerJoin('a.CategoryAttribute ca')

            ->innerJoin('a.ProductAttribute p1')

            ->innerJoin('p1.Product p2')

            ->innerJoin('p2.XArea x_node')

            ->innerJoin('p2.XArea x_parent ON x_node.lft BETWEEN x_parent.lft AND x_parent.rgt');

    

    $q->andWhereIn('p2.category_id', $categoryIds)

            ->andWhere('a.is_filterable = 1')

            ->andWhere('a.type <> "textarea"')

            ->andWhere('a.type <> "textbox"')

            ->andWhere('ca.category_id = ?', $categoryId)

            ->andWhereIn('x_parent.id', $xAreaIds)

            ->andWhere('p2.status = 1')

            ->groupBy('a.id');



    $whereOr = array();

    //attribute values ids

    if (count($rAttributeValueIds))

    {

      $q->addWhere("MATCH(p2.attribute_value_ids) AGAINST('+".join(" +", $rAttributeValueIds)."' IN BOOLEAN MODE)");

    }



    if (count($keywords))

    {

      $whereOr[] = "MATCH(p2.name) AGAINST('".join(" ", $keywords)."' IN BOOLEAN MODE)";

    }

    if (count($oAttributeValueIds))

    {

      $whereOr[] = "MATCH(p2.attribute_value_ids) AGAINST('".join(" ", $oAttributeValueIds)."' IN BOOLEAN MODE)";

    }

    if (count($whereOr))

    {

      $q->andWhere("(".join(" OR ", $whereOr).")");

    }



    //price range/

    if ($priceRange && strpos($priceRange, '-') !== false)

    {

      list($min_price, $max_price) = explode('-', $priceRange);

      $max_price = (int) $max_price;

      if ($max_price == "more" || $max_price == 0)

      {

        $q->addWhere("p2.price_global > ?", array((int)$min_price));

      }

      else

      {

        $q->addWhere("p2.price_global > ? AND p2.price_global <= ?", array((int)$min_price, $max_price));

      }

    }



    return $q->execute();



  }



  /**

   * return filter list

   * @param integer $category_id

   * @param array $attribute_value_ids

   * @param string $priceRange

   * @return <type>

   */



  public function getBrowseList($params = array())

  {

     $categoryId = $params['categoryId'];

     $xAreaId = $params['xAreaId'];

    $attributeValueIds = isset($params['attributeValueIds']) ? $params['attributeValueIds'] : array();

    $priceRange = isset($params['priceRange']) ? $params['priceRange'] : '';

    $currencyCode = isset($params['currencyCode']) ? $params['currencyCode'] : 'USD';

    $userId = isset($params['userId']) ? $params['userId'] : 0;

    $culture = isset($params['culture']) ? $params['culture'] : "";



    $q = Doctrine_Query::create()

            ->select('a.*')

            ->addSelect('COALESCE(ia.name, a.name) AS name')

            ->from('Attribute a')

            ->leftJoin('a.I18nAttribute ia WITH ia.culture = ?', $culture)

            ->innerJoin('a.CategoryAttribute ca')

            ->innerJoin('a.ProductAttribute p1')

            ->innerJoin('p1.Product p2')

            ->innerJoin('p2.Category node')

            ->innerJoin('p2.Category parent ON node.lft BETWEEN parent.lft AND parent.rgt')

            ->innerJoin('p2.XArea x_node')

            ->innerJoin('p2.XArea x_parent ON x_node.lft BETWEEN x_parent.lft AND x_parent.rgt')

            ->andWhereIn('ca.category_id', $categoryId)

            ->andWhere('a.is_filterable = 1')

            ->andWhere('a.type <> "textarea"')

            ->andWhere('a.type <> "textbox"')

            ->andWhere('node.rgt=(node.lft + 1)')

            ->andWhereIn('parent.id', $categoryId)

			->andWhereIn('x_parent.id', $xAreaId)

            //->andWhere('x_parent.id = ?', $xAreaId)

            ->andWhere('p2.status = 1')

            ->groupBy('a.id');

	

    //attribute values ids

    if (count($attributeValueIds))

    {

      //$q->addWhere("MATCH(p2.attribute_value_ids) AGAINST('+".join(" +", $attributeValueIds)."' IN BOOLEAN MODE)");
	  $q->addWhere("MATCH(p2.attribute_value_ids) AGAINST('".implode(", ", $attributeValueIds)."' IN BOOLEAN MODE)");

    }



    //price range/

    if ($priceRange && strpos($priceRange, '-') !== false)

    {

      list($min_price, $max_price) = explode('-', $priceRange);



      $max_price = (int) $max_price;

      $max_price = CurrencyTable::convertToGlobal($currencyCode, $max_price);

      $min_price = (int) $min_price;

      $min_price = CurrencyTable::convertToGlobal($currencyCode, $min_price);



      if ($max_price == 0 && $min_price > 0){

        $q->addWhere("p2.price_global >= ?", $min_price);

      } elseif ($max_price > 0 && $min_price == 0) {

        $q->addWhere("p2.price_global <= ?", $max_price);

      } elseif ($max_price > 0 && $min_price > 0) {

        $q->addWhere("p2.price_global >= ? AND p2.price_global <= ?", array($min_price, $max_price));

      }

    }
//echo $q->getSQLQuery(); 
//echo "<br>count".count($q->execute());
//exit;
    
    return $q->execute();

  }



      /**

       *

       * @param array $keyword

       * @return array

       */

      public function searchByKeyword($keyword)

      {

        $q = Doctrine_Query::create()

                ->from('Attribute c')

                ->where("c.name LIKE ?", '%'.$keyword.'%');



        return $q->execute();

      }



      public function getFilterableAttributeByCategoryId($category_id, $culture = "")

      {

        $q = Doctrine_Query::create()

                ->select('a.*')

                ->addSelect('COALESCE(ia.name, a.name) AS name')

                ->from('Attribute a')

                ->leftJoin('a.I18nAttribute ia WITH ia.culture = ?', $culture)

                ->innerJoin('a.CategoryAttribute ca')

                ->orderBy('a.sort_order')

                ->where('ca.category_id = ?', $category_id)

                ->andWhere('a.is_filterable = 1')

                ->andWhere('a.is_main <> 1');

        return $q->execute();

      }

}