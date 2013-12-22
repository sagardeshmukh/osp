<?php



/**

 * advertise actions.

 *

 * @package    sf_sandbox

 * @subpackage advertise

 * @author     Your name here

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class productComponents extends sfComponents

{

  public function executeFeatured(sfWebRequest $request)

  {

    $this->products = Doctrine::getTable('Product')->getBuyOnline(sfConfig::get('category_id', 0), 5);

  }



  public function executeSimilarProducts(sfWebRequest $request)

  {

    $this->products = Doctrine::getTable('Product')->getSameProducts($this->productId, 6);
	//echo "count=".count($this->products); exit;

  }



  public function executeNewProjects(sfWebRequest $request)

  {

    $this->products = Doctrine::getTable('Product')->getProductsByCategoryId(40, 4);

  }

  public function executeComments(sfWebRequest $request)

  {

    

    $this->comment_error = $this->comment_error;

    $this->productId=$this->productId;

    $this->comments = Doctrine::getTable('ProductComment')->getComments($this->productId);

    $this->my_product = Doctrine::getTable('Product')->find($this->productId);

  }

  public function executeNewProduct(sfWebRequest $request)

  {

    $this->products = Doctrine::getTable('Product')->getNewProduct(24);

  }

  public function executeIndexComment(sfWebRequest $request)

  {

    $this->comments = Doctrine::getTable('ProductComment')->getIndexComments();

  }

}

