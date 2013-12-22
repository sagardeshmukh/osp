<?php

$salesMan = Doctrine::getTable('User')->find($product->getUserId());

$rootCategory = Doctrine::getTable('Category')->getRootCategory($product->getCategoryId());

$products = Doctrine::getTable('Product')->getProductsByCategoryId($rootCategory->getId(), $product->getId());

?>

<?php if (count($products)):?>

<div class="box boxSidebarGrey user-information">

    <div class="boxHeader"><div><h3><?php echo __('Other real estates') ?></h3></div></div>

    <div class="boxContent">

        <table cellspacing="0" cellpadding="0" border="0" class="table-list-view">

                <?php $i=0;

                foreach($products as $p): $i++;?>
				<?php if($i > 6) continue;  //put condition for displaying limited records. ?>  
            <tr class="<?php echo ($i % 2==0)? "odd":"even" ?>">

                <td align="center" width="80" style="padding-left:10px;">

                       <?php // LNA echo link_to(image_tag($p->getImagePath("t_")), 'product_show', $p)?>

                       <a href="<?php echo url_for("@album?product_id=".$p->getId()) ?>" ><?php echo image_tag($p->getImagePath("t_")); ?></a>

                </td>

                <td>

                    <a href="<?php echo url_for("@album?product_id=".$p->getId()) /*url_for('product_show', $p)*/ ?>"><?php echo strlen($p->getName()) > 50?myTools::utf8_substr($p->getName(), 0, 50).'..':$p->getName() ?></a>

                    <br/>

                    <div class="price" style="color:#999"><?php echo $p->getPrice($sf_user->getPreffCurrency())?></div>

                </td>

            </tr>

                <?php endforeach;?>

          </table>

        <span style="margin-bottom:30px;padding-left:75px" href="#">

            <?php $salesMan= Doctrine::getTable('User')->find($product->getUserId());

                  echo link_to(__('Other real estates').' »' ,'@product_browse?userId='.$product->getUserId().'&xType='.$product->getCategoryType());

                   ?>

        </span>

    </div><!--boxContent-->

 <div class="boxFooter"><div></div></div>

</div>

<?php endif?>

