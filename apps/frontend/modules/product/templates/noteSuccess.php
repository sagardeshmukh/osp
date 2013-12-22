<?php $n=1; $notes=Doctrine::getTable('ProductComment')->getNotes($commentId); $i=1;?>
<?php if($notes){ $j=1; foreach ($notes as $note ):?>
<?php $user_note = Doctrine::getTable('User')->find($note->getUser()); ?>
<div id="comment_note_<?php echo $commentId; ?>_<?php echo $n?>" class="comment_note"<?php if($i==0){?> style="display: none"<?php } $i=0;?>>
    <div class="notes">
        <div class="note">
            <span class="text"><?php echo $note->getBody();?></span>
        <span class="nbc">
          <?php if($j!=1){?><a onclick="noteLeft('<?php echo $n;?>','<?php echo $commentId?>')" style="cursor:pointer">«</a><?php }?>
          <?php echo $j;?>/<?php echo count($notes)?>
          <?php if($j!=count($notes)){ ?><a onclick="noteRight('<?php echo $n+1;?>','<?php echo $commentId?>')" style="cursor:pointer">»</a><?php } $j++;?>
        </span>
        <span class="user">
          <a href="http://biznetwork.mn/profile/<?php if($user_note) echo $user_note->getUsername()?>" target="_blank"><?php if($user_note) echo $user_note->getInitial().". ";  if($user_note) echo $user_note->getFirstname();?></a>
        </span>
        </div>
    </div>
</div>
<?php $n++; endforeach; }?>