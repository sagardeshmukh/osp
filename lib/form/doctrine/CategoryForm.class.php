<?php

/**
 * Category form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryForm extends BaseCategoryForm
{

  public function configure()
  {
    unset($this['lft'], $this['rgt'], $this['level']);
    //$categories = Doctrine::getTable('Category')->getParentCategoryOptions($this->getObject()->getId());
    //$categories = Doctrine::getTable('Category')->getParentCategoryOptions(0);
    
    $this->widgetSchema['parent_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['logo'] = new sfWidgetFormInputFile(array('label' => 'Logo File'), array('size' => 40));
    $this->widgetSchema->setLabels(array('name' => 'Default Name'));
    $categoryId = $this->getObject()->getId();
    foreach (LanguageTable::getLangOption() as $culture => $langName)
    {
      $this->widgetSchema["name_{$culture}"] = new sfWidgetFormInputText(array('label' => "{$langName} name"));

      if ($categoryId && $object = I18nCategoryTable::getByCategoryIdAndCulture($categoryId, $culture))
      {
        $this->setDefault("name_{$culture}", $object->getName());
      }
    }


    $this->validatorSchema->setPreValidator(
        new sfValidatorCallback(array('callback' => array($this, 'preValidateLogo')))
    );

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);
  }

  public function getI18nNameFields()
  {
    $widgets = array();
    foreach (LanguageTable::getLangOption() as $culture => $value)
    {
      $widgets[$culture] = $this["name_{$culture}"];
    }
    return $widgets;
  }

  public function preValidateLogo($validator, $values)
  {
    $required = false;
    $filename = sfConfig::get('sf_upload_dir') . '/category/' . $this->getObject()->getLogo();

    if (!is_file($filename))
    {
      $required = true;
    }

    $this->validatorSchema['logo'] = new sfValidatorFile(array(
          'required' => false,
          'mime_types' => array(
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/x-png',
            'image/gif')
            ), array(
          'invalid' => 'Invalid file.',
          'required' => 'Select a file to upload.',
          'mime_types' => 'The file must be a supported type.'
        ));

    return $values;
  }

  public function save($con = null)
  {
    $category = parent::save($con);
    $taintedValues = $this->getTaintedValues();

    foreach (LanguageTable::getLangOption() as $culture => $value)
    {
      $name = $taintedValues["name_{$culture}"];
      I18nCategoryTable::updateValues($category->getId(), $culture, trim($name));
    }
    return $category;
  }

}