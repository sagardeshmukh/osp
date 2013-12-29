<?php

/**
 * Ipcountry filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIpcountryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ip_to'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'country_iso1' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'country_iso2' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'country_long' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'ip_to'        => new sfValidatorPass(array('required' => false)),
      'country_iso1' => new sfValidatorPass(array('required' => false)),
      'country_iso2' => new sfValidatorPass(array('required' => false)),
      'country_long' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ipcountry_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ipcountry';
  }

  public function getFields()
  {
    return array(
      'ip_from'      => 'Text',
      'ip_to'        => 'Text',
      'country_iso1' => 'Text',
      'country_iso2' => 'Text',
      'country_long' => 'Text',
    );
  }
}
