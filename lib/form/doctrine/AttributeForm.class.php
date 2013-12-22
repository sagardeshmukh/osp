<?php



/**

 * Attribute form.

 *

 * @package    yozoa

 * @subpackage form

 * @author     Falcon

 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class AttributeForm extends BaseAttributeForm

{

  public function configure()

  {

    //unset($this['is_required']);

    $types = Doctrine::getTable('Attribute')->getTypes();

    $this->widgetSchema['type'] = new sfWidgetFormChoice(array('choices' => $types));

    $this->widgetSchema->setLabels(array('hint' => 'Default Hint/Tip/Help', 'name' => 'Default Name'));





    $attributeId = $this->getObject()->getId();

    foreach(LanguageTable::getLangOption() as $culture => $langName)

    {      

		

      $this->widgetSchema["name_{$culture}"] = new sfWidgetFormInputText(array('label' => "{$langName} name"));

      $this->widgetSchema["hint_{$culture}"] = new sfWidgetFormTextarea(array('label' => "{$langName} hint"));



      if ($attributeId && $object = I18nAttributeTable::getByAttributeIdAndCulture($attributeId, $culture)){

        $this->setDefault("name_{$culture}", $object->getName());

        $this->setDefault("hint_{$culture}", $object->getHint());

      }

    }



	//$this->setWidgets( array('for_country'      => new sfWidgetFormInput()));

	//$this->widgetSchema->setLabels( array('for_country'        => 'Country'));

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->validatorSchema->setOption('filter_extra_fields', false);

  }



  public function getI18nNameFields()

  {

    $widgets = array();

    foreach(LanguageTable::getLangOption() as $culture => $value)

    {

      $widgets[$culture] = $this["name_{$culture}"];

    }

    return $widgets;

  }



  public function getI18nHelpFields()

  {

    $widgets = array();

    foreach(LanguageTable::getLangOption() as $culture => $value)

    {

      $widgets[$culture] = $this["hint_{$culture}"];

    }

    return $widgets;

  }





  public function bind(array $taintedValues = null, array $taintedFiles = null)

  {

    parent::bind($taintedValues, $taintedFiles);

  }



  public function save($con = null)

  {

    $attribute = parent::save($con);

    $taintedValues = $this->getTaintedValues();

    

    foreach(LanguageTable::getLangOption() as $culture => $value){

      $name = $taintedValues["name_{$culture}"];

      $help = $taintedValues["hint_{$culture}"];



      I18nAttributeTable::updateValues($attribute->getId(), $culture, trim($name), trim($help));

    }

    return $attribute;

  }

}

