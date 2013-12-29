<?php

/**
 * HelpTopic form base class.
 *
 * @method HelpTopic getObject() Returns the current form's model object
 *
 * @package    symfony
 * @subpackage form
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHelpTopicForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'question'         => new sfWidgetFormInputText(),
      'answer'           => new sfWidgetFormTextarea(),
      'sort_order'       => new sfWidgetFormInputText(),
      'help_category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HelpCategory'), 'add_empty' => false)),
      'read_count'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'question'         => new sfValidatorString(array('max_length' => 255)),
      'answer'           => new sfValidatorString(),
      'sort_order'       => new sfValidatorInteger(),
      'help_category_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('HelpCategory'))),
      'read_count'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('help_topic[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HelpTopic';
  }

}
