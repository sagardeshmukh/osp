<?php



/**

 * User

 * 

 * This class has been auto-generated by the Doctrine ORM Framework

 * 

 * @package    yozoa

 * @subpackage model

 * @author     Falcon

 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $

 */

class User extends BaseUser

{

  public function getName()

  {

    return ucfirst($this->getInitial()).'. '.ucfirst($this->getFirstname());

  }



  public function setPassword($pass){

         if($pass){

             $this->_set('password', md5($pass));

         }

    }



}