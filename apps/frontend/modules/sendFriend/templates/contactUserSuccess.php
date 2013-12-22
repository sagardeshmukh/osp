<div class="boxHeader"><div><h3><?php echo __('Contact') ?></h3></div></div>
              <div class="boxContent">
                <div class="boxWrap">
<?php include_partial('form', array('form' => $form, 'product_id'=>$product_id, 'action' => url_for('sendFriend/create'))) ?>

                    <div class="clear"></div>
                    </div>
                  </div>
                  <div class="boxFooter"><div></div></div>
                  <div class="clear">&nbsp;</div>