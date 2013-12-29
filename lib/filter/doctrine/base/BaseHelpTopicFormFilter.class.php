<?php

/**
 * HelpTopic filter form base class.
 *
 * @package    symfony
 * @subpackage filter
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHelpTopicFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'question'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'answer'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'help_category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HelpCategory'), 'add_empty' => true)),
      'read_count'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'question'         => new sfValidatorPass(array('required' => false)),
      'answer'           => new sfValidatorPass(array('required' => false)),
      'sort_order'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'help_category_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('HelpCategory'), 'column' => 'id')),
      'read_count'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('help_topic_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HelpTopic';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'question'         => 'Text',
      'answer'           => 'Text',
      'sort_order'       => 'Number',
      'help_category_id' => 'ForeignKey',
      'read_count'       => 'Number',
    );
  }
}
