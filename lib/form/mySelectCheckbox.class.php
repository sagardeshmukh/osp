<?php
class mySelectCheckbox extends sfWidgetFormSelectCheckbox
{
  public function formatter($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
    {
      $rows[] = $widget->renderContentTag('div', $input['input'].$this->getOption('label_separator').$input['label'], array('class' => 'd'));
    }
    return !$rows ? '' : implode($widget->getOption('separator'), $rows);
  }
}