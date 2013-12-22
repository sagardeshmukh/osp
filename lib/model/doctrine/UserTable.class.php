<?php



class UserTable extends Doctrine_Table

{

  public function getUserByNamePassword($username, $password)

  {

    $q = Doctrine_Query::create()

            ->from('User u')

            ->where('(u.username = ? OR u.email = ?) AND u.password = ?', array($username, $username, md5($password)));

    return $q->fetchOne();

  }

    

  public function getByUsername($username)

  {

       $q = Doctrine_Query::create()

            ->from('User u')

            ->where('u.username = ? ', $username);

      return $q->fetchOne();

  }
  
  public function getUserDetails($user_id){

    $q = Doctrine_Query::create()            
            
			->from('User')
            
			->where('id = ?', $user_id);
			
    return $q->execute();

  }

}