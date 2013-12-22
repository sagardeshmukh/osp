<?php use_javascript('ui/ui.core.min.js')?>
<?php use_javascript('ui/ui.dialog.min.js')?>
<?php use_stylesheet('flick/jquery-ui-1.7.2.custom.css')?>
<div class="leftSidebar">
  <div class="box boxSidebarBlue">
    <div class="boxHeader"><div><h3><?php echo __('Comment board') ?></h3></div></div>
      <div class="boxContent">
        <ul class="cats">
            <li>
                <span class="button" style="padding-bottom:50px">
                    <a title="<?php echo __('Continue') ?>" class="blueSmall" href="#"  onclick="newGuestbook(); return false;"><span><?php echo __('Leave a comment') ?></span></a>
                </span>
            </li>
         </ul><br/><br/>
        </div>
        <div class="boxFooter"><div></div></div>
    </div><!--box-->
</div>
