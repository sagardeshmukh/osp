<?php

/**
 * tabs actions.
 *
 * @package    yozoa
 * @subpackage tabs
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tabsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  /*
   * Advanced Search products
   * @param sfWebRequest $request
   */
  public function executeSearch(sfWebRequest $request)
  {
      $paramsJSON = array(
              'xAreaId' => 0,
              'categoryId' => 0,
              'is_raw'  => true,
          );
      $this->xareas = Doctrine::getTable('XArea')->getRealEstateArea($paramsJSON);

      $this->setLayout(false);
  }

  /*
   * Advanced Search products
   * @param sfWebRequest $request
   */
  public function executeOption(sfWebRequest $request)
  {
      $realestate_id = myConstants::getCategoryId('realestates');
      $rental_id = myConstants::getCategoryId('rental');
      $category_id = myConstants::getCategoryId('category_id');

      $params = array(
        'visible' => 1,
        'culture' => $this->getUser()->getCulture()
      );

      $xarea_id = $request->getParameter('xarea_id');

      $params['xType'] = 'realestate';
      $params['parent_id'] = $realestate_id;
      $this->categories = Doctrine::getTable('Category')->getRealEstateCategory($params);

      $params['xType'] = 'rental';
      $params['parent_id'] = $rental_id;
      $this->rental_categories = Doctrine::getTable('Category')->getRealEstateCategory($params);
    $this->setLayout(false);
  }

  /*
   *
   * @param sfWebRequest object picture xml
   */
  public function executeXml(sfWebRequest $request)
  {
      $this->product = Doctrine::getTable('Product')->find($request->getParameter('ObjectID'));
      $this->productImages = $this->product->getProductImages();
    sfView::NONE;
  }

  public function executeParam(sfWebRequest $request)
  {
      $this->product = Doctrine::getTable('Product')->find($request->getParameter('ObjectID'));
    sfView::NONE;
  }

}
