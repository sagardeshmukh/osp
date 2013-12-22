<?php



/**

 * Product form.

 *

 * @package    yozoa

 * @subpackage form

 * @author     Falcon

 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class CustomProductForm extends ProductForm

{

  private $productAttributeForms = array();

  //private $xTypeForm;

  public function configure()

  {

    parent::configure();



    $culture = sfContext::getInstance("frontend")->getUser()->getCulture();

    $object            = $this->getObject();

    $productAttributes = Doctrine::getTable('ProductAttribute')->getProductAttributes($object->getId(), -1, -1, -1, $culture); 

    $attributes        = Doctrine::getTable('Attribute')->getAttributeByCategoryId($object->getCategoryId(), $culture);    

    $root = Doctrine::getTable('Category')->getRootCategory($object->getCategoryId());

    $xType = myConstants::getCategoryType($root->getId());


/*
    switch($xType){

        case 'jobs':

            $xTypeForm = new JobForm($object->getJob());

            $this->embedForm('job', $xTypeForm);

            unset($this['phone_cell'], $this['phone_home']);

            break;

        case 'realestates':

            $xTypeForm = new RealEstateForm($object->getRealEstate());

            $this->embedForm('realestate', $xTypeForm);

            break;

        case 'rental':

            $xTypeForm = new RentalForm($object->getRental());

            $this->embedForm('rental', $xTypeForm);

            break;

        case 'service':

            $xTypeForm = new ServiceForm($object->getService());

            $this->embedForm('service', $xTypeForm);

            break;

        case 'motor':

            break;

    }
*/
    



    $productMainAttributeForm     = new sfForm();

    $productOptionalAttributeForm = new sfForm();



    foreach($attributes as $attribute)

    {

      $attribute_id = $attribute->getId();
      if (!isset($productAttributes[$attribute_id]))

      {
		//if($xType == 'realestates' && $attribute_id != 182){
        	$productAttributes[$attribute_id] = new ProductAttribute();
        	$productAttributes[$attribute_id]->setAttributeObject($attribute);
	    //}
      }

	  //if($xType == 'realestates' && $attribute_id != 182)
      $this->productAttributeForms["attribute_{$attribute_id}"] = new ProductAttributeForm($productAttributes[$attribute_id]);



      if ($attribute->getIsMain())

      {
		//if($xType == 'realestates' && $attribute_id != 182)
        $productMainAttributeForm->embedForm("attribute_{$attribute_id}", $this->productAttributeForms["attribute_{$attribute_id}"]);

      }

      else

      {

        $productOptionalAttributeForm->embedForm("attribute_{$attribute_id}", $this->productAttributeForms["attribute_{$attribute_id}"]);

      }

    }



	//print_r($productMainAttributeForm);



    $this->embedForm('mainAttributes', $productMainAttributeForm);

    $this->embedForm('optianalAttributes', $productOptionalAttributeForm);



    $this->widgetSchema->setNameFormat('product[%s]');

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->validatorSchema->setOption('filter_extra_fields', false);



    $decorator = new attributeFormDecorator($this->getWidgetSchema());

    $this->widgetSchema->addFormFormatter('custom', $decorator);

    $this->widgetSchema->setFormFormatterName('custom');

  }





  /**

   * Update the product_id of the productAttribute after the product has been saved

   */



  public function saveEmbeddedForms($con = null, $forms = null)

  {

    //parent::saveEmbeddedForms($con, $forms);

  }



  public function bind(array $taintedValues = null, array $taintedFiles = null)

  {

    if (isset($taintedValues['mainAttributes']))

    {

      foreach($taintedValues['mainAttributes'] as $key => $values)

      {

        if (isset($this->productAttributeForms[$key]))

        {

          $this->productAttributeForms[$key]->bind($taintedValues['mainAttributes'][$key]);

        }

      }

    }



    if (isset($taintedValues['optianalAttributes']))

    {

      foreach($taintedValues['optianalAttributes'] as $key => $values)

      {

        if (isset($this->productAttributeForms[$key]))

        {

          $this->productAttributeForms[$key]->bind($taintedValues['optianalAttributes'][$key]);

        }

      }

    }

    //attribute value ids

    $attribute_values_ids = array();

    foreach($this->productAttributeForms as $productAttributeForm)

    {

      $attribute_values_ids = array_merge($attribute_values_ids, (array) $productAttributeForm->getValue('attribute_values_list'));

    }



    //

    $oldAttributeValueIds        = explode(',', $this->getObject()->getAttributeValueIds());

    $specialAttributeValueIds    = array_keys(myConstants::getAttributeTypes());

    $oldSpecialAttributeValueIds = array_intersect($oldAttributeValueIds, $specialAttributeValueIds);



    //huuchin special attribute aa nemj baina

    $attribute_values_ids   = array_merge($attribute_values_ids, $oldSpecialAttributeValueIds);



    

    $taintedValues['user_id'] = sfContext::getInstance('frontend')->getUser()->getId();

    $taintedValues['attribute_value_ids'] = join(",", $attribute_values_ids);

    

    parent::bind($taintedValues, $taintedFiles);

  }



  public function save($con = null)

  {

    $product = parent::save($con);



    foreach($this->productAttributeForms as $productAttributeForm)

    {

      $productAttributeForm->getObject()->setProductId($product->getId());

      if (in_array($productAttributeForm->attributeType, array('checkbox', 'selectbox')))

      {

        if ($productAttributeForm->getValue('attribute_values_list'))

        {

          $productAttributeForm->save();

        }

        else

        {

          $productAttributeForm->getObject()->delete();

        }

      }

      else

      {

        $productAttributeForm->save();

      }

    }

    return $product;

  }

}

