<?php
function generateSearchParameterString($paramArray)
{
		$paramStr='';
		foreach ($paramArray as $key => $value)
		{
			//if($value !='')
			{
				if(is_array($value)){
				   if($key == 'attributeValueIds')
						$key = 'av';
				   if($key == 'xAreaId'){
				   		$paramStr.= '&'.trim($key).'[]='.implode('|',$value);
				   } else {
				   		$paramStr.= '&'.trim($key).'='.implode('|',$value);
				   }
				   
                } else {
					$paramStr.='&'.trim($key).'='.trim($value); 
				}
			}
    	}    	
    	return trim($paramStr);
}

function url_browse($url, $query_string_array, $key, $value)
{
  //if($value !='')	
  $query_string_array[$key] = $value;
  return url_for($url)."?".join("&", $query_string_array);

}



function store_product_counter($productStat)

{

  $total = "".$productStat;



  for($i=0; $i<strlen($total); $i++)

  {

    echo '<img src="/images/counters/'.$total[$i].'.png" />';

  }

}





function product_counter($productStat)

{

  $total = "".$productStat->getReadCount();



  for($i=0; $i<strlen($total); $i++)

  {

    echo '<img src="/images/counters/'.$total[$i].'.png" />';

  }

}



function formatPrice($price, $symbol)

{

  return number_format($price, 0, '.', ',') . " " . $symbol;

}



function getProductName($product, $culture, $seperator = " - ")

{

  $name = $product->getName();

  $attributes = array();

  foreach($product->getProductColumnAttribute(array(), $culture) as $attribute)

  {

    if ($attribute->getType() == "textbox" || $attribute->getType() == "textarea")

    {

      $attributes[] = $attribute->getAttributeValue();

    }

    else

    {

      $attributes[] = join(", ", $attribute->getProductAttributeValues(false, $culture));

    }

  }

  if (count($attributes))

  {

    return $name . $seperator . join(" ", $attributes);

  }

  return $name;

}



function time_ago($timestamp, $format = '

<span class="number">%number%</span> %word%')

{

  if(!is_numeric($timestamp))

  {

    $timestamp = strtotime($timestamp);

  }



  $now_timestamp = time();



  if ($timestamp > $now_timestamp) $timestamp = $now_timestamp;



  $distance_in_minutes = ceil(abs($now_timestamp - $timestamp) / 60) + 1;



  $parameters = array();



  if ($distance_in_minutes <= 58)

  {

    $parameters['%word%'] = __('minut ago');

    $parameters['%number%'] = $distance_in_minutes;

  }

  else if ($distance_in_minutes <= 1379)

  {

    $minute = fmod($distance_in_minutes, 60);

    if ($minute > 0)

    {

      $str = strtr($format, array('%word%' => __('hour'),'%number%' => round($distance_in_minutes / 60)));

      $str .= strtr($format, array('%word%' => __('minuts ago'), '%number%' => "&nbsp;".$minute));

    }

    else

    {

      $str = strtr($format, array('%word%' => __('hours ago'),'%number%' => round($distance_in_minutes / 60)));

    }

    return $str;

  }

  else

  {

    $parameters['%word%'] = '';

    $parameters['%number%'] = date("Y-m-d H:i", $timestamp);

  }

  return strtr($format, $parameters);

}





function pager_navigation($pager, $uri, $page=null)

{

  if(!$page){

		$page=__("page");

  }

  

  $navigation = '<span>'.__('Total').' '.$pager->getNbResults().' '.__('results').'.</span> &nbsp; ';



  if ($pager->haveToPaginate())

  {

    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').$page.'=';



// First and previous page

    if ($pager->getPage() != 1)

    {

//$navigation .= link_to(image_tag('/sf/sf_admin/images/first.png', 'align=absmiddle'), $uri.'1');

      $navigation .= link_to(__('First'), $uri.$pager->getFirstPage(), array("alt"=>__("First page"), "title"=>__("First page"))).' ';

    }



// Pages one by one

    $links = array();

    foreach ($pager->getLinks() as $page)

    {

      $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page, 'class=current');

    }

    $navigation .= join('  ', $links);



// Next and last page

    if ($pager->getPage() != $pager->getLastPage())

    {

      $navigation .= ' '.link_to(__('Last'), $uri.$pager->getLastPage(), array("alt"=>__('Last page'), "title"=>__("Last page")));

//$navigation .= link_to(image_tag('/sf/sf_admin/images/last.png', 'align=absmiddle'), $uri.$pager->getLastPage());

    }



  }

  return $navigation;

}





function js_pager_navigation($pager, $uri, $element_id)

{

  $navigation = '<span>'.__('Total').' '.$pager->getNbResults().' '.__('results').'.</span> &nbsp; ';



  if ($pager->haveToPaginate())

  {

    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';



// First and previous page

    if ($pager->getPage() != 1)

    {

      $navigation .= link_to(__('First page'), $uri.$pager->getFirstPage(), array('onclick' => "return pagerNavigation('".$uri.$pager->getPreviousPage()."','{$element_id}')", "alt"=>__('First page'), "title"=>__('First page'))).' ';

    }



// Pages one by one

    $links = array();

    foreach ($pager->getLinks() as $page)

    {

      $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page, array('class' => 'current','onclick' => "return pagerNavigation('".$uri.$page."', '{$element_id}')"));

//$links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);

    }

    $navigation .= join('  ', $links);



// Next and last page

    if ($pager->getPage() != $pager->getLastPage())

    {

      $navigation .= ' '.link_to(__('Last'), $uri.$pager->getLastPage(), array('onclick' => "return pagerNavigation('".$uri.$pager->getNextPage()."','{$element_id}')", "alt"=>__('Last page'), "title"=>__('Last page')));

//$navigation .= link_to_function(image_tag('/sf/sf_admin/images/last.png', 'align=absmiddle'), "pagerNavigation('".$uri.$pager->getLastPage()."','{$element_id}')");

    }

  }

  return $navigation;

}



  

function returnDopingPurpose($doping_id)

{

  switch($doping_id)

  {

    case 29: return __('sale');

    case 33: return __('homepage');

    case 34: return __('subpage');

    case 35: return __('toplist');

    case 36: return __('topsearch');

    case 37: return __('different');

    case 38: return __('urgent');

  }

}

?>