<?php

/**
 * CategoryAttribute form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryAttributeForm extends BaseCategoryAttributeForm
{
  public function configure()
  {
    $categories = Doctrine::getTable('Category')->getParentCategoryOptions(0);

    $this->widgetSchema['attribute_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['category_id']  = new sfWidgetFormChoice(array('choices' => $categories), array('style' => 'width: 450px'));

    $this->validatorSchema['category_id'] = new sfValidatorDoctrineChoice(array('model' => 'Category', 'column' => 'id', 'required' => false));
    $this->validatorSchema['attribute_id'] = new sfValidatorDoctrineChoice(array('model' => 'Attribute', 'column' => 'id', 'required' => false));

    $this->validatorSchema->setPostValidator(
            new sfValidatorCallback(array('callback' => array($this, 'checkUnique')))
    );
  }

  public function checkUnique($validator, $values)
  {
    $q = Doctrine_Core::getTable('CategoryAttribute')->createQuery('a');
    if (isset($values['category_id']) && isset($values['attribute_id']))
    {
      $q->andWhere('a.category_id = ?', $values['category_id']);
      $q->andWhere('a.attribute_id = ?', $values['attribute_id']);

      if ($q->fetchOne())
      {
        throw new sfValidatorError($validator, 'Already inserted in DB');
      }
    }
    // password is correct, return the clean values
    return $values;
  }
}
