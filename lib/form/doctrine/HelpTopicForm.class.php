<?php

/**
 * HelpTopic form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HelpTopicForm extends BaseHelpTopicForm
{
  public function configure()
  {
      unset(
            $this['read_count']
           );
    $this->widgetSchema['answer']    = new sfWidgetFormTextarea(array('label' => 'Тайлбар *'),array('class' => 'fckeditor', 'rows' => 20));
    $this->widgetSchema->setLabels(array('question'       => 'Question'));
    $this->widgetSchema->setLabels(array('sort_order'       => 'Sort'));

  }
}
