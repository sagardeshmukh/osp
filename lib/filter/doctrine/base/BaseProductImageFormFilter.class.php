<?php

/**
 * ProductImage filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductImageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'folder'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'filename'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'product_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'folder'     => new sfValidatorPass(array('required' => false)),
      'filename'   => new sfValidatorPass(array('required' => false)),
      'sort_order' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'product_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Product'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('product_image_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductImage';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'folder'     => 'Text',
      'filename'   => 'Text',
      'sort_order' => 'Number',
      'product_id' => 'ForeignKey',
    );
  }
}
