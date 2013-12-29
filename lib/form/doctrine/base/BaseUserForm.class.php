<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'username'            => new sfWidgetFormInputText(),
      'password'            => new sfWidgetFormInputText(),
      'firstname'           => new sfWidgetFormInputText(),
      'lastname'            => new sfWidgetFormInputText(),
      'initial'             => new sfWidgetFormInputText(),
      'gender'              => new sfWidgetFormInputText(),
      'email'               => new sfWidgetFormInputText(),
      'address'             => new sfWidgetFormTextarea(),
      'is_active'           => new sfWidgetFormInputCheckbox(),
      'last_seen_at'        => new sfWidgetFormDateTime(),
      'image'               => new sfWidgetFormInputText(),
      'culture'             => new sfWidgetFormInputText(),
      'x_area_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'add_empty' => false)),
      'fevorite_products'   => new sfWidgetFormInputText(),
      'prefferred_language' => new sfWidgetFormInputText(),
      'prefferred_currency' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'username'            => new sfValidatorString(array('max_length' => 50)),
      'password'            => new sfValidatorString(array('max_length' => 50)),
      'firstname'           => new sfValidatorString(array('max_length' => 100)),
      'lastname'            => new sfValidatorString(array('max_length' => 100)),
      'initial'             => new sfValidatorString(array('max_length' => 1)),
      'gender'              => new sfValidatorInteger(),
      'email'               => new sfValidatorString(array('max_length' => 50)),
      'address'             => new sfValidatorString(array('max_length' => 500)),
      'is_active'           => new sfValidatorBoolean(array('required' => false)),
      'last_seen_at'        => new sfValidatorDateTime(),
      'image'               => new sfValidatorString(array('max_length' => 255)),
      'culture'             => new sfValidatorString(array('max_length' => 4)),
      'x_area_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'))),
      'fevorite_products'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'prefferred_language' => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'prefferred_currency' => new sfValidatorString(array('max_length' => 4, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
