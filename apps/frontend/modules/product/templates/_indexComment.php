<?php if(count($comments)):?>
<div class="box boxGray">
  <div class="boxHeader"><div><a href="/buy_online"><h3><?php echo __('New Questions and Answers') ?></h3></a></div></div>
  <div class="boxContent" style="padding: 1px;">
    <ul id="listticker">
        <?php foreach($comments as $comment):?>
            <?php $user= $comment->getUser();?>
            <?php
            if($user){
            $product= Doctrine::getTable('Product')->find($comment->getProductId());?>
            <li style="opacity: 1;">
                        <div style="padding-left:5px;">
                             <div style="float:left;">
                                <div class="profile-image" style="padding-right: 5px; padding-bottom: 2px;  ">
                                  <div class="img-holder small">
                                    <span class="free-member"></span>
                                    <a href="http://biznetwork.mn/profile/<?php echo $user->getUsername()?>" target="_blank">
                                       <img border="0" widt0.h="60" height="40" src="http://biznetwork.mn/uploads/profile/<?php if(!$user->getImage()&&$user->getGender()==0) echo "nobody_f.gif";
                                                   elseif(!$user->getImage()&&$user->getGender()==1) echo "nobody_m.gif"; elseif($user->getImage()) echo ceil($user->getId()/300)?>/s_<?php echo $user->getImage()?>"
                                       />
                                   </a>
                                  </div>
                                </div>
                            </div>
                            <div class="description">
                                <a href="http://biznetwork.mn/profile/<?php echo $user->getUsername()?>" target="_blank"><?php  echo  $user->getInitial().". "; echo $user->getFirstname()?></a> user
                                left comment <a  href="/p/<?php echo $comment->getProductId()?>#answer"> <?php echo myTools::mb_strlen($product->getName()) > 19?myTools::utf8_substr($product->getName(), 0, 40).'..':$product->getName() ?></a>.
                                <div style="font-style:inherit; color:grey; font-size: 10px;">
                                    <?php echo date("Y/m/d H:i", strtotime($comment->getCreatedAt()));?>
                                </div>
                             </div>
                         <div style="width: 650px">
                            <?php echo myTools::mb_strlen($comment->getBody()) > 100?myTools::utf8_substr($comment->getBody(), 0, 100).'..':$comment->getBody() ?>
                         </div>
                        </div>
                     <div class="clear"></div>
                </li>
           <?php } endforeach;?>
     </ul>
  </div>
  <div class="boxFooter"><div></div></div>
</div><!--boxBlue-->
<?php endif?>
   