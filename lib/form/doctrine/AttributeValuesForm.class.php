<?php

/**
 * AttributeValues form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AttributeValuesForm extends BaseAttributeValuesForm
{
  public function configure()
  {
    $this->widgetSchema['attribute_id'] = new sfWidgetFormInputHidden();
  }
}
