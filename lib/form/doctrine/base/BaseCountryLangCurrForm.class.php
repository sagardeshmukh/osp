<?php

/**
 * CountryLangCurr form base class.
 *
 * @method CountryLangCurr getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCountryLangCurrForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'country_name'  => new sfWidgetFormInputText(),
      'country_code'  => new sfWidgetFormInputText(),
      'language_name' => new sfWidgetFormInputText(),
      'language_code' => new sfWidgetFormInputText(),
      'currency_code' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'country_name'  => new sfValidatorString(array('max_length' => 255)),
      'country_code'  => new sfValidatorString(array('max_length' => 2)),
      'language_name' => new sfValidatorString(array('max_length' => 255)),
      'language_code' => new sfValidatorString(array('max_length' => 2)),
      'currency_code' => new sfValidatorString(array('max_length' => 3)),
    ));

    $this->widgetSchema->setNameFormat('country_lang_curr[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CountryLangCurr';
  }

}
