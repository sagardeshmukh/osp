<?php

/**
 * ProductAttribute form base class.
 *
 * @method ProductAttribute getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductAttributeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'product_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => false)),
      'attribute_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Attribute'), 'add_empty' => false)),
      'attribute_value'       => new sfWidgetFormInputText(),
      'attribute_values_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'AttributeValues')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'product_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Product'))),
      'attribute_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Attribute'))),
      'attribute_value'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'attribute_values_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'AttributeValues', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_attribute[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductAttribute';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['attribute_values_list']))
    {
      $this->setDefault('attribute_values_list', $this->object->AttributeValues->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveAttributeValuesList($con);

    parent::doSave($con);
  }

  public function saveAttributeValuesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['attribute_values_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->AttributeValues->getPrimaryKeys();
    $values = $this->getValue('attribute_values_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('AttributeValues', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('AttributeValues', array_values($link));
    }
  }

}
