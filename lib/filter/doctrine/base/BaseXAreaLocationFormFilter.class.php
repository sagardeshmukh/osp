<?php

/**
 * XAreaLocation filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseXAreaLocationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'add_empty' => true)),
      'name'      => new sfWidgetFormFilterInput(),
      'map_lat'   => new sfWidgetFormFilterInput(),
      'map_lng'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'parent_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('XArea'), 'column' => 'id')),
      'name'      => new sfValidatorPass(array('required' => false)),
      'map_lat'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'map_lng'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('x_area_location_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'XAreaLocation';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'parent_id' => 'ForeignKey',
      'name'      => 'Text',
      'map_lat'   => 'Number',
      'map_lng'   => 'Number',
    );
  }
}
