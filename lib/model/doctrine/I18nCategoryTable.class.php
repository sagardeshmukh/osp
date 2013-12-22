<?php

class I18nCategoryTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('I18nCategory');
  }

  static public function updateValues($categoryId, $culture, $name = null)
  {
    $object = self::getByCategoryIdAndCulture($categoryId, $culture);
    if (!$object)
    {
      $object = new I18nCategory();
      $object->setCategoryId($categoryId);
      $object->setCulture($culture);
    }
    
    $object->setName($name ? $name : null);
    $object->save();
  }

  static public function getByCategoryIdAndCulture($categoryId, $culture)
  {
    $q = Doctrine_Query::create()
            ->from('I18nCategory ic')
            ->where('ic.category_id = ? AND ic.culture = ?', array($categoryId, $culture));
    return $q->fetchOne();
  }
}