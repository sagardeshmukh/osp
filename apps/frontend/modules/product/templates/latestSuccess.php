<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
  <head>
    <meta name="robots" content="index, follow"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="language" content="mn" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="title" content="Yozoa - Sell, Sold! - " />
    <meta name="description" content="One of the biggest Norwayne e-Commerce web site." />
    <meta name="keywords" content="e-Commerce, product, sell, bye, car, real estate, construction, sedan, electronics, computer, online shop, e shopping, internet marketing, advertisement, rent." />
    <meta name="language" content="no" />
    <meta name="robots" content="index, follow" />
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" media="screen" href="/css/base.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
  </head>
  <body>
    <table cellspacing="0" cellpadding="0" border="0" class="table-list-view">
      <?php foreach ($products as $product): $i++; ?>
        <tr class="<?php echo ($i % 2 == 0) ? "even" : "odd" ?>">
          <td align="center" width="80">
          <?php echo link_to(image_tag($product->getImagePath("t_")), 'product_show', $product, array('target' => '_blank')) ?>
        </td>
        <td>
          <a target="_blank" href="<?php echo url_for('product_show', $product) ?>"><?php echo strlen($product->getName()) > 50 ? myTools::utf8_substr($product->getName(), 0, 50) . '..' : $product->getName() ?></a>
          <br/>
          <div class="price" style="color:#999"><?php echo $product->getPrice($sf_user->getPreffCurrency()) ?></div>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </body>
</html>