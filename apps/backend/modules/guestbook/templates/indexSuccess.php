<form action="">
<h1>Guestbook</h1>
<table>
  <thead>
    <tr class="header">
      <td>Name</td>
      <td>Created at</td>
      <td>#####</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach($guestbooks as  $guestbook):?>
    <tr>
       <td><?php echo $guestbook->getName()?></td>
       <td><?php if ($guestbook->getConfirmed() == 1) echo image_tag('icons/checked.png');?></td>
       <td class="action" nowrap>
          <?php echo link_to(image_tag('icons/edit.png'), 'guestbook/edit?id='.$guestbook->getId(), array('class' => 'edit'))?>
          <?php echo link_to(image_tag('icons/cross.png'), 'guestbook_delete', $guestbook,
                array(
                'confirm' => 'Are you sure?',
                'method'  => 'delete'));
          ?>
       </td>
   </tr>
   <?php endforeach;?>
  </tbody>
</table>
</form>