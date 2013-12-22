<?php

class languageComponents extends sfComponents
{
  public function executeLanguage(sfWebRequest $request)
  {
    $languages = array_keys(LanguageTable::getLangOption());
    $languages[] = 'en';
    $this->form = new sfFormLanguage($this->getUser(), array('languages' => $languages));
	$this->currency = Doctrine::getTable('Currency')->getCurrOptions();
  }
}