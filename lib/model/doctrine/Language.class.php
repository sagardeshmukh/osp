<?php

/**
 * Language
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    yozoa
 * @subpackage model
 * @author     Falcon
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Language extends BaseLanguage
{
  public function save(Doctrine_Connection $conn = null)
  {
    $this->setCulture(strtolower($this->getCulture()));
    return parent::save($conn);
  }

  public function  __toString()
  {
      return $this->getName();
  }

}