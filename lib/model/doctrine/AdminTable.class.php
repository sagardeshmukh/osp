<?php


class AdminTable extends Doctrine_Table
{
    
  public static $_types = array('Сэтгүүлч', 'Админ', 'Зар оруулагч');
  public static function getTypes()
  {
    return self::$_types;
  }
  public function getUserByNamePassword($username, $password)
  {
    $q = Doctrine_Query::create()
        ->from('Admin u')
        ->where('u.username = ? AND u.password = ?', array($username, md5($password)));
       return $q->fetchOne();
  }

  public function getSearchQuery($username = null)
  {
    $q = Doctrine_Query::create()
        ->from('Admin u');

    if ($username){
      $q->where("u.username LIKE '". mysql_escape_string($username)."%'");
    }

    return $q;
  }
}