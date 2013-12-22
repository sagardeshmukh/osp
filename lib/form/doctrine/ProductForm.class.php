<?php



/**

 * Product form.

 *

 * @package    yozoa

 * @subpackage form

 * @author     Falcon

 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class ProductForm extends BaseProductForm

{



  public function configure()

  {

    $i18n = sfContext::getInstance()->getI18N();

    unset(

        $this['id'],

        $this['user_id'],

        $this['category_id'],

        $this['is_new'],

        $this['status'],

        $this['delivery_status'],

        $this['delivery_type'],

        $this['price_global'],

        $this['created_at'],

        $this['updated_at'],

        $this['confirmed_at'],

        $this['attribute_value_ids']

    );



    $object            = $this->getObject();

    $root = Doctrine::getTable('Category')->getRootCategory($object->getCategoryId());

    $xType = myConstants::getCategoryType($root->getId());

    $curr_option = CurrencyTable::getInstance()->getCurrOptions();

    $pref_curr = sfContext::getInstance()->getUser()->getPreffCurrency();

    $pref_xarea = $this->getObject()->isNew() ? sfContext::getInstance()->getUser()->getPreffXArea()  : $this->getObject()->getXAreaId();

    $duration_option = array(

      "15" => $i18n->__("15 days"),

      "30" => $i18n->__("1 month"),

      "60" => $i18n->__("2 month"));



    //Product values

    $this->setDefault('currency_main', $pref_curr);

    //$this->widgetSchema['id'] = new sfWidgetFormInputHidden();

    $this->widgetSchema['name'] = new sfWidgetFormInput(array('label' => $i18n->__('Title') . ' *'), array('size' => 80));

    $this->widgetSchema['description'] = new sfWidgetFormTextarea(array('label' => $i18n->__('Description') . ' *'), array('style' => 'width:100%'));

    $this->widgetSchema['currency_main'] = new sfWidgetFormChoice(array('label' => $i18n->__('Currency') . ' *', 'choices' => $curr_option));

    $this->widgetSchema['price_original'] = new sfWidgetFormInput(array('label' => $i18n->__('Price') . ' *'));

    $this->widgetSchema['x_area_id'] = new sfWidgetFormInput(array('label' => $i18n->__('Location') .' *'), array('value' => $pref_xarea, 'style' => 'display:none;'));
	
	$this->widgetSchema['x_area_location_id'] = new sfWidgetFormInput();


    if($xType =='products'){

        $this->widgetSchema['delivery_status'] = new sfWidgetFormChoice(array('label' => 'Is available *', 'choices' => array("1" => "Available", "2" => "Shipping order")));

        $this->widgetSchema['delivery_type'] = new sfWidgetFormChoice(array('label' => $i18n->__('Shipping') . ' *', 'choices' => array("1" => "Shipping", "2" => "No shipping")));

        $this->widgetSchema['phone_cell'] = new sfWidgetFormInput(array('label' => $i18n->__('Phone number') .' *'), array('size' => 80));

        $this->widgetSchema['phone_home'] = new sfWidgetFormInput(array('label' => $i18n->__('Mob. number')), array('size' => 80));

        $this->widgetSchema['surname'] = new sfWidgetFormInput(array('label' => $i18n->__('Fullname') .' *'), array('size' => 80));

    } else if($xType =='jobs'){

        unset($this['delivery_status'],

            $this['delivery_type'],

            $this['phone_cell'],

            $this['price_original'],

            $this['phone_home'],

            $this['image'],

            $this['surname']

                );

    } else {

        unset($this['delivery_status'],

            $this['delivery_type'],

            $this['phone_cell'],

          //  $this['price_original'],  // show default price field 18- 11 - 2011.

            $this['phone_home'],

            $this['image'],

            $this['surname']

                );

    }

    

    $this->widgetSchema['duration'] = new sfWidgetFormChoice(array('label' => $i18n->__('Duration'), 'choices' => $duration_option ));



    //new sfValidatorString(array('max_length' => 255), array('required' => 'Та бүтээгдxүүний нэрийг оруулна уу'))

    $this->validatorSchema['id'] = new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false));

    $this->validatorSchema['name'] = new sfValidatorRegex(array('pattern' => '/^\s*$/', 'must_match' => false), array('invalid' => 'Insert your product name', 'required' => 'Insert your product name'));

    $this->validatorSchema['description'] = new sfValidatorCallback(array('callback' => array($this, 'descriptionValidate')));

    $this->validatorSchema['category_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category')));

    $this->validatorSchema['user_id'] = new sfValidatorInteger(array('required' => false));



    $this->validatorSchema['duration'] = new sfValidatorChoice(array('choices' => array_keys($duration_option)),

                                                               array(

                                                                'invalid' => $i18n->__('Please select correct duration'),

                                                                'required' => $i18n->__('Please select correct duration')

                                                          ));

    //$this->setDefault("price", $this->getObject()->getPriceOriginal());



    $this->validatorSchema['x_area_id'] = new sfValidatorCallback(array('callback' => array($this, 'xAreaValidate')));



    if($xType =='products'){

        $this->validatorSchema['image'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

        $this->validatorSchema['phone_cell'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

        $this->validatorSchema['phone_home'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

        $this->validatorSchema['surname'] = new sfValidatorRegex(array('pattern' => '/^\s*$/', 'must_match' => false), array('invalid' => 'Insert your full name', 'required' => 'Insert your full name'));

        $this->validatorSchema->setPostValidator(

        new sfValidatorCallback(array('callback' => array($this, 'validatePhoneNumber')))

        );

        $this->validatorSchema['currency_main'] = new sfValidatorChoice(array('choices' => array_keys($curr_option)),array(

                                                                                       'invalid' => $i18n->__('Please select correct currency'),

                                                                                       'required' => $i18n->__('Please select correct currency')));

        $this->validatorSchema['price_global'] = new sfValidatorNumber(array('required' => false));

        $this->validatorSchema['price_original'] = new sfValidatorNumber(array('required' => true, 'min' => 0.01), array(

                                                                                                                'required' => 'You inserted wrong data',

                                                                                                                'invalid' => 'You inserted wrong data',

                                                                                                                'min' => 'Insert celling price correctly'));

    }
	
	if(isset($this['price_original']) && ($xType != 'realestates') && ($xType != 'cars')) {
		
		$this->validatorSchema['price_original'] = new sfValidatorNumber(array('required' => true, 'min' => 0.01), array(

                                                                                                                'required' => 'You inserted wrong data',

                                                                                                                'invalid' => 'You inserted wrong data',

                                                                                                                'min' => 'Insert celling price correctly'));
	}

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->validatorSchema->setOption('filter_extra_fields', false);

  }



  public function validatePhoneNumber($validator, $values)

  {

    if (!$values['phone_cell'] && !$values['phone_home'])

    {

      $error = new sfValidatorError($validator, 'Insert your phone number');

      $this->getErrorSchema()->addError($error, 'phone_cell');

      throw $this->getErrorSchema();

    }

    return $values;

  }





  public function descriptionValidate($validator, $value)

  {

    $description = strip_tags(html_entity_decode($value));

    if (preg_match('/^\s*$/', $description))

    {

      // password is not correct, throw an error

      throw new sfValidatorError($validator, 'Insert your product description');

    }

    return $value;

  }



  public function xAreaValidate($validator, $value)

  {

    if (!$value['x_area_id'])

    {

      // password is not correct, throw an error

      throw new sfValidatorError($validator, 'Insert your location');

    }

    return $value;

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

    if (isset($taintedValues['phone_cell']))

    {

      $taintedValues['phone_cell'] = trim($taintedValues['phone_cell']);

    }

    if (isset($taintedValues['phone_home']))

    {

      $taintedValues['phone_home'] = trim($taintedValues['phone_home']);

    }



    $taintedValues['id'] = $this->getObject()->getId();

    parent::bind($taintedValues, $taintedFiles);

  }

}

