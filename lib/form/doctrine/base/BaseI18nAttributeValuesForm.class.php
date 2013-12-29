<?php

/**
 * I18nAttributeValues form base class.
 *
 * @method I18nAttributeValues getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseI18nAttributeValuesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'attr_value_id' => new sfWidgetFormInputHidden(),
      'culture'       => new sfWidgetFormInputHidden(),
      'value'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'attr_value_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('attr_value_id')), 'empty_value' => $this->getObject()->get('attr_value_id'), 'required' => false)),
      'culture'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('culture')), 'empty_value' => $this->getObject()->get('culture'), 'required' => false)),
      'value'         => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('i18n_attribute_values[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'I18nAttributeValues';
  }

}
