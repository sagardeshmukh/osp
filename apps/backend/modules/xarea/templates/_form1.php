<?php //use_javascripts_for_form($form) ?>
<?php use_javascript('http://maps.google.com/maps/api/js?sensor=false&libraries=places') ?>
<?php use_javascript('YozoaInsertMap.js') ?>

<form id="xAreaForm" action="<?php echo url_for('xarea/updateXarea') ?>" method="post">
    <table>
      <tfoot>
        <tr>
          <td colspan="2">
            <!--&nbsp;<a href="<?php //echo url_for('xarea/index') ?>">Back to list</a>-->
            <input type="submit" value="Save" onclick="xAreaLocationFormSubmit(); return false;" />
          </td>
        </tr>
      </tfoot>
	  <input type="hidden" name="id" value="<?php echo $x_area->getId() ?>" >
	  <input type="hidden" name="lvl" value="<?php echo $lvl ?>" >
      <tbody>
            <tr>
             <td>Parent Location</td>
		     <td> 
			 	<?php 
					if(count(explode( ',',$patentLocation)) > 1){
						echo "<b>  World >> ".str_replace(',',' >> ',$patentLocation)."</b>"; 
					}else{
						echo "<b> World </b>";
					}
				?>
		     </td>
        </tr>
        <tr>
		  <td>Name</td>
          <td>
		  <input id="locationName" name="name" value="<?php echo $locationName; ?>" type="text" size="39">
          </td>
        </tr>
		<?php if($x_area->getMapLat() && $x_area->getMapLng()){ ?>
				<tr>
				  <td colspan="2">Gmap Location: </td>
				</tr>
				<tr>
				  <td colspan="2">
					<div id="gMapContainer" style="width:760px; height:340px;"></div>
				  </td>
				</tr>
		<?php } ?>
      </tbody>
    </table>
  </form>
<script type="text/javascript">
	
     $(document).ready(function(){
        Yozoa.InsertMap.initialize({
            "lat": '<?php echo $x_area->getMapLat() ?>',
            "lng": '<?php echo $x_area->getMapLng() ?>',
            "zoom": 12,
            "mapContainer": "gMapContainer",
            "marker_icon": "http://www.dura-bar.com/images/customcf/distributors_red_pushpin_marker.png",
            "latid": "<?php echo 'mapLat'; ?>",
            "lngid": "<?php echo 'mapLng'; ?>"
        });
     });
	 function xAreaLocationFormSubmit(){
	  
	  if (/^\s*$/.test($('#locationName').val())){
        alert('Please enter location name.');
        return;
      }
	  $("#xAreaForm").submit();
    }
</script>