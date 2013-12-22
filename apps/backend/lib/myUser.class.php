<?php

class myUser extends sfBasicSecurityUser
{
  private $_instance;

  /**
   * Get User profile
   * @return User
   */
  public function getInstance()
  {
    if (!$this->isAuthenticated())
    {
      return null;
    }
    if (!isset($this->_instance))
    {
      $this->_instance = Doctrine::getTable('Admin')->find($this->getUserId());
    }
    return $this->_instance;
  }

  /**
   * Sign In user
   * @param User $user
   */
  public function signIn(Admin $user)
  {
    $this->setAuthenticated(true);
 
    $this->addCredential('admin');
    $this->setAttribute('userId' , $user->getId(), 'yozoa');

    //cyyld nevterch orson ognoo
    $user->setLastLoggedAt(date("Y-m-d H:i:s", time()));
    $user->save();
   }

  /**
   * User sign out
   */
  public function signOut()
  {
    $this->clearCredentials();
    $this->setAuthenticated(false);
  }

  /**
   * get Logged user id
   * @return integer
   */
  public function getUserId()
  {
    if ($this->isAuthenticated())
    {
      return $this->getAttribute('userId', 0, 'yozoa');
    }
    return null;
  }
}
