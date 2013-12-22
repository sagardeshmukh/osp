<?php

/**
 * advertise actions.
 *
 * @package    sf_sandbox
 * @subpackage advertise
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryComponents extends sfComponents
{
  public function executeLeftMenu(sfWebRequest $request)
  {
    $this->parentCategories = Doctrine::getTable('Category')->getChildren(sfConfig::get('category_id', 0), true, $this->getUser()->getCulture());
  }

  public function executeHeaderMenu(sfWebRequest $request)
  {
    $this->parentCategories = Doctrine::getTable('Category')->getChildren(0, false, 0, $this->getUser()->getCulture());
  }
  
  public function executeFeatured(sfWebRequest $request)
  {
    $this->categories = Doctrine::getTable('Category')->getFeatured(0, 5, $this->getUser()->getCulture());
  }
}
