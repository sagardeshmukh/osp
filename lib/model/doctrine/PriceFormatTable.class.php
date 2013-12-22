<?php


class PriceFormatTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PriceFormat');
    }

    public static function getListByCategoryId($category_id = ''){
        $q = Doctrine_Query::create()
                ->select("p.*")
                ->from("priceFormat AS p")
                ->innerJoin("p.Category p_c")
                ->where("p.category_id = ?", $category_id);
        
        return $q->execute();

    }

    public static function validateUnique($id, $category_id, $x_area_id)
    {
        $q = Doctrine_Query::create()
                ->select("p.*")
                ->from("PriceFormat AS p")
                ->where("p.category_id = ?", $category_id)
                ->andWhere("p.x_area_id = ?", $x_area_id);
        if($id){
            $q->andWhere("p.id = ?", $id);
        }
        return $q->fetchOne();
    }


}