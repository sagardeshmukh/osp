<?php



/**

 * rss actions.

 *

 * @package    yozoa

 * @subpackage rss

 * @author     Falcon

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class rssActions extends sfActions

{

	

  /**

  * list latest categories

  *

  * @param sfRequest $request A request object

  */

  public function executeList(sfWebRequest $request)

  {

    //selected category id

    $category_id = (int) $request->getParameter('categoryId', 0);

    $this->forward404Unless($this->category = Doctrine::getTable('Category')->find($category_id));

    sfConfig::set('category_id', $category_id);



    // sort type

    $sortType = 'date_desc';

    

    $products = Doctrine::getTable('Product')->getLatest(null, 25);

    

    $feed = new sfAtom1Feed();



    //$feed->setTitle('Yozoa - '.$this->category->getName());//. ' - '. __('New product') );

    //$feed->setLink('@product_browse?categoryId='.$this->category->getId()."&xType=cars");

    //$feed->setAuthorName('yozoa.mn');



    foreach ($products as $product)

    {

      $item = new sfFeedItem();

      $item->setTitle(myTools::utf8_substr(strip_tags($product->getName()), 0, 100));

      $item->setLink('http://yozoa.mn/p/'.$product->getId());

      $item->setAuthorName('yozoa.mn');

      $item->setAuthorEmail('info@singleton.mn');

      //$date = new DateTime($product->getConfirmedAt());

      $item->setPubdate($product->getConfirmedAt('U'));

      $item->setUniqueId($product->getId());

      $item->setDescription(myTools::utf8_substr(trim(strip_tags($product->getDescription())), 0, 200));



      $feed->addItem($item);

    }



    $this->feed = $feed;    

  }

}

