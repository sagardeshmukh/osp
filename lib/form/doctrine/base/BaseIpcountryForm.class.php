<?php

/**
 * Ipcountry form base class.
 *
 * @method Ipcountry getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIpcountryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ip_from'      => new sfWidgetFormInputHidden(),
      'ip_to'        => new sfWidgetFormInputText(),
      'country_iso1' => new sfWidgetFormInputText(),
      'country_iso2' => new sfWidgetFormInputText(),
      'country_long' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ip_from'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('ip_from')), 'empty_value' => $this->getObject()->get('ip_from'), 'required' => false)),
      'ip_to'        => new sfValidatorString(array('max_length' => 255)),
      'country_iso1' => new sfValidatorString(array('max_length' => 5)),
      'country_iso2' => new sfValidatorString(array('max_length' => 5)),
      'country_long' => new sfValidatorString(array('max_length' => 200)),
    ));

    $this->widgetSchema->setNameFormat('ipcountry[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ipcountry';
  }

}
