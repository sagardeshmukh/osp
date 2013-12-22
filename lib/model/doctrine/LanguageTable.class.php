<?php

class LanguageTable extends Doctrine_Table
{
  static $_languages = null;

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Language');
  }

  private static function generateInstance()
  {
    if (is_null(self::$_languages))
    {
      self::$_languages = array();
      $rows = Doctrine_Query::create()
              ->from('Language l')
              ->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
      foreach ($rows as $row)
      {
        self::$_languages[$row['culture']] = $row;
      }
    }
  }

  public static function getLangOption()
  {
    self::generateInstance();

    $option = array();
    foreach (self::$_languages as $code => $row)
    {
      $option[$row['culture']] = $row['name'];
    }
    return $option;
  }

  public static function getPreffCurrency($culture)
  {
    self::generateInstance();
    $rows = self::$_languages;
    if (isset($rows[$culture])){
      return $rows[$culture]['prefferred_currency'];
    }
    return false;
  }
}