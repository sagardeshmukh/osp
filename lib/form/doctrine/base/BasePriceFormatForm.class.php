<?php

/**
 * PriceFormat form base class.
 *
 * @method PriceFormat getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePriceFormatForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'category_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => false)),
      'x_area_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'add_empty' => false)),
      'currency_main'  => new sfWidgetFormInputText(),
      'price_original' => new sfWidgetFormInputText(),
      'price_global'   => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'category_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'))),
      'x_area_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'))),
      'currency_main'  => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'price_original' => new sfValidatorNumber(array('required' => false)),
      'price_global'   => new sfValidatorNumber(array('required' => false)),
      'description'    => new sfValidatorString(),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('price_format[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PriceFormat';
  }

}
