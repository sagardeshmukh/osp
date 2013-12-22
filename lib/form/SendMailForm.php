<?php

class SendMailForm extends sfForm
{
  public function configure()
  {

    $i18n = sfContext::getInstance()->getI18N();

    if(isset($this->options['user'])){
        $user =$this->options['user'];
    }

    if(isset($user)){
        $this->widgetSchema['to']=new sfWidgetFormInputText(array(),array('value' => $user->getName(), 'size'=>60, 'disabled' => 'disabled'));
        $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden(array(), array('value' => $user->getId()));
    }else{
        unset($this['to']);
    }
    
    $this->widgetSchema['username']=new sfWidgetFormInputText(array(),array('size'=>60));
    $this->widgetSchema['mail']  = new sfWidgetFormInputText(array(), array('size'=>60));
    
    if(isset($user)){
     $this->widgetSchema['subject']=new sfWidgetFormInputText(array(),array('value' => ' Application for the post:&nbsp;('.$this->options['title'].')', 'size'=>60));
     $this->widgetSchema['cv']  = new sfWidgetFormInputFile();
     $this->widgetSchema['cv1']  = new sfWidgetFormInputFile();
     $this->widgetSchema['cv2']  = new sfWidgetFormInputFile();
     $this->widgetSchema['cv3']  = new sfWidgetFormInputFile();
    }else{
        unset($this['cv'],$this['subject']);
    }

    $this->widgetSchema['infor'] = new sfWidgetFormTextarea(array(), array('cols' => 72, 'rows' => 7));

    $this->widgetSchema->setLabels(array('username'=>$i18n->__("Your name* :")));
    $this->widgetSchema->setLabels(array('mail' => $i18n->__("Your email address* :")));
    $this->widgetSchema->setLabels(array('title'=>$i18n->__("Subject* :")));
    $this->widgetSchema->setLabels(array('cv' => $i18n->__('Your CV* :')));
    $this->widgetSchema->setLabels(array('cv1' => $i18n->__('Your CV* :')));
    $this->widgetSchema->setLabels(array('cv2' => $i18n->__('Your CV* :')));
    $this->widgetSchema->setLabels(array('cv3' => $i18n->__('Your CV* :')));
    $this->widgetSchema->setLabels(array('to' => $i18n->__("Your application goes To* :")));
    $this->widgetSchema->setLabels(array('infor' => $i18n->__("Message text* :")));

    $this->widgetSchema->setHelp('cv', $i18n->__('<span class="aright">Only *.doc, *.docx, *.pdf, *.txt files allowed </span>'));
//    $this->widgetSchema->setHelp('subject', $i18n->__('<span class="aright">Email subject text</span>'));

    $this->validatorSchema['username']=new sfValidatorString(array('required' => true), array('required'=>'You must insert your name'));
    $this->validatorSchema['mail']  = new sfValidatorEmail(array(), array('required'=>'You must insert your email address', 'invalid'=>'Invalid email address'));
    $this->validatorSchema['infor'] = new sfValidatorString(array('required' => false));
    $this->validatorSchema['user_id'] = new sfValidatorPass();
    if(isset($user)){
    $this->validatorSchema['cv'] = new sfValidatorFile(array('required' => false, 'mime_types' => array('application/msword', 'application/pdf', 'text/plain' )), array('mime_types' => 'No file was uploaded, Only *.doc, *.docx, *.pdf, *.txt files allowed.'));
    $this->validatorSchema['cv1'] = new sfValidatorFile(array('required' => false, 'mime_types' => array('application/msword', 'application/pdf', 'text/plain' )), array('mime_types' => 'No file was uploaded, Only *.doc, *.docx, *.pdf, *.txt files allowed.'));
    $this->validatorSchema['cv2'] = new sfValidatorFile(array('required' => false, 'mime_types' => array('application/msword', 'application/pdf', 'text/plain' )), array('mime_types' => 'No file was uploaded, Only *.doc, *.docx, *.pdf, *.txt files allowed.'));
    $this->validatorSchema['cv3'] = new sfValidatorFile(array('required' => false, 'mime_types' => array('application/msword', 'application/pdf', 'text/plain' )), array('mime_types' => 'No file was uploaded, Only *.doc, *.docx, *.pdf, *.txt files allowed.'));
    $this->validatorSchema['subject'] = new sfValidatorString(array('required' => true), array('required' => 'You must insert subject'));
    $this->validatorSchema['to'] = new sfValidatorString(array('required' => false));
    }
    
    //$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setNameFormat('sendMail[%s]');
  }
}
