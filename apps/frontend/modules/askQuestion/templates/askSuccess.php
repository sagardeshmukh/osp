<div class="boxHeader"><div><h3><?php echo __('Ask a Question') ?></h3></div></div>
<div class="boxContent">
	<div class="boxWrap">
   		<?php include_partial('form', array('form' => $form, 'action' => url_for('askQuestion/create'))) ?>
    	<div class="clear"></div>
    </div>
</div>
<div class="boxFooter">
    <div></div>
</div>
<div class="clear">&nbsp;</div>