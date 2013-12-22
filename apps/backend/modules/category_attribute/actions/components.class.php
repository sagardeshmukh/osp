<?php



/**

 * advertise actions.

 *

 * @package    sf_sandbox

 * @subpackage advertise

 * @author     Your name here

 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $

 */

class category_attributeComponents extends sfComponents

{

  /**

   * Index page banner

   */

  public function executeList(sfWebRequest $request)

  {

    $this->category_attributes = Doctrine::getTable('CategoryAttribute')->getListByAttributeId($this->attribute_id);

    $this->form = new CategoryAttributeForm();

    $this->form->setDefault('attribute_id', $this->attribute_id);

  }

}

