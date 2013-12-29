<?php

/**
 * I18nAttribute form base class.
 *
 * @method I18nAttribute getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseI18nAttributeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'attribute_id' => new sfWidgetFormInputHidden(),
      'culture'      => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'hint'         => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'attribute_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('attribute_id')), 'empty_value' => $this->getObject()->get('attribute_id'), 'required' => false)),
      'culture'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('culture')), 'empty_value' => $this->getObject()->get('culture'), 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'hint'         => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('i18n_attribute[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'I18nAttribute';
  }

}
