<?php

/**
 * Attribute form base class.
 *
 * @method Attribute getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAttributeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'type'          => new sfWidgetFormInputText(),
      'country'       => new sfWidgetFormInputText(),
      'is_main'       => new sfWidgetFormInputCheckbox(),
      'is_column'     => new sfWidgetFormInputCheckbox(),
      'is_filterable' => new sfWidgetFormInputCheckbox(),
      'sort_order'    => new sfWidgetFormInputText(),
      'is_required'   => new sfWidgetFormInputCheckbox(),
      'is_collapse'   => new sfWidgetFormInputText(),
      'is_map'        => new sfWidgetFormInputCheckbox(),
      'hint'          => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 255)),
      'type'          => new sfValidatorString(array('max_length' => 50)),
      'country'       => new sfValidatorInteger(array('required' => false)),
      'is_main'       => new sfValidatorBoolean(),
      'is_column'     => new sfValidatorBoolean(),
      'is_filterable' => new sfValidatorBoolean(array('required' => false)),
      'sort_order'    => new sfValidatorInteger(array('required' => false)),
      'is_required'   => new sfValidatorBoolean(array('required' => false)),
      'is_collapse'   => new sfValidatorInteger(array('required' => false)),
      'is_map'        => new sfValidatorBoolean(),
      'hint'          => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('attribute[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attribute';
  }

}
