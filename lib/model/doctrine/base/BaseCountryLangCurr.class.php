<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CountryLangCurr', 'yozoa');

/**
 * BaseCountryLangCurr
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $country_name
 * @property string $country_code
 * @property string $language_name
 * @property string $language_code
 * @property string $currency_code
 * 
 * @method integer         getId()            Returns the current record's "id" value
 * @method string          getCountryName()   Returns the current record's "country_name" value
 * @method string          getCountryCode()   Returns the current record's "country_code" value
 * @method string          getLanguageName()  Returns the current record's "language_name" value
 * @method string          getLanguageCode()  Returns the current record's "language_code" value
 * @method string          getCurrencyCode()  Returns the current record's "currency_code" value
 * @method CountryLangCurr setId()            Sets the current record's "id" value
 * @method CountryLangCurr setCountryName()   Sets the current record's "country_name" value
 * @method CountryLangCurr setCountryCode()   Sets the current record's "country_code" value
 * @method CountryLangCurr setLanguageName()  Sets the current record's "language_name" value
 * @method CountryLangCurr setLanguageCode()  Sets the current record's "language_code" value
 * @method CountryLangCurr setCurrencyCode()  Sets the current record's "currency_code" value
 * 
 * @package    symfony
 * @subpackage model
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCountryLangCurr extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('country_lang_curr');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('country_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('country_code', 'string', 2, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('language_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('language_code', 'string', 2, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('currency_code', 'string', 3, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 3,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}