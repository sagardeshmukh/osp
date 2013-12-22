<?php
class GuestbookForm extends BaseGuestbookForm
{
  public function configure()
  {
    unset($this['created_at']);
    $this->widgetSchema['name'] = new sfWidgetFormInputText(array('label' => 'Name'));
    $this->widgetSchema['confirmed'] = new sfWidgetFormInputCheckbox(array('label' => 'Active'), array('value'=>1));
    $this->widgetSchema['email'] = new sfWidgetFormInputText(array('label' => 'Email'));
    $this->widgetSchema['body'] = new sfWidgetFormTextarea(array('label' => 'Body'), array('cols' => 45, 'rows' => 8));
    $this->validatorSchema['body']     = new sfValidatorString(
            array('required' => true),
            array('required' => 'Insert your comment in here'));
    $this->validatorSchema['name']     = new sfValidatorString(
            array('required' => true),
            array('required' => 'Insert your name'));
    $this->validatorSchema['email']     = new sfValidatorEmail(
            array('required' => true),
            array('required' => 'Insert your email address'));
    $this->validatorSchema['email']->setMessage('invalid', 'Wrong email address');
    $this->setValidator['confirmed']  = new sfValidatorPass();
    $this->setValidator['body']  = new sfValidatorString(array('max_length' => 255));
  }
}
