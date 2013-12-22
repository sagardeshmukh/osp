<script type="text/javascript">
  function resizeIframe(){
    var productSource = document.getElementById('productSource');
    var height = productSource.contentWindow.document.body.scrollHeight;
    productSource.height = height + 50;
  }
  $(document).ready(function(){
    $('#dialog').dialog({
      autoOpen: false,
      width: 400,
      buttons: { "Ok": function() {
          $.ajax({ 
            url: "<?php echo url_for('product/delete')?>",
            data : ({id: <?php echo $sf_request->getParameter('id')?> , reason_id: $('#reason').val()}),
            success: function(){
              window.location = "<?php echo url_for("product/index")?>";
            }});
          $(this).dialog("close");
        }}
    });
    
    $('#deny_dialog').dialog({
      autoOpen: false,
      width: 400,
      buttons: { "Send email": function() {
          $.ajax({ 
            url: "<?php echo url_for('product/denyProduct')?>",
            data : ({id: <?php echo $sf_request->getParameter('id')?> , reason_id: $('#deny_reason').val()}),
            success: function(){
              window.location = "<?php echo url_for("product/index?status=denied")?>";
            }});
          $(this).dialog("close");
        }}
    });
    
    $('#confirm_button').bind('click', function(){
      window.location = "<?php echo url_for('product/confirmProduct?id='.$sf_request->getParameter('id'))?>";
      return false;
    });

    $('#edit_button').bind('click', function(){
      window.location = "<?php echo url_for('product/edit?id='.$sf_request->getParameter('id'))?>";
      return false;
    });

    $('#deny_button').bind('click', function(){
      $('#deny_dialog').dialog('open');
      return false;
    });
    $('#delete_button').bind('click', function(){
      $('#dialog').dialog('open');
      return false;
    });

  });
</script>

<div id="deny_dialog" title="<?php echo __('Reason for return'); ?>">
  <?php $sfWidgetSelect = new sfWidgetFormSelect(array('choices'=> array(
                          1 => __('compliance terms and conditions'),
                          2 => __('Lack of requirements'),
                          3 => __('Forbidden product'),
                          
          )), array("style"=>"width:350px;"));?>
  <br />
  <label for="deny_reason"><?php echo __('Reason') ?>:</label>
  <?php echo $sfWidgetSelect->render('deny_reason')?>
</div>

<div id="dialog" title="<?php echo __('Reason for delete') ?>">
  <?php $sfWidgetSelect = new sfWidgetFormSelect(array('choices'=> array(
                          1 => 'Compliance terms and conditions',
                          2 => 'Same information already exist'
          )));?>
  <br />
  <label for="reason"><?php echo __('Reason') ?> :</label>
  <?php echo $sfWidgetSelect->render('reason')?>
</div>

<?php  if ($product->getStatus() <= 0):?>
<button type="submit" id="confirm_button"><span><span><?php echo __('Confirm') ?></span></span></button>
<button type="submit" id="deny_button"><span><span><?php echo __('Return') ?></span></span></button>
<?php endif?>
<button type="submit" id="edit_button"><span><span><?php echo __('Edit') ?></span></span></button>
<button type="submit" id="delete_button"><span><span><?php echo __('Delete') ?></span></span></button>

<iframe style="border:1px solid #5494AF;" id="productSource" onload="resizeIframe();" width="100%" src="/product/show?has_layout=false&id=<?php echo $sf_request->getParameter('id')?>"></iframe>

<!-- User details -->
<?php if($userDetails) {?>
<?php   include_partial('user/userDetails', array('user' => $userDetails));?>
<?php } ?>
<!-- end user details -->

<?php  if (count($otherProducts)):?>
<h2 style="float:left;">Other ads added by this person. </h2>
<table style="clear: both; width: 80%">
  <tr>
    <td><?php echo __('Number') ?></td>
    <td><?php echo __('Products name') ?></td>
    <td><?php echo __('Active') ?></td>
    <td><?php echo __('Created date') ?></td>
    <td></td>
  </tr>
    <?php foreach($otherProducts as $oProduct):?>
  <tr>
    <td><?php echo $oProduct->getId()?></td>
    <td><?php echo $oProduct->getName()?></td>
    <td><?php if ($oProduct->getStatus() == 1) echo image_tag('icons/checked.png')?></td>
    <td><?php echo $oProduct->getCreatedAt()?></td>
    <td><?php echo link_to(__('Show'), 'product/show?id='.$oProduct->getId())?></td>
  </tr>
    <?php endforeach?>
</table>
<?php endif ?>