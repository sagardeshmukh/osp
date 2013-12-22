<?php

/**
 * category actions.
 *
 * @package    yozoa
 * @subpackage category
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends sfActions
{

  public function executeSort(sfWebRequest $request)
  {
    $ids = explode(",", $request->getParameter('ids'));
    $counter = 1;
    foreach($ids as $id)
    {
      $category = Doctrine::getTable('Category')->find($id);
      if ($category)
      {
        $category->setSortOrder($counter++);
        $category->save(null, false);
      }
    }
    //fixing left right
    Doctrine::getTable('Category')->fixLftRgt();
    return sfView::NONE;
  }

  public function executeAjax(sfWebRequest $request)
  {
      $id = $request->getParameter('id');

      $data = array(
            'content' => $this->getPartial('category',
            array(
            'categories' => Doctrine::getTable('Category')->getChildren($id, false, 1, 'en')
    )));

      return $this->renderText(json_encode($data));
    
    
    return sfView::NONE;
  }

  /**
   * Get child area by parent_id
   * @param sfWebRequest $request
   * @return <type>
   */
  public function executeChildCategory(sfWebRequest $request)
  {
    $parent_id = $request->getParameter('id');
    if (!$request->isXmlHttpRequest())
    {
      return $this->forward404();
    }
    if ($parent_id != 0)
    {
      $this->categories = Doctrine::getTable('Category')->getChildren($parent_id);
      if ($this->categories)
      {
        return $this->renderPartial('category/categoryOptions', array('categories' => $this->categories, 'selected_id' => $parent_id));
      }
      $this->setLayout(false);
    }
  }

  public function executeIndex(sfWebRequest $request)
  {
//    $categorys = Doctrine_Query::create()->from('Category c')->where('c.id <> 0')->orderBy('c.sort_order')->execute();
//    $this->nested_categories = array();
    $this->categories = Doctrine::getTable('Category')->getChildren(0, false, 1, 'en');
//    foreach($categorys as $category)
//    {
//      $this->nested_categories[$category->getParentId()][$category->getId()] = $category;
//    }
  }

  public function executeSearch(sfWebRequest $request)
  {
    $keyword = mysql_escape_string($request->getParameter('keyword'));

    $this->results = Doctrine::getTable('Category')->searchByKeyword($keyword);

  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CategoryForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CategoryForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($category = Doctrine::getTable('Category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoryForm($category);

    $category_table = Doctrine::getTable('Category');
    $this->parent_id = $category->getParentId();
    $this->categories = $category_table->getParentCategories($category->getParentId(), 1, $this->getUser()->getCulture());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($category = Doctrine::getTable('Category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoryForm($category);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($category = Doctrine::getTable('Category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $category->delete();

    $this->redirect('category/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $category = $form->save();
      $file = $form->getValue('logo');
      //is file uploaded
      if ($file)
      {
        //removing old file
        @unlink(sfConfig::get('sf_upload_dir').'/category/'.$category->getLogo());
        $filename = sha1($file->getOriginalName()).$file->getExtension($file->getOriginalExtension());
        $thumbnail = new sfThumbnail(100, 100, false);
        $thumbnail->loadFile($file->getTempName());
        $thumbnail->save(sfConfig::get('sf_web_dir').'/uploads/category/'.$filename);
        @unlink($file->getTempName());
        $category->setLogo($filename);
        $category->save();
      }
      $this->getUser()->setFlash('success', 'Saved Successfully.');

      $this->redirect('category/edit?id='.$category->getId());
    }
  }
  
   public function executeEditIsMap(sfWebRequest $request)
   {
   $is_map=$request->getParameter('is_map');
   $category_id = $request->getParameter('id');
			$q = Doctrine_Query::create()
			  ->update('Category')
			  ->set('is_map', $is_map?0:1)
			  ->where('id = ?', $category_id);
		  // ...
		  $rows = $q->execute();
	   $this->redirect('category/index');

   }

}
