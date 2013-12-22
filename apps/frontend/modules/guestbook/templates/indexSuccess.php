<?php include_component('guestbook', 'leftMenu')?>
<div id="content">
  <div class="box info-container product-view" style="padding-left: 15px">
     <div class="boxYellow">
       <div class="boxHeader">
           <div>
               <h3><?php echo __('Customer comments') ?></h3>
           </div>
       </div>
       <div class="boxContent">
           <div>
               <table class="table-list-view">
                 <?php $i=0; foreach($pager as $guestbook): ?>
                   <tr class="<?php if($i==1){ echo "odd"; $i=0; }else { echo "even"; $i=1;} ?>">
                      <td valign="top" width="10%">
                         <b><?php echo $guestbook->getName();?></b>                                                  
                         <div><?php echo strftime("%Y/%m/%d", strtotime($guestbook->getCreatedAt())); ?></div>
                      </td>
                      <td>
                         <?php echo $guestbook->getBody();?>
                      </td>
                  </tr>
                   <?php endforeach?>
               </table>        
             </div>
             
             <div class="pagenav">
              <div class="pagenavWrap">
                <?php echo pager_navigation($pager, url_for("guestbook/index")) ?>
              </div>
            </div><!--pagenav-->
         </div><!--boxContent-->
         
         <div class="boxFooter"><div></div></div>        
        </div>
    </div>
</div><!--content-->
<div class="clear"></div>

<div id="guestbook_form_container" class="guestbook-dialog"></div>