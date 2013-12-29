<?php

/**
 * Product filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'category_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'is_new'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'status'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'currency_main'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_original'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_global'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'attribute_value_ids' => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'confirmed_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'duration'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'buy_online'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'internal'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'delivery_status'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'delivery_type'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'phone_cell'          => new sfWidgetFormFilterInput(),
      'phone_home'          => new sfWidgetFormFilterInput(),
      'surname'             => new sfWidgetFormFilterInput(),
      'x_area_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'add_empty' => true)),
      'x_area_location_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XAreaLocation'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                => new sfValidatorPass(array('required' => false)),
      'description'         => new sfValidatorPass(array('required' => false)),
      'image'               => new sfValidatorPass(array('required' => false)),
      'category_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'is_new'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'status'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'currency_main'       => new sfValidatorPass(array('required' => false)),
      'price_original'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'price_global'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'attribute_value_ids' => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'confirmed_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'duration'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'buy_online'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'internal'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'delivery_status'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'delivery_type'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'phone_cell'          => new sfValidatorPass(array('required' => false)),
      'phone_home'          => new sfValidatorPass(array('required' => false)),
      'surname'             => new sfValidatorPass(array('required' => false)),
      'x_area_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('XArea'), 'column' => 'id')),
      'x_area_location_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('XAreaLocation'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Product';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'name'                => 'Text',
      'description'         => 'Text',
      'image'               => 'Text',
      'category_id'         => 'ForeignKey',
      'is_new'              => 'Boolean',
      'status'              => 'Number',
      'user_id'             => 'Number',
      'currency_main'       => 'Text',
      'price_original'      => 'Number',
      'price_global'        => 'Number',
      'attribute_value_ids' => 'Text',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'confirmed_at'        => 'Date',
      'duration'            => 'Number',
      'buy_online'          => 'Boolean',
      'internal'            => 'Boolean',
      'delivery_status'     => 'Boolean',
      'delivery_type'       => 'Boolean',
      'phone_cell'          => 'Text',
      'phone_home'          => 'Text',
      'surname'             => 'Text',
      'x_area_id'           => 'ForeignKey',
      'x_area_location_id'  => 'ForeignKey',
    );
  }
}
