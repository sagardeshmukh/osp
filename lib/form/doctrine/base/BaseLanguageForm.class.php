<?php

/**
 * Language form base class.
 *
 * @method Language getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLanguageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'culture'             => new sfWidgetFormInputHidden(),
      'name'                => new sfWidgetFormInputText(),
      'prefferred_currency' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'culture'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('culture')), 'empty_value' => $this->getObject()->get('culture'), 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 255)),
      'prefferred_currency' => new sfValidatorString(array('max_length' => 3)),
    ));

    $this->widgetSchema->setNameFormat('language[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Language';
  }

}
