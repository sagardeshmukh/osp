<?php

class help_categoryActions extends sfActions
{
 

  public function executeIndex(sfWebRequest $request)
  {
      $this->help_attributes = Doctrine_Query::create()
              ->select('h.*')
              ->from('HelpCategory h')
              ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new HelpCategoryForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new HelpCategoryForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $help_category = $this->getRoute()->getObject();
    $help_category->delete();

    $this->getUser()->setFlash('notice', 'deleted successfully');

    $this->redirect('help_category/index');
  }
  public function executeEdit(sfWebRequest $request)
  {
    $this->form = new HelpCategoryForm($this->getRoute()->getObject());
    $this->setTemplate('edit');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->form = new HelpCategoryForm($this->getRoute()->getObject());
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $help_category = $form->save();
      $this->getUser()->setFlash('notice', 'Saved successfully');
      $this->redirect('help_category/index');
    }
  }
}
