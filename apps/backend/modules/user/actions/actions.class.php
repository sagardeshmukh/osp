<?php

/**
 * Admin actions.
 *
 * @package    sf_sandbox
 * @subpackage Admin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserActions extends sfActions
{
  /**
   *
   * @param sfWebRequest $request
   */
  public function executeLogin(sfWebRequest $request)
  {
    $this->form = new AdminLoginForm();
    if ($request->isMethod('post'))
    {

      $this->form->bind($request->getParameter($this->form->getName()));
      //checking Admin login action

      if ($this->form->isValid())
      {     
          $this->getUser()->signIn($this->form->getObject());
          
          $this->redirect('public/home');
      }
      
      }
   
  }

  /**
   * Admin Logout
   */
  public function executeLogout()
  {
    $this->getUser()->signOut();
    $this->redirect('user/login');
  }

}
