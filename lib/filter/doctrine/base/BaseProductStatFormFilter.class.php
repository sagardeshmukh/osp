<?php

/**
 * ProductStat filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductStatFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => true)),
      'sold'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'incorrect'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'read_count'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'share_count' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'product_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Product'), 'column' => 'id')),
      'sold'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'incorrect'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'read_count'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'share_count' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('product_stat_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductStat';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'product_id'  => 'ForeignKey',
      'sold'        => 'Number',
      'incorrect'   => 'Number',
      'read_count'  => 'Number',
      'share_count' => 'Number',
    );
  }
}
