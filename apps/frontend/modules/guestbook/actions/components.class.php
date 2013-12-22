<?php

class guestbookComponents extends sfComponents
{
  public function executeLeftMenu(sfWebRequest $request)
  {
  }
  public function executeRightMenu(sfWebRequest $request)
  {
     
  }
  public function executeLatest(sfWebRequest $request)
  {  
    $this->guestbook = Doctrine::getTable('Guestbook')->getLastEntry();
  }  
}
