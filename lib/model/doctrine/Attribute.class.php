<?php



/**

 * Attribute

 *

 * This class has been auto-generated by the Doctrine ORM Framework

 *

 * @package    yozoa

 * @subpackage model

 * @author     Falcon

 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $

 */

class Attribute extends BaseAttribute

{

  public function save(Doctrine_Connection $conn = null)

  {

//    if ($this->getIsMain())

//    {

//      $this->setIsRequired(true);

//    }

//    else

//    {

//      $this->setIsRequired(false);

//    }

    return parent::save($conn);

  }

}