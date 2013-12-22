<?php

/**
 * language actions.
 *
 * @package    yozoa
 * @subpackage language
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class languageActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeChangeLanguage(sfWebRequest $request)
    {
        $language = $request->getParameter('language','en');
		$currency = $request->getParameter('currency','NOK');
		$_SESSION['currency'] = $currency ? "$currency" : "NOK";
		//$this->getRequest()->setAttribute('currency', $currency ? "$currency" : "NOK");
		//$_SESSION['currency'] = $currency;//$this->getUser()->setAttribute('currency', $currency);
		
		$this->getUser()->setLangAndCurrInCookie($currency, $language, 'reset');

		$form = new sfFormLanguage($this->getUser(),array('languages' => array('en', 'no')));
        $form->process($request);
        return $this->redirect('localized_homepage');
    }
}
