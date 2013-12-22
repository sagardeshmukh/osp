<?php
$salesMan = Doctrine::getTable('User')->find($product->getUserId());
$rootCategory = Doctrine::getTable('Category')->getRootCategory($product->getCategoryId());
$products = Doctrine::getTable('Product')->getProductsByCategoryId($rootCategory->getId(), $product->getId());
?>
<?php if($salesMan):?>
<div class="clear"></div>

<div class="box boxSidebarYellow user-information">
    <div class="boxHeader"><div><h3><?php echo __('Provider') ?></h3></div></div>
    <div class="boxContent">
        <div class="boxWrap">
            <div class="user-profile">
                <?php /*?><div class="image">
                    <div class="profile-image">
                        <div class="img-holder medium">
                            <span class="free-member"></span>
                            <?php
                            $upload_profile_img = 'uploads/profile/' . ($salesMan->getGender() ? 'nobody_m.gif' : 'nobody_f.gif');
                            if ($salesMan->getImage())
                            {
                              $upload_profile_img = 'uploads/profile/' . ceil($salesMan->getId()/300) . '/s_' . $salesMan->getImage();
                            }?>
                            <a href="http://yozoadev.icoldo.com/profile/<?php echo $salesMan->getUsername()?>" target="_blank">
                              <img border="0" width="60" height="60" title="<?php echo $salesMan->getFirstname()?>" src="<?php //echo $upload_profile_img?>" />
                            </a>
                        </div>
                    </div>
                </div><?php */?>
                <div class="">
                    <span><a href="/user/profiles/id/<?php echo $salesMan->getId()?>" target="_blank"><?php echo $salesMan->getInitial().".".$salesMan->getFirstname()?></a></span>
                </div>
            </div><!--user-profile-->
            <ul class="contact-tools">
                <li><span class="name"><b><?php echo __('Phone') ?> 1:</b>  <?php echo $product->getPhoneCell()?></span></li>
                <li><span class="name"><b><?php echo __('Phone') ?> 2:</b> <?php echo $product->getPhoneHome()?></span></li>
                <!--<li><span class="name">Fax:  <?php //echo $salesMan->getFax()?></span></li>-->
            </ul>
            <span class="button"><?php echo link_to('<span>'.__('Contact').'</span>', 'sendFriend/contactUser', array('class' => 'blueSmall', 'title' => __('Send a message'))) ?></span>
            <br clear="all"/>
            <div class="clear"></div>

        </div><!--boxWrap-->
    </div><!--boxContent-->
    <div class="boxFooter"><div></div></div>
</div><!--box-->
<?php endif;?>