<?php

/**
 * AttributeValues filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAttributeValuesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'attribute_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Attribute'), 'add_empty' => true)),
      'value'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'product_attribute_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ProductAttribute')),
    ));

    $this->setValidators(array(
      'attribute_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Attribute'), 'column' => 'id')),
      'value'                  => new sfValidatorPass(array('required' => false)),
      'sort_order'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'product_attribute_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ProductAttribute', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('attribute_values_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addProductAttributeListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('ProductAttributeValue.product_attribute_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'AttributeValues';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'attribute_id'           => 'ForeignKey',
      'value'                  => 'Text',
      'sort_order'             => 'Number',
      'product_attribute_list' => 'ManyKey',
    );
  }
}
