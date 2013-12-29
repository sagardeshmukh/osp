<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Category', 'yozoa');

/**
 * BaseCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $logo
 * @property boolean $is_visible
 * @property boolean $is_featured
 * @property boolean $is_map
 * @property integer $parent_id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $sort_order
 * @property Category $Category
 * @property Doctrine_Collection $I18nCategory
 * @property Doctrine_Collection $CategoryAttribute
 * @property Doctrine_Collection $Product
 * @property Doctrine_Collection $PriceFormat
 * 
 * @method integer             getId()                Returns the current record's "id" value
 * @method string              getName()              Returns the current record's "name" value
 * @method string              getDescription()       Returns the current record's "description" value
 * @method string              getLogo()              Returns the current record's "logo" value
 * @method boolean             getIsVisible()         Returns the current record's "is_visible" value
 * @method boolean             getIsFeatured()        Returns the current record's "is_featured" value
 * @method boolean             getIsMap()             Returns the current record's "is_map" value
 * @method integer             getParentId()          Returns the current record's "parent_id" value
 * @method integer             getLft()               Returns the current record's "lft" value
 * @method integer             getRgt()               Returns the current record's "rgt" value
 * @method integer             getLevel()             Returns the current record's "level" value
 * @method integer             getSortOrder()         Returns the current record's "sort_order" value
 * @method Category            getCategory()          Returns the current record's "Category" value
 * @method Doctrine_Collection getI18nCategory()      Returns the current record's "I18nCategory" collection
 * @method Doctrine_Collection getCategoryAttribute() Returns the current record's "CategoryAttribute" collection
 * @method Doctrine_Collection getProduct()           Returns the current record's "Product" collection
 * @method Doctrine_Collection getPriceFormat()       Returns the current record's "PriceFormat" collection
 * @method Category            setId()                Sets the current record's "id" value
 * @method Category            setName()              Sets the current record's "name" value
 * @method Category            setDescription()       Sets the current record's "description" value
 * @method Category            setLogo()              Sets the current record's "logo" value
 * @method Category            setIsVisible()         Sets the current record's "is_visible" value
 * @method Category            setIsFeatured()        Sets the current record's "is_featured" value
 * @method Category            setIsMap()             Sets the current record's "is_map" value
 * @method Category            setParentId()          Sets the current record's "parent_id" value
 * @method Category            setLft()               Sets the current record's "lft" value
 * @method Category            setRgt()               Sets the current record's "rgt" value
 * @method Category            setLevel()             Sets the current record's "level" value
 * @method Category            setSortOrder()         Sets the current record's "sort_order" value
 * @method Category            setCategory()          Sets the current record's "Category" value
 * @method Category            setI18nCategory()      Sets the current record's "I18nCategory" collection
 * @method Category            setCategoryAttribute() Sets the current record's "CategoryAttribute" collection
 * @method Category            setProduct()           Sets the current record's "Product" collection
 * @method Category            setPriceFormat()       Sets the current record's "PriceFormat" collection
 * 
 * @package    symfony
 * @subpackage model
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCategory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('category');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '',
             ));
        $this->hasColumn('logo', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('is_visible', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             'notnull' => true,
             ));
        $this->hasColumn('is_featured', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             'notnull' => true,
             ));
        $this->hasColumn('is_map', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             'notnull' => true,
             ));
        $this->hasColumn('parent_id', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             ));
        $this->hasColumn('lft', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             ));
        $this->hasColumn('rgt', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             ));
        $this->hasColumn('level', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('sort_order', 'integer', 2, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 2,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Category', array(
             'local' => 'parent_id',
             'foreign' => 'id'));

        $this->hasMany('I18nCategory', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('CategoryAttribute', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('Product', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('PriceFormat', array(
             'local' => 'id',
             'foreign' => 'category_id'));
    }
}