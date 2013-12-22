<div class="box boxYellow">
  <div class="boxHeader"><div><a href="/buy_online"><h3><?php echo __('Buy now') ?></h3></a></div></div>
  <div class="boxContent">
    <div class="five-col-one last">
      <?php foreach($products as $i => $product):?>
        <?php include_partial('homeItem', array('product'=>$product, 'sf_cache_key'=> $product->getCacheKey(), 'is_last' => $i==4?1:0))?>
      <?php endforeach?>
      <div class="clear"></div>
    </div><!--similar-products-->
  </div>
  <div class="boxFooter"><div></div></div>
</div><!--boxBlue-->