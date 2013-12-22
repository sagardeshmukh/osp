<?php

/**
 * PriceFormat form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PriceFormatForm extends BasePriceFormatForm
{
  public function configure()
  {
      $i18n = sfContext::getInstance()->getI18N();
      unset(
            $this['created_at'],
            $this['updated_at'],
            $this['price_global']
          );
      $object            = $this->getObject();
      $curr_option = CurrencyTable::getInstance()->getCurrOptions();
      $categories = Doctrine::getTable('Category')->getParentCategoryOptions(0, '', true);
      $xareas = Doctrine::getTable('XArea')->getParentOptions(0, 1);
      unset($categories[0]);

      $this->widgetSchema['category_id'] = new sfWidgetFormChoice(array('choices' => $categories));
      $this->widgetSchema['x_area_id'] = new sfWidgetFormChoice(array('choices' => $xareas));

      $this->widgetSchema['currency_main'] = new sfWidgetFormChoice(array('label' => $i18n->__('Currency') . ' *', 'choices' => $curr_option));
      $this->widgetSchema['price_original'] = new sfWidgetFormInput(array('label' => $i18n->__('Price') . ' *'));

      $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'validateUnique')))
        );

      $this->validatorSchema['category_id'] = new sfValidatorChoice(array('choices' => array_keys($categories)),array(
                                                                                       'invalid' => $i18n->__('Please select correct category'),
                                                                                       'required' => $i18n->__('Please select category')));

      $this->validatorSchema['x_area_id'] = new sfValidatorChoice(array('choices' => array_keys($xareas)),array(
                                                                                       'invalid' => $i18n->__('Please select correct location'),
                                                                                       'required' => $i18n->__('Please select location')));

      $this->validatorSchema['currency_main'] = new sfValidatorChoice(array('choices' => array_keys($curr_option)),array(
                                                                                       'invalid' => $i18n->__('Please select correct currency'),
                                                                                       'required' => $i18n->__('Please select correct currency')));
      $this->validatorSchema['price_global'] = new sfValidatorNumber(array('required' => false));
      $this->validatorSchema['price_original'] = new sfValidatorNumber(array('required' => true, 'min' => 0.01), array(
                                                                                                                'required' => 'You inserted wrong data',
                                                                                                                'invalid' => 'You inserted wrong data',
                                                                                                                'min' => 'Insert celling price correctly'));

  }

  public function validateUnique($validator, $values)
  {
    if (Doctrine::getTable('priceFormat')->validateUnique($this->getObject()->getId(), $values['category_id'], $values['x_area_id']))
    {
        if($this->getObject()->getId()){
            return $values;
        }
      $error = new sfValidatorError($validator, 'These category and location price already in it, Select different category or location');
      $this->getErrorSchema()->addError($error, 'category_id');
      throw $this->getErrorSchema();
    }
    return $values;
  }


  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    //for dumb peoples
    if (isset($taintedValues['price_original']))
    {
      $taintedValues['price_original'] = str_replace(',', '', $taintedValues['price_original']);
      $taintedValues['price_original'] = (float) trim($taintedValues['price_original']);

      $taintedValues['price_global'] = CurrencyTable::convertToGlobal($taintedValues['currency_main'], $taintedValues['price_original']);
    }

    $taintedValues['id'] = $this->getObject()->getId();
    parent::bind($taintedValues, $taintedFiles);
  }

}
