<?php if( $i > 8 ) $special_style = 'hide'; else $special_style = '';?>
<div id="imageDiv<?php echo $i; ?>" class="image-upload <?php echo $special_style; ?>">
  <?php if ($image->getFilename() && is_file(sfConfig::get('sf_web_dir').$image->getFolder().$image->getFilename())):?>
  <img id="imageAdd<?php echo $i; ?>" class="default-image" style="display: none;" src="/images/add-image.gif" alt="blank" />
  <img id="imageUpload<?php echo $i; ?>" class="uploaded-image" src="<?php echo $image->getFolder()."s_".$image->getFilename()."?rand=".rand()?>" alt="blank" />
  <div id="imageDelete<?php echo $i; ?>" class="img-delete"><img src="/images/icons/remove.png" alt="Delete"></div>
  <?php else:?>
  <img id="imageAdd<?php echo $i; ?>" class="default-image" src="/images/add-image.gif" alt="blank" />
  <img id="imageUpload<?php echo $i; ?>" class="uploaded-image" src="/images/add-image.gif" alt="blank" style="display: none;" />
  <div id="imageDelete<?php echo $i; ?>" class="img-delete" style="display: none;"><img src="/images/icons/remove.png" alt="Delete"></div>
    <?php endif?>
  <div class="img-uploading"><img src="/images/uploading.gif" alt="Loading"/></div>
</div>