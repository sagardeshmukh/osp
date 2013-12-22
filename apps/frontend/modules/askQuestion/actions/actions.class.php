<?php
class askQuestionActions extends sfActions
{
	public function executeAsk(sfWebRequest $request)
	{
		$this->product_id = $request->getParameter('product_id');
		$this->form = new SendMailForm();
		
		if($request->isMethod('post')){
			$this->form->bind($request->getParameter($this->form->getName()));
			if($this->form->isValid())
			{
				//SENDING MAIL
    			$news = Doctrine::getTable('Product')->find($request->getParameter('product_id'));
				$url    = $this->generateUrl('product_show', $news, true);
				$values = $this->form->getValues();
				
				//$mailTo = $values['mail'];
				$mailTo = array('elena12ian@yahoo.com'=>'Yozoa');
				$mailFrom = array($values['mail']=>$values['username']);
				$mailSubject = __('New post from')."{$values['username']}.";
				$mailBody = $this->getPartial("mail/askQuestion", array("information"=>$values['infor'], "url"=>$url, "description"=>$news->getDescription()));
				$message = $this->getMailer()->compose($mailFrom, $mailTo, $mailSubject, $mailBody);
				$message->setContentType("text/html");
				$this->getMailer()->send($message);
				
				// close dialog
				$str = <<<EOF
<script type="text/javascript">
jQuery('.askQuestion-dialog').dialog('close');
</script>
EOF;
                echo "Send successfully";
                return $this->renderText($str);
             }
		}
	}
    
    public function executeCreate(sfWebRequest $request)
    {
        $this->form = new SendMailForm();
        $this->product_id = $request->getParameter('product_id');
        $this->form->bind($request->getParameter($this->form->getName()));
        if($this->form->isValid())
        {
            //SENDING MAIL
            $news = Doctrine::getTable('Product')->find($request->getParameter('product_id'));
			$url    = $this->generateUrl('product_show', $news, true);
            $values = $this->form->getValues();
            
            $mailTo = array('elena12ian@yahoo.com'=>'Yozoa');
            $mailFrom = array($values['mail']=>$values['username']);
            $mailSubject ='Ask a Question from ' ."{$values['username']}.";
            $mailBody = $this->getPartial("mail/askQuestion", array("information"=>$values['infor'], "url"=>$url, "description"=>$news->getDescription()));
            $message = $this->getMailer()->compose($mailFrom, $mailTo, $mailSubject, $mailBody);
            $message->setContentType("text/html");
            $this->getMailer()->send($message);
            
            // close dialog  
            $str = <<<EOF
<script type="text/javascript">
//jQuery('.askQuestion-dialog').dialog('close');
</script>
EOF;
            echo "Send successfully";
            return $this->renderText($str);
        }
        else
        {
        	return $this->renderPartial('form', array('form' => $this->form));
        }
    }
}

?>