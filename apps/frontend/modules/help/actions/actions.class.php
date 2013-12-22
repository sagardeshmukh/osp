<?php

class helpActions extends sfActions
{

  public function postExecute(){
    $this->getResponse()->setTitle('Yozoa.com - help');
  }
  public function executeWarning(sfWebRequest $request)
  {
    $this->product_id = $request->getParameter('product_id');
  	$this->type = $request->getParameter('type');
  	$this->forward404Unless($this->product = Doctrine::getTable('Product')->find($this->product_id));
  	$this->forward404Unless(in_array($this->type, array('sold', 'incorrect','share_count')));
  	Doctrine::getTable('ProductStat')->increaseStat($this->product_id, $this->type);
  	      $str = <<<EOF
         <script type="text/javascript">
            jQuery("#product_warning_container").html("<div align='center'><b>Thank you for you declaration. </b></div>");
            setTimeout(function(){jQuery('#product_warning_container').dialog('close')}, 3000);
         </script>
EOF;
      echo $str;
      return $this->renderText($str);
  	//return sfView::NONE;
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->help_categories = Doctrine_Query::create()
              ->select('ht.*')
              ->orderBy('ht.read_count DESC')
              ->from('HelpTopic ht')
              ->limit(10)
              ->execute();
    $this->categories = Doctrine_Query::create()
              ->select('h.*')
              ->orderBy('h.sort_order ASC')
              ->from('HelpCategory h')
              ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {  
      $this->help_answer = Doctrine::getTable('HelpTopic')-> find($request->getParameter('id'));
      $this->related_answer = Doctrine::getTable('HelpTopic')-> relatedHelp($this->help_answer->getHelpCategoryId(),$request->getParameter('id'));
      $this->help_answer->setReadCount($this->help_answer->getReadCount()+1);
      $this->help_answer->save();
      $this->categories = Doctrine_Query::create()
              ->select('h.*')
              ->orderBy('h.sort_order ASC')
              ->from('HelpCategory h')
              ->execute();      
  } 
  

}