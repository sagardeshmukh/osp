<div class="desc" style="font-size: 10px; color: #999">
  <img src="/images/right_arrow.jpg" height="9"/>If you think it's contain wrong information, please <a href="#" onclick="warningDailog('incorrect','<?php echo $product->getId()?>'); return false;" style="color: #6699ee">inform</a><br/>
	<img src="/images/right_arrow.jpg" height="9"/>if you think it's Sold / Rented <a href="#" onclick="warningDailog('sold','<?php echo $product->getId()?>'); return false;" style="color: #6699ee">inform</a><br/>
	<?php if($product->getBuyOnline()== 0):?>
		<img src="/images/right_arrow.jpg" height="9"/>If you decide to buy it <a href="#customer_security" style="color: #6699ee">take attention in following!</a>
	<?php endif;?>
</div>