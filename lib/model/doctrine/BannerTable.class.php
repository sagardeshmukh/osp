<?php

class BannerTable extends Doctrine_Table
{
  public function getBanner($categoryIds)
  {
    $today = date("Y-m-d");
    $q = Doctrine_Query::create()
            ->from('Banner b')
            ->whereIn('b.category_id', $categoryIds)
            ->andWhere('b.begin_date <= ?', $today)
            ->andWhere('b.end_date >= ?', $today);
    return $q->fetchOne();
  }

}