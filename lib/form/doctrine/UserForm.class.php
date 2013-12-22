<?php

/**
 * User form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserForm extends BaseUserForm
{

  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
    
    unset($this['last_seen_at'], $this['initial'], $this['image'], $this['is_active']);

    $pref_xarea = $this->getObject()->isNew() ? sfContext::getInstance()->getUser()->getPreffXArea()  : $this->getObject()->getXAreaId();
    $xareas = Doctrine::getTable('XArea')->getChildrenOption(0);
    $languages = Doctrine::getTable('Language')->getLangOption();
	$currency = Doctrine::getTable('Currency')->getCurrOptions();
    // feilds
    $this->setWidgets(array(
      'id' => new sfWidgetFormInputHidden(),
      'username' => new sfWidgetFormInput(array(), array('title'=> ''.$i18n->__('Your login name').'', 'size' => 20)),
      'firstname' => new sfWidgetFormInput(array(), array('title'=> ''.$i18n->__('Your first name').'','size' => 20)),
      'lastname' => new sfWidgetFormInput(array(), array('title'=> ''.$i18n->__('Your last name').'','size' => 20)),
      'password' => new sfWidgetFormInputPassword(array(), array('title'=> ''.$i18n->__('Password').'','size' => 20)),
      //'confirm_password' => new sfWidgetFormInputPassword(array(), array('title'=> ''.$i18n->__('Password confirmation').'','size' => 20)),
      'gender' => new sfWidgetFormChoice(array('choices' => array(0 => 'male', 1 => 'female')), array('title'=> ''.$i18n->__('Select gender').'',)),
	  'prefferred_language' => new sfWidgetFormChoice(array('choices' => $languages), array('title'=> ''.$i18n->__('Select language').'',)),
	  'prefferred_currency' => new sfWidgetFormChoice(array('choices' => $currency), array('title'=> ''.$i18n->__('Select currency').'',)),
      'culture' => new sfWidgetFormChoice(array('choices' => $languages)),
      'x_area_id' => new sfWidgetFormInput(array('label' => $i18n->__('Location') .' *'), array('value' => $this->getObject()->getXAreaId(), 'style' => 'display:none;')),
      //'image'=>new sfWidgetFormInputFile(array('label' => 'Image',)),
      'email' => new sfWidgetFormInput(array(), array('title'=> ''.$i18n->__('Email address').'','size' => 20)),
      'address' => new sfWidgetFormInput(array(), array('title'=> ''.$i18n->__('Address').'','size' => 20)),
      'permission' => new sfWidgetFormInputHidden(array(), array('value' => 1, 'title'=> ''.$i18n->__('Permission').'')),
    ));



    // labels
    $this->widgetSchema->setLabels(array(
      'username' => ''.$i18n->__('Login name').': ',
      'firstname' => ''.$i18n->__('First name').': ',
      'lastname' => ''.$i18n->__('Last name').': ',
      'password' => ''.$i18n->__('Password').': ',
      //'confirm_password' => ''.$i18n->__('Confirm password').': ',
      'email' => ''.$i18n->__('Email').': ',
      'address' => ''.$i18n->__('Address').': ',
	  'prefferred_language' => ''.$i18n->__('Prefferred Language').': ',
	  'prefferred_currency' => ''.$i18n->__('Prefferred Currency').': ',
      'culture' => ''.$i18n->__('Language').': ',
      'x_area_id' => ''.$i18n->__('Country').': ',
    ));

    // validators
    $this->setValidators(array(
      'id' => new sfValidatorDoctrineChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'username' => new sfValidatorString(array('required' => true), array('required' => ''.$i18n->__('Enter your login name').'')),
      'firstname' => new sfValidatorString(array('required' => true), array('required' => ''.$i18n->__('Enter your first name').'')),
      'lastname' => new sfValidatorString(array('required' => true), array('required' => ''.$i18n->__('Enter your last name').'')),
      'password' => new sfValidatorString(array('required' => true), array('required' => ''.$i18n->__('Enter your password').'')),
      'email' => new sfValidatorEmail(array('required' => true), array('required' => ''.$i18n->__('Enter your email').'', 'invalid' => ''.$i18n->__('Invalid email').'.')),
      //'confirm_password' => new sfValidatorPass(),
      'gender' => new sfValidatorPass(),
	  'prefferred_language' => new sfValidatorPass(),
	  'prefferred_currency' => new sfValidatorPass(),
      'culture' => new sfValidatorChoice(array('choices' =>array_keys($languages),)),
      'x_area_id' => new sfValidatorCallback(array('callback' => array($this, 'xAreaValidate'))),
      //'image'                           => new sfValidatorFile(array( 'required' => false, 'path' => sfConfig::get('sf_upload_dir').'/jobs','mime_types' => 'web_images',)),
      'address' => new sfValidatorString(array('required' => true), array('required' => ''.$i18n->__('Enter your address').'')),
      'permission' => new sfValidatorPass(),
    ));

//    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
//          new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'confirm_password',
//              array(),
//              array('invalid' => ''.$i18n->__('Password do not match').'')
//          ),
//        )));
    $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => 'username'), array('invalid' => ''.$i18n->__('Same user name already registered ').'')));

    $this->widgetSchema->setNameFormat('user[%s]');
  }

  public function xAreaValidate($validator, $value)
  {
    if (!$value['x_area_id'] && $value['x_area_id']==0)
    {
      // password is not correct, throw an error
      throw new sfValidatorError($validator, 'Insert your location');
    }
    return $value;
  }

}
