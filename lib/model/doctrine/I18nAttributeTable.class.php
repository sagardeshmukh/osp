<?php

class I18nAttributeTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('I18nAttribute');
  }

  static public function updateValues($attributeId, $culture, $name = null, $hint = null)
  {
    $object = self::getByAttributeIdAndCulture($attributeId, $culture);
    if (!$object)
    {
      $object = new I18nAttribute();
      $object->setAttributeId($attributeId);
      $object->setCulture($culture);
    }
    
    $object->setName($name ? $name : null);
    $object->setHint($hint ? $hint : null);
    $object->save();
  }

  static public function getByAttributeIdAndCulture($attributeId, $culture)
  {
    $q = Doctrine_Query::create()
            ->from('I18nAttribute ia')
            ->where('ia.attribute_id = ? AND ia.culture = ?', array($attributeId, $culture));
    return $q->fetchOne();
  }

}