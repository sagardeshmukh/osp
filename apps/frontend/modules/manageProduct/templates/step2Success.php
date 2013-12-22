<script type="text/javascript" src="/js/jquery.formatCurrency.js"></script>
<?php use_javascript('/js/jquery-ui-1.7.3.custom.min.js') ?>
<?php use_stylesheet('/css/jquery-ui-1.7.3.custom.css') ?>
    <?php if(in_array($xType, array('realestates', 'rental'))): ?>
        <?php use_javascript('http://maps.google.com/maps/api/js?sensor=false&libraries=places') ?>
        <?php use_javascript('YozoaInsertMap.js') ?>
        <?php if($form->isNew()): ?>
          <?php $preff_area = Doctrine::getTable('XArea')->find($sf_user->getPreffXArea());?>
        <?php endif; ?>

    <?php elseif($xType == 'rental'): ?>
        <?php use_javascript('ui/ui.core.min.js')?>
        <?php use_javascript('ui/ui.dialog.min.js')?>
        <?php use_javascript('/js/jquery.form.js')?>
        <?php use_stylesheet('flick/jquery-ui-1.7.2.custom.css')?>
   <?php elseif($xType == 'jobs'): ?>
        <?php use_javascript('/js/job.js')?>
   <?php elseif($xType == 'service'): ?>
        <?php use_javascript('/js/date.js')?>
    <?php endif; ?>
<script type="text/javascript">
		$(function() {
			// jQuery formatCurrency plugin: http://plugins.jquery.com/project/formatCurrency

			// Format while typing & warn on decimals entered, no cents
			$('#product_price_original').blur(function() {
				$('#formatWhileTypingAndWarnOnDecimalsEnteredNotification').html(null);
				$(this).formatCurrency({ colorize: true, positiveFormat: '%n%s',
					symbol: '',
					negativeFormat: '-%n%s',
					decimalSymbol: '.',
					digitGroupSymbol: ',',
					groupDigits: true, roundToDecimalPlace: 0 });
			})
			.keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 27: this.value = ''; break; // Esc
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({ colorize: true,
							positiveFormat: '%n%s',
							symbol: '',
							negativeFormat: '-%n%s',
							decimalSymbol: '.',
							digitGroupSymbol: ',',
							groupDigits: true, roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
					}
				}
			})
			.bind('decimalsEntered', function(e, cents) {
				var errorMsg = 'You must insert number (0.' + cents + ')';
				$('#formatWhileTypingAndWarnOnDecimalsEnteredNotification').html(errorMsg);
			});

 		});
</script>

<?php include_partial('bread_crumb', array(
                        'title' => 'Insert '.$xType,
                        'xType' => $xType,
                        'checked' => 2,
                        'current' => 2,
                            )) ?>

<form method="post" action="<?php echo url_for('manageProduct/step2')?>" id="product_form" onSubmit="return checkform()" enctype="multipart/form-data">
  <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $unique_id ?>" />
  <?php echo $form->renderHiddenFields(false) ?>
  <div class="box boxGray">
    <div class="boxHeader"><div><h3><?php echo __('Main information') ?></h3></div></div>
    <div class="boxContent">
      <div class="boxWrap">
        <div class="add-detail">
          <?php echo $form->renderGlobalErrors(); ?>
          <div class="row">
            <div class="label"><?php echo __('Category') ?> *</div>
            <div class="field">
              <div class="selectedCat">
                <span class="path">
                	<?php 
						//print "<pre>";
						//print_r($form->getObject()->getParentCategories($sf_user->getCulture()));
					
					?>
                  <?php foreach($form->getObject()->getParentCategories($sf_user->getCulture()) as $category):?>
                    <?php if ($category->getId() == 0) continue;?>
                    <?php echo $category->getName();?> <em>&raquo;</em>
                  <?php endforeach;?>
                </span>
                <span class="button"><a title="<?php echo __('Back') ?>" class="graySmall" href="<?php echo url_for("manageProduct/step1")?>?unique_id=<?php echo $unique_id;?>"><span><?php echo __('Back') ?></span></a></span>
                <div class="clear"></div>
              </div><!--selectedCat-->
            </div><!--field-->
          </div><!--row-->
          <?php echo $form['name']->renderRow(); ?>
          <?php echo $form['description']->renderRow(); ?>
		  <?php if(($xType != 'products') && (count($form['mainAttributes'] ) != 0)) {
					    unset($form['price_original']);
		  } ?>
          <?php if(isset($form['price_original']) && ($xType != 'jobs')) { ?>
          <div class="row">
            <div class="label"><?php echo $form['price_original']->renderLabel() ?></div>
            <div class="field">
              <?php echo $form['price_original'] ?>
              <?php echo $form['currency_main'] ?>
              <?php echo $form['price_original']->renderError() ?>
              <?php echo $form['currency_main']->renderError(); ?>
            </div>
          </div>
		  <?php } ?>

          <?php echo $form['duration']->renderRow(); ?>
          <?php if($xType == 'realestates'):// && $xType != 'rental'): ?>
            <?php ///*?><div class="row">
                <div class="label">
                    <label for="product_area_id"><?php echo $form['x_area_id']->renderLabel(); ?></label>
                    <?php echo $form['x_area_id']?>
                </div>
                <div class="field" id="location_selector">
                            <?php
                  if (sizeof($areas))
                  {
                    foreach($areas as $i => $area)
                    {
                      include_partial('childArea', array('x_areas' => $xarea_table->getChildren($area->getParentId()), 'selected_id' => $area->getId()));

                    }
                  }
                  else
                  {
                      include_partial('childArea', array('x_areas' => $xarea_table->getChildren(0), 'selected_id' => 0));
                  }
                  ?>
                    <!--<span class="error_list"><?php echo $form['x_area_id']->renderError(); ?></span>-->
                <!--</div>-->
				<?php if(count($x_area_locations) >0){
					include_partial('childArea', array('x_areas' => $x_area_locations, 'selected_id' => 0,'isXAreaLocations'=>1));
					echo "</div>";
				} else{ 
					echo "</div>";
			    } ?>
				<div id="autocomplete_textbox" style="float:right; display: <?php echo count($x_area_locations) >0 ? 'none':'block' ?>;height:0px;">
					<input id="searchTextField" name="searchTextField" placeholder="Enter your location here." type="text" style="position: relative; width: 240px; height: 13px; left: 255px; top: -25px;" size="39">
				</div>

				<div id="loading_img" style="float:right; display:none;height:0px;">
					<img src="/images/loading.gif" alt="Loading..." title="Loading..." style=" position: relative; width: 17px; height: 17px; left: 25px; top: -20px;"/>
				</div>
				<span class="error_list" style="margin-left: 230px; padding-top:10px;"><?php echo $form['x_area_id']->renderError(); ?><?php echo $form['x_area_location_id']->renderError(); ?></span>
            </div><?php //*/?>
          <?php endif; ?>

          <?php foreach($form['mainAttributes'] as $formField): ?>
            <?php echo $formField ?>
          <?php endforeach; ?>
          <div class="clear"></div>
        </div><!--add-detail-->
      </div>
    </div>
    <div class="boxFooter"><div></div></div>
  </div>

  <?php if (sizeof($form['optianalAttributes'])):?>
  <div class="box boxGray">
    <div class="boxHeader"><div><h3><?php echo __('Additional information') ?></h3></div></div>
    <div class="boxContent">
      <div class="boxWrap">
        <div class="add-detail">
            <?php foreach($form['optianalAttributes'] as $formField): ?>
              <?php echo $formField?>
            <?php endforeach; ?>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <div class="boxFooter"><div></div></div>
  </div>
  <?php endif;?>

  <div class="box boxGray">
    <div class="boxHeader"><div><h3><?php echo __('Map') ?></h3></div></div>
    <div class="boxContent">
      <div class="boxWrap">
        <div class="add-detail">
          <div class="clear"></div>
            <div id="gMapContainerEdit" style="width:960px; height:340px;"></div>
          <div class="clear"></div>
        </div><!--add-detail-->
      </div>
    </div>
    <div class="boxFooter"><div></div></div>
  </div>

  <?php if($xType!='jobs'): ?>
  <div class="box boxGray">
    <div class="boxHeader"><div><h3><?php echo __('Insert image') ?></h3></div></div>
    <div class="boxContent">
      <div class="boxWrap">
        <div class="add-image" id="image_container">
          <?php 
		  $i = 0;
		  foreach($images as $index => $image):?>
            <?php include_partial('uploadImage', array('image' => $image, 'index' => $index, 'i'=> $i))?>
            <?php $i++; ?>
          <?php endforeach;?>
          <div class="clear"></div>
          <input type="button" value=" + " id="add_image" onclick="display_new_image()" class="hand margin-12 add-button" />
          <div class="clear"></div>
        </div><!--add-image-->
      </div>
    </div>
    <div class="boxFooter"><div></div></div>
  </div><!--box-->
<?php endif; ?>
  <div class="box boxGray">
    <div class="boxHeader boxNoTitle"><div></div></div>
    <div class="boxContent">
      <div class="boxWrap">
        <div class="actions">
          <span class="button"><a title="<?php echo __('Back') ?>" class="gray" href="<?php echo url_for("manageProduct/step1")?>?unique_id=<?php echo $unique_id;?>"><span><?php echo __('Back') ?></span></a></span>
          <span class="button"><a title="<?php echo __('Continue') ?>" class="blue continue" href="#" submit="false<?php //echo $xType == 'jobs' ? true: false ?>" id="continue_form"><span><?php echo __('Continue') ?></span></a></span>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <div class="boxFooter"><div></div></div>
  </div><!--box-->
</form>
<div id="cboxOverlay" style="display: block; cursor: pointer; opacity: 0.9;"></div>
<div id="agreement_form_container" class="agreement-dialog"></div>
<div id="dialog" title="<?php echo __('Warning') ?>!!!"></div>
<div id="dialogGoogle" title="You didn't insert picture. Please select picture that similar your product.">
  <input type="text" id="gSearchTitle" value="" size="40" />
  <input type="submit" value="<?php echo __('Search') ?>" onclick="searchImageFromGoogle() ;return false;" />
  <img src="/images/loading.gif" id="googleImageIndicator" style="display: none;"/>
  <form action="#" id="googleImageForm">
    <div id="googleSearchImages"></div>
  </form>
</div>
<?php if(in_array($xType, array('realestates', 'rental'))): ?>
<?php
if ($form->getObject()->isNew()){
    $lat = 0;//$preff_area->getMapLat();
    $lng = 0;//$preff_area->getMapLng();
}elseif($xType == "realestates"){
    $lat = 0;//$form->getObject()->getRealEstate()->getMapLat();
    $lng = 0;//$form->getObject()->getRealEstate()->getMapLng();
}else{
    $lat = 0;//$form->getObject()->getRental()->getMapLat();
    $lng = 0;//$form->getObject()->getRental()->getMapLng();
    
}
/*if($xType == "realestates"){
    $latId = 'product_realestate_map_lat';
    $lngId = 'product_realestate_map_lng';
}else{*/
    $latId = 'product_rental_map_lat';
    $lngId = 'product_rental_map_lng';

//}
?>

<script type="text/javascript">
    $(document).ready(function(){
        Yozoa.InsertMap.initialize({
            "lat": <?php echo $lat ?>,
            "lng": <?php echo $lng ?>,
            "zoom": 12,
            "mapContainer": "gMapContainerEdit",
            "marker_icon": "http://www.dura-bar.com/images/customcf/distributors_red_pushpin_marker.png",
            "latid": "<?php echo $latId ?>",
            "lngid": "<?php echo $lngId ?>"
        });
		getLocationBound($("#product_realestate_map_lat").val(),$("#product_realestate_map_lng").val());
		//getLocationBound(0, 0);
    });
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
</script>
<?php endif; ?>
<script type="text/javascript">
  jQuery(document).ready(function(){
    //editor
    //var niceEditArea = new nicEditor({fullPanel : true}).panelInstance('product_description');
    makeWhizzyWig("product_description", "fontname formatblock bold italic InsertTextArea color hilite superscript bullet link table image textbox selectall html clean");
    var uploadingImage = false;
  <?php if($xType == 'service'): ?>
    $("#optional_phone input:checkbox").click(function () {
            var b = $(this).is(":checked");
            if (!b) {
                $('#phone_number').hide();
            } else {
                $('#phone_number').show();
            }
        });
  <?php endif; ?>

    function submibStep2Form(){
      syncTextarea();
      jQuery("#product_form").submit();
    }
    //onsubmit
    jQuery('#continue_form').click(function(){
        if($(this).attr('submit')){
			/*if(1) {
				$('#price_error').html("<font color= 'red'>Insert price value</font>");
			}*/
			<?php if($xType == 'jobs'){ ?>
			if( jQuery('#product_job_contact').val() == '' && jQuery('#product_job_url').val() == '' ){ 
				jQuery('.applicationtype_error').html('<?php echo __('Please select/insert application method!')?>');
								
				return false;
			}else{
				jQuery('.applicationtype_error').html('');
				jQuery('.continue').attr('submit', true);
			<?php } ?>
				syncTextarea();
				$("#product_form").submit();
				return false;
			<?php if($xType == 'jobs'){ ?>	
			}
			<?php } ?>
        }
      if (uploadingImage == true){
        return false;
      }
      //getting nb uploaded images
      jQuery.ajax({
        url : "<?php echo url_for("manageProduct/getNbImage")?>",
        data : { unique_id: $("#unique_id").val() },
        dataType : 'json',
        cache : false,
        success :function(data){
          if (parseInt(data.nb_image) > 0){
            submibStep2Form();
          } else {
            $("#gSearchTitle").val($("#product_name").val());
            $('#dialogGoogle').dialog('open');
            searchImageFromGoogle();
          }
        }
      });
      return false;
    });

    jQuery('#dialog').dialog({
      autoOpen: false,
      modal: true,
      width: 400,
      buttons: { "Ok": function() { $(this).dialog("close");}}
    });

    jQuery('#dialogGoogle').dialog({
      autoOpen: false,
      modal: true,
      width: 480,
      buttons: {
        "Make selected picture to your product picture": function() {
          var val = $("#googleImageForm input[name='imageId']:radio:checked").val();
          if (typeof(val) == 'undefined'){
            alert("Select picture!!!");
            return false;
          }
          // changing img src
          var element        = $($('#image_container .default-image')[0]);
          var parentDiv      = element.parents('div:first');
          var loadingElement = parentDiv.find('.img-uploading');
          var uploadedImage  = parentDiv.find('.uploaded-image');
          var deleteImage    = parentDiv.find('.img-delete');

          jQuery.ajax({
            url: "<?php echo url_for("manageProduct/uploadGoogleImage")?>",
            data: { imageId : val, unique_id : $("#unique_id").val() },
            dataType : 'json',
            cache : false,
            beforeSend: function(){
              element.css({opacity : 0.6});
              loadingElement.show();
              uploadingImage = true;
              $("#dialogGoogle").dialog("close");
            },
            success : function(data){
              uploadingImage = false;
              loadingElement.hide();
              element.css({opacity : 1});
              if (data.error == true){
                $("#dialog").html('<p>'+data.msg+'</p>');
                $('#dialog').dialog('open');
              } else {
                element.hide();
                deleteImage.show();
                uploadedImage.attr("src", data.folder+"s_"+data.image+"?rand="+Math.random()).show();
              }
            }
          });
        },
        "Move next step" : function(){
          $("#dialogGoogle").dialog("close");
          submibStep2Form();
        }}
    });

    jQuery('#image_container .default-image').each(function(index){
      var element        = $(this);
      var parentDiv      = element.parents('div:first');
      var loadingElement = parentDiv.find('.img-uploading');
      var uploadedImage  = parentDiv.find('.uploaded-image');
      var deleteImage    = parentDiv.find('.img-delete');

      deleteImage.bind('click', function(){
        if (window.confirm('Are you sure?')){
          deleteImage.hide();
          uploadedImage.hide();
		  $('#imageDiv'+index).remove();
		  $('#image_container > div.hide:first').removeClass('hide');
          $.ajax({
            url: "<?php echo url_for("manageProduct/deleteImage")?>",
            cache : false,
            data: { unique_id : $("#unique_id").val(), index : index }
          });
        }
      });
	
      //upload blah blah
      new AjaxUpload(element, {
        action: '<?php echo url_for('manageProduct/uploadImage')?>',
        data : { unique_id : $("#unique_id").val(), index : index },
        responseType: 'json',
        onSubmit : function(file, ext){
            element.css({opacity : 0.6});
            loadingElement.show();
        },
        onComplete: function(file, response){
          uploadingImage = false;
          loadingElement.hide();
          element.css({opacity : 1});
          if (response.error == true){
            $("#dialog").html('<p>'+response.msg+'</p>');
            $('#dialog').dialog('open');
          } else {
            element.hide();
			var index_no = response['index_no'];
			var count    = response['count'];
			count = parseInt(count) + parseInt(index_no);
			
			for(var i = index_no; i < count ; i++)
			{
				$('#imageAdd'+i).hide();
				$('#imageUpload'+i).show();
				$('#imageUpload'+i).attr("src", response['folder'+i]+"s_"+response['image'+i]).show(); 
				$('#imageDelete'+i).show();
				if(i == 10)
				  display_new_image();
				else if(i == 19)
				  display_new_image();
				else if(i == 28)
				  display_new_image();
				else if(i == 37)
				  display_new_image();
				else if(i == 46)
				  display_new_image();
				else if(i == 55)
				  display_new_image();
			}
			
			if(response['file_type_error']){
				$("#dialog").html('<p>'+response['file_type_error']+'</p>');
            	$('#dialog').dialog('open');
			}
          }
        }
      });
    });
  });

</script>

<script type="text/javascript">

	function display_new_image(){
		$('#image_container > div.hide:first').removeClass('hide');	
		$('#image_container > div.hide:first').removeClass('hide');
		$('#image_container > div.hide:first').removeClass('hide');
		$('#image_container > div.hide:first').removeClass('hide');
		$('#image_container > div.hide:first').removeClass('hide');
		$('#image_container > div.hide:first').removeClass('hide');
		$('#image_container > div.hide:first').removeClass('hide');
		$('#image_container > div.hide:first').removeClass('hide');
		$('#image_container > div.hide:first').removeClass('hide');
	}

//job logo upload
jQuery('#job_logo .default-image').each(function(index){
      var element        = jQuery(this);
      var parentDiv      = element.parents('div:first');
      var loadingElement = parentDiv.find('.img-uploading');
      var uploadedImage  = parentDiv.find('.uploaded-image');
      var deleteImage    = parentDiv.find('.img-delete');

      deleteImage.bind('click', function(){
        if (window.confirm('Are you sure?')){
          $('#product_job_logo').val("");
          deleteImage.hide();
          uploadedImage.hide();
          element.show();
          jQuery.ajax({
            url: "<?php echo url_for('manageProduct/deleteJobLogo') ?>",
            cache : false,
            data: { unique_id : jQuery("#unique_id").val() }
          });
        }
      });

      //upload blah blah
      new AjaxUpload(element, {
        action: '<?php echo url_for('manageProduct/uploadJobLogo') ?>',
        data : { unique_id : jQuery("#unique_id").val(), index : index },
        responseType: 'json',
        onSubmit : function(file, ext){
          if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
            element.css({opacity : 0.6});
            loadingElement.show();
            uploadingImage = true;
          } else {
            jQuery("#dialog").html('<p>Insert only (png, jpg, gif) formatted picture  .</p>');
            jQuery('#dialog').dialog('open');
            return false;
          }
        },
        onComplete: function(file, response){
          uploadingImage = false;
          loadingElement.hide();
          element.css({opacity : 1});
          $('#product_job_logo').val(response.image);
          $('#job_logo .error_list').hide();
          if (response.error == true){
            jQuery("#dialog").html('<p>'+response.msg+'</p>');
            jQuery('#dialog').dialog('open');
          } else {
            element.hide();
            deleteImage.show();
            uploadedImage.attr("src", response.folder+"s_"+response.image+"?rand="+Math.random()).show();
          }
        }
      });
    });

  function getChildElement(element){
  	  
      jQuery(element).nextAll(':select').remove();
      var id = jQuery(element).val();
      var parent= jQuery(element).parent('div')
      jQuery('#product_x_area_id').val(id);
	
	  if(id == -1){
		$("#loading_img").css('display','none');
		jQuery('.product_x_area:last').remove();
		getLocationBound($("#product_realestate_map_lat").val(),$("#product_realestate_map_lng").val());
		$("#searchTextField").val('');
		$("#autocomplete_textbox").css('display','block');
		return false;
	  }	
	
    jQuery.ajax({
      url : "<?php echo url_for("manageProduct/childArea")?>",
      data : { id : id },
      cache : false,
      beforeSend: function(){
	  		$("#loading_img").css('display','block');
            jQuery(element).nextAll().remove();
			$("#autocomplete_textbox").css('display','none');
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
                  <?php if(in_array($xType, array("realestates", "rental"))): ?>
                Yozoa.InsertMap.parse();
                jQuery('#x_area_parent_id').val(jQuery(element).val());
                <?php endif; ?>
            }
          },
      success : function(data){ //alert(data);
	  	  $("#loading_img").css('display','none');
          var jQueryresponse=jQuery(data);
          jQuery('#product_x_area_id').val(jQueryresponse.filter(':select:first').val());
          jQuery('.product_x_area:last').after(data);
		  if(data == '' && id < 2773030){
			getLocationBound($("#product_realestate_map_lat").val(),$("#product_realestate_map_lng").val());
			$("#searchTextField").val('');
		  	$("#autocomplete_textbox").css('display','block');
		  }
      }
    });
  }

  //google image search
  function onClickGImageSelect(element) {
    jQuery("#googleSearchImages div").removeClass('selected');
    jQuery(element).nextAll('input:radio').attr('checked','checked');
    jQuery(element).parents("div:first").addClass('selected');
  }
  function searchImageFromGoogle(){
    jQuery.ajax({
      url : "<?php echo url_for("manageProduct/searchGoogleImage")?>",
      data : { unique_id : jQuery("#unique_id").val(), q : jQuery("#gSearchTitle").val() },
      cache : false,
      dataType: 'json',
      beforeSend: function(){
        jQuery("#googleImageIndicator").show();
      },
      success : function(data){
        jQuery("#googleImageIndicator").hide();
        if (data.responseData.results && data.responseData.results.length > 0) {
          var results = data.responseData.results;
          var content = document.getElementById('googleSearchImages');
          content.innerHTML = '';

          for (var i=0; i < results.length; i++) {
            var tmUrl   = results[i].tbUrl;
            var imageId = results[i].imageId;
            var title   = results[i].titleNoFormatting;
            content.innerHTML += '\
            <div> \
              <label for="gImg'+i+'" onclick="onClickGImageSelect(this);"><img src="'+tmUrl+'" style="width:96px;" /></label> \
              <br /> \
              <input id="gImg'+i+'" style="display:none;" type="radio" name="imageId" value="'+imageId+'" /> \
            <div>';
          } //end for
        } // end if
      }
    });
  }

</script>

<?php if($xType == 'rental'): ?>
<script type="text/javascript">
function addAgreement(){
    jQuery('.agreement-dialog').dialog('close');
  jQuery('#agreement_form_container').load('addAgreement').dialog({
    title:  'Add a new Agreement Contract',
    autoOpen: false,
    modal: true,
    resizable: false,
    width: 450,
    autoResize : true
  });
  jQuery('.agreement-dialog').dialog('open');
  return false;
}
</script>

<?php endif; ?>

<?php if($xType == 'jobs'): ?>
<script type="text/javascript">
	jQuery('.continue').click(function(){

	});
</script>

<?php endif; ?>