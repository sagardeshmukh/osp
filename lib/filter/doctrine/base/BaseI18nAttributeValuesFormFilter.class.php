<?php

/**
 * I18nAttributeValues filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseI18nAttributeValuesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'value'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'value'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('i18n_attribute_values_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'I18nAttributeValues';
  }

  public function getFields()
  {
    return array(
      'attr_value_id' => 'Number',
      'culture'       => 'Text',
      'value'         => 'Text',
    );
  }
}
