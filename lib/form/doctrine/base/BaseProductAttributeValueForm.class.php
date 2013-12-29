<?php

/**
 * ProductAttributeValue form base class.
 *
 * @method ProductAttributeValue getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductAttributeValueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_attribute_id' => new sfWidgetFormInputHidden(),
      'attribute_value_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'product_attribute_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('product_attribute_id')), 'empty_value' => $this->getObject()->get('product_attribute_id'), 'required' => false)),
      'attribute_value_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('attribute_value_id')), 'empty_value' => $this->getObject()->get('attribute_value_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_attribute_value[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductAttributeValue';
  }

}
