<?php

/**
 * Attribute filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAttributeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'country'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_main'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_column'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_filterable' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'sort_order'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_required'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_collapse'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_map'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'hint'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'type'          => new sfValidatorPass(array('required' => false)),
      'country'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_main'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_column'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_filterable' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'sort_order'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_required'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_collapse'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_map'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'hint'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('attribute_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attribute';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'type'          => 'Text',
      'country'       => 'Number',
      'is_main'       => 'Boolean',
      'is_column'     => 'Boolean',
      'is_filterable' => 'Boolean',
      'sort_order'    => 'Number',
      'is_required'   => 'Boolean',
      'is_collapse'   => 'Number',
      'is_map'        => 'Boolean',
      'hint'          => 'Text',
    );
  }
}
