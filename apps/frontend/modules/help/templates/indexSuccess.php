<?php include_component('help', 'leftMenu')?>
<div id="content">
    <div class="box info-container product-view" style="width:450px; padding-left:20px">
        <div class="boxYellow">
            <div class="boxHeader"><div><h3><?php echo __('Common questions') ?></h3></div></div>
            <div class="boxContent">
                <div style="padding:10px ">
                    <?php foreach($help_categories as $help_category): ?>
                      <div style="padding: 5px 3px 1px 20px;" >
                        <li><?php echo link_to($help_category->getQuestion(), '@answer?id='.$help_category->getId())?></li>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
            <div class="boxFooter"><div></div></div>
        </div>
    </div>
</div><!--content-->
<?php include_component('help','rightMenu')?>
<div class="clear"></div>
