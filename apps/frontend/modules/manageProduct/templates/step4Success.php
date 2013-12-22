<?php include_partial('bread_crumb', array('title' => 'Update')) ?>

<form method="post" action="<?php echo url_for('manageProduct/step4')?>" id="doping_form">
  <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $unique_id ?>" />
  <div class="box boxGray">
    <div class="boxHeader"><div><h3>Advertise product - <?php echo $product->getName()?></h3></div></div>
    <div class="boxContent">
      <div class="boxWrap">
      	<table style="width: 40%; float: left">
          <tr>
            <td>
            
            </td>
          </tr>
        </table>
        <table style="width: 58%;">
          <?php foreach($dopings as $doping):?>
          <tr>
            <td>
              <input type="checkbox" id="doping_id_<?php echo $doping->getId()?>" name="doping[id][<?php echo $doping->getId()?>]" value="<?php echo $doping->getId()?>" />
              <input type="hidden" id="doping_def_price_<?php echo $doping->getId()?>" value="<?php echo $doping->getPriceMnt()?>" />
            </td>
            <td><label for="doping_id_<?php echo $doping->getId()?>"><?php echo $doping->getName()?></label></td>
            <td>
                <?php
                $sfWidgetSelect = new sfWidgetFormSelect(array('choices'=> $doping->getDopingPriceOptions()));
                echo $sfWidgetSelect->render("doping[duration][{$doping->getId()}]");
                ?>
            </td>
          </tr>
          <?php endforeach;?>
        </table>
        <h2>Total cost :<span id="total_price">0</span> </h2>
      </div>
    </div>
    <div class="boxFooter"><div></div></div>
  </div>
</form>


<div class="box boxGray">
  <div class="boxHeader boxNoTitle"><div></div></div>
  <div class="boxContent">
    <div class="boxWrap">
      <div class="actions">
        <span class="button"><a title="<?php echo __('Return') ?>" class="gray" href="<?php echo url_for('manageProduct/step3')?>?unique_id=<?php echo $unique_id?>"><span><?php echo __('Back') ?></span></a></span>
        <span class="button"><a id="continue_form" title="<?php echo __('Continue') ?>" class="blue" href="#"><span><?php echo __('Finish') ?></span></a></span>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
    $('#continue_form').click(function(){
      $("#doping_form").submit();
      return false;
    });
    function calculateSum() {
      var sum = 0;
      $('#doping_form input:checked').each(function(){
        var id = $(this).val();
        switch($('#doping_duration_' + id).val()){
          case '7':
            sum += 1 * parseInt($('#doping_def_price_' + id).val());
            break;
          case '14':
            sum += 1.8 * parseInt($('#doping_def_price_' + id).val());
            break;
          case '28':
            sum += 3.2 * parseInt($('#doping_def_price_' + id).val());
            break;
        }
      });
      $('#total_price').text(sum);
    }
    
    $('#doping_form :checkbox, #doping_form select').bind('change', function(){
      calculateSum();
    });
    calculateSum();
  });
</script>