<div class="clear">&nbsp;</div>



<div class="box clear" style="width:700px;">

    <div class="boxHeader"><div><h3><?php echo __('Answers, Questions') ?></h3></div></div>

    <div class="boxContent"><br/>

        <ul class="boxContent-list">

          <?php $n=1; foreach( $comments as $comment): ?>

          <?php $user = Doctrine::getTable('User')->find($comment->getUser()); if($user){?>

          <li style="padding: 3px -1px">

                <div style="padding-left:5px;" id="comment_body_<?php echo $comment->getId()?>">

                    <a name="comment_307693"></a>

                    <div style="float:right; display: inline-block">

                        <div style="text-align: right;padding-right:5px">

                         <span id="comment303571rate">

                             <?php if($user) { if($sf_user->getId()==$user->getId()||$sf_user->hasCredential('admin')||$sf_user->getId()==$my_product->getUserId()){?>

                            <a style="cursor:pointer" onclick="deleteComment(<?php echo $comment->getId()?>,<?php echo $user->getId()?>,this)">

                                <img height="15" src="/images/icons/delete.png"/>

                            </a><?php }}?>

                        </span>

                            <a href="#" <?php if($sf_user->getId()){?>

                                              onclick="replyComment('<?php echo $comment->getId()?>','<?php echo $comment->getProductId()?>'); return false;" <?php } else {

                                                  ?>

                                              onclick="loginDialog('<?php echo $productId?>'); return false;"

                                                  <?php

                                              }

                            ?>>

                                 <img alt="<?php echo __('Add comment')?>" src="/images/icons/comment_add.png" />

                            </a>

                        </div>

                        <div id="comment_note_container_<?php echo $comment->getId();?>">

                        <?php $notes=Doctrine::getTable('ProductComment')->getNotes($comment->getId()); $i=1;?>

                        <?php if($notes){ $j=1; foreach ($notes as $note ): ?>

                        <?php $user_note = Doctrine::getTable('User')->find($note->getUser()); ?>

                        <div id="comment_note_<?php echo $comment->getId();?>_<?php echo $n?>" class="comment_note"<?php if($i==0){?> style="display: none"<?php } $i=0;?>>

                            <div class="notes">

                                <div class="note">

                                <span class="text"><?php echo $note->getBody();?></span>

                                <span class="nbc">

                                  <?php if($j!=1){?><a onclick="noteLeft('<?php echo $n;?>','<?php echo $comment->getId();?>')" style="cursor:pointer">«</a><?php }?>

                                  <?php echo $j;?>/<?php echo count($notes)?>

                                  <?php if($j!=count($notes)){ ?><a onclick="noteRight('<?php echo $n+1;?>','<?php echo $comment->getId();?>')" style="cursor:pointer">»</a><?php } $j++;?>

                                </span>

                                <span class="user">

                                    <a href="http://biznetwork.mn/profile/<?php if($user_note) echo $user_note->getUsername()?>" target="_blank"><?php if($user_note) echo $user_note->getInitial().". ";  if($user_note) echo $user_note->getFirstname();?></a>

                                </span>

                                </div>

                            </div>

                        </div>

                        <?php $n++; endforeach; }?>

                       </div>

                     </div>

                     <div style="float:left;">

                        <div class="profile-image" style="padding-right: 5px; padding-bottom: 2px;  ">

                          <div class="img-holder small">

                            <span class="<?php $ispaid=$user->getIsPaid(); if($ispaid==1){echo "business";}else{if($ispaid==2){echo "support";}else{echo "free";}}?>-member"></span>

                            <a href="http://biznetwork.mn/profile/<?php echo $user->getUsername()?>" target="_blank">

                               <img border="0" width="60" height="40" src="http://biznetwork.mn/uploads/profile/<?php if(!$user->getImage()&&$user->getGender()==0) echo "nobody_f.gif";

                                           elseif(!$user->getImage()&&$user->getGender()==1) echo "nobody_m.gif"; elseif($user->getImage()) echo ceil($user->getId()/300)?>/s_<?php echo $user->getImage()?>"

                               />

                           </a>

                          </div>

                        </div>

                    </div>

                    <div class="description">

                        <a href="http://biznetwork.mn/profile/<?php echo $user->getUsername()?>" target="_blank"><?php  echo  $user->getInitial().". "; echo $user->getFirstname()?></a>

                          <span style="font-style:inherit; color:grey; font-size: 10px;">

                            <?php echo strftime("%Y/%m/%d", strtotime($comment->getCreatedAt())); ?>.

                          </span>

                     </div>

                 <div style="width: 650px">

		   <?php echo $comment->getBody();?>

                 </div>

                </div>

             <div class="clear"></div>

          </li>

        <?php } endforeach;?>

        </ul><!--comment-list-->

		<a name="answer"></a>

        <?php if(!$sf_user->getId()){?>

        <div class="warning">

          <?php echo __('Answer a question')?>

        <div>

          In order to asking a question, you have to <a href="#" onclick="loginDialog('<?php echo $productId?>'); return false;">login</a>. If you haven't registered yet, click <a href="<?php echo url_for('user/new') ?>">here</a>!

        </div>

        <?php }else{?>

            <?php if($comment_error==0) {?>

                      <ul class="error_list">

                         <li><?php echo __('Insert your question.')?></li>

                      </ul>

           <?php } ?>

        <div class="warning">

              Insert only related question of that product!

          <div>

          <form name="product_comment" id="product_comment" method="post" enctype="multipart/form-data" action="product/createComment">

              <div>

                <textarea class="comment" rows="5" cols="75" name="product_comment_body" id="product_comment_body"></textarea><br/>

                <span class="buttons"><a <?php if($comment_error!=2) {?> href="#" onclick="newProductCommentSubmit(<?php echo $productId?>); return false" <?php }?> class="yellows" title="<?php echo __('Send')?> &raquo;"><span><?php echo __('Send') ?> &raquo;</span></a></span>

              </div>

              <div class="clear"></div>

          </form>

          </div>

       <?php }?>

      </div>

    <div class="clear">&nbsp;</div>

</div><!--box-->

<div class="boxFooter"><div></div></div>

</div>