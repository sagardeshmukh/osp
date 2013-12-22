
<div style="margin-bottom: 10px;">

<form method="post" action="<?php echo url_for('product/search')?>">
<input type="hidden" id="xarea_id" name="xarea_id" value=""/>
<input type="hidden" name="xType" value="realestates"/>
 <div class="head">
    <h1 style="width: 500px; float: left;">Real Estate advanced search</h1>

    <ul class="SearchView">
                <li class="map">
                    <a href="<?php echo url_for('product/realestateMapAdvancedSearch') ?>"><span class="search_icon map"></span>Map view</a>                </li>

                <li class="list selected">
                    <span class="search_icon list"></span>
                    List view                    <i class="view_corner tl"></i>
                    <i class="view_corner tr"></i>
                    <i class="view_corner bl"></i>
                    <i class="view_corner br"></i>
                </li>
            </ul>
 </div>
    <div class="clear"></div>
<div class="title"><?php echo __('Country') ?></div>
    <table class="joblist">
        <tbody>
            <tr>
                <td><div style="margin-left: 10px;">
                            <?php include_partial('manageProduct/childArea', array('x_areas' => $xareas, 'selected_id' => 0)); ?>
                    </div>
        </td>
            </tr>
        </tbody>
    </table>

    <div class="title"><?php echo __('Category') ?></div>
<div style="display: block; position: relative">
    <table class="joblist">
        <tbody>
            <tr>
                <td valign="top">
                <ul style="float: left;">
                    <?php $i=0; foreach($categories as $category): ?>
                    <?php if($i>=4):?>
                    </ul><ul style="float: left; padding-left: 50px;">
                    <?php $i= 0 ;  ?>
                    <?php endif; ?>
                        
                    <li><input type="checkbox" name="categoryIds[]" value="<?php echo $category->getId() ?>"/><?php echo $category->getName(); $i++; ?></li>
                    <?php endforeach; ?>
                </ul>
        </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="title"><?php echo __('Attributes') ?></div>
<div style="display: block; position: relative">
    <table class="joblist">
        <tbody>
            <tr>
                <td valign="top">
                <ul style="float: left;">
                    <?php $i=0; foreach($attributes as $attribute): ?>
                    <?php if($i>=4):?>
                    </ul><ul style="float: left; padding-left: 50px;">
                    <?php $i= 0 ;  ?>
                    <?php endif; ?>

                    <li><input type="checkbox" name="av" value="<?php echo $attribute->getId() ?>"/><?php echo $attribute->getName(); $i++; ?></li>
                    <?php endforeach; ?>
                </ul>
        </td>
            </tr>
        </tbody>
    </table>
</div>

    <div class="title"><?php echo __('Price and size') ?></div>
    <table class="joblist">
        <tbody>
            <tr>
                <td><div style="margin-left: 10px;"><?php echo __('Price') ?>.
                    <?php echo __('min') ?><input type="text" name="min" value=""/>
                    <?php echo __('max') ?><input type="text" name="max" value=""/>
                    </div>
        </td>
            </tr>
            <tr>
                <td><div style="margin-left: 10px;"> &nbsp;Size.
                   <?php echo __('min') ?>. m²<input type="text" name="minS" value=""/>
                    <?php echo __('max') ?>. m²<input type="text" name="maxS" value=""/>
                    </div>
        </td>
            </tr>
        </tbody>
    </table>

    <div class="title">Keyword</div>
    <table class="joblist">
        <tbody>
            <tr>
                <td>
                <input class="search_input" type="text" name="keyword"/>
                <input class="search_button" type="submit" name="submit" value="Search" />
        </td>
            </tr>
        </tbody>
    </table>
</form>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    function getChildElement(element){
      $(element).nextAll(':select').remove();
      var id = $(element).val();
      var parent= $(element).parent('div')
      $('#xarea_id').val(id);

    $.ajax({
      url : "<?php echo url_for("manageProduct/childArea")?>",
      data : { id : id },
      cache : false,
      success : function(data){
          var $response=$(data);
          $('#xarea_id').val($response.filter(':select:first').val());
          $('.product_x_area:last').after(data);
      }
    });
  }
</script>