<?php

class CurrencyTable extends Doctrine_Table
{
  private $_currOptions = null;

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Currency');
  }

  private function buildOptions()
  {
    if (is_null($this->_currOptions))
    {
      $q = Doctrine_Query::create()
              ->from('Currency c');

      $rows = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
      foreach ($rows as $row)
      {
        $this->_currOptions[$row['code']] = $row;
      }
    }
  }

  public function getCurrOptions()
  {
    $this->buildOptions();
    $option = array();
    foreach ($this->_currOptions as $row){
      $option[$row['code']] = $row['name'];
    }
    return $option;
  }

  public function getValue($code)
  {
    $code = strtoupper($code);
    $this->buildOptions();
    if (isset($this->_currOptions[$code])) {
      return $this->_currOptions[$code]['value'];
    }
    return 1;
  }

  public function getSymbol($code)
  {
    $code = strtoupper($code);
    $this->buildOptions();
    if (isset($this->_currOptions[$code])) {
      return $this->_currOptions[$code]['symbol'];
    }
    return '';
  }

  static public function convertToGlobal($code, $value)
  {
    $perValue = self::getInstance()->getValue($code);
    return $value / $perValue;
  }
}