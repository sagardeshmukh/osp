<?php

/**
 * XArea filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseXAreaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'add_empty' => true)),
      'name'      => new sfWidgetFormFilterInput(),
      'map_lat'   => new sfWidgetFormFilterInput(),
      'map_lng'   => new sfWidgetFormFilterInput(),
      'lft'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rgt'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lvl'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'parent_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('XArea'), 'column' => 'id')),
      'name'      => new sfValidatorPass(array('required' => false)),
      'map_lat'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'map_lng'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'lft'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lvl'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('x_area_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'XArea';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'parent_id' => 'ForeignKey',
      'name'      => 'Text',
      'map_lat'   => 'Number',
      'map_lng'   => 'Number',
      'lft'       => 'Number',
      'rgt'       => 'Number',
      'lvl'       => 'Number',
    );
  }
}
