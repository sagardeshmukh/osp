<?php

/**
 * Banner form base class.
 *
 * @method Banner getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBannerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'type'         => new sfWidgetFormInputText(),
      'width'        => new sfWidgetFormInputText(),
      'height'       => new sfWidgetFormInputText(),
      'begin_date'   => new sfWidgetFormDateTime(),
      'end_date'     => new sfWidgetFormDateTime(),
      'file'         => new sfWidgetFormInputText(),
      'link'         => new sfWidgetFormInputText(),
      'nb_views'     => new sfWidgetFormInputText(),
      'category_id'  => new sfWidgetFormInputText(),
      'is_recursive' => new sfWidgetFormInputText(),
      'user_id'      => new sfWidgetFormInputText(),
      'is_active'    => new sfWidgetFormInputText(),
      'code'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 255)),
      'type'         => new sfValidatorString(array('max_length' => 5)),
      'width'        => new sfValidatorInteger(),
      'height'       => new sfValidatorInteger(),
      'begin_date'   => new sfValidatorDateTime(),
      'end_date'     => new sfValidatorDateTime(),
      'file'         => new sfValidatorString(array('max_length' => 255)),
      'link'         => new sfValidatorString(array('max_length' => 255)),
      'nb_views'     => new sfValidatorInteger(),
      'category_id'  => new sfValidatorInteger(array('required' => false)),
      'is_recursive' => new sfValidatorInteger(array('required' => false)),
      'user_id'      => new sfValidatorInteger(array('required' => false)),
      'is_active'    => new sfValidatorInteger(),
      'code'         => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('banner[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banner';
  }

}
