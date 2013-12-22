<?php $salesMan = Doctrine::getTable('User')->find($product->getUserId()); ?>

<?php

$categoryId = myConstants::getCategoryId($product->getCategoryType());

$products = Doctrine::getTable('Product')->getUserOtherProducts($product->getUserId(), $product->getId(), $categoryId); ?>

<?php /* if($salesMan):?>

<div id="sendFriend_form_container" class="sendFriend-dialog"></div>

<div id="askQuestion_form_container" class="askQuestion-dialog"></div>

<div class="box boxSidebarYellow user-information inline right">

    <div class="boxHeader"><div><h3><?php echo __('Provider') ?></h3></div></div>

    <div class="boxContent">

        <div class="boxWrap">

            <div class="user-profile">

                <div class="info">

                    <span><a href="/user/profiles/id/<?php echo $salesMan->getId()?>" target="_blank"><?php echo $salesMan->getInitial().".".$salesMan->getFirstname()?></a></span>

                </div>

            </div><!--user-profile-->

            <ul class="contact-tools">

                <li><span class="name"><b><?php echo __('Phone') ?> 1:</b>  <?php echo $product->getPhoneCell()?></span></li>

                <li><span class="name"><b><?php echo __('Phone') ?> 2:</b> <?php echo $product->getPhoneHome()?></span></li>

                <!--<li><span class="name">Fax:  <?php //echo $salesMan->getFax()?></span></li>-->

            </ul>

            <span class="button"><a class="blueSmall" href="javascript:;"  onclick="AskQuestion(<?php echo $product->getId() ?>)"><span><?php echo __('Ask a question') ?></span></a></span>

            <br clear="all"/>

            <div class="clear"></div>



        </div><!--boxWrap-->

    </div><!--boxContent-->

    <div class="boxFooter"><div></div></div>

</div><!--box-->

<?php endif; */?>

<div class="clear"></div>

<?php if (count($products)):?>

<div class="box boxSidebarGrey user-information">

    <div class="boxHeader"><div><h3><?php echo __('Other products') ?></h3></div></div>

    <div class="boxContent">

        <table cellspacing="0" cellpadding="0" border="0" class="table-list-view">

                <?php $i=0;

                foreach($products as $p): $i++;?>

            <tr class="<?php echo ($i % 2==0)? "odd":"even" ?>">

                <td align="center" width="80">

                       <?php echo link_to(image_tag($p->getImagePath("t_")), 'product_show', $p)?>

                </td>

                <td>

                    <a href="<?php echo url_for('product_show', $p)?>"><?php echo strlen($p->getName()) > 50?myTools::utf8_substr($p->getName(), 0, 50).'..':$p->getName() ?></a>

                    <br/>

                    <div class="price" style="color:#999"><?php echo $p->getPrice($sf_user->getPreffCurrency())?></div>

                </td>

            </tr>

                <?php endforeach;?>

          </table>

        <span style="margin-bottom:30px;padding-left:75px" href="#">

            <?php $salesMan= Doctrine::getTable('User')->find($product->getUserId());

                  echo link_to(__('Other products').' »' ,'@product_browse?userId='.$product->getUserId().'&xType='.$product->getCategoryType());

                   ?>

        </span>

    </div><!--boxContent-->

 <div class="boxFooter"><div></div></div>

</div>

<?php endif?>

