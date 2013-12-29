<?php

/**
 * ProductStat form base class.
 *
 * @method ProductStat getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductStatForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'product_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => false)),
      'sold'        => new sfWidgetFormInputText(),
      'incorrect'   => new sfWidgetFormInputText(),
      'read_count'  => new sfWidgetFormInputText(),
      'share_count' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'product_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Product'))),
      'sold'        => new sfValidatorInteger(),
      'incorrect'   => new sfValidatorInteger(),
      'read_count'  => new sfValidatorInteger(array('required' => false)),
      'share_count' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_stat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductStat';
  }

}
