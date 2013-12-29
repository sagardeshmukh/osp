<?php

/**
 * CountryLangCurr filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCountryLangCurrFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'country_name'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'country_code'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'language_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'language_code' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'currency_code' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'country_name'  => new sfValidatorPass(array('required' => false)),
      'country_code'  => new sfValidatorPass(array('required' => false)),
      'language_name' => new sfValidatorPass(array('required' => false)),
      'language_code' => new sfValidatorPass(array('required' => false)),
      'currency_code' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('country_lang_curr_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CountryLangCurr';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'country_name'  => 'Text',
      'country_code'  => 'Text',
      'language_name' => 'Text',
      'language_code' => 'Text',
      'currency_code' => 'Text',
    );
  }
}
