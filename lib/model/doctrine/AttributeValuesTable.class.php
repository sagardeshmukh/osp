<?php



class AttributeValuesTable extends Doctrine_Table

{

  public function getAttributeValues($attribute_id, $culture = "")

  {

    $q = Doctrine_Query::create()

            ->select('av.*')

            ->addSelect('COALESCE(iav.value, av.value) AS value')

            ->from('AttributeValues av')

            ->leftJoin('av.I18nAttributeValues iav WITH iav.culture = ?', $culture)

            ->where('av.attribute_id = ?', $attribute_id)

            ->orderBy('av.sort_order ASC');

    return $q->execute();

  }



  public function getValueOption($attribute_id, $include_blank = false, $culture = "")

  {

    $attributes = $this->getAttributeValues($attribute_id, $culture);

    $option = array();

    if ($include_blank)

    {

      $option[] = "-";

    }

    foreach($attributes as $attribute)

    {

      $option[$attribute->getId()] = $attribute->getValue();

    }

    return $option;

  }



  public function getSearchValues($categoryId, $xAreaId, $attributeId, $rAttributeValueIds = array(), $oAttributeValueIds = array(), $keywords = array(), $priceRange = '')

  {

    $q = Doctrine_Query::create()

            ->select('av.*, COUNT(p3.id) AS nb_product')

            ->from('AttributeValues av')

            ->innerJoin('av.ProductAttributeValue p1')

            ->innerJoin('p1.ProductAttribute p2')

            ->innerJoin('p2.Product AS p3')

            ->innerJoin('p3.XArea x_node')

            ->innerJoin('p3.XArea x_parent ON x_node.lft BETWEEN x_parent.lft AND x_parent.rgt')

            ->innerJoin('p3.Category n_c')

            ->innerJoin('p3.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

            ->where('av.attribute_id = ?', $attributeId)

            ->andWhere('p_c.id = ?', $categoryId)

            ->andWhere('x_parent.id = ?', $xAreaId)

            ->andWhere('n_c.rgt=(n_c.lft + 1)')

            ->addWhere('p3.status = 1')

            ->groupBy('av.id')

            ->orderBy('av.sort_order ASC');



    if (count($rAttributeValueIds))

    {

      $q->addWhere("MATCH(p3.attribute_value_ids) AGAINST('+".join(" +", $rAttributeValueIds)."' IN BOOLEAN MODE)");

    }



    if (count($keywords))

    {

      $whereOr[] = "MATCH(p3.name) AGAINST('".join(" ", $keywords)."' IN BOOLEAN MODE)";

    }

    if (count($oAttributeValueIds))

    {

      $whereOr[] = "MATCH(p3.attribute_value_ids) AGAINST('".join(" ", $oAttributeValueIds)."' IN BOOLEAN MODE)";

    }

    if (count($whereOr))

    {

      $q->andWhere("(".join(" OR ", $whereOr).")");

    }



    //////////////

    //price range/

    //////////////



    if ($priceRange && strpos($priceRange, '-') !== false)

    {

      list($min_price, $max_price) = explode('-', $priceRange);

      $max_price = (int) $max_price;

      if ($max_price == "more" || $max_price == 0)

      {

        $q->addWhere("p3.price_global > ?", array((int)$min_price));

      }

      else

      {

        $q->addWhere("p3.price_global > ? AND p3.price_global <= ?", array((int)$min_price, $max_price));

      }

    }



    return $q->execute();

  }







  public function getValues($params = array())

  {

    $categoryId = $params['categoryId'];

    $xAreaId = $params['xAreaId'];

    $attributeId = isset($params['attributeId']) ? $params['attributeId'] : 0;
    $attributeValueIds = isset($params['attributeValueIds']) ? $params['attributeValueIds'] : array();

    $priceRange = isset($params['priceRange']) ? $params['priceRange'] : '';

    $currencyCode = isset($params['currencyCode']) ? $params['currencyCode'] : 'USD';

    $userId = isset($params['userId']) ? $params['userId'] : 0;

    $culture = isset($params['culture']) ? $params['culture'] : "";



    $q = Doctrine_Query::create()

            ->select('av.*')

            ->addSelect('COUNT(p3.id) AS nb_product')

            ->addSelect('COALESCE(iav.value, av.value) AS value')

            ->from('AttributeValues av')

            ->leftJoin('av.I18nAttributeValues iav WITH iav.culture = ?', $culture)

            ->innerJoin('av.ProductAttributeValue p1')

            ->innerJoin('p1.ProductAttribute p2')

            ->innerJoin('p2.Product AS p3')

            ->innerJoin('p3.Category n_c')

            ->innerJoin('p3.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

            ->innerJoin('p3.XArea x_node')

            ->innerJoin('p3.XArea x_parent ON x_node.lft BETWEEN x_parent.lft AND x_parent.rgt')

            ->where('av.attribute_id = ?', $attributeId)

            ->andWhereIn('p_c.id', $categoryId)

//            ->andWhere('x_parent.id = ?', $xAreaId)

			->andWhereIn('x_parent.id', $xAreaId)

            ->andWhere('n_c.rgt=(n_c.lft + 1)')

            ->addWhere('p3.status = 1')

            ->groupBy('av.id')

            ->orderBy('av.sort_order ASC');



    if (count($attributeValueIds))

    {
	  $q->addWhere("MATCH(p3.attribute_value_ids) AGAINST('".implode(", ", $attributeValueIds)."' IN BOOLEAN MODE)");
      //$q->addWhere("MATCH(p3.attribute_value_ids) AGAINST('+".join(" +", $attributeValueIds)."' IN BOOLEAN MODE)");

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

        $q->addWhere("p3.price_global >= ?", $min_price);

      } elseif ($max_price > 0 && $min_price == 0) {

        $q->addWhere("p3.price_global <= ?", $max_price);

      } elseif ($max_price > 0 && $min_price > 0) {

        $q->addWhere("p3.price_global >= ? AND p3.price_global <= ?", array($min_price, $max_price));

      }

    }

    return $q->execute();

  }



  public function getValuesByPrimaryKeys($value_ids = array(), $culture = "")

  {

    if (count($value_ids) == 0)

    {

      return array();

    }

    $q = Doctrine_Query::create()

            ->select('av.*')

            ->addSelect('a.name AS attribute_name')

            ->addSelect('COALESCE(iav.value, av.value) AS value')

            ->from('AttributeValues av')

            ->leftJoin('av.I18nAttributeValues iav WITH iav.culture = ?', $culture)

            ->innerJoin('av.Attribute a')

            ->andWhereIn('av.id', $value_ids);

    return $q->execute();

  }



  /**

   *

   * @param integer $pav_id Product Attribute Value Id

   * @param integer $a_id Attribute Id

   */

  public function getProductAttributeValues($pav_id, $a_id, $include_null = true, $culture = "")

  {

    $q = Doctrine_Query::create()

            ->select('av.*')

            ->addSelect('(CASE WHEN pav.product_attribute_id IS NULL THEN 0 ELSE 1 END) AS checked')

            ->addSelect('COALESCE(iav.value, av.value) AS value')

            ->from('AttributeValues av')

            ->leftJoin('av.I18nAttributeValues iav WITH iav.culture = ?', $culture)

            ->leftJoin('av.ProductAttributeValue pav WITH pav.product_attribute_id = ?', $pav_id)

            ->where('av.attribute_id = ?', $a_id)

            ->orderBy('av.sort_order');

    if (!$include_null)

    {

      $q->andWhere('pav.product_attribute_id IS NOT NULL');

    }

    $rows = array();

    foreach($q->execute() as $row)

    {

      $rows[] = $row;

    }

    return $rows;

  }



  public function getIdsByKeywords($keywords = array())

  {

    $q = Doctrine_Query::create()

            ->from('AttributeValues av')

            ->where("av.value REGEXP '[[:<:]]".join("|", $keywords)."[[:>:]]'");

    $results = $q->execute();

    $ids     = array();

    foreach($results as $result)

    {

      $ids[] = $result->getId();

    }

    return $ids;

  }

}