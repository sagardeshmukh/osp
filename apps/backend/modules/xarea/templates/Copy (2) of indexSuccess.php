<?php

/*function print_category($parent_id, $level, $nested_categories)
{
  foreach($nested_categories[$parent_id] as $category)
  {
    if (isset($nested_categories[$category->getId()]))
    {
      echo "<li>".str_repeat('&nbsp;', $level * 7)."<span class=\"icon icon10\" onclick=\"expandCollapseThis(this);\">&nbsp;</span>".$category->getName();
    }
    else
    {
      echo "<li>".str_repeat('&nbsp;', $level * 7).$category->getName();
    }

    //echo image_tag('/uploads/category/'.$category->getLogo());
    echo '<input type="hidden" value="'.$category->getId().'" name="cat_ids[]" />';
    echo '<span style="position:absolute;right:4px;">'.
            link_to(image_tag('/images/icons/edit.png'), 'xarea/edit?id='.$category->getId(), 'class=edit').'&nbsp;'.'&nbsp;'.
            link_to(image_tag('/images/icons/cross.png'), 'xarea/delete?id='.$category->getId(), 'class=delete confirm="Are you sure?"')
            .'</span>';

    if (isset($nested_categories[$category->getId()]))
    {
      echo "<ul style=\"display:none;\">";
      print_category($category->getId(), $level + 1, $nested_categories);
      echo "</ul>";
    }
    echo '</li>';
  }
}*/
?>

<h1>Location List</h1>
<b><?php echo str_replace(',',' >> ',$patentLocation); ?></b>
<!--<div style="position: relative">
  <ul>
    <li style="background:none repeat scroll 0 0 #F0F0F0;color:#5494AF;font-size:12px;font-weight:bold;">
      Name
      <span style="position: absolute; right: 40px;">#</span>
    </li>-->
    <?php
	  if(isset($xAreas))
	  	$array = $xAreas;
	  else
	  	$array = $nested_categories[0];
		
	  if($level == 1)
	  	$locality = 'Manage state';
	  else if($level == 2)
	  	$locality = 'Manage city';
	  else if($level == 3)
	  	$locality = 'Manage location';
	  /*foreach($array as $category)
	  {
		echo "<li>".str_repeat('&nbsp;', 0 * 7).$category->getName();
		echo '<input type="hidden" value="'.$category->getId().'" name="cat_ids[]" />';
		
		echo '<span style="position:absolute;right:4px;">';
		if($level < 4){
			if($level != 3){
				echo link_to($locality, 'xarea/index?id='.$category->getId().'&level='.$category->getLvl()).'&nbsp;'.'&nbsp;';
			} else {
				if(in_array($category->getId(),$xAreaParentLocationId))
					echo link_to($locality, 'xarea/index?id='.$category->getId().'&level='.$category->getLvl()).'&nbsp;'.'&nbsp;';
			}
		}
		
		echo link_to(image_tag('/images/icons/edit.png'), 'xarea/edit?id='.$category->getId(), 'class=edit').'&nbsp;'.'&nbsp;'.'</span>';
		echo '</li>';
	  }*/
    ?>
  <!--</ul>
</div>-->
<table>
  <thead>
    <tr class="header">
      <td>Name</td>
      <td class="action" style="padding-right:75px;">#</td>
    </tr>
  </thead>
  <tbody id="CategoryItems">
    <?php foreach ($array as $location): ?>
    <tr>
      <td><?php echo $location->getName() ?></td>
      <td class="action" nowrap>
          <?php 
		  	if($level < 4){
				if($level != 3){
					echo link_to($locality, 'xarea/index?id='.$location->getId().'&level='.$location->getLvl()).'&nbsp;'.'&nbsp;';
				} else {
					if(in_array($location->getId(),$xAreaParentLocationId))
						echo link_to($locality, 'xarea/index?id='.$location->getId().'&level='.$location->getLvl()).'&nbsp;'.'&nbsp;';
				}
			}
			
			echo link_to(image_tag('/images/icons/edit.png'), 'xarea/edit?id='.$location->getId(), 'class=edit').'&nbsp;'.'&nbsp;';
		  ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!--<script type="text/javascript">
  /*function expandCollapseThis(element) {
    var element = $(element);
    if (element.hasClass('icon11')) {
      element.removeClass('icon11').addClass('icon10').siblings('ul').toggle();
    } else {
      element.removeClass('icon10').addClass('icon11').siblings('ul').toggle();
    }
  }*/
</script>
-->