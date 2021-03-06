<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ProductStat', 'yozoa');

/**
 * BaseProductStat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $product_id
 * @property integer $sold
 * @property integer $incorrect
 * @property integer $read_count
 * @property integer $share_count
 * @property Product $Product
 * 
 * @method integer     getId()          Returns the current record's "id" value
 * @method integer     getProductId()   Returns the current record's "product_id" value
 * @method integer     getSold()        Returns the current record's "sold" value
 * @method integer     getIncorrect()   Returns the current record's "incorrect" value
 * @method integer     getReadCount()   Returns the current record's "read_count" value
 * @method integer     getShareCount()  Returns the current record's "share_count" value
 * @method Product     getProduct()     Returns the current record's "Product" value
 * @method ProductStat setId()          Sets the current record's "id" value
 * @method ProductStat setProductId()   Sets the current record's "product_id" value
 * @method ProductStat setSold()        Sets the current record's "sold" value
 * @method ProductStat setIncorrect()   Sets the current record's "incorrect" value
 * @method ProductStat setReadCount()   Sets the current record's "read_count" value
 * @method ProductStat setShareCount()  Sets the current record's "share_count" value
 * @method ProductStat setProduct()     Sets the current record's "Product" value
 * 
 * @package    symfony
 * @subpackage model
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProductStat extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('product_stat');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('product_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('sold', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('incorrect', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('read_count', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             ));
        $this->hasColumn('share_count', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Product', array(
             'local' => 'product_id',
             'foreign' => 'id'));
    }
}