<?php

/**
 * XArea form base class.
 *
 * @method XArea getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseXAreaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'parent_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'add_empty' => false)),
      'name'      => new sfWidgetFormInputText(),
      'map_lat'   => new sfWidgetFormInputText(),
      'map_lng'   => new sfWidgetFormInputText(),
      'lft'       => new sfWidgetFormInputText(),
      'rgt'       => new sfWidgetFormInputText(),
      'lvl'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'parent_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'map_lat'   => new sfValidatorNumber(array('required' => false)),
      'map_lng'   => new sfValidatorNumber(array('required' => false)),
      'lft'       => new sfValidatorInteger(array('required' => false)),
      'rgt'       => new sfValidatorInteger(array('required' => false)),
      'lvl'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('x_area[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'XArea';
  }

}
