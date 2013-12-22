<?php $user = $sf_user->getInstance()?>
<form method="post" action="/product/updateComment" id="product_comment_form" class="flash_notice">
<input type="hidden" name="pid" value="<?php echo $pid?>">
<table>
  <tbody>
    <tr>
      <th><label for="guestbook_body"><?php echo __('Name') ?></label></th>
      <td>
        <?php if ($sf_user->isLogged()):?>
           <b><a href="http://biznetwork.mn/profile/<?php echo $user->getUsername()?>" target="_blank"><?php echo $user->getName()?></a></b>
        <?php else:?>
          <input type="text" id="product_comment_username" name="product_comment_username">
        <?php endif;?>
      </td>
    </tr>
    <tr>
      <th><label for="product_comment_email"><?php echo __('Email') ?></label></th>
      <td>
        <?php if ($sf_user->isLogged()):?>
           <?php echo $user->getEmail()?>
           <?php $check_email = 0?>
        <?php else:?>
          <input type="text" id="product_comment_email" name="product_comment_email">
          <?php $check_email = 1?>
        <?php endif;?>
      </td>
    </tr>
		<tr>
		  <th><label for="product_comment_body"><?php echo __('Content') ?></label></th>
		  <td><textarea id="product_comment_body" name="product_comment_body" cols="45" rows="8"></textarea></td>
		</tr>
  </tbody>
</table>
  <div align="center">
      <input type="submit" value="<?php echo __('Send')?>" onclick="newProductCommentSubmit(<?php echo $check_email?>, <?php echo $pid?>); return false"/>
      <input type="submit" value="<?php echo __('Cancel')?>" onclick="jQuery('#comment_form_container').dialog('close'); return false;" />
  </div>
</form>