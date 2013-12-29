<?php

/**
 * User filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'username'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'firstname'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lastname'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'initial'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'gender'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'address'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'last_seen_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'image'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'culture'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'x_area_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'add_empty' => true)),
      'fevorite_products'   => new sfWidgetFormFilterInput(),
      'prefferred_language' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prefferred_currency' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'username'            => new sfValidatorPass(array('required' => false)),
      'password'            => new sfValidatorPass(array('required' => false)),
      'firstname'           => new sfValidatorPass(array('required' => false)),
      'lastname'            => new sfValidatorPass(array('required' => false)),
      'initial'             => new sfValidatorPass(array('required' => false)),
      'gender'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'email'               => new sfValidatorPass(array('required' => false)),
      'address'             => new sfValidatorPass(array('required' => false)),
      'is_active'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_seen_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'image'               => new sfValidatorPass(array('required' => false)),
      'culture'             => new sfValidatorPass(array('required' => false)),
      'x_area_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('XArea'), 'column' => 'id')),
      'fevorite_products'   => new sfValidatorPass(array('required' => false)),
      'prefferred_language' => new sfValidatorPass(array('required' => false)),
      'prefferred_currency' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'username'            => 'Text',
      'password'            => 'Text',
      'firstname'           => 'Text',
      'lastname'            => 'Text',
      'initial'             => 'Text',
      'gender'              => 'Number',
      'email'               => 'Text',
      'address'             => 'Text',
      'is_active'           => 'Boolean',
      'last_seen_at'        => 'Date',
      'image'               => 'Text',
      'culture'             => 'Text',
      'x_area_id'           => 'ForeignKey',
      'fevorite_products'   => 'Text',
      'prefferred_language' => 'Text',
      'prefferred_currency' => 'Text',
    );
  }
}
