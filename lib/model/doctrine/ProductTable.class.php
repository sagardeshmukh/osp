<?php



class ProductTable extends Doctrine_Table

{



    static public function getInstance()

    {

        return Doctrine::getTable('Product');

    }



    public function getPriceOption($params = array())

    {

        $categoryId = (array)$params['categoryId'];

        $xAreaId = $params['xAreaId'];

        $attributeValueIds = isset($params['attributeValueIds']) ? $params['attributeValueIds'] : array();

        $currencyCode = isset($params['currencyCode']) ? $params['currencyCode'] : 'USD';

        $userId = isset($params['userId']) ? $params['userId'] : 0;

        $currencyValue = CurrencyTable::getInstance()->getValue($currencyCode);

        $categoryIds = implode(",", $categoryId);

        $conn = $this->getConnection();

        $query = "

            SELECT MIN(price_global) AS min_price, MAX(price_global) AS max_price

            FROM product p

            INNER JOIN category c ON p.category_id = c.id

            INNER JOIN category c2 ON (c.lft BETWEEN c2.lft AND c2.rgt)

            WHERE c2.id IN ($categoryIds)

            AND c.rgt = (c.lft + 1)

            AND p.status=1";



        $row = $conn->fetchRow($query);

        if (!$row)

        {

            return array();

        }



        $min_price = (int) $row['min_price'] * $currencyValue;

        $max_price = (int) $row['max_price'] * $currencyValue;

        $min_limit = pow(10, strlen($min_price) - 1);



        $max_option = 28;



        $exp = strlen($min_price) - 1;

        $dec_num = $min_price / pow(10, $exp);



        if ($exp == 0)

        {

            $price_range_max = 10;

            $price_range_min = 0;

        } elseif ($dec_num == 1)

        {

            $price_range_max = $dec_num * pow(10, $exp - 1);

            $price_range_min = (7.5 * pow(10, $exp - 2));

        } elseif ($dec_num > 5 && $dec_num <= 7.5)

        {

            $price_range_max = (7.5 * pow(10, $exp - 1));

            $price_range_min = (5 * pow(10, $exp - 1));

        } elseif ($dec_num > 7.5)

        {

            $price_range_max = pow(10, $exp);

            $price_range_min = 7.5 * pow(10, $exp - 1);

        } else

        {

            $price_range_max = ceil($dec_num) * pow(10, $exp - 1);

            $price_range_min = floor($dec_num) * pow(10, $exp - 1);

        }



        $array_select = array();

        $array_select_option = array();



        $alias = round($price_range_min)."_".round($price_range_max);

        $array_select[] = " SUM(IF(p.price_global >= ".($price_range_min/$currencyValue)." AND

                               p.price_global <= ".($price_range_max/$currencyValue).", 1, 0))

                        AS p{$alias}";

        $array_select_option["{$price_range_min}-{$price_range_max}"] = "p{$alias}";





        for ($i = 0; $i < $max_option; $i++)

        {

            $first_digit = substr($price_range_max, 0, 1);

            $exp = strlen($price_range_max);

            $price_range_min = $price_range_max;



            if ($first_digit >= 1 && $first_digit < 2)

            {

                $price_range_max = 2.5 * pow(10, $exp - 1);

            }

            else if ($first_digit >=2 && $first_digit < 5)

            {

                $price_range_max = 5 * pow(10, $exp - 1);

            }

            else if ($first_digit >= 5 && $first_digit < 7)

            {

                $price_range_max = 7.5 * pow(10, $exp - 1);

            }

            else

            {

                $price_range_max = pow(10, $exp);

            }



            $alias = round($price_range_min)."_".round($price_range_max);



            $array_select[] = " SUM(IF(p.price_global > ".($price_range_min/$currencyValue)." AND

                                 p.price_global <= ".($price_range_max/$currencyValue).", 1, 0))

                          AS p{$alias}";

            $array_select_option["{$price_range_min}-{$price_range_max}"] = "p{$alias}";



            if ($max_price <= $price_range_max)

            {

                break;

            }

        }



        if ($price_range_max < $max_price)

        {

            $array_select[] = " SUM(IF(p.price_global > ".($price_range_max/$currencyValue).", 1, 0)) AS p".round($price_range_min)."_more";

            $array_select_option["{$price_range_min}-more"] = "p".round($price_range_min)."_more";

        }



        $whereAnd = array();

        $whereAnd[] = "c2.id IN ($categoryIds)";

        $whereAnd[] = "c.rgt = (c.lft + 1)";

        $whereAnd[] = "p.status=1";



        if (count($attributeValueIds))

        {

            $whereAnd[] = "MATCH(p.attribute_value_ids) AGAINST('+" . join(" +", $attributeValueIds) . "' IN BOOLEAN MODE)";

        }



        $row = $conn->fetchRow("

            SELECT " . join(",", $array_select) . "

            FROM product p

            INNER JOIN category c ON p.category_id = c.id

            INNER JOIN category c2 ON (c.lft BETWEEN c2.lft AND c2.rgt)

            WHERE " . join(" AND ", $whereAnd));



        $price_option = array();

        foreach ($array_select_option as $range => $value)

        {

            if ($row[$value])

            {

                list ($min, $max) = explode('-', $range);

                $price_option[] = array('nb_product' => $row[$value], 'min' => $min, 'max' => $max);

            }

        }

        return $price_option;

    }



    /**

     * Get Search Query

     * @param array $keywords

     * @param array $categoryIds

     * @param array $attributeValueIds

     * @return Doctrine_Query

     */

    public function searchQuery($params = array())

    {

        $categoryId = $params['categoryId'];

        $categoryIds = $params['categoryIds'];

        $xAreaId = $params['xAreaId'];

        $xType = $params['xType'];

        $rAttributeValueIds = isset($params['rAttributeValueIds']) ? $params['rAttributeValueIds'] : array();

        $oAttributeValueIds = isset($params['oAttributeValueIds']) ? $params['oAttributeValueIds'] : array();

        $keywords = isset($params['keywords']) ? $params['keywords'] : '';

        $sordOrder = isset($params['sordOrder']) ? $params['sordOrder'] : 'date_desc';

        $priceRange = isset($params['priceRange']) ? $params['priceRange'] : '';

        $squareRange = isset($params['squareRange']) ? $params['squareRange'] : '';



        $q = Doctrine_Query::create()

                ->select("p.*")

                ->from('Product AS p')

                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->innerJoin('p.Category p_d ON n_c.lft BETWEEN p_d.lft AND p_d.rgt')

                ->innerJoin('p.XArea n_x')

                ->innerJoin('p.XArea p_x ON n_x.lft BETWEEN p_x.lft AND p_x.rgt')

                ->where('p_c.id = ?', $categoryId)

                ->andWhereIn('p_d.id', $categoryIds)

                ->andWhereIn('p_x.id', $xAreaId)

                ->andWhere('n_c.rgt=(n_c.lft + 1)');



        $whereOr = array();

        switch($xType)

        {

            case 'jobs':

                $q->innerJoin('p.Job j');

                $whereOr[] = "MATCH(j.company_name) AGAINST('" . join(" ", $keywords) . "' IN BOOLEAN MODE)";

                $whereOr[] = "MATCH(j.description) AGAINST('" . join(" ", $keywords) . "' IN BOOLEAN MODE)";

                $whereOr[] = "MATCH(j.location) AGAINST('" . join(" ", $keywords) . "' IN BOOLEAN MODE)";

                break;

            case 'realestates':

                $q->innerJoin('p.RealEstate r_s');

                //square range/

                if ($squareRange && strpos($squareRange, '-') !== false)

                {

                    list($min_square, $max_square) = explode('-', $squareRange);

                    $max_square = (int) $max_square;

                    $min_square = (int) $min_square;



                    if ($max_square == 0 && $min_square > 0)

                    {

                        $q->addWhere("r_s.total_area >= ?", $min_square);

                    } elseif ($max_square > 0 && $min_square == 0)

                    {

                        $q->addWhere("r_s.total_area <= ?", $max_square);

                    } elseif ($max_square > 0 && $min_square > 0)

                    {

                        $q->addWhere("r_s.total_area >= ? AND r_s.total_area <= ?", array($min_square, $max_square));

                    }

                }

                break;

        }



        if (count($rAttributeValueIds))

        {

            $q->addWhere("MATCH(p.attribute_value_ids) AGAINST('+" . join(" +", $rAttributeValueIds) . "' IN BOOLEAN MODE)");

        }





        if (count($keywords))

        {

            $whereOr[] = "MATCH(p.name) AGAINST('" . join(" ", $keywords) . "' IN BOOLEAN MODE)";

        }

        if (count($oAttributeValueIds))

        {

            $whereOr[] = "MATCH(p.attribute_value_ids) AGAINST('" . join(" ", $oAttributeValueIds) . "' IN BOOLEAN MODE)";

        }

        if (count($whereOr))

        {

            $q->andWhere("(" . join(" OR ", $whereOr) . ")");

        }

        $q->andWhere('p.status = 1');



        //price range/

        if ($priceRange && strpos($priceRange, '-') !== false)

        {

            list($min_price, $max_price) = explode('-', $priceRange);

            $max_price = (int) $max_price;

            $min_price = (int) $min_price;



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

        switch ($sordOrder)

        {

            case "date_desc":

                $q->orderBy('p.confirmed_at DESC');

                break;

            case "price_asc":

                $q->orderBy('p.price_global ASC');

                break;

            case "price_desc":

                $q->orderBy('p.price_global DESC');

                break;

            default:

                $q->orderBy('p.confirmed_at ASC');

                break;

        }



        return $q;

    }



    /**

     * RETURN filter query

     * @param integer $category_id

     * @param array $attribute_value_ids

     * @param string $sordOrder

     * @param string $priceRange

     * @return Doctrine_Query

     */

    public function browseQuery($params = array(), $extraParams = array())

    {

        $categoryId = $params['categoryId'];

        $xAreaId = $params['xAreaId'];

        $attributeValueIds = isset($params['attributeValueIds']) ? $params['attributeValueIds'] : array();

        $sordOrder = isset($params['sortType']) ? $params['sortType'] : array();
		
		$lastPosts = isset($params['lastPosting']) ? $params['lastPosting'] : array();

        $priceRange = isset($params['priceRange']) ? $params['priceRange'] : '';

        $currencyCode = isset($params['currencyCode']) ? $params['currencyCode'] : 'USD';

        $userId = isset($params['userId']) ? $params['userId'] : 0;

		$contentView = isset($params['contentView']) ? $params['contentView'] : 'listview';

        $q1 = Doctrine_Query::create()
				
				->select('p.*, n_x.map_lat, n_x.map_lng, n_x_l.map_lat, n_x_l.map_lng')

                ->from('Product AS p')
				
                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->innerJoin('p.XArea n_x')
				
				->leftJoin('p.XAreaLocation n_x_l');

               // ->innerJoin('p.XArea p_x ON n_x.lft BETWEEN p_x.lft AND p_x.rgt')

		if ($xAreaId != ""){
				$q1->innerJoin('p.XArea p_x ON n_x.lft BETWEEN p_x.lft AND p_x.rgt');
		}
				
		if ($categoryId != ""){		

               $q1->whereIn('p_c.id', $categoryId);
		}

		if ($xAreaId != ""){	
                $q1->andWhereIn('p_x.id', $xAreaId);

		}
        $q1->andWhere('p.status = 1')
	        ->andWhere('n_c.rgt=(n_c.lft + 1)');



        if ($userId > 0) //from user
        {

            $q1->andWhere('p.user_id = ?', $userId);

        }

		
		
		

        if (count($attributeValueIds))

        {

            $q1->innerJoin('p.ProductAttribute pa')

              ->innerJoin('pa.ProductAttributeValue pav');
			//foreach($attributeValueIds as $id) {
            	$q1->andWhereIn('pav.attribute_value_id', $attributeValueIds);
			//}

        }



        //price range/

        if ($priceRange && strpos($priceRange, '-') !== false)
        {

            list($min_price, $max_price) = explode('-', $priceRange);



            $max_price = (int) $max_price;

            $max_price = CurrencyTable::convertToGlobal($currencyCode, $max_price);

            $min_price = (int) $min_price;

            $min_price = CurrencyTable::convertToGlobal($currencyCode, $min_price);



            if ($max_price == 0 && $min_price > 0)

            {

                $q1->addWhere("p.price_global >= ?", $min_price);

            } elseif ($max_price > 0 && $min_price == 0)

            {

                $q1->addWhere("p.price_global <= ?", $max_price);

            } elseif ($max_price > 0 && $min_price > 0)

            {

                $q1->addWhere("p.price_global >= ? AND p.price_global <= ?", array($min_price, $max_price));

            }

        }
		// filter result on the basis of how old the posting are ! .
		if(is_numeric($lastPosts) && $lastPosts != 0 && $lastPosts != -1) {
			
			 $days = $lastPosts;
			 $date = mktime(0,0,0,date('m',time()), date('d',time())-$days, date('y',time()));
			 $date = date('Y-m-d H:i:s',$date);
			 $q1->addWhere("DATE(p.confirmed_at) >= DATE(?) AND DATE(NOW()) >= DATE(?)", array($date, $date));
			 $q1->orderBy('p.confirmed_at ASC');
		
		} 
		switch ($sordOrder)
		{

			case "date_desc":

				$q1->orderBy('p.confirmed_at DESC');

				break;

			case "price_asc":

				$q1->orderBy('p.price_global ASC');

				break;

			case "price_desc":

				$q1->orderBy('p.price_global DESC');

				break;

			default:

				$q1->orderBy('p.confirmed_at ASC');

				break;
		}	
		/*echo $q1->getSQLQuery(); 
echo "<br>count".count($q1->execute());
exit;*/
		$q1->execute();
		if($contentView == 'listview')
        	return $q1;
		else if($contentView == 'mapview')
			return $q1->execute();
    }



    /**

     * Get featured products

     * @param <type> $limit

     * @return <type>

     */

    public function getProductsByCategoryId($category_id = 0, $product_id = 0, $limit = 15)

    {

        $q = Doctrine_Query::create()

                ->select('p.*, p.status AS sort_order')

                ->from('Product AS p')

                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->where('p.status = 1')

                ->andWhere('p.id <> ' . $product_id)

                ->andWhere('p_c.id = ?', $category_id)

                ->andWhere('n_c.rgt=(n_c.lft + 1)')

                ->andWhere('n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->orderBy('sort_order ASC')

                ->limit($limit);



        return $q->execute();

    }



    /**

     * Get featured products

     * @param <type> $limit

     * @return <type>

     */

    public function getItemWithPhoto($category_id = 0)

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->where('p.status = 1')

                ->andWhere('p.image <> ""')

                ->andWhere('p_c.id = ?', $category_id)

                ->andWhere('n_c.rgt=(n_c.lft + 1)')

                ->andWhere('n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->orderBy('p.id DESC');



        return $q->fetchOne();

    }



    /**

     * Get featured products

     * @param <type> $limit

     * @return <type>

     */

    public function getFeaturedProducts($category_id = 0, $limit = 15)

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->where('p.status = 1')

                ->andWhere('p_c.id = ?', $category_id)

                ->andWhere('n_c.rgt=(n_c.lft + 1)')

                ->andWhere('n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->orderBy('sort_order ASC')

                ->limit($limit);



        return $q->execute();

    }



    public function getSubPageProducts($category_id = 0, $limit = 15)

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->where('p.status = 1')

                ->andWhere('p_c.id = ?', $category_id)

                ->andWhere('n_c.rgt=(n_c.lft + 1)')

                ->andWhere('n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->orderBy('sort_order ASC')

                ->limit($limit);



        return $q->execute();

    }



    public function getHomePageProducts($category_id = 0, $limit = 15)

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->where('p.status = 1')

                ->andWhere('p_c.id = ?', $category_id)

                ->andWhere('n_c.rgt=(n_c.lft + 1)')

                ->andWhere('n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->limit($limit);



        return $q->execute();

    }



    /**

     * Returns Buy Online products

     * @param integer $category_id

     * @param integer $limit

     * @return <type>

     */

    public function getBuyOnline($category_id = 0, $limit = 4)

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->where('p.status = 1')

                ->andWhere('p.buy_online = 1')

                ->orderBy('RAND()')

                ->limit($limit);

        if ($category_id > 0)

        {

            $q->innerJoin('p.Category n_c')

                    ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                    ->andWhere('p_c.id = ?', $category_id)

                    ->andWhere('n_c.rgt=(n_c.lft + 1)')

                    ->andWhere('n_c.lft BETWEEN p_c.lft AND p_c.rgt');

        }

        return $q->execute();

    }



    /**

     * Xereglegchiin oruulsan productin query-g butsaana

     * @param integer $user_id

     */

    public function getUserProductQuery($user_id, $status)

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->where('p.user_id = ?', $user_id)

                ->andWhere('p.status = ?', $status);

        return $q;

    }



    /**

     * Tuhain buteegdhuuniig oruulsan hereglegchin busad buteegdhuun

     * @param integer $product_id

     * @return <type>

     */

    public function getOtherProducts($product_id)

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->addFrom('Product AS p1')

                ->where('p.user_id = p1.user_id')

                ->andWhere('p.id <> ?', $product_id)

                ->andWhere('p1.id = ?', $product_id)

                ->andWhere('p.status = 1')

                ->orderBy('p.name ASC');



        return $q->execute();

    }

	public function getUserID($product_id)

    {

        $q = Doctrine_Query::create()

                ->select('user_id')

                ->from('Product')

                ->andWhere('id = ', $product_id);

        return $q->execute();

    }


    /**

     *

     * @param integer $user_id

     * @param integer $product_id

     * @return <type>

     */

    public function getProductUserAndId($user_id, $product_id)

    {

        $q = Doctrine_Query::create()

                ->from('Product AS p')

                ->where('p.user_id = ?', $user_id)

                ->andWhere('p.id = ?', $product_id);

        return $q->fetchOne();

    }



    /**

     * products find by primary keys

     * @param array $primary_keys

     * @return Doctrine_Collection

     */

    public function findByPrimaryKeys($primary_keys = array(), $limit = -1)

    {

        $q = Doctrine_Query::create()

                ->from('Product AS p')

                ->whereIn('p.id', $primary_keys);

        if ($limit != -1)

        {

            $q->limit($limit);

        }

        return $q->execute();

    }



    /**

     * Oiroltsoo buteegdexuunuuud

     */

    public function getSameProducts($productId, $limit = 5)
    {
        $q = Doctrine_Query::create()

                ->select('p1.*, ABS(p2.price_global - p1.price_global) AS price_diff')

                ->from('Product AS p1')

                ->addFrom('Product AS p2')

                ->where('p2.id = ?', $productId)

                ->andWhere('p1.status = 1')

                ->andWhere('p1.category_id=p2.category_id')

                ->andWhere('p1.id <> ?', $productId)

                ->orderBy('price_diff')

                ->limit($limit);

        return $q->execute();
    }

    public function countUserProducts($user_id, $is_active = false)

    {

        $q = Doctrine_Query::create()

                ->from('Product p')

                ->where('p.user_id =?', $user_id)

                ->orderBy('p.created_at DESC');



        if ($is_active)

        {

            $q->andWhere('p.status=1');

        }



        return $q->count();

    }



    /**

     * Returns Buy Online products

     * @param integer $category_id

     * @param integer $limit

     * @return <type>

     */

    public function getLatest($category_id = 0, $limit = 4, $has_image = false)

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->where('p.status = 1')

                ->orderBy('p.confirmed_at desc')

                ->limit($limit);



        if ($has_image)

        {

            $q->andWhere('p.image <> ""');

        }



        if ($category_id > 0)

        {

            $q->innerJoin('p.Category n_c')

                    ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                    ->andWhere('p_c.id = ?', $category_id)

                    ->andWhere('n_c.rgt=(n_c.lft + 1)')

                    ->andWhere('n_c.lft BETWEEN p_c.lft AND p_c.rgt');

        }

        return $q->execute();

    }



    public function getExpiredProducts()

    {

        $today = date("Y-m-d");

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                //->where('p.status = 2')

                ->where('(DATE_ADD(p.confirmed_at, INTERVAL p.duration DAY)) >= ?', $today . " 00:00:00")

                ->andWhere('(DATE_ADD(p.confirmed_at, INTERVAL p.duration DAY)) <= ?', $today . " 23:59:59");

        return $q->execute();

    }



    public function get14DaysProducts()

    {

        $q = Doctrine_Query::create()

                ->select('p.*')

                ->from('Product AS p')

                ->where('p.status = 1')

                ->andWhere('MOD(DATEDIFF(NOW(), p.confirmed_at), 14) = 0')

                ->andWhere('p.confirmed_at NOT LIKE ?', "%" . date("Y-m-d") . "%");

        return $q->execute();

    }



    public function getUserOtherProducts($user_id, $product_id, $xType = '',$limit='')
    {
		

        $today = date("Y-m-d");

        $q = Doctrine_Query::create()

                ->from('Product AS p')

                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->where('p.user_id = ?', $user_id)

                ->andWhere('p.id <> ' . $product_id)

                ->andWhereIn('p_c.id', $xType)

                ->andWhere('p.status =?', 1)

                ->andWhere('n_c.rgt=(n_c.lft + 1)');
		
		if ($limit)
			$q->limit($limit);		

        return $q->execute();

    }



    public function getNewProduct($date)

    {

        $today = date("Y-m-d", (time() - $date * 3600));

        $q = Doctrine_Query::create()

                ->from('Product AS p')

				->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->where('p.status = 1')

                ->andWhereIn('p_c.id ', array(38, 1, 1269)) // LNA  HOME PAGE

                ->andWhere('n_c.rgt=(n_c.lft + 1)')

                ->andWhere('n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->orderBy('p.confirmed_at DESC')

                ->limit(10);

        return $q->execute();

    }



    /**

     * Get Search Query

     * @param array $keywords

     * @param array $categoryIds

     * @param array $attributeValueIds

     * @return Doctrine_Query

     */

    public function searchRealEstateByArea($params = array())

    {

        $categoryId = isset($params['categoryId']) ? $params['categoryId']: '';

        $xAreaId = isset($params['xAreaId'])? $params['xAreaId']: '';

        $xType = isset($params['xType'])? $params['xType']: '';

        $priceRange = isset($params['priceRange']) ? $params['priceRange'] : '';

        $squareRange = isset($params['squareRange']) ? $params['squareRange'] : '';

        $bedroomsRange = isset($params['bedroomsRange']) ? $params['bedroomsRange'] : '';

        $propertyTypeRange = isset($params['propertyRange']) ? $params['propertyRange'] : '';

        $floorRange = isset($params['floorRange']) ? $params['floorRange'] : '';

        $tenureRange = isset($params['tenureRange']) ? $params['tenureRange'] : '';

        $constructionDate = isset($params['constructionDate']) ? $params['constructionDate'] : '';



        $q = Doctrine_Query::create()

                ->from('Product AS p')

                ->innerJoin('p.XArea n_x')

                ->innerJoin('p.XArea p_x ON n_x.lft BETWEEN p_x.lft AND p_x.rgt')

                ->innerJoin('p.Category n_c')

                ->innerJoin('p.Category p_c ON n_c.lft BETWEEN p_c.lft AND p_c.rgt')

                ->where('p_c.id = ?', $categoryId)

                ->andWhereIn('p_x.id', $xAreaId)

                ->andWhere('p.status = 1')

                ->andWhere('n_c.rgt=(n_c.lft + 1)');



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



        //price range/

        if ($priceRange && strpos($priceRange, '-') !== false)

        {

            list($min_price, $max_price) = explode('-', $priceRange);

            $max_price = (int) $max_price;

            $min_price = (int) $min_price;



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



        //LNA bedrooms range/

		$products_array = array();

		if($xType == 'realestates'){

			if ($bedroomsRange && strpos($bedroomsRange, '-') !== false)

			{

				list($min_bedrooms, $max_bedrooms) = explode('-', $bedroomsRange);

				if($max_bedrooms != 0)

				{

					$max_bedrooms = (int) $max_bedrooms;

					$min_bedrooms = (int) $min_bedrooms;



					$bedRoomsSql = "SELECT product_id FROM `product_attribute` WHERE attribute_id = 177 AND attribute_value >= $min_bedrooms AND attribute_value <= $max_bedrooms"; // Bed Rooms

					$conn = $this->getConnection();

					$product_ids = array();

					$product_ids = $conn->fetchColumn($bedRoomsSql);

					$bedrooms_array = $product_ids;

					if(count($product_ids) > 0){

						//$q->andWhereIn('p.id', $product_ids);

					}

				}else{

					$bedRoomsSql = "SELECT product_id FROM `product_attribute` WHERE attribute_id = 177"; // Bed Rooms

					$conn = $this->getConnection();

					$product_ids = array();

					$product_ids = $conn->fetchColumn($bedRoomsSql);

					$bedrooms_array = $product_ids;

				}

			}

		}

		

		//echo "[$propertyTypeRange]";

		

		// Property type

		if($xType == 'realestates'){

			if ($propertyTypeRange)

			{

				$propertyTypeRange = (int) $propertyTypeRange;

				$bedRoomsSql = "SELECT product_id FROM `product_attribute`

										LEFT JOIN product_attribute_value ON id = product_attribute_id

										WHERE 

											attribute_id = 175 

											AND attribute_value_id = $propertyTypeRange"; // Bed Rooms

				$conn = $this->getConnection();

				$product_ids = array();

				$product_ids = $conn->fetchColumn($bedRoomsSql);

				$property_array = $product_ids;

				if(count($product_ids) > 0){

					//$q->andWhereIn('p.id', $product_ids);

				}

			}else{

				$bedRoomsSql = "SELECT product_id FROM `product_attribute`

										LEFT JOIN product_attribute_value ON id = product_attribute_id

										WHERE 

											attribute_id = 175 "; // Bed Rooms

				$conn = $this->getConnection();

				$product_ids = array();

				$product_ids = $conn->fetchColumn($bedRoomsSql);

				$property_array = $product_ids;

			}

		}

		// LNA end Property Type

		

		// Construction Date

		if($xType == 'realestates'){

			list($min_constructionDate, $max_constructionDate) = explode('-', $constructionDate);

			$max_constructionDate = (int) $max_constructionDate;

			$min_constructionDate = (int) $min_constructionDate;



			if ($max_constructionDate || $min_constructionDate)

			{

				$bedRoomsSql = "SELECT product_id FROM `product_attribute`

								WHERE 

									attribute_id = 168 

									AND attribute_value >= $min_constructionDate 

									AND attribute_value <= $max_constructionDate"; // Construction Date

				$conn = $this->getConnection();

				$product_ids = array();

				$product_ids = $conn->fetchColumn($bedRoomsSql);

				$date_array = $product_ids;

				if(count($product_ids) > 0){

					//$q->andWhereIn('p.id', $product_ids);

				}

			}else{

				$bedRoomsSql = "SELECT product_id FROM `product_attribute`

								WHERE 

									attribute_id = 168"; // Construction Date

				$conn = $this->getConnection();

				$product_ids = array();

				$product_ids = $conn->fetchColumn($bedRoomsSql);

				$date_array = $product_ids;

			}

		}



		// LNA end Construction Date

		

		

		// FLOOR

		if($xType == 'realestates'){

			if ($floorRange)

			{

				$floorRange = (int) $floorRange;

				$floorSql = "SELECT product_id FROM `product_attribute`

										LEFT JOIN product_attribute_value ON id = product_attribute_id

										WHERE 

											attribute_id = 195 

											AND attribute_value_id = $floorRange"; // Bed Rooms

				$conn = $this->getConnection();

				$product_ids = array();

				$product_ids = $conn->fetchColumn($floorSql);

				$floor_array = $product_ids;

				//print_r($product_ids);

				if(count($product_ids) > 0){

					//$q->andWhereIn('p.id', $product_ids);

				}

			}else{

				$floorSql = "SELECT product_id FROM `product_attribute`

										LEFT JOIN product_attribute_value ON id = product_attribute_id

										WHERE 

											attribute_id = 195 "; // Bed Rooms

				$conn = $this->getConnection();

				$product_ids = array();

				$product_ids = $conn->fetchColumn($floorSql);

				$floor_array = $product_ids;	

			}

		}

		// LNA end FLOOR

		

		// TENURE

		if($xType == 'realestates'){

			if ($tenureRange)

			{

				$tenureRange = (int) $tenureRange;

				$tenureRangeSql = "SELECT product_id FROM `product_attribute`

										LEFT JOIN product_attribute_value ON id = product_attribute_id

										WHERE 

											attribute_id = 176 

											AND attribute_value_id = $tenureRange"; // Bed Rooms

				$conn = $this->getConnection();

				$product_ids = array();

				$product_ids = $conn->fetchColumn($tenureRangeSql);

				$tenure_array = $product_ids;

				//print_r($product_ids);

				if(count($product_ids) > 0){

					//$q->andWhereIn('p.id', $product_ids);

				}

			}else{

				$tenureRangeSql = "SELECT product_id FROM `product_attribute`

										LEFT JOIN product_attribute_value ON id = product_attribute_id

										WHERE 

											attribute_id = 176 "; // Bed Rooms

				$conn = $this->getConnection();

				$product_ids = array();

				$product_ids = $conn->fetchColumn($tenureRangeSql);

				$tenure_array = $product_ids;	

			}

		}

		// LNA end TENURE

		

		$products_array = array_intersect( isset($bedrooms_array)?$bedrooms_array:'', $tenure_array, $property_array, $floor_array, $date_array);

		//print_r($bedrooms_array);print_r($tenure_array);print_r($property_array);print_r($floor_array);

		//die;

		if(count($products_array) > 0)

		{

			$q->andWhereIn('p.id', $products_array);

		}else{

			if(count($bedrooms_array) == 0 || count( $tenure_array ) == 0 || count( $property_array) == 0 || count($floor_array) == 0 || count($date_array) == 0) $q->andWhere('0 = 1');	

		}

		

        //square range/

        if($xType == 'realestate'){

            if ($squareRange && strpos($squareRange, '-') !== false)

            {

                list($min_square, $max_square) = explode('-', $squareRange);

                $max_square = (int) $max_square;

                $min_square = (int) $min_square;



                if ($max_square == 0 && $min_square > 0)

                {

                    $q->addWhere("r_x.total_area >= ?", $min_square);

                } elseif ($max_square > 0 && $min_square == 0)

                {

                    $q->addWhere("r_x.total_area <= ?", $max_square);

                } elseif ($max_square > 0 && $min_square > 0)

                {

                    $q->addWhere("r_x.total_area >= ? AND r_x.total_area <= ?", array($min_square, $max_square));

                }

            }

         }

		//echo "[$q]";die;

        return $q;

    }



    public function getMapBoundaries($params = array())

    {

        $q = $this->searchRealEstateByArea($params)

                ->addSelect('MAX(r_x.map_lat) AS max_lat')

                ->addSelect('MIN(r_x.map_lat) AS min_lat')

                ->addSelect('MAX(r_x.map_lng) AS max_lng')

                ->addSelect('MIN(r_x.map_lng) AS min_lng');

        $product = $q->fetchOne();

        if ($product)

        {

            return array(

                    'max_lat' => $product->getMaxLat(),

                    'min_lat' => $product->getMinLat(),

                    'max_lng' => $product->getMaxLng(),

                    'min_lng' => $product->getMinLng());

        }

            return array(

                    'max_lat' => $product->getMaxLat(),

                    'min_lat' => $product->getMinLat(),

                    'max_lng' => $product->getMaxLng(),

                    'min_lng' => $product->getMinLng());

    }



    public function getWithinBoundaries($params = array())

    {

        $minLat = $params['minLat'];

        $minLng = $params['minLng'];

        $maxLat = $params['maxLat'];

        $maxLng = $params['maxLng'];



        



        $q = $this->searchRealEstateByArea($params)

                ->addWhere("r_x.map_lat >= ? AND r_x.map_lat <= ?", array($minLat, $maxLat))

                ->addWhere("r_x.map_lng >= ? AND r_x.map_lng <= ?", array($minLng, $maxLng));



        return $q->execute();



    }



    public function findByCompanyName($company_name, $product_id, $limit = 15)

    {

        $q = Doctrine_Query::create()

                ->select('p.*, p.status AS sort_order')

                ->from('Product p')

                ->innerJoin('p.Job j')

                ->where('p.status = 1')

                ->andWhere('j.company_name LIKE ?', $company_name)

                ->andWhere('p.id <> ' . $product_id)

                ->orderBy('sort_order ASC')

                ->limit($limit);



        return $q->execute();

    }

	//Select Query function for get Price Range slider Max & Min values 
	public function minmaxPriceRange()

    {
	   $q1 = Doctrine_Query::create()

		->select('MIN(price_global ) AS min, MAX(price_global ) AS max')
		->from('Product');
		$data = array();
		foreach($q1->execute() as $d){
			$data['min'] =  $d['min'];
			$data['max'] =  $d['max'];
		}
		return $data;
    }

}