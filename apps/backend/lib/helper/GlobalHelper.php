<?php

function time_ago($timestamp, $format = '<span class="number">%number%</span> %word%')
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
    $parameters['%word%'] = __('minuts ago');
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


function pager_navigation($pager, $uri)
{
  $navigation = '<span>'.__('Page').$pager->getPage().' .'.__('Total ').$pager->getLastPage().__('page').'.</span> &nbsp; ';

  if ($pager->haveToPaginate())
  {
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';

    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= link_to(image_tag('/sf/sf_admin/images/first.png', 'align=absmiddle'), $uri.'1');
      $navigation .= link_to(image_tag('/sf/sf_admin/images/previous.png', 'align=absmiddle'), $uri.$pager->getPreviousPage()).' ';
    }

    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
    }
    $navigation .= join('  ', $links);

    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= ' '.link_to(image_tag('/sf/sf_admin/images/next.png', 'align=absmiddle'), $uri.$pager->getNextPage());
      $navigation .= link_to(image_tag('/sf/sf_admin/images/last.png', 'align=absmiddle'), $uri.$pager->getLastPage());
    }

  }
  return $navigation;
}


function returnDenyReason($reason_id)
{
  switch ($reason_id)
  {
  	case 1: return __('Your product has been broken our terms and conditions').". <a href='http://yozoa.com/help/29'>".__('click here')."</a> ".__('to read terms and conditions').".";
  	case 2: return __('Your product information does not meet requirements. Insert more information ');
  	case 3: return __('Your product has been recorded our forbidden product list').". <a href='http://yozoa.com/help/29'>".__('click here')."</a> ".__('to read terms and conditions').".";
  	default: __('Your product was deleted due to in forbidden product list').". <a href='http://yozoa.com/help/29'>".__('click here')."</a> ".__('to read terms and conditions')."."; break;
  };
}

function returnDeleteReason($reason_id)
  {
  switch ($reason_id)
  {
  	case 1: return __('Your product has been broken our terms and conditions').". <a href='http://yozoa.com/help/29'>".__('click here')."</a> ".__('to read terms and conditions').".";
  	case 2: return __('Your product information does not meet requirements. Insert more information ');
  	default: __('Your product was deleted due to in forbidden product list').". <a href='http://yozoa.com/help/29'>".__('click here')."</a> ".__('to read terms and conditions')."."; break;
  };
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