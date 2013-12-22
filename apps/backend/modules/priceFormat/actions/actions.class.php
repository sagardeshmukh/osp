<?php

/**
 * priceFormat actions.
 *
 * @package    yozoa
 * @subpackage priceFormat
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class priceFormatActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->price_formats = Doctrine::getTable('PriceFormat')
      ->createQuery('a')
      ->execute();
  }

  public function executeOnChangeCategory(sfWebRequest $request)
  {
      $category_id = $request->getParameter('catId');
      if($category_id){
            $data = array(
                    'update'  => 'CategoryItems',
                    'content' => $this->getPartial('list',
                    array(
                    'price_formats' => Doctrine::getTable('PriceFormat')->getListByCategoryId($category_id)
            )));
         
      }

      return $this->renderText(json_encode($data));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->price_formats = Doctrine::getTable('PriceFormat')
      ->createQuery('a')
      ->execute();
    
    $this->form = new PriceFormatForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    //$this->forward404Unless($request->isMethod(sfRequest::POST));
    $form = new PriceFormatForm();
    $values = $request->getParameter($form->getName());
    $form->bind($values, $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $form->save();

      //update category attribute list
    $data = array(
                    'update'  => 'CategoryItems',
                    'content' => $this->getPartial('list',
                        array(
                        'price_formats' => Doctrine::getTable('PriceFormat')->getListByCategoryId($values['category_id'])
            )));

    return $this->renderText(json_encode($data));
    }else{
        //update category attribute list
        $data = array(
                        'update'  => 'priceForm',
                        'content' => $this->getPartial('form',
                            array(
                            'form' => $form
                )));

        return $this->renderText(json_encode($data));
    }

  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($price_format = Doctrine::getTable('PriceFormat')->find(array($request->getParameter('id'))), sprintf('Object price_format does not exist (%s).', $request->getParameter('id')));
    $this->form = new PriceFormatForm($price_format);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($price_format = Doctrine::getTable('PriceFormat')->find(array($request->getParameter('id'))), sprintf('Object price_format does not exist (%s).', $request->getParameter('id')));
    $this->form = new PriceFormatForm($price_format);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($price_format = Doctrine::getTable('PriceFormat')->find(array($request->getParameter('id'))), sprintf('Object price_format does not exist (%s).', $request->getParameter('id')));
    $price_format->delete();

    $this->redirect('priceFormat/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $price_format = $form->save();

      $this->redirect('priceFormat/index');
    }
  }
}
