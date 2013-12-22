<div class="leftSidebar">
  <div class="box boxSidebarBlue">
    <div class="boxHeader"><div><h3><?php echo __('Help') ?></h3></div></div>
      <div class="boxContent">
        <ul class="cats">
        <div>
          <?php foreach($categories as $category):?>
            <?php $answers = Doctrine::getTable('HelpTopic')->getAnswers($category->getId());?>
              <?php if(sizeof($answers)) {?>
                  <li class="title icon icon<?php  if($selected_category && ($selected_category->getHelpCategoryId() == $category->getId())) {echo '11';} else echo '10';?>" onclick="toggleContainers(this);" style="cursor:pointer;">
                       <?php echo $category->getName()?>
                  </li>
                  <div style="padding-left: 27px;display:<?php  if($selected_category && ($selected_category->getHelpCategoryId() == $category->getId())) {echo 'block';} else echo 'none';?>">
                  <?php foreach($answers as $answer):?>
                   <li>
                     <?php echo link_to($answer->getQuestion(), '@answer?id='.$answer->getId())?>
                   </li>
                  <?php endforeach; }?>
                   </div>                          
            <?php endforeach?>
         </div>
       </ul>
     </div>
     <div class="boxFooter"><div></div></div>
 </div><!--box-->
 
  <div class="box boxSidebarBlue">
    <div class="boxHeader"><div><h3><?php echo __('Customer comments') ?></h3></div></div>
    <div class="boxContent">
      <?php include_component('guestbook', 'latest')?>
    </div>
    <div class="boxFooter"><div></div></div>
  </div><!--box-->  
 
</div>