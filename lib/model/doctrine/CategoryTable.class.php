<?php



class CategoryTable extends Doctrine_Table

{



  private $cat_options = array('----');



  public function getTypes()

  {

    $q = Doctrine_Query::create()

            ->from('Category c')

            ->orderBy('c.sort_order, c.name')

            ->where('c.parent_id = ?', 1);

    return $q->execute();

  }



  public function formatCategory($level, $parent_id, $nested_category)

  {

    foreach ($nested_category[$parent_id] as $id => $name)

    {

      $this->cat_options[$id] = str_repeat('&nbsp;', $level * 8) . $name;

      if (isset($nested_category[$id]))

      {

        $this->formatCategory($level + 1, $id, $nested_category);

      }

    }

  }



  /**

   * return formatted array

   * @param integer $self_ids

   * @return array

   */

  public function getParentCategoryOptions($self_ids = 0, $culture = "", $lvl = "")

  {

    //if (!is_array($self_ids)) $self_ids = (array) $self_ids;

    //first select categories

    $q = Doctrine_Query::create()

            ->select('c.*')

            ->addSelect('COALESCE(ic.name, c.name) AS name')

            ->from('Category c')

            ->leftJoin('c.I18nCategory ic WITH ic.culture = ?', $culture)

            ->orderBy('c.sort_order, c.name')

            ->andWhereNotIn('c.id', (array) $self_ids);

   if($lvl){

     $q->andWhere("c.level=0");

    }

    $categories = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

    //$categories = $q->execute();



    $nested_category = array();

    foreach ($categories as $category)

    {

      //$nested_category[$category->getParentId()][$category->getId()] = $category->getName();

      $nested_category[$category['parent_id']][$category['id']] = $category['name'];

    }

    if (isset($nested_category[0]))

    {

      $this->formatCategory(0, 0, $nested_category);

    }



    return $this->cat_options;

  }



  /**

   * return Number of product

   * @param integer $category_id

   */

  public function getNbProduct($category_id)

  {

    $con = $this->getConnection();



    $row = $con->fetchRow("

      SELECT COUNT(parent.id) AS nb_product

      FROM

        category AS parent,

        category AS node

        INNER JOIN product AS p ON node.id=p.category_id

        WHERE

           (

            node.lft BETWEEN parent.lft AND parent.rgt

             AND parent.id = {$category_id}

            )

            AND

           (

              node.rgt=(node.lft + 1)

              

            )

            AND p.status = 1

        GROUP BY(parent.id)");

    if ($row)

    {

      return $row['nb_product'];

    }

    return 0;

  }



  /**

   *

   * @param integer $parent_id

   * @param boolean $count_product

   * @return Doctrine_Collection

   */

  public function getChildren($parent_id, $count_product = false, $visible = 0, $culture = "")

  {



    if ($count_product)

    {

      $q = Doctrine_Query::create()

              ->select('parent.*')

              ->addSelect('COUNT(parent.id) AS nb_product')

              ->addSelect('COALESCE(ic.name, parent.name) AS name')

              ->from('Category parent')

              ->innerJoin('parent.Category node ON node.lft BETWEEN parent.lft AND parent.rgt')

              ->leftJoin('parent.I18nCategory ic WITH ic.culture = ?', $culture)

              ->innerJoin('node.Product p')

              ->where('parent.parent_id = ?', $parent_id)

              ->andWhere('node.rgt=(node.lft + 1)')

              ->andWhere('p.status=1')

              ->orderBy(' ic.name') // parent.sort_order,

              ->groupBy('parent.id');



      if ($visible == 1)

      {

        $q->andWhere('parent.is_visible=1');

      }

    } else

    {

      $q = Doctrine_Query::create()

              ->select('c.*')

              ->addSelect('COALESCE(ic.name, c.name) AS name')

              ->from('Category c')

              ->leftJoin('c.I18nCategory ic WITH ic.culture = ?', $culture)

              ->orderBy(' ic.name')  // c.sort_order,

              ->where('c.parent_id = ?', $parent_id);

      if ($visible == 1)

      {

        $q->andWhere('c.is_visible=1');

      }

    }



	//echo "[$q]";



    return $q->execute();

  }



  /**

   *

   * @param integer $parent_id

   * @param boolean getChildren nodes by parent_id

   * @return Doctrine_Collection

   */

  public function getChildrenNodes($parent_id, $count_product = false, $lft, $rgt, $visible = 0, $culture = "")

  {

    if ($count_product)

    {

      $q = Doctrine_Query::create()

              ->select('parent.*')

              ->addSelect('COUNT(parent.id) AS nb_product')

              ->addSelect('COALESCE(ic.name, parent.name) AS name')

              ->from('Category parent')

              ->innerJoin('parent.Category node ON node.lft BETWEEN parent.lft AND parent.rgt')

              ->leftJoin('parent.I18nCategory ic WITH ic.culture = ?', $culture)

              ->where('parent.parent_id = ?', $parent_id)

              ->andWhere('node.rgt=(node.lft + 1)')

              ->where('parent.lft > ?', $lft)

              ->where('parent.rgt < ?', $rgt)

              ->orderBy(' parent.name') //parent.sort_order,

              ->groupBy('parent.id');



      if ($visible == 1)

      {

        $q->andWhere('parent.is_visible=1');

      }

    } else

    {

      $q = Doctrine_Query::create()

              ->select('c.*')

              ->addSelect('COALESCE(ic.name, c.name) AS name')

              ->from('Category c')

              ->leftJoin('c.I18nCategory ic WITH ic.culture = ?', $culture)

              ->orderBy(' c.name') // c.sort_order,

              ->where('c.parent_id = ?', $parent_id);

      if ($visible == 1)

      {

        $q->andWhere('c.is_visible=1');

      }

    }





    return $q->execute();

  }



  public function getParentCategories($child_id, $visible = false, $culture = "")

  {

      $q = Doctrine_Query::create()

            ->select('c.*')

            ->addSelect('COALESCE(ic.name, c.name) AS name')

            ->from('Category c')

            ->leftJoin('c.I18nCategory ic WITH ic.culture = ?', $culture)

            ->innerJoin('c.Category node ON (node.lft BETWEEN c.lft AND c.rgt)')

            ->orderBy('c.lft')

            ->where('node.id = ?', $child_id);

    if ($visible)

    {

      $q->andWhere('c.is_visible = 1');

    }

    return $q->execute();

  }



  public function getFeatured($parent_id, $limit, $culture = "")

  {

    $q = Doctrine_Query::create()

            ->select('c.*')

            ->addSelect('COALESCE(ic.name, c.name) AS name')

            ->from('Category c')

            ->leftJoin('c.I18nCategory ic WITH ic.culture = ?', $culture)

            ->orderBy('RAND()')

            ->where('c.is_featured = 1')

            ->limit($limit);

    return $q->execute();

  }



  /**

   * Reallocate left, right number

   */

  public function fixLftRgt()

  {

    $results = $q = Doctrine_Query::create()

            ->from('Category c')

            ->orderBy('c.sort_order, c.name')

            ->where('c.id <> 0')

            ->execute();



    $categories = array();

    foreach ($results as $result)

    {

      $categories[$result->getParentId()][$result->getId()] = $result;

    }

    $results = null;



    function reallocateLftRgt(&$categories, $parent_id, $number, $level)

    {

      foreach ($categories[$parent_id] as $id => $category)

      {

        $category->setLft($number + 1);

        $category->setLevel($level);

        if (isset($categories[$id]))

        {

          $category->setRgt(reallocateLftRgt($categories, $id, $number + 1, $level + 1));

        } else

        {

          $category->setRgt($number + 2);

        }

        $category->save(null, false);

        $number = $category->getRgt();

      }

      return $number + 1;

    }



    if (isset($categories[0]))

    {

      reallocateLftRgt($categories, 0, 0, 0);

    }

  }



  /**

   *

   * @param array $keywords

   * @return array

   */

  public function getIdsByKeywords($keywords = array())

  {

    $q = Doctrine_Query::create()

            ->from('Category c')

            ->where("c.name REGEXP '[[:<:]]" . join("|", $keywords) . "[[:>:]]'");

    $results = $q->execute();

    $ids = array();

    foreach ($results as $result)

    {

      $ids[] = $result->getId();

    }

    return $ids;

  }



  public function getSearchCategories($categoryId, $rAttributeValueIds = array(), $oAttributeValueIds = array(), $keywords = array())

  {

    $q = Doctrine_Query::create()

            ->select('c2.*, COUNT(c2.id) AS nb_product')

            ->addFrom('Category c2')

            ->addFrom('Category c')

            ->addFrom('Product p')

            ->where('p.category_id=c2.id')

            ->andWhereIn('c.id', $categoryId)

            ->andWhere('c2.rgt=(c2.lft + 1)')

            ->andWhere('c2.lft > c.lft AND c2.lft < c.rgt')

            ->andWhere('p.status=1')

			->groupBy('c2.id');



    if (count($rAttributeValueIds))

    {
	  $q->addWhere("MATCH(p.attribute_value_ids) AGAINST('" . implode(",", $rAttributeValueIds) . "' IN BOOLEAN MODE)");	
      //$q->addWhere("MATCH(p.attribute_value_ids) AGAINST('+" . join(" +", $rAttributeValueIds) . "' IN BOOLEAN MODE)");
			////$whereOr[] = "MATCH(p.name) AGAINST('" . join(" ", $keywords) . "' IN BOOLEAN MODE)";

    }

    $whereOr = array();



    if (count($keywords))

    {

      $whereOr[] = "MATCH(p.name) AGAINST('" . implode(",", $keywords) . "' IN BOOLEAN MODE)";
	  //$whereOr[] = "MATCH(p.name) AGAINST('" . join(" ", $keywords) . "' IN BOOLEAN MODE)";
			//$whereOr[] = "MATCH(p.name) AGAINST('" . join(" ", $keywords) . "' IN BOOLEAN MODE)";
    }

    if (count($oAttributeValueIds))

    {

      $whereOr[] = "MATCH(p.attribute_value_ids) AGAINST('" . implode(",", $oAttributeValueIds) . "' IN BOOLEAN MODE)";
	  //$whereOr[] = "MATCH(p.name) AGAINST('" . join(" ", $oAttributeValueIds) . "' IN BOOLEAN MODE)";
				 //$whereOr[] = "MATCH(p.name) AGAINST('" . join(" ", $keywords) . "' IN BOOLEAN MODE)";
    }

    if (count($whereOr))

    {

      $q->andWhere("(" . implode(" OR ", $whereOr) . ")");
	  //$q->andWhere("(" . join(" OR ", $whereOr) . ")");

    }

    return $q->execute();

  }



  public function getBrowseCategories($params = array())

  {

    $categoryId = $params['categoryId'];

    $xAreaId = $params['xAreaId'];

    $attributeValueIds = isset($params['attributeValueIds']) ? $params['attributeValueIds'] : array();

    $priceRange = isset($params['priceRange']) ? $params['priceRange'] : '';

    $currencyCode = isset($params['currencyCode']) ? $params['currencyCode'] : 'USD';

    $userId = isset($params['userId']) ? $params['userId'] : 0;

    $culture = isset($params['culture']) ? $params['culture'] : "";



    $q = Doctrine_Query::create()

            ->select('c2.*')

            ->addSelect('COUNT(c2.id) AS nb_product')

            ->addSelect('COALESCE(ic.name, c2.name) AS name')

            ->from('Category c2')

            ->leftJoin('c2.I18nCategory ic WITH ic.culture = ?', $culture)

            ->innerJoin('c2.Category c ON c.lft BETWEEN c2.lft AND c2.rgt')

            ->addFrom('Product p')

            ->addFrom('XArea n_x')

            ->addFrom('XArea p_x')

            ->where('p.category_id = c.id')

            ->addWhere('p.x_area_id = n_x.id')

            ->andWhereIn('c2.parent_id', $categoryId)

            //->addWhere('p_x.id = ?', $xAreaId)

			->andWhereIn('p_x.id', $xAreaId)

            ->addWhere('c.rgt=(c.lft + 1)')

            ->addWhere('n_x.lft BETWEEN p_x.lft AND p_x.rgt')

            ->addWhere('p.status=1')

			// LNA - order by name ASC

			->orderBy('ic.name')

            ->groupBy('c2.id');





    if ($userId > 0) //from user

    {

      $q->andWhere('p.user_id = ?', $userId);

    }



    if (count($attributeValueIds))

    {

     // $q->addWhere("MATCH(p.attribute_value_ids) AGAINST('+" . join(" +", $attributeValueIds) . "' IN BOOLEAN MODE)");
	  $q->addWhere("MATCH(p.attribute_value_ids) AGAINST('" . implode(" ,", $attributeValueIds) . "' IN BOOLEAN MODE)");

    }

    //price

    if ($priceRange && strpos($priceRange, '-') !== false)

    {

      list($min_price, $max_price) = explode('-', $priceRange);



      $max_price = (int) $max_price;

      $max_price = CurrencyTable::convertToGlobal($currencyCode, $max_price);

      $min_price = (int) $min_price;

      $min_price = CurrencyTable::convertToGlobal($currencyCode, $min_price);



      if ($max_price == 0 && $min_price > 0)

      {

        $q->addWhere("p.price_global >= ?", $min_price);

      } elseif ($max_price > 0 && $min_price == 0)

      {

        $q->addWhere("p.price_global <= ?", $max_price);

      } elseif ($max_price > 0 && $min_price > 0)

      {

        $q->addWhere("p.price_global >= ? AND p.price_global <= ?", array($min_price, $max_price));

      }

    }



    return $q->execute();

  }



  public function getRootCategory($categoryId, $culture = "")

  {

    $q = Doctrine_Query::create()

            ->select('c.*')

            ->addSelect('COALESCE(ic.name, c.name) AS name')

            ->from('Category c')

            ->leftJoin('c.I18nCategory ic WITH ic.culture = ?', $culture)

            ->innerJoin('c.Category c1 ON c1.lft >= c.lft AND c1.rgt <= c.rgt')

            ->where('c1.id = ?', $categoryId)

            ->andWhere('c.id <> 0')

            ->limit(1)

            ->orderBy('c.lft');



    return $q->fetchOne();

  }



  public function findWithCulture($primaryKey, $culture = "")

  {    

    $q = Doctrine_Query::create()

            ->select('c.*')

            ->addSelect('COALESCE(ic.name, c.name) AS name')

            ->from('Category c')

            ->leftJoin('c.I18nCategory ic WITH ic.culture = ?', $culture)

            ->where('c.id = ?', $primaryKey);

    return $q->fetchOne();

  }



  /**

   *

   * @param array $keyword

   * @return array

   */

  public function searchByKeyword($keyword)

  {

    $q = Doctrine_Query::create()

            ->from('Category c')

            ->where("c.name LIKE ?", '%'.$keyword.'%');



    return $q->execute();

  }



  /**

   *

   * @param integer $parent_id

   * @param boolean getRealestate category

   * @return Doctrine_Collection

   */

  public function getRealEstateCategory($params = array())

  {

      $xType = $params['xType'];

      $parent_id = $params['parent_id'];

      $visible = $params['visible'];

      $culture = $params['culture'];



      $q = Doctrine_Query::create()

              ->select('parent.*')

              ->addSelect('COUNT(parent.id) AS nb_product')

              ->addSelect('COALESCE(ic.name, parent.name) AS name')

              ->from('Category parent')

              ->innerJoin('parent.Category node ON node.lft BETWEEN parent.lft AND parent.rgt')

              ->leftJoin('parent.I18nCategory ic WITH ic.culture = ?', $culture)

              ->innerJoin('node.Product p')

              ->where('parent.parent_id = ?', $parent_id)

              ->andWhere('node.rgt=(node.lft + 1)')

              ->andWhere('p.status=1')

              ->orderBy('parent.sort_order, parent.name')

              ->groupBy('parent.id');



      switch($xType){

          case 'realestate':

              $q->innerJoin('p.RealEstate r_x');

              break;

          case 'rental':

              $q->innerJoin('p.Rental r_x');

              break;

          default:

              $q->innerJoin('p.RealEstate r_x');

              break;

      }





      if ($visible == 1)

      {

        $q->andWhere('parent.is_visible=1');

      }





    return $q->execute();

  }



  /*

   * Selected Categories

   */

  public function getSelectedCategories($categoryIds)

  {

    $q = Doctrine_Query::create()

            ->select('c.*')

            ->addFrom('Category c')

            ->whereIn('c.id', $categoryIds);

    return $q->execute();

  }

}