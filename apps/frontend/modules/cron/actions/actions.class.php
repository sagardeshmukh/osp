<?php



/**

 * attribute actions.

 *

 * @package    yozoa

 * @subpackage attribute

 * @author     Falcon

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class cronActions extends sfActions

{



  public function preExecute()

  {

    set_time_limit(0);

  }



  private function getMySqlLink()

  {

    $link = mysql_connect('localhost', 'root', 'newyear');

    if (!$link)

    {

      die('Could not connect: ' . mysql_error());

    }

    // make foo the current db

    $db_selected = mysql_select_db('yozoa', $link);

    if (!$db_selected)

    {

      die('Can\'t use foo : ' . mysql_error());

    }

    return $link;

  }



  // daily

  public function executeUpdateProductCurrency()

  {

    $q = Doctrine_Query::create()->from('Currency c');

    foreach ($q->execute() as $currency)

    {

      if ($currency->getCode() == "USD")

      {

        continue;

      }

      Doctrine_Query::create()

          ->update('Product')

          ->set('price_global', "price_original / {$currency->getValue()}")

          ->where('currency_main = ?', $currency->getCode())

          ->execute();

    }

    exit();

  }



  // daily

  public function executeUpdateProductExpire()

  {

    //$mysql_link  = $this->getMySqlLink();

    Doctrine_Query::create()

        ->update('Product')

        ->set('status', '?', 2)

        ->where('status = ?', 1)

        ->andWhere('DATE_ADD(product.confirmed_at, INTERVAL product.duration DAY) < NOW()')

        ->execute();

    //mysql_query('UPDATE product SET status=2 WHERE product.status=1 AND ');

    exit();

  }



  /**

   * runs daily. updates doping of Homepage, Subpage, TopList, Different, Sale, Urgent, Paid

   * @return unknown_type

   */

  public function executeUpdateProductDoping()

  {

    /*

     */

    $expireDate = date("Y-m-d H:i:s", time());

    $mysql_link = $this->getMySqlLink();

    $attributeDValues = array(

      myConstants::$DIFFERENT => 'different',

      myConstants::$HOMEPAGE => 'homepage',

      myConstants::$SUBPAGE => 'subpage',

      myConstants::$TOPLIST => 'toplist',

      myConstants::$TOPSEARCH => 'topsearch',

      myConstants::$SALE => 'sale',

      myConstants::$URGENT => 'urgent'

    );

    $attributeDkeys = array_keys($attributeDValues);

  /**

   *  6 hourly (4 times a day). updates TOP 100, Hot

   *

   */

  public function executeUpdateTopProducts()

  {

    $limit = 100;

    $mysql_link = $this->getMySqlLink();

    $attributeValueId = myConstants::$TOP;

    $products = mysql_query("

      SELECT p.*, ps.read_count

      FROM product p

      INNER JOIN product_stat ps ON p.id=ps.product_id

      WHERE p.status=1

      ORDER BY ps.read_count DESC

      LIMIT {$limit}");





    $read_count = 0;

    //adding attribute

    while ($product = mysql_fetch_assoc($products))

    {

      $attributeValueIds = preg_split('/,/', $product['attribute_value_ids'], -1, PREG_SPLIT_NO_EMPTY);

      if (!in_array($attributeValueId, $attributeValueIds))

      {

        $attributeValueIds[] = $attributeValueId;

        mysql_query("UPDATE product SET attribute_value_ids='" . join(",", $attributeValueIds) . "' WHERE id='{$product['id']}'");

      }

      $read_count = (int) $product['read_count'];

    }



    // This is done automatically at the end of the script

    mysql_free_result($products);



    $products = mysql_query("

      SELECT p.*

      FROM product p

      INNER JOIN product_stat ps ON p.id=ps.product_id

      WHERE MATCH(p.attribute_value_ids) AGAINST('+" . $attributeValueId . "}' IN BOOLEAN MODE)

        AND p.status=1

        AND ps.read_count < {$read_count}");



    while ($product = mysql_fetch_assoc($products))

    {

      $attributeValueIds = preg_split('/,/', $product['attribute_value_ids'], -1, PREG_SPLIT_NO_EMPTY);

      $attributeValueIds = array_diff($attributeValueIds, array($attributeValueId));

      mysql_query("UPDATE product SET attribute_value_ids='" . join(",", $attributeValueIds) . "' WHERE id='{$product['id']}'");

    }

    mysql_free_result($products);

    exit();

  }



  /*   * *

   * Update Buy Online

   */



  public function executeUpdateBuyOnline()

  {

    $mysql_link = $this->getMySqlLink();

    $products = mysql_query("

      SELECT p.*

      FROM product p

      WHERE p.status=1

      AND FIND_IN_SET(" . myConstants::$BUY_ONLINE . ", p.attribute_value_ids)=0

      AND p.buy_online=1");



    while ($product = mysql_fetch_assoc($products))

    {

      $attributeValueIds = preg_split('/,/', $product['attribute_value_ids'], -1, PREG_SPLIT_NO_EMPTY);

      $attributeValueIds[] = myConstants::$BUY_ONLINE;

      mysql_query("UPDATE product SET attribute_value_ids='" . join(",", $attributeValueIds) . "' WHERE id='{$product['id']}'");

    }



    mysql_free_result($products);

    exit();

  }



  /**

   * PRODUCT EMAILS

   */

  public function executeRecentProducts()

  {

    $mysql_link = $this->getMySqlLink();



    $date = date("Y-m-d H:i:s", (time() - 86400));

    //LAST 24 HOUR REMOVING

    $products = mysql_query("SELECT product.* FROM product WHERE status=1 AND MATCH(attribute_value_ids) AGAINST('+" . myConstants::$RECENT_HOURS . "}' IN BOOLEAN MODE) AND confirmed_at < '{$date}'");

    while ($product = mysql_fetch_assoc($products))

    {

      $attributeValueIds = preg_split('/,/', $product['attribute_value_ids'], -1, PREG_SPLIT_NO_EMPTY);

      $attributeValueIds = array_diff($attributeValueIds, array(myConstants::$RECENT_HOURS));

      mysql_query("UPDATE product SET attribute_value_ids='" . join(",", $attributeValueIds) . "' WHERE id='{$product['id']}'");

    }



    mysql_free_result($products);

    $products = mysql_query("SELECT product.* FROM product WHERE status=1 AND FIND_IN_SET(" . myConstants::$RECENT_HOURS . ", attribute_value_ids)=0 AND confirmed_at >= '{$date}'");

    while ($product = mysql_fetch_assoc($products))

    {

      $attributeValueIds = preg_split('/,/', $product['attribute_value_ids'], -1, PREG_SPLIT_NO_EMPTY);

      $attributeValueIds[] = myConstants::$RECENT_HOURS;

      mysql_query("UPDATE product SET attribute_value_ids='" . join(",", $attributeValueIds) . "' WHERE id='{$product['id']}'");

    }

    mysql_free_result($products);



    //LAST 3 DAYS REMOVING

    $products = mysql_query("SELECT product.* FROM product WHERE status=1 AND MATCH(attribute_value_ids) AGAINST('+" . myConstants::$RECENT_DAYS . "}' IN BOOLEAN MODE) AND confirmed_at < '" . date("Y-m-d H:i:s", time() - 86400 * 3) . "'");

    while ($product = mysql_fetch_assoc($products))

    {

      $attributeValueIds = preg_split('/,/', $product['attribute_value_ids'], -1, PREG_SPLIT_NO_EMPTY);

      $attributeValueIds = array_diff($attributeValueIds, array(myConstants::$RECENT_DAYS));

      mysql_query("UPDATE product SET attribute_value_ids='" . join(",", $attributeValueIds) . "' WHERE id='{$product['id']}'");

    }

    mysql_free_result($products);



    $products = mysql_query("SELECT product.* FROM product WHERE status=1 AND FIND_IN_SET(" . myConstants::$RECENT_DAYS . ", attribute_value_ids)=0  AND confirmed_at > '" . date("Y-m-d H:i:s", time() - 86400 * 3) . "'");

    while ($product = mysql_fetch_assoc($products))

    {

      $attributeValueIds = preg_split('/,/', $product['attribute_value_ids'], -1, PREG_SPLIT_NO_EMPTY);

      $attributeValueIds[] = myConstants::$RECENT_DAYS;

      mysql_query("UPDATE product SET attribute_value_ids='" . join(",", $attributeValueIds) . "' WHERE id='{$product['id']}'");

    }

    mysql_free_result($products);

    exit();

  }





  /**

   * SEND PRODUCTS' REPORTS TO PRODUCTS OWNERS

   */

  public function executeSendToProductOwner()

  {

    $expiredProducts = Doctrine::getTable("Product")->getExpiredProducts();

    foreach ($expiredProducts as $expiredProduct)

    {

      $days = (time() - strtotime($expiredProduct->getConfirmedAt()));

      $days = number_format($days / (86400), 0);



      $user = $expiredProduct->getUser();

      $mailTo = $user ? $user->getEmail() : "handaa.1224@gmail.com";

      $mailSubject = __('Your product has been expired.');

      $mailBody = $this->getPartial("mail/toProductOwner", array("days" => $days, "product" => $expiredProduct));

      $message = $this->getMailer()->compose(array('info@yozoa.mn' => 'yozoa'), $mailTo, $mailSubject, $mailBody);

      $message->setContentType("text/html");

      try

      {

        $this->getMailer()->send($message);

      } catch (Exception $e)

      {



      }

    }



    $products = Doctrine::getTable("Product")->get14DaysProducts();

    foreach ($products as $product)

    {

      $days = (time() - strtotime($product->getConfirmedAt()));

      $days = number_format($days / (86400), 0);



      $user = $product->getUser();

      $mailTo = $user ? $user->getEmail() : "handaa.1224@gmail.com";

      $mailSubject = __('Your inserted product in Yozoa.com.');

      $mailBody = $this->getPartial("mail/toProductOwner", array("days" => $days, "product" => $product));

      $message = $this->getMailer()->compose(array('info@yozoa.mn' => 'yozoa'), $mailTo, $mailSubject, $mailBody);

      $message->setContentType("text/html");

      try

      {

        $this->getMailer()->send($message);

      } catch (Exception $e)

      {

        

      }

    }



    $this->getUser()->setFlash("success", "Emails successfully send :)");

    $this->redirect("@homepage");

  }



}