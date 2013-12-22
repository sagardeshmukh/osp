<?php


class ProductCommentTable extends Doctrine_Table
{
  public static function getInstance()
  {
    return Doctrine_Core::getTable('ProductComment');
  }

  public function getComments($product_id)
  {
    $q = Doctrine_Query::create()
            ->from('ProductComment pc')
            ->innerJoin('pc.Product p')
            ->where('pc.product_id = ?', $product_id)
            ->andWhere('pc.type = ?', 0)
            ->orderBy('pc.created_at ASC');
    return $q->execute();
  }
  public function getIndexComments()
  {
    $q = Doctrine_Query::create()
            ->from('ProductComment pc')
            ->innerJoin('pc.Product p on pc.product_id = p.id')
            ->where('pc.parent_id = ?',0)
            ->andWhere('p.status = 1')
            ->orderBy('pc.created_at DESC')
            ->limit(10);
    return $q->execute();
  }
  public function getNotes($product_id)
  {
    $q = Doctrine_Query::create()
            ->from('ProductComment pc')
            ->innerJoin('pc.Product p')
            ->where('pc.parent_id = ?', $product_id)
            ->orderBy('pc.created_at ASC');
    return $q->execute();
  }

  public function getQuestion($comment_id, $user_id)
  {
    $q = Doctrine_Query::create()
            ->from('ProductComment pc')
            ->innerJoin('pc.Product p')
            ->where('pc.parent_id = ?', $comment_id)
            ->andWhere('pc.user_id <> ', $user_id)
            ->distinct('pc.parent_id')
            ->groupBy('pc.parent_id');
    return $q->execute();
  }
  /**
   * Product-t haryalagdax bux comment
   * @param integer $product_id
   * @return DoctrineCollection
   */
  
  public function getProductComments($product_id)
  {
    $product_id = (int) $product_id;
    $q = Doctrine_Query::create()
            ->from('ProductComment pc')
            ->where('pc.product_id = ?', $product_id);
    return $q->execute();
  }
}