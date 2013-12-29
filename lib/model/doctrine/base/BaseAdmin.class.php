<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Admin', 'yozoa');

/**
 * BaseAdmin
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $type
 * @property timestamp $last_logged_at
 * @property timestamp $created_at
 * @property string $permission
 * 
 * @method integer   getId()             Returns the current record's "id" value
 * @method string    getFirstname()      Returns the current record's "firstname" value
 * @method string    getLastname()       Returns the current record's "lastname" value
 * @method string    getUsername()       Returns the current record's "username" value
 * @method string    getPassword()       Returns the current record's "password" value
 * @method string    getEmail()          Returns the current record's "email" value
 * @method integer   getType()           Returns the current record's "type" value
 * @method timestamp getLastLoggedAt()   Returns the current record's "last_logged_at" value
 * @method timestamp getCreatedAt()      Returns the current record's "created_at" value
 * @method string    getPermission()     Returns the current record's "permission" value
 * @method Admin     setId()             Sets the current record's "id" value
 * @method Admin     setFirstname()      Sets the current record's "firstname" value
 * @method Admin     setLastname()       Sets the current record's "lastname" value
 * @method Admin     setUsername()       Sets the current record's "username" value
 * @method Admin     setPassword()       Sets the current record's "password" value
 * @method Admin     setEmail()          Sets the current record's "email" value
 * @method Admin     setType()           Sets the current record's "type" value
 * @method Admin     setLastLoggedAt()   Sets the current record's "last_logged_at" value
 * @method Admin     setCreatedAt()      Sets the current record's "created_at" value
 * @method Admin     setPermission()     Sets the current record's "permission" value
 * 
 * @package    symfony
 * @subpackage model
 * @author     Sagar S. Deshmukh
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAdmin extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('admin');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('firstname', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('lastname', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('username', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('password', 'string', 32, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 32,
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('type', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('last_logged_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'notnull' => true,
             'length' => 25,
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'notnull' => true,
             'length' => 25,
             ));
        $this->hasColumn('permission', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}