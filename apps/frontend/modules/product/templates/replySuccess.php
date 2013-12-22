<form  class="flash_notice" action="product/replyComment" name="reply_comment" id="replay_comment" method="post">
    <input type="hidden" name="commentId" value="<?php echo $commentId?>"/>
    <input type="hidden" name="product_id" value="<?php echo $product_id?>"/>
    <div align="center">
        <table>
            <tr><td><?php echo __('Content')?></td><tr>
            <tr>              
                <td>
                    <textarea rows="1" cols="55" name="product_comment_body"
                              onKeyDown="limitText(this.form.product_comment_body,this.form.countdown,100);"
                              onKeyUp="limitText(this.form.product_comment_body,this.form.countdown,100);"></textarea>
                </td>
            </tr>
            <tr align="center"><td>
                    <input readonly type="text" name="countdown" size="3" value="100">
                    <input type="submit" value="<?php echo __('Send')?>" onclick="submitComment(<?php echo $commentId ?>); return false"/>
                    <input type="submit" value="<?php echo __('Cancel')?>" onclick="jQuery('.guestbook-dialog').dialog('close'); return false;" />
                </td>
            </tr> 
        </table>
    </div>
</form>