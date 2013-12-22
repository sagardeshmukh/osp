<?php
  $cats = Doctrine::getTable("Category")->getParentCategories($categoryId);
  
  $cat_ids = array();
  foreach ($cats as $cat) {
    $cat_ids[] = $cat->getId();
  }
  
  $banner = Doctrine::getTable("Banner")->getBanner($cat_ids); 
?>

<?php if (sizeof($banner) > 1 && file_exists(sfConfig::get("sf_upload_dir")."/surtalchilgaa/".$banner->getFile()))
{
  if(myTools::getFileExtension($banner->getFile()) == 'swf'){?>
    <object width="<?php echo $banner->getWidth()?>" height="<?php echo $banner->getHeight()?>">
      <param name="movie" value="/uploads/surtalchilgaa/<?php echo $banner->getFile()?>">
      <param name="quality" value="high">
      <param name="wmode" value="transparent">
      <embed width="<?php echo $banner->getWidth()?>" height="<?php echo $banner->getHeight()?>" wmode="transparent" src="/uploads/surtalchilgaa/<?php echo $banner->getFile()?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
    </object>
    
    <?php } else {
      echo link_to(image_tag('/uploads/surtalchilgaa/'.$banner->getFile()), $banner->getLink(), array('target'=>'blank', 'width'=>$banner->getWidth()));
    }
    ?>
    <br clear="all">
    <br clear="all">
<?php }?>