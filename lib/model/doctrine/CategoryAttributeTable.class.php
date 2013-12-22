<?php



class CategoryAttributeTable extends Doctrine_Table

{

  public function getListByAttributeId($attribute_id)

  {

    $q = Doctrine_Query::create()

            ->select('ca.*, c.name AS category_name')

            ->from('CategoryAttribute ca')

            ->innerJoin('ca.Category c')

            ->where('ca.attribute_id = ?', $attribute_id);

    return $q->execute();

  }





  public function getMainAttributeList($category_id)

  {

    $q = Doctrine_Query::create()

            ->select('ca.*, a.name AS attribute_name, a.type AS type')

            ->from('CategoryAttribute ca')

            ->innerJoin('ca.Attribute a')

            ->where('ca.category_id = ?', $category_id)

            ->andWhere('a.is_column = 1')

            ->orderBy('a.sort_order');

    return $q->execute();

  }



  /**

   * 

   */

  public function countFilterableAttribute($category_id)

  {

    return Doctrine_Query::create()

            ->from('CategoryAttribute ca')

            ->innerJoin('ca.Attribute a WITH a.is_filterable=1')

            ->where('ca.category_id = ?', $category_id)

            ->count();

  }

}