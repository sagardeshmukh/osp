<?php



/**

 * CategoryAttribute

 *

 * This class has been auto-generated by the Doctrine ORM Framework

 *

 * @package    yozoa

 * @subpackage model

 * @author     Falcon

 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $

 */

class CategoryAttribute extends BaseCategoryAttribute

{

  public function save(Doctrine_Connection $conn = null)

  {

    if ($this->isNew())

    {

      if (is_null($conn))

      {

        $conn = $this->getTable()->getConnection();

      }



      $category_id  = $this->getCategoryId();

      $attribute_id = $this->getAttributeId();



      $values = $conn->execute("

      SELECT

         node.id AS category_id, {$attribute_id} AS attribute_id

      FROM

         category AS parent,

         category AS node

      WHERE

            parent.lft < node.lft

        AND node.rgt < parent.rgt

        AND parent.id = {$category_id}");



      foreach($values as $value)

      {

        try

        {

          $conn->execute("

            INSERT INTO category_attribute (category_id, attribute_id)

            VALUES ({$value['category_id']}, {$value['attribute_id']})");

        }

        catch(Exception $e)

        {

        }

      }

    }

    return parent::save($conn);

  }



  public function delete(Doctrine_Connection $conn = null)

  {

    if (is_null($conn))

    {

      $conn = Doctrine_Manager::connection();

    }



    $category_id  = $this->getCategoryId();

    $attribute_id = $this->getAttributeId();



    //parents

    $values = $conn->execute("

      SELECT

         parent.id AS category_id

      FROM

         category AS parent,

         category AS node

      WHERE

            parent.lft < node.lft

        AND node.rgt < parent.rgt

        AND node.id = {$category_id}");



    foreach($values as $value)

    {

      try

      {

        $conn->execute("DELETE FROM category_attribute WHERE category_id={$value['category_id']} AND attribute_id={$attribute_id}");

      }

      catch(Exception $e)

      {

      }

    }

    return parent::delete($conn);

  }



}