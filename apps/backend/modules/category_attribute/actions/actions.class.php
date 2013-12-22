<?php

/**
 * category_attribute actions.
 *
 * @package    yozoa
 * @subpackage category_attribute
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class category_attributeActions extends sfActions
{
  public function executeCreate(sfWebRequest $request)
  {
    //$this->forward404Unless($request->isMethod(sfRequest::POST));
    $form = new CategoryAttributeForm();
    $values = $request->getParameter($form->getName());
    $form->bind($values, $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $form->save();
    }

    //update category attribute list
    $data = array(
            'update'  => 'category_attribute_list',
            'content' => $this->getPartial('list',
            array(
            'category_attributes' => Doctrine::getTable('CategoryAttribute')->getListByAttributeId($values['attribute_id']),
            'form'                => $form
    )));
    return $this->renderText(json_encode($data));
  }

  /*
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($category_attribute = Doctrine::getTable('CategoryAttribute')->find(array($request->getParameter('category_id'),
        $request->getParameter('attribute_id'))), sprintf('Object category_attribute does not exist (%s).', $request->getParameter('category_id'),
        $request->getParameter('attribute_id')));
    $this->form = new CategoryAttributeForm($category_attribute);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($category_attribute = Doctrine::getTable('CategoryAttribute')->find(array($request->getParameter('category_id'),
        $request->getParameter('attribute_id'))), sprintf('Object category_attribute does not exist (%s).', $request->getParameter('category_id'),
        $request->getParameter('attribute_id')));
    $this->form = new CategoryAttributeForm($category_attribute);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
  */

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($category_attribute = Doctrine::getTable('CategoryAttribute')->find(array($request->getParameter('category_id'),
            $request->getParameter('attribute_id'))), sprintf('Object category_attribute does not exist (%s).', $request->getParameter('category_id'),
            $request->getParameter('attribute_id')));

    $category_attribute->delete();
    return sfView::NONE;
  }
}
