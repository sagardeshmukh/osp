<?php

class myConstants
{

  // static attributes
  public static $RECENT_HOURS = 2008;
  public static $RECENT_DAYS = 2009;
  public static $HOMEPAGE = 2010;
  public static $SUBPAGE = 2012;
  public static $TOP = 2013;
  public static $HOT = 2014;
  public static $URGENT = 2015;
  public static $SALE = 2016;
  public static $DIFFERENT = 2020;
  public static $TOPLIST = 2021;
  public static $BUY_ONLINE = 2022;
  public static $PAID = 2023;
  public static $TOPSEARCH = 2024;

  public static function getAttributeTypes()
  {
    return array(
      self::$RECENT_HOURS => 'recent_hours',
      self::$RECENT_DAYS => 'recent_days',
      self::$HOMEPAGE => 'homepage',
      self::$SUBPAGE => 'subpage',
      self::$TOP => 'top',
      self::$HOT => 'hot',
      self::$URGENT => 'urgent',
      self::$SALE => 'sale',
      self::$DIFFERENT => 'different',
      self::$TOPLIST => 'toplist',
      self::$BUY_ONLINE => 'buy_online',
      self::$PAID => 'paid',
      self::$TOPSEARCH => 'topsearch');
  }

  public static function getAttributeId($attributeType)
  {
    $types = array_flip(self::getAttributeTypes());
    return isset($types[$attributeType]) ? $types[$attributeType] : 0;
  }

  public static function getStaticNumbers()
  {
    return array_flip(self::getStaticNames());
  }

  public static function getExtendDuration()
  {
    return array(
      '30' => 'One month',
      '60' => 'Two month'
    );
  }

  public static function getCategoryTypes()
  {
    return array(
      '1' => 'products',
      '1215' => 'jobs',
      '1269' => 'cars',
      '38' => 'realestates',
      '1370' => 'rental',
      '1372' => 'service',
    );
  }
  public static function getCategoryId($categoryType)
  {
    $typeIds = array_flip(self::getCategoryTypes());
    return isset($typeIds[$categoryType]) ? $typeIds[$categoryType] : 0;
  }

  public static function getCategoryType($categoryId)
  {
    $types = self::getCategoryTypes();
    return isset($types[$categoryId]) ? $types[$categoryId] : '';
  }

    public static function getStartValues()
    {
        return array(
                  '' => 'as soon as possible',
                );
    }

    public static function getDeliveryValues()
    {
        return array(
          '0' => 'same day',
          '2' => 'a few days after starting',
          '7' => 'a week after the start',
          '14' => 'two weeks after the start',
          '21' => 'three weeks after the start',
          '30' => 'a month after startup',
          '90' => 'three months after the start',
          '182' => 'six months after start',
          '365' => 'a year after start',
          '9999' => 'more than one year after start',
        );
    }

    public static function getStartMissionType($type)
    {
      if($type != 'choose'){
         $startMission = self::getStartValues();
         return isset($startMission[$type]) ? $startMission[$type] : '';
      }else{
          return null;
        }
    }

    public static function getEndMissionType($type)
    {
        if($type != 'choose'){
           $endMission = self::getDeliveryValues();
           return isset($endMission[$type]) ? $endMission[$type] : '';
        }else{
            return null;
        }
    }
}
