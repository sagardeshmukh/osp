<?php

/**
 * Language form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LanguageForm extends BaseLanguageForm
{

  public function configure()
  {
    $this->widgetSchema['culture'] = new sfWidgetFormInputText();
    $options = CurrencyTable::getInstance()->getCurrOptions();
    $this->widgetSchema['prefferred_currency'] = new sfWidgetFormChoice(array('choices' => $options));

    $this->validatorSchema['culture'] = new sfValidatorRegex(
            array(
              'pattern' => '/^[a-z]{2}$/', 'must_match' => true,
              'required' => true),
            array(
              'invalid' => "Culture is incorrect [a-z][a-z]",
              'required' => "Culture is incorrect [a-z][a-z]"));
    $this->getWidgetSchema()->setLabel('prefferred_currency', 'Preferred Currency');
    $this->getWidgetSchema()->setDefault('prefferred_currency', 'USD');
  }

}
