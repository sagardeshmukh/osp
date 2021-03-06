<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CategoryAttribute', 'yozoa');

/**
 * BaseCategoryAttribute
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $category_id
 * @property integer $attribute_id
 * @property Category $Category
 * @property Attribute $Attribute
 * 
 * @method integer           getCategoryId()   Returns the current record's "category_id" value
 * @method integer           getAttributeId()  Returns the current record's "attribute_id" value
 * @method Category          getCategory()     Returns the current record's "Category" value
 * @method Attribute         getAttribute()    Returns the current record's "Attribute" value
 * @method CategoryAttribute setCategoryId()   Sets the current record's "category_id" value
 * @method CategoryAttribute setAttributeId()  Sets the current record's "attribute_id" value
 * @method CategoryAttribute setCategory()     Sets the current record's "Category" value
 * @method CategoryAttribute setAttribute()    Sets the current record's "Attribute" value
 * 
 * @package    symfony
 * @subpackage model
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCategoryAttribute extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('category_attribute');
        $this->hasColumn('category_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('attribute_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Category', array(
             'local' => 'category_id',
             'foreign' => 'id'));

        $this->hasOne('Attribute', array(
             'local' => 'attribute_id',
             'foreign' => 'id'));
    }
}