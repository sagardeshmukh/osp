<?php 
class ResetPasswordForm extends sfForm
{
  public function configure()
  {
    	
	$i18n = sfContext::getInstance()->getI18N();
	
	$this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('id' => 'username', 'size' => 25));

    $this->widgetSchema['nPassword'] = new sfWidgetFormInputPassword(array(), array('size' => 25));

    $this->widgetSchema->setLabels(array('password' => $i18n->__('New password').'* :'));

    $this->widgetSchema->setLabels(array('nPassword' => $i18n->__('Renter new password').'* :'));

	$this->widgetSchema->setNameFormat('resetpassword[%s]');
	
	$this->validatorSchema['password'] = new sfValidatorString(

            array('required' => true),

            array('required' => $i18n->__('Enter new password.'))
			
	);
	
	$this->validatorSchema['nPassword'] = new sfValidatorString(

            array('required' => true),

            array('required' => $i18n->__('Enter new password.'))
			
	);
	
	$this->validatorSchema->setPostValidator(

        new sfValidatorCallback(array('callback' => array($this, 'matchPasswords')))

    );
   }	
  
  public function matchPasswords($validator, $values)
  {
  	//Print_r($values);
	//echo "test=".$values['password'];
	$i18n = sfContext::getInstance()->getI18N();
	if($values['password'] && $values['nPassword']){
		   
		  if ($values['password'] != $values['nPassword'])
		  {
			throw new sfValidatorError($validator, $i18n->__('The password you entered is incorrect'));
	
		  } 
	}
		return $values;
  }
}
