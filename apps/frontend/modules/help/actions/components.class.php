<?php

class helpComponents extends sfComponents
{
  public function executeLeftMenu(sfWebRequest $request)
  {
      $this->categories = Doctrine_Query::create()
              ->select('h.*')
              ->orderBy('h.sort_order ASC')
              ->from('HelpCategory h')
              ->execute();
      $this->selected_category  = Doctrine::getTable('HelpTopic')-> find($request->getParameter('id'));      
   }
  public function executeRightMenu(sfWebRequest $request)
  {
     
  }
}
