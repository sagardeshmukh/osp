<?php if ($pager1->getNbResults()):?>
<div class="box boxBlue">
  <div class="boxHeader"><div><h3><?php echo __('Expired')?></h3></div></div>
  <div class="boxContent">
    <div id="inactive_products">
        <?php include_partial('products', array('divId' => 'inactive_products', 'pager' => $pager1, 'status' => -1))?>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>
<?php endif?>

<?php if ($pager4->getNbResults()):?>
<div class="box boxBlue">
  <div class="boxHeader"><div><h3><?php echo __('Denied')?></h3></div></div>
  <div class="boxContent">
    <div id="active_products">
        <?php include_partial('products', array('divId' => 'pending_products', 'pager' => $pager4, 'status' => 3))?>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>
<?php endif?>

<?php if ($pager2->getNbResults()):?>
<div class="box boxBlue">
  <div class="boxHeader"><div><h3><?php echo __('Pending')?></h3></div></div>
  <div class="boxContent">
    <div id="pending_products">
        <?php include_partial('products', array('divId' => 'pending_products', 'pager' => $pager2, 'status' => 0))?>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>
<?php endif?>

<?php if ($pager3->getNbResults()):?>
<div class="box boxBlue">
  <div class="boxHeader"><div><h3><?php echo __('Active')?></h3></div></div>
  <div class="boxContent">
    <div id="active_products">
        <?php include_partial('products', array('divId' => 'active_products', 'pager' => $pager3, 'status' => 1))?>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>
<?php endif?>

<?php if (($pager3->getNbResults()+$pager2->getNbResults()+$pager1->getNbResults()+$pager4->getNbResults()) == 0):?>
	<center><?php echo __('You have no product.')?></center>
	<br/> 
<?php endif;?>
<br/>
<span class="button"><a href="/manageProduct/step1" class="blue"><span><?php echo __('Add product')?></span></a></span>
<br/>
<br/>
<br/>

<div id="dialog" title="<?php echo __("Extend")?>">
  <h2 id="productTitle"></h2>
  <input type="hidden" value="" name="id" id="extendProductId" />
  <select name="duration" id="extendDuration">
    <?php foreach(myConstants::getExtendDuration() as $value => $name):?>
    <option value="<?php echo $value?>"><?php echo __($name)?></option>
    <?php endforeach?>
  </select>
</div>
<div id="dialogExtend">
  <h1><?php echo __('Successfully extended')?></h1>
</div>

<script type="text/javascript">
  function showExtendDialog(productId) {
    $.ajax({
      url: "<?php echo url_for('manageProduct/productInfo')?>",
      data: { id : productId },
      dataType: "json",
      success: function(data){
        $('#productTitle').html(data.title);
        $('#extendProductId').val(data.id);
        $('#dialog').dialog('open');
      }});
  }
  $(document).ready(function(){
    $('#dialogExtend').dialog({
      autoOpen: false,
      width: 400,
      buttons: { "Ok": function() { $(this).dialog("close");}}
    });
    $('#dialog').dialog({
      autoOpen: false,
      width: 400,
      buttons: { "Extend": function() {
          $.ajax({
            url: "<?php echo url_for('manageProduct/extendProduct')?>",
            data: {
              id : $("#extendProductId").val(),
              duration: $("#extendDuration").val()
            },
            success: function(){
              $('#dialogExtend').dialog('open');
            }
          });
          $(this).dialog("close");
        }}
    });
  });
</script>