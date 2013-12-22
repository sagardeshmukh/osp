<?php
$salesMan = Doctrine::getTable('User')->find($product->getUserId());
$rootCategory = Doctrine::getTable('Category')->getRootCategory($product->getCategoryId());
$job = $product->getJob();
$products = Doctrine::getTable('Product')->findByCompanyName($job->getCompanyName(), $product->getId());
    if($job->getContact()){
      if(substr($job->getContact(), 0,7) == 'http://' || substr($job->getContact(), 0,8) == 'https://'){
        $via_url =  $job->getContact();
      }else{
        $via_url =  'http://'.$job->getContact();
      }
    }
?>
<?php if($salesMan):?>
<div class="box boxSidebarYellow user-information>
    <div class="boxHeader"><div><h3><?php echo __('Employer') ?></h3></div></div>
    <div class="boxContent">
        <div class="boxWrap">
            <div class="user-profile">
                <div class="image">
                    <div class="profile-image">
                        <div class="img-holder medium">
                            <span class="free-member"></span>
                            <?php
                            $upload_profile_img = 'uploads/profile/' . ($salesMan->getGender() ? 'nobody_m.gif' : 'nobody_f.gif');
                            if ($salesMan->getImage())
                            {
                              $upload_profile_img = 'uploads/profile/' . ceil($salesMan->getId()/300) . '/s_' . $salesMan->getImage();
                            }?>
                            <a href="#" target="_blank">
                              <img border="0" width="60" height="60" title="<?php echo $salesMan->getFirstname()?>" src="http://biznetwork.mn/<?php echo $upload_profile_img?>" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <span><a href="#" target="_blank"><?php echo $salesMan->getInitial().".".$salesMan->getFirstname()?></a></span>
                </div>
            </div><!--user-profile-->
            <ul class="contact-tools">
                <li><span class="name"><b><?php echo __('Phone') ?> 1:</b>  <?php echo $product->getPhoneCell()?></span></li>
                <li><span class="name"><b><?php echo __('Phone') ?> 2:</b> <?php echo $product->getPhoneHome()?></span></li>
                <!--<li><span class="name">Fax:  <?php //echo $salesMan->getFax()?></span></li>-->
            </ul>
            <span class="button"><?php echo isset($via_url) ? link_to('<span>'.__('Search here').'</span>', $via_url, array('class' => 'blueSmall', 'title' => __('Application via url'), 'target' => '_blank')): link_to('<span>'.__('Apply now').'</span>', 'sendFriend/contact?p_id='.$product->getId(), array('class' => 'blueSmall', 'title' => __('Send a message'))) ?></span>
            <br clear="all"/>
            <div class="clear"></div>

        </div><!--boxWrap-->
    </div><!--boxContent-->
    <div class="boxFooter"><div></div></div>
</div><!--box-->
<?php endif;?>

<?php if (count($products)):?>
<div class="box boxSidebarGrey user-information">
    <div class="boxHeader"><div><h3><?php echo __('Other jobs') ?></h3></div></div>
    <div class="boxContent">
        <table cellspacing="0" cellpadding="0" border="0" class="table-list-view">
                <?php $i=0;
                foreach($products as $p): $i++;?>
            <?php
                $job = $p->getJob();
            ?>
            <tr class="<?php echo ($i % 2==0)? "odd":"even" ?>">
                <td align="center" width="80">
                       <?php echo link_to(image_tag('/uploads/product-image-1/t_'.$job->getLogo()), 'product_show', $p)?>
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
                  echo link_to(__('Other jobs').' »' ,'@product_browse?userId='.$product->getUserId().'&xType='.$product->getCategoryType());
                   ?>
        </span>
    </div><!--boxContent-->
 <div class="boxFooter"><div></div></div>
</div>
<?php endif?>
