<?php

/**
 * Banner filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBannerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'width'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'height'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'begin_date'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'end_date'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'file'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'link'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nb_views'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'category_id'  => new sfWidgetFormFilterInput(),
      'is_recursive' => new sfWidgetFormFilterInput(),
      'user_id'      => new sfWidgetFormFilterInput(),
      'is_active'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'         => new sfValidatorPass(array('required' => false)),
      'type'         => new sfValidatorPass(array('required' => false)),
      'width'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'height'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'begin_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'end_date'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'file'         => new sfValidatorPass(array('required' => false)),
      'link'         => new sfValidatorPass(array('required' => false)),
      'nb_views'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'category_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_recursive' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'code'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banner_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banner';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'name'         => 'Text',
      'type'         => 'Text',
      'width'        => 'Number',
      'height'       => 'Number',
      'begin_date'   => 'Date',
      'end_date'     => 'Date',
      'file'         => 'Text',
      'link'         => 'Text',
      'nb_views'     => 'Number',
      'category_id'  => 'Number',
      'is_recursive' => 'Number',
      'user_id'      => 'Number',
      'is_active'    => 'Number',
      'code'         => 'Text',
    );
  }
}
