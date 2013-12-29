<?php

/**
 * I18nAttribute filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseI18nAttributeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'         => new sfWidgetFormFilterInput(),
      'hint'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'         => new sfValidatorPass(array('required' => false)),
      'hint'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('i18n_attribute_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'I18nAttribute';
  }

  public function getFields()
  {
    return array(
      'attribute_id' => 'Number',
      'culture'      => 'Text',
      'name'         => 'Text',
      'hint'         => 'Text',
    );
  }
}
