<?php

class help_topicActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
      $this->help_topics = Doctrine_Query::create()
              ->select('ht.*')
              ->from('HelpTopic ht')
              ->orderBy('ht.sort_order ASC')
              ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new HelpTopicForm();
  }

  public function executeCreate(sfWebRequest $request)
  {     
    $this->form = new HelpTopicForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }
   public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $category = $this->getRoute()->getObject();
    $category->delete();

    $this->getUser()->setFlash('notice', 'Deleted successfully!');

    $this->redirect('help_topic/index');
  }
  public function executeEdit(sfWebRequest $request)
  {
    $this->form = new HelpTopicForm($this->getRoute()->getObject());
    $this->setTemplate('edit');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->form = new HelpTopicForm($this->getRoute()->getObject());
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {

    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $help_topic = $form->save();
      $this->getUser()->setFlash('notice', 'Saved successfully');
      $this->redirect('help_topic/index');
    }
  }
}
