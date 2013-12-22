<?php

class ProductImageTable extends Doctrine_Table
{
  public function getImagesByProductId($product_id)
  {
    $q = Doctrine_Query::create()
            ->from('ProductImage pi')
            ->where('pi.product_id = ?', $product_id)
            ->orderBy('pi.sort_order ASC');
    return $q->execute();
  }

  public function getProductImage($product_id){
    
    $q = Doctrine_Query::create()
           ->from('ProductImage pim')
           ->where('pim.product_id = ?',$product_id);
   return $q  ->fetchOne();
    }
}