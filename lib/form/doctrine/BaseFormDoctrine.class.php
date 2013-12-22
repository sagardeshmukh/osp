<?php

/**
 * Project form base class.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
{
  public function setHelp($name, $value)
  {
    if ($value && trim($value))
    {
      $this->getWidgetSchema()->setHelp($name, nl2br(trim($value)));
    }
  }
  public function setup()
  {
  }
}
