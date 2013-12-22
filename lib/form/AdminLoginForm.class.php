<?php

/**
 * User form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AdminLoginForm extends sfForm
{
  protected $_object;


  public function getObject()
  {
    return $this->_object;
  }

  public function configure()
  {
    $this->widgetSchema['username']  = new sfWidgetFormInputText();
    $this->widgetSchema['password']  = new sfWidgetFormInputPassword();

    $this->widgetSchema->setLabels(array('username' => 'Name:'));
    $this->widgetSchema->setLabels(array('password' => 'Password:'));

    $this->validatorSchema['username'] = new sfValidatorString(
        array('required' => true),
        array('required' => 'Insert your username'));

    $this->validatorSchema['password'] = new sfValidatorString(
        array('required' => true),
        array('required' => 'Insert your password'));

    $this->widgetSchema->setNameFormat('login[%s]');

    $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'checkPassword')))
    );
  }
  
  public function checkPassword($validator, $values)
  {
        $this->_object = Doctrine::getTable('Admin')->getUserByNamePassword(
            $values['username'],
            $values['password']);
    
    if (!$this->_object)
    {
        
      // password is not correct, throw an error
      throw new sfValidatorError($validator, 'Invalid username or password');
    }
        
    // password is correct, return the clean values
    return $values;
  }
  
}
