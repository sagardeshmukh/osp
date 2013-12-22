
<div class="box boxSidebar user-information-new">
    <div class="boxHeader"><div><h3><?php echo $mystr;?><?php echo __('Main information') ?></h3></div></div>
      <div class="boxContent">
        <div class="boxWrap">
          <div class="user-profile">
            <div class="image">
              <div class="profile-image">
                <div class="img-holder medium">
                  <?php $ispaid = 0; ?>
                  <span class="<?php if($ispaid==1){echo "business";}else{if($ispaid==2){echo "support";}else{echo "free";}}?>-member"></span>
                  <a href="http://biznetwork.mn/profile/<?php echo $sf_user->getUsername()?>" target="_blank">
                      <img border="0" width="60" height="60" title="<?php echo $sf_user->getFirstname()?>" src="http://biznetwork.mn/uploads/profile/<?php echo ceil($sf_user->getId()/300)?>/s_<?php echo $sf_user->getImage()?>"/>
                  </a>
                </div>
              </div>
            </div>
            <div class="info">
              <span><a href="http://biznetwork.mn/profile/<?php echo $sf_user->getUsername()?>" target="_blank"><?php echo $sf_user->getName()?></a></span>
              <span><?php echo $sf_user->getLastname() ?></span>
            </div>
          </div><!--user-profile-->
          <ul class="contact-tools">
           <?php if($sf_user->getEmail()){?><li><span class="name"><?php echo __('Email') ?>: <?php echo $sf_user->getEmail()?></span></li><?php }?>
            <!--li><span class="name">Fax:  <?php// echo $salesMan->getFax()?></span></li-->
          </ul>
        </div>
      </div>
    <div class="boxFooter"><div></div></div>
  <br clear="all"/>
  </div><!--box-->

  <div class="box boxSidebar user-information-last">
    <div class="boxHeader"><div><h3><?php echo __('Profile information') ?></h3></div></div>
      <div class="boxContent">
        <div class="boxWrap">
          <div style="padding: 5px;">
            <table cellspacing="1" cellpadding="3" border="0" class="table-list-view">
              <tr class="list-title">
                <td><?php echo __('User name') ?></td>
                <td><?php echo __('Full name') ?></td>
                <td><?php echo __('Email') ?></td>
                <td><?php echo __('Location') ?></td>
                <td><?php echo __('Company name') ?></td>
                <td><?php echo __('Edit') ?></td>
              </tr>
                  <tr class="list-title-new">
                  <tr>
                    <td><?php echo $user->getUsername();?></td>
                    <td><?php echo $user->getFirstname().'&nbsp;'.$user->getLastname();?></td>
                    <td><?php echo $user->getEmail();?></td>
                    <td><?php echo $user->getXArea()->getName();?></td>
                    <td></td>
                    <td align="center"><?php echo link_to(image_tag('icons/edit.png', array("title"=>"Edit", "alt"=>"Edit")), 'user/edit?id='.$user->getId())?></td>
                  </tr>

            </table>
          </div>
         </div>
      </div>
    <div class="boxFooter"><div></div></div>
  <div style="margin-top: 10px; float: right; padding-right: 10px;">
      <span class="button"><a href="<?php echo url_for('user/edit')?>"><span><?php echo __('Edit profile') ?> &raquo;</span></a></span>
  </div>
  <br clear="all"/>
  </div><!--box-->
  <br clear="all"/>