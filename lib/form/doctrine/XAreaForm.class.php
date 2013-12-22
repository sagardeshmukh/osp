<?php

/**
 * XArea form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class XAreaForm extends BaseXAreaForm
{
  public function configure()
  {
    unset($this['lft'], $this['rgt'], $this['lvl']);
    $this->widgetSchema['name'] = new sfWidgetFormInputText(array(), array('size' => 40));
    $this->widgetSchema['parent_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['map_lat'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['map_lng'] = new sfWidgetFormInputHidden();
  }
}
