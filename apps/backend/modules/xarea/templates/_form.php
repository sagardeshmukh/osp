<?php 
use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_javascript('http://maps.google.com/maps/api/js?sensor=false&libraries=places') ?>
<?php use_javascript('YozoaInsertMap.js') ?>

<form id="xAreaLocationForm" action="<?php echo url_for('xarea/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post">
  <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
    <table>
      <tfoot>
        <tr>
          <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
     <!--       &nbsp;<a href="<?php //echo url_for('xarea/index') ?>">Back to list</a>-->
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'xarea/delete?id=' . $form->getObject()->getId().'&p_id='.$x_area_location->getParentId() , array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
            <input type="submit" value="Save" onclick="xAreaLocationFormSubmit(); return false;" />
          </td>
        </tr>
      </tfoot>
      <tbody>
      <?php echo $form->renderGlobalErrors() ?>
            <tr>
             <td width="20%">Parent Location</td>
		     <td width="80%">  
			 <?php if($form->getObject()->isNew()){ ?>
		     	<div class="field" id="location_selector">
             <?php
                  if (sizeof($areas))
                  {
                    foreach($areas as $i => $area)
                    {
                      include_partial('childArea', array('x_areas' => $xarea_table->getChildren($area->getParentId()), 'isNew' => $form->getObject()->isNew() ? '1' : '0' , 'selected_id' => $area->getId()));
					  $map_lat = $area->getMapLat();
					  $map_lng = $area->getMapLng();
					  $parent_id = $area->getId();

                    }
                  }
                  else
                  {
                      include_partial('childArea', array('x_areas' => $xarea_table->getChildren(0),'isNew' => $form->getObject()->isNew() ? '1' : '0', 'selected_id' => 0));
                  }
				  
				  echo "</div>";
			     ?>
				<span id="loading_img" style="display:none;">
					<img src="/images/loading.gif" alt="Loading..." title="Loading..."/>
				</span>
            </div>
			<?php } else{ 
			 	  		echo "<b>".str_replace(',',' >> ',$patentLocation)."</b>";
				  }
			?>
			<!--<input type="hidden" name="p_id" value="<?php echo isset($x_area_location)? $x_area_location->getParentId() : $parent_id; ?>" />-->
		   </td>
        </tr>
        <tr>
          <td><?php echo $form['name']->renderLabel() ?></td>
          <td>
          <?php echo $form['name']->renderError() ?>
		  <input id="searchTextField" name="x_area_location[name]" value="<?php echo isset($x_area_location)? $x_area_location->getName() : ''; ?>" type="text" size="39">
          <?php //echo $form['name'] ?>
          </td>
        </tr>
		<tr>
          <td><?php echo $form['map_lat']->renderLabel() ?></td>
          <td>
          <?php echo $form['map_lat']->renderError() ?>
          <?php //echo $form['map_lat'] ?>
		  <input id="mapLat" name="x_area_location[map_lat]" value="<?php echo isset($x_area_location)? $x_area_location->getMapLat() : $map_lat; ?>" type="text" size="25">
          </td>
        </tr>
		<tr>
		  <td><?php echo $form['map_lng']->renderLabel() ?></td>
          <td>
          <?php echo $form['map_lng']->renderError() ?>
          <?php //echo $form['map_lng'] ?>
		  <input id="mapLng" name="x_area_location[map_lng]" value="<?php echo isset($x_area_location)? $x_area_location->getMapLng() : $map_lng; ?>" type="text" size="25">
          </td>
		</tr>
        <tr>
          <td colspan="2">Gmap Location: </td>
        </tr>
        <tr>
          <td colspan="2">
            <div id="gMapContainer" style="width:760px; height:340px;"></div>
          </td>
        </tr>
      </tbody>
    </table>
	<input type="hidden" id="parent_id" name="p_id" value="<?php echo isset($x_area_location)? $x_area_location->getParentId() : $parent_id ; ?>"/>
  </form>
<input type="hidden" id="parent_id" name="p_id" value="<?php echo isset($x_area_location)? $x_area_location->getParentId() : $parent_id ; ?>"/>
<input type="hidden" id="map_latitude" name="product_realestate_map_lat" />
<input type="hidden" id="map_longitude" name="product_realestate_map_lng" />
<script type="text/javascript">
    $(document).ready(function(){
        Yozoa.InsertMap.initialize({
            "lat": $("#mapLat").val(),
            "lng": $("#mapLng").val(),
            "zoom": 12,
            "mapContainer": "gMapContainer",
            "marker_icon": "http://www.dura-bar.com/images/customcf/distributors_red_pushpin_marker.png",
            "latid": "<?php echo 'mapLat'; ?>",
            "lngid": "<?php echo 'mapLng'; ?>"
        });
		getLocationBound($("#mapLat").val(),$("#mapLng").val());
		//getLocationBound(0, 0);
    });
	
	function IsNumeric(input){
		var RE = /^-{0,1}\d*\.{0,1}\d+$/;
		return (RE.test(input));
	}
	function xAreaLocationFormSubmit(){
      if($(".product_x_area option:selected").text().search(new RegExp("---Select Location---", "i")) > -1){
	  	 alert('Please select parent location.');
        return;
	  }
	  
	  if (/^\s*$/.test($('#searchTextField').val())){
        alert('Please enter location name.');
        return;
      }
	  
      if (/^\s*$/.test($('#mapLat').val()) || /^\s*$/.test($('#mapLng').val())) {
        alert('Latitude and Longitude must be added...');
        return;
      }
	  if(!(IsNumeric($('#mapLat').val())) || !(IsNumeric($('#mapLng').val()))) {
        alert('Latitude and Longitude must be numeric...');
        return;
      }
	  var action = '<?php echo $form->getObject()->isNew() ? '1' : '2'; ?>';
	  if(action == 1){
		  $.ajax({
				type: 'POST',
				url : "<?php echo url_for("xarea/new")?>",
				data : 'lname='+$('#searchTextField').val()+'&parentId='+$('#parent_id').val()+'&action='+action,
				success :function(data){
				  if(data == 1){
					alert('Location name already exist.');
					return;
				  }else{
					$("#xAreaLocationForm").submit();
				  }
				}
		  });
	  }else{
	  		$("#xAreaLocationForm").submit();
	  }
	  //alert("test");
      //$("#xAreaLocationForm").submit();
    }
	
	function getLocationBound(lat,lng){
		var defaultBounds = new google.maps.LatLngBounds(
		  new google.maps.LatLng(lat, lng),
		  new google.maps.LatLng(lat, lng)
		);
		
		var option = {
		  bounds: defaultBounds,
		  types: ['establishment']
		};

		var autocomplete = new google.maps.places.Autocomplete($("#searchTextField")[0], option);
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			console.log(place.address_components);
			jQuery('#location_selector').val($("#searchTextField").val());
			Yozoa.InsertMap.parse('#location_selector');
		});
	}

	function getChildElement(element){
		  
		  jQuery(element).nextAll(':select').remove();
		  var id = jQuery(element).val();
		  $('#parent_id').val(id);
		  var parent= jQuery(element).parent('div')
		  jQuery('#product_x_area_id').val(id);
		
		jQuery.ajax({
		  url : "<?php echo url_for("xarea/childArea")?>",
		  data : { id : id },
		  cache : false,
		  beforeSend: function(){
				$("#loading_img").css('display','block');
				jQuery(element).nextAll().remove();
				$("#searchTextField").val('');
				//$("#autocomplete_textbox").css('display','none');
				switch(jQuery(element).val()){
				  case "-1":
					jQuery('#x_area_parent_id').val(jQuery(element).prev().val());
					return false;
					break;
				  case "0" :
					jQuery('#x_area_parent_id').val(jQuery(element).val());
					return false
					break;
				  default:
					Yozoa.InsertMap.parse();
					jQuery('#x_area_parent_id').val(jQuery(element).val());
				}
			  },
		  success : function(data){ //alert(data);
			  $("#loading_img").css('display','none');
			  var jQueryresponse=jQuery(data);
			  jQuery('#product_x_area_id').val(jQueryresponse.filter(':select:first').val());
			  jQuery('.product_x_area:last').after(data);
			  getLocationBound($("#mapLat").val(),$("#mapLng").val());
		  }
		});
	  }
</script>

