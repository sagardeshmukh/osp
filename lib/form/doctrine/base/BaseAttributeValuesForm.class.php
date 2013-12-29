<?php

/**
 * AttributeValues form base class.
 *
 * @method AttributeValues getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAttributeValuesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'attribute_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Attribute'), 'add_empty' => false)),
      'value'                  => new sfWidgetFormInputText(),
      'sort_order'             => new sfWidgetFormInputText(),
      'product_attribute_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ProductAttribute')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'attribute_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Attribute'))),
      'value'                  => new sfValidatorString(array('max_length' => 255)),
      'sort_order'             => new sfValidatorInteger(array('required' => false)),
      'product_attribute_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ProductAttribute', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('attribute_values[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AttributeValues';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['product_attribute_list']))
    {
      $this->setDefault('product_attribute_list', $this->object->ProductAttribute->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveProductAttributeList($con);

    parent::doSave($con);
  }

  public function saveProductAttributeList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['product_attribute_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ProductAttribute->getPrimaryKeys();
    $values = $this->getValue('product_attribute_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ProductAttribute', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ProductAttribute', array_values($link));
    }
  }

}
