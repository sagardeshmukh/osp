<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Attribute', 'yozoa');

/**
 * BaseAttribute
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $country
 * @property boolean $is_main
 * @property boolean $is_column
 * @property boolean $is_filterable
 * @property integer $sort_order
 * @property boolean $is_required
 * @property integer $is_collapse
 * @property boolean $is_map
 * @property string $hint
 * @property Doctrine_Collection $AttributeValues
 * @property Doctrine_Collection $I18nAttribute
 * @property Doctrine_Collection $CategoryAttribute
 * @property Doctrine_Collection $ProductAttribute
 * 
 * @method integer             getId()                Returns the current record's "id" value
 * @method string              getName()              Returns the current record's "name" value
 * @method string              getType()              Returns the current record's "type" value
 * @method integer             getCountry()           Returns the current record's "country" value
 * @method boolean             getIsMain()            Returns the current record's "is_main" value
 * @method boolean             getIsColumn()          Returns the current record's "is_column" value
 * @method boolean             getIsFilterable()      Returns the current record's "is_filterable" value
 * @method integer             getSortOrder()         Returns the current record's "sort_order" value
 * @method boolean             getIsRequired()        Returns the current record's "is_required" value
 * @method integer             getIsCollapse()        Returns the current record's "is_collapse" value
 * @method boolean             getIsMap()             Returns the current record's "is_map" value
 * @method string              getHint()              Returns the current record's "hint" value
 * @method Doctrine_Collection getAttributeValues()   Returns the current record's "AttributeValues" collection
 * @method Doctrine_Collection getI18nAttribute()     Returns the current record's "I18nAttribute" collection
 * @method Doctrine_Collection getCategoryAttribute() Returns the current record's "CategoryAttribute" collection
 * @method Doctrine_Collection getProductAttribute()  Returns the current record's "ProductAttribute" collection
 * @method Attribute           setId()                Sets the current record's "id" value
 * @method Attribute           setName()              Sets the current record's "name" value
 * @method Attribute           setType()              Sets the current record's "type" value
 * @method Attribute           setCountry()           Sets the current record's "country" value
 * @method Attribute           setIsMain()            Sets the current record's "is_main" value
 * @method Attribute           setIsColumn()          Sets the current record's "is_column" value
 * @method Attribute           setIsFilterable()      Sets the current record's "is_filterable" value
 * @method Attribute           setSortOrder()         Sets the current record's "sort_order" value
 * @method Attribute           setIsRequired()        Sets the current record's "is_required" value
 * @method Attribute           setIsCollapse()        Sets the current record's "is_collapse" value
 * @method Attribute           setIsMap()             Sets the current record's "is_map" value
 * @method Attribute           setHint()              Sets the current record's "hint" value
 * @method Attribute           setAttributeValues()   Sets the current record's "AttributeValues" collection
 * @method Attribute           setI18nAttribute()     Sets the current record's "I18nAttribute" collection
 * @method Attribute           setCategoryAttribute() Sets the current record's "CategoryAttribute" collection
 * @method Attribute           setProductAttribute()  Sets the current record's "ProductAttribute" collection
 * 
 * @package    symfony
 * @subpackage model
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAttribute extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('attribute');
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
        $this->hasColumn('type', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('country', 'integer', 2, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('is_main', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));
        $this->hasColumn('is_column', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));
        $this->hasColumn('is_filterable', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             'notnull' => true,
             ));
        $this->hasColumn('sort_order', 'integer', 2, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('is_required', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             'notnull' => true,
             ));
        $this->hasColumn('is_collapse', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('is_map', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));
        $this->hasColumn('hint', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('AttributeValues', array(
             'local' => 'id',
             'foreign' => 'attribute_id'));

        $this->hasMany('I18nAttribute', array(
             'local' => 'id',
             'foreign' => 'attribute_id'));

        $this->hasMany('CategoryAttribute', array(
             'local' => 'id',
             'foreign' => 'attribute_id'));

        $this->hasMany('ProductAttribute', array(
             'local' => 'id',
             'foreign' => 'attribute_id'));
    }
}