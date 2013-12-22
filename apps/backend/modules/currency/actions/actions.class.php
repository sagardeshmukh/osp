<?php

/**
 * currency actions.
 *
 * @package    yozoa
 * @subpackage currency
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class currencyActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $q = Doctrine_Query::create()->from('Currency c');
    $this->currencies = $q->execute();
  }

  public function executeFetchDataXe(sfWebRequest $request)
  {
    require 'simple_html_dom.php';

    $globalCurrency = "USD";
    $q = Doctrine_Query::create()->from('Currency c');
    $data = array();
    foreach ($q->execute() as $currency)
    {
      if ($currency->getCode() == "USD")
      {
        continue;
      }

      $html = file_get_html('http://www.xe.com/ucc/convert.cgi?Amount=1&From=USD&To=' . $currency->getCode());

      foreach ($html->find('.ucc_in tr') as $i => $row)
      {
        if ($i != 4)
        {
          continue;
        } else {
          $tds = $row->children;
          $value = (float) preg_replace('/,/', '', $tds[2]->plaintext);
          //
          $data[] = array('code' => $currency->getCode(), 'value' => $value);
          break;
        }
      }
    }
    return $this->renderText(json_encode($data));
    //return $this->redirect('currency/index');
  }

  public function executeSaveAll(sfWebRequest $request)
  {
    $values = $request->getParameter('value');
    foreach ($values as $code => $value){
      $currency = CurrencyTable::getInstance()->find($code);
      if ($currency){
        $currency->setValue($value);
        $currency->save();
      }
    }
    return sfView::NONE;
  }

  public function executeAddEdit(sfWebRequest $request)
  {
    $this->currency = CurrencyTable::getInstance()->find($request->getParameter('code'));
    if (!$this->currency)
    {
      $this->currency = new Currency();
    }
  }

  public function executeSave(sfWebRequest $request)
  {
    $currency = CurrencyTable::getInstance()->find($request->getParameter('code'));
    if (!$currency)
    {
      $currency = new Currency();
      $currency->setCode($request->getParameter('code'));
    }
    $currency->setName($request->getParameter('name'));
    $currency->setSymbol($request->getParameter('symbol'));
    $currency->setValue($request->getParameter('value'));
    $currency->save();
    return $this->redirect('currency/index');
  }

}
