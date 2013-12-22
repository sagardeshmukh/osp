<h1>Help</h1>
<table>
  <thead>
    <tr class="header">
      <td>Question</td>
      <td>Sort order</td>
      <td>Category</td>
      <td>Read count</td>
      <td>##</td>
    </tr>
  </thead>
  <tbody>
   <?php foreach($help_topics as $help_topic):?>
    <tr>
       <td><?php echo $help_topic->getQuestion()?> </td>
       <td><?php echo $help_topic->getSortOrder()?> </td>
       <td><?php echo $help_topic->getHelpCategory()->getName()?> </td>
       <td><?php echo $help_topic->getReadCount()?> </td>
       <td class="action" nowrap>
          <?php echo link_to(image_tag('icons/edit.png'), '@help_topic_edit?id='.$help_topic->getId(), array('class' => 'edit'))?>
           <?php echo link_to(image_tag('icons/cross.png'), '@help_topic_delete?id='.$help_topic->getId(), $help_topic,
                array(
                'confirm' => 'Are you sure?',
                'method'  => 'delete'));
          ?>       </td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
