<?php

/**
 * ProductAttribute filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductAttributeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => true)),
      'attribute_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Attribute'), 'add_empty' => true)),
      'attribute_value'       => new sfWidgetFormFilterInput(),
      'attribute_values_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'AttributeValues')),
    ));

    $this->setValidators(array(
      'product_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Product'), 'column' => 'id')),
      'attribute_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Attribute'), 'column' => 'id')),
      'attribute_value'       => new sfValidatorPass(array('required' => false)),
      'attribute_values_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'AttributeValues', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_attribute_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addAttributeValuesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProductAttributeValue ProductAttributeValue')
      ->andWhereIn('ProductAttributeValue.attribute_value_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'ProductAttribute';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'product_id'            => 'ForeignKey',
      'attribute_id'          => 'ForeignKey',
      'attribute_value'       => 'Text',
      'attribute_values_list' => 'ManyKey',
    );
  }
}
