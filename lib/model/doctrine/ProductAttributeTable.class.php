<?php

class ProductAttributeTable extends Doctrine_Table
{
  public function getQuery($product_id, $is_main = -1, $is_column = -1, $is_filter = -1, $culture = "")
  {
    $q = Doctrine_Query::create()
            ->select('pa.*')
            ->addSelect('COALESCE(ia.name, a.name) AS attribute_name')
            ->addSelect('a.type AS type')
            ->addSelect('a.is_required AS is_required')
            ->from('ProductAttribute pa')
            ->innerJoin('pa.Attribute a')
             ->leftJoin('a.I18nAttribute ia WITH ia.culture = ?', $culture)
            ->orderBy('a.sort_order')
            ->where('pa.product_id = ?', $product_id);
    if ($is_main != -1)
    {
      $q->andWhere('a.is_main = ?', $is_main);
    }
    if ($is_column != -1)
    {
      $q->andWhere('a.is_column = ?', $is_column);
    }
    if ($is_filter != -1)
    {
      $q->andWhere('a.is_filterable = ?', $is_filter);
    }
    //$q->andWhere('pa.attribute_id <> 98');
    return $q;
  }


  public function getProductAttributes($product_id, $is_main = -1, $is_column = -1, $is_filter = -1, $culture = "")
  {
    $q = $this->getQuery($product_id, $is_main, $is_column, $is_filter, $culture);
    $results = array();
    foreach($q->execute() as $row)
    {
      $results[$row->getAttributeId()] = $row;
    }
    return $results;
  }

  public function getProductAttributeByProductId($product_id)
  {
    $product_id = (int) $product_id;
    $q = Doctrine_Query::create()
            ->from('ProductAttribute pa')
            ->where('pa.product_id = ?', $product_id)
            ->andWhere('pa.attribute_id <> 98');
    return $q->execute();
  }

  public function getProductColumnAttribute($product_id, $attribute_ids = array(), $culture = "")
  {
    $q = $this->getQuery($product_id, -1, 1, -1, $culture);
    $q->andWhereIn('pa.attribute_id', $attribute_ids);
    return $q->execute();
  }

  public function findByProductAttribute($product_id, $attribute_id)
  {
    $q = Doctrine_Query::create()
            ->from('ProductAttribute as pa')
            ->andWhere('pa.product_id = ? AND pa.attribute_id = ?', array($product_id, $attribute_id));
    return $q->fetchOne();
  }
}