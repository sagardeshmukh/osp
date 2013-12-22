<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_javascript('http://maps.google.com/maps/api/js?sensor=false') ?>

<form id="xAreaForm" action="<?php echo url_for('xarea/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post">
  <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
    <table>
      <tfoot>
        <tr>
          <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('xarea/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'xarea/delete?id=' . $form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
            <input type="submit" value="Save" onclick="xAreaFormSubmit(); return false;" />
          </td>
        </tr>
      </tfoot>
      <tbody>
      <?php echo $form->renderGlobalErrors() ?>
            <tr>
              <td>Parent Location</td>
              <td id="location_selector">
          <?php
            $choices = Doctrine::getTable('XArea')->getChildrenOption(0);
            $choices = array_merge(array("0" => "---New Country---"), $choices);
            $selectField = new sfWidgetFormChoice(array('choices' => $choices), array('onchange' => "xarea.change(this)"));
          ?>
          <?php echo $selectField->render('fst_slct') ?>
          </td>
        </tr>
        <tr>
          <td><?php echo $form['name']->renderLabel() ?></td>
          <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
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
  </form>

  <script type="text/javascript">
    var map;
    var geocoder;
    var marker = null;
    function xAreaFormSubmit(){
      if (/^\s*$/.test($('#x_area_name').val())){
        alert('Please insert location name');
        return;
      }
      if (/^\s*$/.test($('#x_area_map_lat').val())) {
        alert('Please add marker');
        return;
      }
      $("#xAreaForm").submit();
    }
    var xarea = {
      change : function(element){
        $.ajax({
          url : '<?php echo url_for('xarea/child') ?>',
          data : { id : $(element).val() },
          dataType: 'json',
          beforeSend: function(){
            $(element).nextAll().remove();
            switch($(element).val()){
              case "-1":
                $('#x_area_parent_id').val($(element).prev().val());
                return false;
                break;
              case "0" :
                $('#x_area_parent_id').val($(element).val());
                return false
                break;
              default:
                var addressArray = new Array();;
                $('#location_selector select').each(function(){
                  addressArray.push($(this).find("option[value='" + $(this).val() + "']").text());
                });

                geocoder.geocode({ 'address': addressArray.join(", ") }, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                  }
                });
                $('#x_area_parent_id').val($(element).val());
            }
          },
          success: function(data){
            var content= '<select onchange="xarea.change(this);">'
            for(var i = 0, len = data.length; i < len; i++){
              content += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            }
            content += '</select>';
            $('#location_selector').append(content);
          }
        });
      }
    }

    function updateLocation(id, values){
      geocoder.geocode({ 'address': values.join(", ") }, function(results, status) {
        console.log(values);
        if (status == google.maps.GeocoderStatus.OK) {
          $.ajax({
            url : '<?php echo url_for('xarea/ajaxUpdate') ?>',
            data : {id : id,
              lat : results[0].geometry.location.lat(),
              lng: results[0].geometry.location.lng()}
          });
        }
      });
    }
    function getAllData(){
      $.ajax({
        url: '<?php echo url_for('xarea/getAllData') ?>',
        dataType: 'json',
        success: function(data){
          var counter = 0;
          $.each(data, function(id, values){
            counter = counter + 1000;
            window.setTimeout(function(){
              updateLocation(id, values);
            }, counter);
          });
        }
      });
    }
    $(document).ready(function(){
      function setMarkerLocation(location){
        $('#x_area_map_lat').val(location.lat());
        $('#x_area_map_lng').val(location.lng());
      }
<?php if ($form->getObject()->isNew()): ?>
        var myLatLng = new google.maps.LatLng(59.8598994605527, 10.7101569375);
<?php else : ?>
          var myLatLng = new google.maps.LatLng(<?php echo $form->getObject()->getMapLat() ?>, <?php echo $form->getObject()->getMapLng() ?>);
<?php endif ?>
          var myOptions = {
            zoom: 6,
            center: myLatLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          };
          geocoder = new google.maps.Geocoder();
          map = new google.maps.Map(document.getElementById("gMapContainer"), myOptions);
          google.maps.event.addListener(map, 'rightclick', function(event) {
            if (marker == null){
              marker = new google.maps.Marker({
                position: event.latLng,
                draggable: true,
                map: map
              });
              google.maps.event.addListener(marker, 'dragend', function(event) {
                setMarkerLocation(event.latLng);
              });
            } else {
              marker.setPosition(event.latLng);
            }
            setMarkerLocation(event.latLng);
          });
<?php if (!$form->getObject()->isNew()): ?>
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(<?php echo $form->getObject()->getMapLat() ?>, <?php echo $form->getObject()->getMapLng() ?>),
              draggable: true,
              map: map
            });
            google.maps.event.addListener(marker, 'dragend', function(event) {
              setMarkerLocation(event.latLng);
            });
<?php endif ?>
  });
</script>

