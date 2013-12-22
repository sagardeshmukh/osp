<?php

/**
 * xarea actions.
 *
 * @package    yozoa
 * @subpackage xarea
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class xareaActions extends sfActions
{

  public function executeChild(sfWebRequest $request)
  {
    $xAreas = Doctrine::getTable('XArea')->getChildren($request->getParameter('id'));
    $data = array(array('id' => -1, 'name' => '<-------'));
    foreach ($xAreas as $xArea)
    {
      $data[] = array('id' => $xArea->getId(), 'name' => $xArea->getName());
    }
    return $this->renderText(json_encode($data));
  }
  
  /**

   * Get child area by parent_id

   * @param sfWebRequest $request

   * @return <type>

   */

  public function executeChildArea(sfWebRequest $request)
  {

    $parent_id = $request->getParameter('id');

    if (!$request->isXmlHttpRequest())

    {

      return $this->forward404();

    }

    if ($parent_id != 0)

    {
      $this->x_areas = Doctrine::getTable('XArea')->getChildren($parent_id);

      if ($this->x_areas)
      {
		 return $this->renderPartial('xarea/childArea', array('x_areas' => $this->x_areas, 'selected_id' => $parent_id));
      }
      $this->setLayout(false);
    }
  }

  
  public function executeIndex(sfWebRequest $request)
  {
	// XAreaTable::getInstance()->rebuildLftRgt();
	$xAreaId = $request->getParameter('id');
	$level = $request->getParameter('level',0);
	$this->level = $level? $level + 1 : 1;
	$this->xAreaParentLocationId = array();
	$this->patentLocation = '';
	$this->xAreaId = $xAreaId;
	if($xAreaId){
		if($this->level < 4){
			$this->xAreas = Doctrine::getTable('XArea')->getChildren($xAreaId);
			$this->patentLocation = Doctrine::getTable('XArea')->getParents($xAreaId);
			if($this->level == 3){
				$query = Doctrine_Query::create()
					->select('x.parent_id')
					->distinct()
					->from('XAreaLocation AS x')
					->execute();
				$xAreaParentLocationId = array();
				foreach ($query as $xAreaLocations)
				{
				  $xAreaParentLocationId[] = $xAreaLocations->getParentId();
				}
				$this->xAreaParentLocationId = $xAreaParentLocationId;
			}
		}else if($this->level == 4){
			$this->patentLocation = Doctrine::getTable('XArea')->getParents($xAreaId);
			$this->xAreas = Doctrine::getTable('XAreaLocation')->getChildrens($xAreaId);
		}
	}else{
		$xAreas = Doctrine_Query::create()
			  ->from('XArea x')
			  ->where('x.id <> 0 AND lvl = 1')
			  ->execute();
		$this->nested_categories = array();
		foreach ($xAreas as $xArea)
		{
		  $this->nested_categories[$xArea->getParentId()][$xArea->getId()] = $xArea;
		}
	}    
  }

  public function executeNew(sfWebRequest $request)
  {
	$this->xarea_table = Doctrine::getTable('XArea');
    $x_area_id = $request->getParameter('id');
    $this->areas = null;
    if ($x_area_id){
        
		$this->areas = $this->xarea_table->getParentAreas($x_area_id);		
	}
	
	$this->form = new XAreaLocationForm();
    //XAreaTable::rebuildLftRgt();
	
	if ($request->isXmlHttpRequest())
    {
	 	if($request->getParameter('lname')) {
			$lname = $request->getParameter('lname');
			$parentId = $request->getParameter('parentId');
			$action = $request->getParameter('action');
			$query = Doctrine_Query::create()
					->select('x.id')
					->from('XAreaLocation AS x')
					->where('x.parent_id = ?', $parentId)
					->andWhere('x.name = ?', $lname)
					->execute();
			$recCount = count($query);
			if($recCount > 0)	
				return $this->renderText(1);
			else
				return $this->renderText(0);
		}
	}
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new XAreaLocationForm();
	$x_area = Doctrine::getTable('XArea')->find(array($request->getParameter('p_id')));
    $this->processForm($request, $this->form, $x_area->getParentId(),2);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {	
	if($request->getParameter('lvl') < 4){
		$this->editXarea = 1;
		$this->forward404Unless($x_area = Doctrine::getTable('XArea')->find(array($request->getParameter('id'))), sprintf('Object x_area does not exist (%s).', $request->getParameter('id')));
		$this->lvl = $request->getParameter('lvl');
		$this->x_area = $x_area;
		$this->locationName = $x_area->getName();
		$this->patentLocation = Doctrine::getTable('XArea')->getParents($x_area->getId());
		
	}else if($request->getParameter('lvl') == 4){
	
		$this->forward404Unless($x_area_location = Doctrine::getTable('XAreaLocation')->find(array($request->getParameter('id'))), sprintf('Object x_area does not exist (%s).', $request->getParameter('id')));
		
		$this->xarea_table = Doctrine::getTable('XArea');
		$this->areas = null;
		$this->x_area_location = $x_area_location;
		$this->patentLocation = Doctrine::getTable('XArea')->getParents($x_area_location->getParentId());
		if ($x_area_location->getParentId()){
			
			$this->areas = $this->xarea_table->getParentAreas($x_area_location->getParentId());		
		}
		
		$this->form = new XAreaLocationForm($x_area_location);
	}
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($x_area_location = Doctrine::getTable('XAreaLocation')->find(array($request->getParameter('id'))), sprintf('Object x_area does not exist (%s).', $request->getParameter('id')));
    $this->form = new XAreaLocationForm($x_area_location);

    $this->processForm($request, $this->form, $request->getParameter('p_id'), 3);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($x_area_location = Doctrine::getTable('XAreaLocation')->find(array($request->getParameter('id'))), sprintf('Object x_area does not exist (%s).', $request->getParameter('id')));
    $x_area_location->delete();
	$id  = $request->getParameter('p_id');
	if($id)
    	$this->redirect('xarea/index?id='.$id.'&level=3');
	else
		$this->redirect('xarea/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $p_id, $lvl)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $x_area = $form->save();
      $this->redirect('xarea/index?id='.$p_id.'&level='.$lvl);
    }
  }

  public $areaData = array();

  private function prepareData($parent_id, $nested_categories, $nameArray) {
      foreach ($nested_categories[$parent_id] as $xArea) {

        $this->areaData[$xArea->getId()] = array_merge($nameArray,  array($xArea->getName()));
        if (isset($nested_categories[$xArea->getId()])){
          $this->prepareData($xArea->getId(), $nested_categories, array_merge($nameArray,  array($xArea->getName())));
        }
      }
    }

  public function executeGetAllData(sfWebRequest $request)
  {
    $xAreas = Doctrine_Query::create()->from('XArea x')->where('x.id <> 0')->execute();
    $results = array();
    foreach ($xAreas as $xArea)
    {
      $results[$xArea->getParentId()][$xArea->getId()] = $xArea;
    }
    //
    $this->prepareData(0, $results, array());
    echo json_encode($this->areaData);
    exit();
    //return $this->renderText(json_encode($this->areaData));
  }

  public function executeAjaxUpdate(sfWebRequest $request)
  {
    $xarea = XAreaTable::getInstance()->find($request->getParameter('id'));
    $xarea->setMapLat($request->getParameter('lat'));
    $xarea->setMapLng($request->getParameter('lng'));
    $xarea->save();
    exit();
  }
  
  public function executeUpdateXarea(sfWebRequest $request)
  {
    $x_area_id = $request->getParameter('id');
	if($x_area_id){
		$q = Doctrine_Query::create()
			->update('XArea x')
			->set('x.name', '?', $request->getParameter('name'))
			->where('x.id = ?', $x_area_id);
		$q->execute();
	}
	$lvl = $request->getParameter('lvl');
	$x_area = Doctrine::getTable('XArea')->find(array($x_area_id));
	if($lvl==1){
		$this->redirect('xarea/index');
	}else{
		$lvl = $lvl -1;
		$this->redirect('xarea/index?id='.$x_area->getParentId().'&level='.$lvl);
	}
  }

}
