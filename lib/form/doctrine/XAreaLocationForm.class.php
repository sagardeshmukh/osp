<?php

/**
 * XAreaLocation form.
 *
 * @package    symfony
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class XAreaLocationForm extends BaseXAreaLocationForm
{
  public function configure()
  {
    $this->widgetSchema['name'] = new sfWidgetFormInputText(array(), array('size' => 40));
    $this->widgetSchema['parent_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['map_lat'] = new sfWidgetFormInputText(array(), array('size' => 20));
    $this->widgetSchema['map_lng'] = new sfWidgetFormInputText(array(), array('size' => 20));
	
	$this->widgetSchema->setLabels(array(
      'name' => 'Location name',
      'map_lat' => 'Latitude',
      'map_lng' => 'Longitude',
    ));
  }
}
