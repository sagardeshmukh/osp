<?php 
class ForgetPasswordForm extends sfForm
{
  public function configure()
  {
    	
	$i18n = sfContext::getInstance()->getI18N();
	
	$this->setWidgets(array( 'vUsername'    => new sfWidgetFormInput() ));
	
	$this->widgetSchema->setLabels(array('vUsername' => $i18n->__('Username').' :'));
	
	$this->widgetSchema->setNameFormat('forgetpassword[%s]');
	$this->validatorSchema['vUsername'] = new sfValidatorString(

            array('required' => true),

            array('required' => $i18n->__('Enter your username'))
			
	);
	
	$this->validatorSchema->setPostValidator(

        new sfValidatorCallback(array('callback' => array($this, 'getByUsername')))

    );
   }	
  
  public function getByUsername($validator, $values)
  {
  	$i18n = sfContext::getInstance()->getI18N();
	if($values['vUsername'] ){
     		
		   $this->_object = Doctrine::getTable('User')

              ->getByUsername(

                  $values['vUsername']

                  );

		  if (!$this->_object)
		  {
			throw new sfValidatorError($validator, $i18n->__('The username you entered is incorrect'));
	
		  } 
	}
		return $values;
  }
}
