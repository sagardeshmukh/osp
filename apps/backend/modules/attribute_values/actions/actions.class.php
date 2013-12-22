<?php

/**
 * attribute_values actions.
 *
 * @package    yozoa
 * @subpackage attribute_values
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class attribute_valuesActions extends sfActions
{
  public function executeSort(sfWebRequest $request)
  {
    $ids = explode(",", $request->getParameter('ids'));
    $counter = 1;
    foreach($ids as $id)
    {
      $attributeValue = Doctrine::getTable('AttributeValues')->find($id);
      if ($attributeValue)
      {
        $attributeValue->setSortOrder($counter);
        $attributeValue->save();
        $counter++;
      }
    }
    
    return sfView::NONE;
  }

  public function executeAddValues(sfWebRequest $request)
  {
    $values = (array) $request->getParameter('values');
    $attributeId = $request->getParameter('attributeId');
    $sortOrder = 1;
    $attributeValueObj = Doctrine_Query::create()
        ->from('AttributeValues av')
        ->where('av.attribute_id = ?', $attributeId)
        ->orderBy('av.sort_order DESC')
        ->limit(1)
        ->fetchOne();
    if ($attributeValueObj) $sortOrder = $attributeValueObj->getSortOrder();

    foreach($values as $value){
      $attributeValueObj = new AttributeValues();
      $attributeValueObj->setAttributeId($attributeId);
      $attributeValueObj->setValue($value);
      $attributeValueObj->setSortOrder(++$sortOrder);
      $attributeValueObj->save();
    }
    
    $data = array(
            'update'  => 'attribute_value_list',
            'content' => $this->getComponent('attribute_values', 'list',
            array('attribute_id' => $attributeId)
    ));
    return $this->renderText(json_encode($data));
  }

  /**
   * ADD VALUE
   * @param sfWebRequest $request
   * @return <type>
   */
  public function executeCreate(sfWebRequest $request)
  {
    //$this->forward404Unless($request->isMethod(sfRequest::POST));
    $form = new AttributeValuesForm();

    $values = $request->getParameter($form->getName());
    //update attribute values
    $form->bind($values, $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $attribute_value = $form->save();
    }
    $data = array(
            'update'  => 'attribute_value_list',
            'content' => $this->getPartial('list',
            array(
            'attribute_list' => Doctrine::getTable('AttributeValues')->getAttributeValues($values['attribute_id']),
            'form'           => $form)
    ));
    return $this->renderText(json_encode($data));
  }

  /*
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($attribute_values = Doctrine::getTable('AttributeValues')->find(array($request->getParameter('id'))), sprintf('Object attribute_values does not exist (%s).', $request->getParameter('id')));
    $this->form = new AttributeValuesForm($attribute_values);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($attribute_values = Doctrine::getTable('AttributeValues')->find(array($request->getParameter('id'))), sprintf('Object attribute_values does not exist (%s).', $request->getParameter('id')));
    $this->form = new AttributeValuesForm($attribute_values);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
  */

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($attribute_value = Doctrine::getTable('AttributeValues')->find(array($request->getParameter('id'))), sprintf('Object attribute_values does not exist (%s).', $request->getParameter('id')));
    $attribute_value->delete();
    return sfView::NONE;
  }
  
  public function executeDeleteMultipleAttributeValues(sfWebRequest $request)
  {
    $data = explode(',',$request->getParameter('str'));
 	foreach($data as $key => $value){
		if($value != NULL && $value != ''){
			$this->forward404Unless($attribute_value = Doctrine::getTable('AttributeValues')->find(array($value)), sprintf('Object attribute_values does not exist (%s).', $value));
			$attribute_value->delete();
		}
	}
    return sfView::NONE;
  }
}
