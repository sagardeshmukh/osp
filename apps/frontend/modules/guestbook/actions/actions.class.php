<?php

class guestbookActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new GuestbookForm();
    $this->pager = new sfDoctrinePager('Guestbook', 20);
    $this->pager->setQuery(Doctrine::getTable('Guestbook')->getSearchQuery());
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    
    $this->getResponse()->setTitle('Yozoa.com - User comments');
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CustomGuestbookForm();
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->form = new GuestbookForm($this->getRoute()->getObject());
    $this->setTemplate('edit');
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new GuestbookForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {    
      $guestbook = new Guestbook();
      $guestbook->fromArray($this->form->getValues());
 
      $guestbook->setBody($guestbook['body']);
      $guestbook = $form->save();
      $str = <<<EOF
         <script type="text/javascript">
            jQuery("#comment_form_container").html("<div align='center'>Send successfully, it'll activated by admin<br/> Thank you for leaving comment</div>");
            setTimeout(function(){jQuery('#guestbook_form_container').dialog('close')}, 3000);
         </script>
EOF;
      echo $str;
      return $this->renderText($str);
      }
  }

}
?>