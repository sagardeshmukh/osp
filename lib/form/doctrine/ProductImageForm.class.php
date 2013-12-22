<?php

/**
 * ProductImage form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductImageForm extends BaseProductImageForm
{
  public function configure()
  {
    unset($this['product_id']);
  }
}
