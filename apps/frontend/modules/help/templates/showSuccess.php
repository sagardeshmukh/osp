<?php include_component('help', 'leftMenu')?>
<div id="content">
    <div class="box info-container product-view" style="width:450px; padding-left:20px">
        <div class="boxYellow">
            <div class="boxHeader"><div><h3><?php echo $help_answer->getQuestion();?></h3></div></div>
            <div class="boxContent">
                <div style="padding: 10px;">
                    <?php echo $help_answer->getAnswer()?>
                </div>
            </div>
            <div class="boxFooter"><div></div></div>
        </div>
        <?php if(sizeof($related_answer)>0){?>
        <div class="boxBlue" style="padding-top:10px">
            <div class="boxHeader"><div><h3><?php echo __('Related Questions') ?></h3></div></div>
            <div class="boxContent">
                <div style="padding:10px;">
                    <?php foreach($related_answer as $answer):?>
                      <div style="padding: 5px 3px 1px 20px;" >
                            <li class="title icon icon5"><?php echo link_to($answer->getQuestion(), '@answer?id='.$answer->getId())?></li>
                     </div>
                    <?php endforeach;?>
                 </div>
            </div>
        </div>
        <div class="boxFooter"><div></div></div>
        <?php }?>
    </div>
</div><!--content-->
<?php include_component('help','rightMenu')?>
<div class="box clear">
     <div class=""><div></div></div>
</div><!--box-->
<div class="clear"></div>
