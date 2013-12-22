<?php



/**

 * attribute actions.

 *

 * @package    yozoa

 * @subpackage attribute

 * @author     Falcon

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class attributeActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
	ini_set("memory_limit", "128M");
    $category_id = $request->getParameter('category_id');

    if ($category_id)
    {
      $this->attributes = Doctrine_Query::create()

              ->select('a.*')
              ->from('Attribute a')
              ->innerJoin('a.CategoryAttribute ca')
              ->where('ca.category_id = ?', $category_id)
              ->orderBy('a.name')
              ->orderBy('a.sort_order')
              ->execute();
    }else{

      $this->attributes = Doctrine_Query::create()

              ->from('Attribute a')
              ->orderBy('a.name')
              ->orderBy('a.sort_order')
              ->execute();
    }
  }

  public function executeSort(sfWebRequest $request)
  {
    $ids = explode(",", $request->getParameter('ids'));
    $counter = 1;
    foreach($ids as $id)
    {

      $attribute = Doctrine::getTable('Attribute')->find($id);
      if ($attribute)
      {

        $attribute->setSortOrder($counter++);

        $attribute->save(null, false);

      }

    }
    return sfView::NONE;
  }

  public function executeSearch(sfWebRequest $request)
  {
    $keyword = mysql_escape_string($request->getParameter('keyword'));
    $this->results = Doctrine::getTable('Attribute')->searchByKeyword($keyword);

  }

  public function executeTranslationList(sfWebRequest $request)
  {

    $this->sf_culture = 'en';
    $this->i18nLanguages = $this->_getI18nLanguages();
    $this->attributes = Doctrine_Query::create()
              ->from('Attribute a')
              ->orderBy('a.name')
              ->execute();

    $this->i18nAttributes = Doctrine_Query::create()
              ->from('i18nAttribute i')
              ->where('i.culture = ?', $this->sf_culture)
              ->orderBy('i.name')
              ->execute();

    $attributes = array();
    $this->messages = array();
	
    foreach($this->i18nAttributes as $i => $i18n){
        $attributes[$i18n->getAttributeId()] = array(
            'cul'=> $i18n->getCulture(),
            'name'=> $i18n->getName(),
        );
    }

    foreach($this->attributes as $index => $attribute){
        $this->messages[$index] = array(
            'id' => $attribute->getId(),
            'source'    => $attribute->getName(),
            $this->sf_culture   => array('target' => isset($attributes[$attribute->getId()])? $attributes[$attribute->getId()]['name']:'' ),
        );
    }
  }

  public function executeUpdateAttributeTranslation(sfWebRequest $request)
  {

    $sf_culture = $request->getParameter('sf_culture');

    $ids = $request->getParameter('id');

    $sources = $request->getParameter('source');

    $targets = $request->getParameter('target');



    if ($sf_culture)
    {

      foreach ($ids as $id)

      {

        $i18nAttribute = Doctrine::getTable('i18nAttribute')->find(array($id, $sf_culture));

        if (!$i18nAttribute) {

            $i18nAttribute = new I18nAttribute();

            $i18nAttribute->setAttributeId($id);

            $i18nAttribute->setCulture($sf_culture);

        }

        $i18nAttribute->setName($targets[$id]);

        $i18nAttribute->save();

      }
    }
    return $this->redirect('attribute/index');
  }

  public function executeNew(sfWebRequest $request)
  {
		
	$this->categories = Doctrine::getTable('Category')->getParentCategoryOptions(0 ,1 , $this->getUser()->getCulture());
	$this->form = new AttributeForm();
	if ($request->isXmlHttpRequest())
    {
		$category_id = $request->getParameter('cat_id');
		$level = $request->getParameter('level');
		$categories = Doctrine::getTable('Category')->getChildren($category_id, false, 1, $this->getUser()->getCulture());
		return $this->renderPartial('category', array('categories' => $categories , 'level' => $level ));
	}
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new AttributeForm();
    $this->processForm($request, $this->form, "create");
    $this->setTemplate('new');

  }



  public function executeEdit(sfWebRequest $request)
  {

    $this->forward404Unless($attribute = Doctrine::getTable('Attribute')->find(array($request->getParameter('id'))), sprintf('Object attribute does not exist (%s).', $request->getParameter('id')));
	//echo $request->getParameter('id'); 
	$category = Doctrine::getTable('CategoryAttribute')->getListByAttributeId($request->getParameter('id'));
	//to Do
	foreach($category as $cat){
		$child_cat_id = $cat->getCategory_id();
	}
	//echo $child_cat_id;
	$ParentCategories = Doctrine::getTable('Category')->getParentCategories($child_cat_id);
	$subcat = array();
	$subcat_ids = array();
	$test = 0;
	foreach($ParentCategories as $ParentCategory){
		//echo $ParentCategory->getId()."<br>";
		$level = $ParentCategory->getLevel() + 1 ;
		if($ParentCategory->getId() == 0) {
			$subcat['subcat0'] = Doctrine::getTable('Category')->getChildren( 0, false, 1, $this->getUser()->getCulture());
			$test = 1;
		} else {
			$subcat['subcat'.$level] = Doctrine::getTable('Category')->getChildren( $ParentCategory->getId(), false, 1, $this->getUser()->getCulture());
		} 
		$subcat_ids['subcat'.$ParentCategory->getLevel()] = $ParentCategory->getId();
	}
	$this->subcat_ids = $subcat_ids;
	$this->subcat = $subcat;
	//echo "count=".count($subcat);
	//exit;
    $this->form = new AttributeForm($attribute);

  }



  public function executeUpdate(sfWebRequest $request)
  {

    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));

    $this->forward404Unless($attribute = Doctrine::getTable('Attribute')->find(array($request->getParameter('id'))), sprintf('Object attribute does not exist (%s).', $request->getParameter('id')));

    $this->form = new AttributeForm($attribute);
    $this->processForm($request, $this->form, "update");
    $this->setTemplate('edit');

  }



  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($attribute = Doctrine::getTable('Attribute')->find(array($request->getParameter('id'))), sprintf('Object attribute does not exist (%s).', $request->getParameter('id')));
    $attribute->delete();
    $this->redirect('attribute/index');
  }



  protected function processForm(sfWebRequest $request, sfForm $form , $action = "")
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
	
    if ($form->isValid())
    {
      $attribute = $form->save(); 
	  $category_id = $request->getParameter('for_category');
	  $categoryArr = explode(",",$category_id);
	  $category_id = $categoryArr[0];
	  $attr_id = $attribute->getId();
	  if($category_id != NULL){
		  if($action == 'create'){				//insert category value to category_attribute table.
			  
			  $user1 = new CategoryAttribute(); 
			  $user1->category_id = $category_id;
			  $user1->attribute_id = $attr_id;
			  $user1->save();
			  
		  } else if($action == 'update'){	   //update category value to category_attribute table.
			  
			  $q = Doctrine_Query::create()
				->update('CategoryAttribute ca')
				->set('ca.category_id', '?', $category_id)
				->where('ca.attribute_id = ?', $attr_id);
				
			  $rows = $q->execute();
		  }
	  }
	  $this->redirect('attribute/index');
      //$this->redirect('attribute/edit?id='.$attribute->getId());
    }
  }

  private function _getI18nLanguages()
  {

    return array('en' => 'English', 'no' => 'Norway');

  }
  
  public function executeShowChildCategory(sfWebRequest $request)
  {

    $category_id = $request->getParameter('cat_id');

    $categories = Doctrine::getTable('Category')->getChildren($category_id, false, 1, $this->getUser()->getCulture());

	//return print_r($categories); exit;
	//echo "count=".count($categories); exit;

    return $this->renderPartial('category', array('categories' => $categories , 'category_id' => $category_id));

  }
  
   public function executeEditCollapse(sfWebRequest $request)
   {
   $is_collapse=$request->getParameter('is_collapse');
   $attribute_id = $request->getParameter('id');
			$q = Doctrine_Query::create()
			  ->update('Attribute')
			  ->set('is_collapse', $is_collapse?0:1)
			  ->where('id = ?', $attribute_id);
		  // ...
		  $rows = $q->execute();
	   $this->redirect('attribute/index');

   }
  
   public function executeEditIsMap(sfWebRequest $request)
   {
   $is_map=$request->getParameter('is_map');
   $attribute_id = $request->getParameter('id');
			$q = Doctrine_Query::create()
			  ->update('Attribute')
			  ->set('is_map', $is_map?0:1)
			  ->where('id = ?', $attribute_id);
		  // ...
		  $rows = $q->execute();
	   $this->redirect('attribute/index');

   }
}

