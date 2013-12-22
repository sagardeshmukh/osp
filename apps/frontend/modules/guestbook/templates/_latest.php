<div class="boxWrap">
  <b>
    <a href="/guestbook"><?php echo $guestbook->getName();?></a>
  </b>
  <div style="text-align: justify; margin-top: 5px;">
    <?php echo myTools::utf8_substr(trim(strip_tags($guestbook->getBody())), 0, 200).'...'?>
  </div>
  <div style="float: right; margin-top: 5px;">
    <?php echo link_to('More &raquo; ', '/guestbook')?>
  </div>
  <br clear="all"/>
</div>