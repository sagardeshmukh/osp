<h1>Search List</h1>

<div style="position: relative">
  <ul>
    <li style="background:none repeat scroll 0 0 #F0F0F0;color:#5494AF;font-size:12px;font-weight:bold;">
      Name
      <span style="position: absolute; right: 250px;">Is Visible</span>
      <span style="position: absolute; right: 160px;">Is Featured</span>
	  <span style="position: absolute; right: 100px;">Is Map</span>
      <span style="position: absolute; right: 40px;">#</span>
    </li>
    <?php foreach($results as $category): ?>
    <li>
            <?php echo $category->getName(); ?>
        <span style="position:absolute;right:180px;">
            <?php echo $category->getIsVisible() ? image_tag('icons/checked.png'): ''; ?>
        </span>
        <span style="position:absolute;right:120px;">
            <?php echo $category->getIsFeatured() ? image_tag('icons/checked.png'): ''; ?>
        </span>
		<span style="position:absolute;right:60px;">
            <?php echo link_to($category->getIsMap()?"Yes" : "No", 'category/editIsMap?id='.$category->getId()."&is_map=".$category->getIsMap(), array('class' => 'editIsMap', 'confirm' => 'Are you sure to change the status?')) ?>
        </span>
        <span style="position:absolute;right:4px;">
            <?php
                echo link_to("edit", 'category/edit?id='.$category->getId(), 'class=edit').'&nbsp;'.'&nbsp;'.
                link_to("delete", 'category/delete?id='.$category->getId(), 'class=delete confirm="Are you sure?"')
            ?>
        </span>
   </li>
    <?php endforeach; ?>
  </ul>
</div>