<h1>Location List</h1>
<?php 
if($patentLocation)
	echo "&nbsp;&nbsp;<b> World >> ".str_replace(',',' >> ',$patentLocation)."</b>"; 

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
?>
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
					echo link_to('Add', 'xarea/new?id='.$location->getId().'&level='.$location->getLvl()).'&nbsp;'.'&nbsp;';
				}
				echo link_to(image_tag('/images/icons/edit.png'), 'xarea/edit?id='.$location->getId().'&lvl='.$location->getLvl(), 'class=edit').'&nbsp;'.'&nbsp;';
			}
			
			if($level == 4){
				echo link_to(image_tag('/images/icons/edit.png'), 'xarea/edit?id='.$location->getId().'&lvl=4', 'class=edit').'&nbsp;'.'&nbsp;';
				echo link_to(image_tag('/images/icons/cross.png'), 'xarea/delete?id='.$location->getId().'&p_id='.$xAreaId, 'class=delete confirm="Are you sure?"');
			}
		  ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
