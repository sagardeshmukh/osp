<?php

class ProductStatTable extends Doctrine_Table
{
    public function readCount($product_id){        
            $q = Doctrine_Query::create()
                        ->from('ProductStat p')
                        ->where('p.product_id = ?',$product_id);
             return $q ->fetchOne();
    }
    
    public function increaseReadCount($product_id){
		$conn  = $this->getConnection();
    	$conn->execute("INSERT INTO `product_stat` (
						`id` ,
						`product_id` ,
						`sold` ,
						`incorrect` ,
						`read_count` ,
						`share_count`
						)
						VALUES (
						NULL , ?,  0,  0,  0,  0
						)
						ON DUPLICATE KEY UPDATE `read_count` = `read_count` + 1;", array($product_id));
        return self::readCount($product_id);
    }
    
    public function increaseStat($product_id, $type){
        $conn  = $this->getConnection();
    	$conn->execute("UPDATE `product_stat` SET `$type` = `$type` + 1 WHERE product_id = ?;", array($product_id));
        return self::readCount($product_id);
    }    
 }