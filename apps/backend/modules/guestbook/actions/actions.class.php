<?php

class guestbookActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  { 
      $this->guestbooks = Doctrine_Query::create()
              ->from('Guestbook f')
              ->where('f.confirmed=?',$request->getParameter('id'))
              ->execute();
  }
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $guestbook = $this->getRoute()->getObject();
    $guestbook->delete();
    $this->getUser()->setFlash('notice', 'Deleted successfully');
    $this->redirect('guestbook/index?id=1');
  }
  public function executeEdit(sfWebRequest $request)
  {
    $this->form = new GuestbookForm($this->getRoute()->getObject());
    $this->setTemplate('edit');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->form = new GuestbookForm($this->getRoute()->getObject());
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $guestbook = $form->save();
      $this->getUser()->setFlash('notice', 'Saved successfully');
      $this->redirect('guestbook/index?id=1');
    }
  }
}
