<h1>Edit location</h1>

<?php 
	if(isset($editXarea))
		include_partial('form1', array('locationName' => $locationName, 'x_area' => $x_area,'lvl' => $lvl, 'patentLocation' => $patentLocation));
	else
		include_partial('form', array('form' => $form, 'xarea_table' => $xarea_table, 'areas' => $areas,'patentLocation' => $patentLocation , 'x_area_location' => $x_area_location)); 
?>
