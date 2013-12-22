<?php

/**
 * ProductAttribute form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductAttributeForm extends BaseProductAttributeForm
{

  public $attributeType = null;

  public function configure()
  {
    unset($this['product_id'], $this['id']);
    
    $i18n = sfContext::getInstance("frontend")->getI18N();
    $culture = sfContext::getInstance("frontend")->getUser()->getCulture();
    
    $attrObject = $this->getObject()->getAttributeObject($culture);
    
    $this->widgetSchema['attribute_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('attribute_id', $attrObject->getId());

    $attribute_type = $attrObject->getType();
    $this->attributeType = $attribute_type;
    //attribute name
    $attribute_name = $attrObject->getName();

    switch ($attribute_type)
    {
      //textbox
      case "textbox":
        $this->widgetSchema['attribute_value'] = new sfWidgetFormInput();
        break;
      //textarea
      case "textarea":
        $this->widgetSchema['attribute_value'] = new sfWidgetFormTextarea();
        break;
      //checkbox
      case "checkbox":
        $choices = Doctrine::getTable('AttributeValues')->getValueOption($attrObject->getId(), false, $culture);
        $this->widgetSchema['attribute_values_list'] = new mySelectCheckbox(array('choices' => $choices));
        break;
      //selectbox
      case "selectbox":
        $choices = Doctrine::getTable('AttributeValues')->getValueOption($attrObject->getId(), true, $culture);
        $this->widgetSchema["attribute_values_list"] = new sfWidgetFormChoice(array('choices' => $choices));
        break;
    }

    switch ($attribute_type)
    {
      case "textbox":
      case "textarea":
        $this->validatorSchema['attribute_value'] = new sfValidatorRegex(
                array('pattern' => '/^\s*$/', 'must_match' => false, 'required' => $attrObject->getIsRequired()),
                array('invalid' => $i18n->__("Please insert %1%", array("%1%" => $attribute_name)),
                      'required' => $i18n->__("Please insert %1%", array("%1%" => $attribute_name))));
        
        $this->widgetSchema->setLabels(array("attribute_value" => $attribute_name . ($attrObject->getIsRequired() ? " *" : "")));
        $this->setHelp('attribute_value', $i18n->__($attrObject->getHint()));
        unset($this['attribute_values_list']);
        break;
      case "checkbox":
      case "selectbox":
        $choiceValues = array_keys($choices);
        if ($attribute_type == "selectbox" && $attrObject->getIsRequired()){
          array_shift($choiceValues);
        }
        $this->validatorSchema['attribute_values_list'] = new sfValidatorChoice(
                array(
                  'multiple' => true,
                  'choices'  => $choiceValues,
                  'required' => $attrObject->getIsRequired()
                ),
                array(
                  'invalid' => $i18n->__("Please select %1%", array("%1%" => $attribute_name))
            ));
        $this->widgetSchema->setLabels(array("attribute_values_list" => $attribute_name . ($attrObject->getIsRequired() ? " *" : "")));
        $this->setHelp('attribute_values_list', $i18n->__($attrObject->getHint()));
        unset($this['attribute_value']);
        break;
    }
    
    if ($attribute_type == "checkbox")
    {
      $decorator = new attributeCheckFormDecorator($this->getWidgetSchema());
    } else {
      $decorator = new attributeFormDecorator($this->getWidgetSchema());
    }

    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
  }
}