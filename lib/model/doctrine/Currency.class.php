<?php

/**
 * Currency
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    yozoa
 * @subpackage model
 * @author     Falcon
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Currency extends BaseCurrency
{
  public function save(Doctrine_Connection $conn = null)
  {
    $this->setCode(strtoupper($this->getCode()));
    return parent::save($conn);
  }
}