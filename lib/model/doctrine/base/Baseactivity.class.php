<?php

// Connection Component Binding

Doctrine_Manager::getInstance()->bindComponent('Activity', 'biznetwork');



/**

 * BaseActivity

 * 

 * This class has been auto-generated by the Doctrine ORM Framework

 * 

 * @property integer $id

 * @property integer $user_id

 * @property integer $object_id

 * @property string $type

 * @property string $comment

 * @property string $content

 * @property timestamp $activity_date

 * @property integer $to_user_id

 * @property integer $can_comment

 * @property integer $is_original

 * @property integer $is_public

 * @property integer $is_new

 * @property integer $is_friend

 * @property integer $is_group

 * 

 * @method integer   getId()            Returns the current record's "id" value

 * @method integer   getUserId()        Returns the current record's "user_id" value

 * @method integer   getObjectId()      Returns the current record's "object_id" value

 * @method string    getType()          Returns the current record's "type" value

 * @method string    getComment()       Returns the current record's "comment" value

 * @method string    getContent()       Returns the current record's "content" value

 * @method timestamp getActivityDate()  Returns the current record's "activity_date" value

 * @method integer   getToUserId()      Returns the current record's "to_user_id" value

 * @method integer   getCanComment()    Returns the current record's "can_comment" value

 * @method integer   getIsOriginal()    Returns the current record's "is_original" value

 * @method integer   getIsPublic()      Returns the current record's "is_public" value

 * @method integer   getIsNew()         Returns the current record's "is_new" value

 * @method integer   getIsFriend()      Returns the current record's "is_friend" value

 * @method integer   getIsGroup()       Returns the current record's "is_group" value

 * @method Activity  setId()            Sets the current record's "id" value

 * @method Activity  setUserId()        Sets the current record's "user_id" value

 * @method Activity  setObjectId()      Sets the current record's "object_id" value

 * @method Activity  setType()          Sets the current record's "type" value

 * @method Activity  setComment()       Sets the current record's "comment" value

 * @method Activity  setContent()       Sets the current record's "content" value

 * @method Activity  setActivityDate()  Sets the current record's "activity_date" value

 * @method Activity  setToUserId()      Sets the current record's "to_user_id" value

 * @method Activity  setCanComment()    Sets the current record's "can_comment" value

 * @method Activity  setIsOriginal()    Sets the current record's "is_original" value

 * @method Activity  setIsPublic()      Sets the current record's "is_public" value

 * @method Activity  setIsNew()         Sets the current record's "is_new" value

 * @method Activity  setIsFriend()      Sets the current record's "is_friend" value

 * @method Activity  setIsGroup()       Sets the current record's "is_group" value

 * 

 * @package    yozoa

 * @subpackage model

 * @author     Falcon

 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $

 */

abstract class BaseActivity extends sfDoctrineRecord

{

    public function setTableDefinition()

    {

        $this->setTableName('activity');

        $this->hasColumn('id', 'integer', 20, array(

             'type' => 'integer',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => true,

             'autoincrement' => true,

             'length' => 20,

             ));

        $this->hasColumn('user_id', 'integer', 11, array(

             'type' => 'integer',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 11,

             ));

        $this->hasColumn('object_id', 'integer', 11, array(

             'type' => 'integer',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => false,

             'autoincrement' => false,

             'length' => 11,

             ));

        $this->hasColumn('type', 'string', 20, array(

             'type' => 'string',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 20,

             ));

        $this->hasColumn('comment', 'string', 255, array(

             'type' => 'string',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 255,

             ));

        $this->hasColumn('content', 'string', null, array(

             'type' => 'string',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => false,

             'autoincrement' => false,

             'length' => '',

             ));

        $this->hasColumn('activity_date', 'timestamp', 25, array(

             'type' => 'timestamp',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 25,

             ));

        $this->hasColumn('to_user_id', 'integer', 11, array(

             'type' => 'integer',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 11,

             ));

        $this->hasColumn('can_comment', 'integer', 1, array(

             'type' => 'integer',

             'default' => '0',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 1,

             ));

        $this->hasColumn('is_original', 'integer', 1, array(

             'type' => 'integer',

             'default' => '1',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 1,

             ));

        $this->hasColumn('is_public', 'integer', 1, array(

             'type' => 'integer',

             'default' => '0',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 1,

             ));

        $this->hasColumn('is_new', 'integer', 1, array(

             'type' => 'integer',

             'default' => '0',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 1,

             ));

        $this->hasColumn('is_friend', 'integer', 1, array(

             'type' => 'integer',

             'default' => '0',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 1,

             ));

        $this->hasColumn('is_group', 'integer', 1, array(

             'type' => 'integer',

             'default' => '0',

             'fixed' => 0,

             'unsigned' => false,

             'primary' => false,

             'notnull' => true,

             'autoincrement' => false,

             'length' => 1,

             ));

    }



    public function setUp()

    {

        parent::setUp();

        

    }

}