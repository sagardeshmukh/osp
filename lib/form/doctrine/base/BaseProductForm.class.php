<?php

/**
 * Product form base class.
 *
 * @method Product getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'name'                => new sfWidgetFormInputText(),
      'description'         => new sfWidgetFormTextarea(),
      'image'               => new sfWidgetFormInputText(),
      'category_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => false)),
      'is_new'              => new sfWidgetFormInputCheckbox(),
      'status'              => new sfWidgetFormInputText(),
      'user_id'             => new sfWidgetFormInputText(),
      'currency_main'       => new sfWidgetFormInputText(),
      'price_original'      => new sfWidgetFormInputText(),
      'price_global'        => new sfWidgetFormInputText(),
      'attribute_value_ids' => new sfWidgetFormTextarea(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'confirmed_at'        => new sfWidgetFormDateTime(),
      'duration'            => new sfWidgetFormInputText(),
      'buy_online'          => new sfWidgetFormInputCheckbox(),
      'internal'            => new sfWidgetFormInputCheckbox(),
      'delivery_status'     => new sfWidgetFormInputCheckbox(),
      'delivery_type'       => new sfWidgetFormInputCheckbox(),
      'phone_cell'          => new sfWidgetFormInputText(),
      'phone_home'          => new sfWidgetFormInputText(),
      'surname'             => new sfWidgetFormInputText(),
      'x_area_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'), 'add_empty' => false)),
      'x_area_location_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('XAreaLocation'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 255)),
      'description'         => new sfValidatorString(),
      'image'               => new sfValidatorString(array('max_length' => 255)),
      'category_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'))),
      'is_new'              => new sfValidatorBoolean(array('required' => false)),
      'status'              => new sfValidatorInteger(array('required' => false)),
      'user_id'             => new sfValidatorInteger(),
      'currency_main'       => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'price_original'      => new sfValidatorNumber(array('required' => false)),
      'price_global'        => new sfValidatorNumber(array('required' => false)),
      'attribute_value_ids' => new sfValidatorString(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'confirmed_at'        => new sfValidatorDateTime(array('required' => false)),
      'duration'            => new sfValidatorInteger(array('required' => false)),
      'buy_online'          => new sfValidatorBoolean(array('required' => false)),
      'internal'            => new sfValidatorBoolean(array('required' => false)),
      'delivery_status'     => new sfValidatorBoolean(array('required' => false)),
      'delivery_type'       => new sfValidatorBoolean(array('required' => false)),
      'phone_cell'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'phone_home'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'surname'             => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'x_area_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('XArea'))),
      'x_area_location_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('XAreaLocation'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Product';
  }

}
