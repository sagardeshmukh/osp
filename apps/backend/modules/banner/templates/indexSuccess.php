<h1>Banners</h1>

<div style="background:#ddd; padding:5px;">Expired</div>
<div style="background:#F6F6F6; padding:5px;">Active</div>
<div style="background:#ffffcc; padding:5px;">Pending </div>

<br clear="all">
<center>
<table width="100%">
	<thead>
		<tr>
		  <th>Banner</th>
		  <th>Category</th>
		  <th>Deminsion</th>
		  <th>Link</th>
		  <th>Begin</th>
		  <th>End</th>
		  <th>#</th>
		</tr>
	</thead>
	<tbody>
	  <?php foreach ($banners as $banner): ?>
  	<tr style="background:<?php echo $banner->getColor()?>">
      <td valign="top">
        <b><?php echo $banner->getName()?></b>
        <br clear="all" />
        <?php $ext = myTools::getFileExtension($banner->getFile()); ?>
        <?php if ($ext == "swf"):?>
          <object width="150" height="100">
            <param name="movie" value="/uploads/banner/<?php echo $banner->getFile()?>">
            <param name="quality" value="high">
            <param name="wmode" value="transparent">
            <embed width="150" height="100" wmode="transparent" src="/uploads/surtalchilgaa/<?php echo $banner->getFile()?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
          </object>
        <?php else:?>
          <?php echo image_tag("/uploads/banner/".$banner->getFile(), array("width"=>150));?>
        <?php endif ?>
        <br clear="all">
        <br clear="all">
      </td>
      <td><?php echo $banner->getType() ?></td>
      <td nowrap><?php echo $banner->getWidth()." x ".$banner->getHeight() ?></td>
      <td><?php if($banner->getLink()) echo link_to($banner->getLink(), $banner->getLink(), array("target"=>"_blank")) ?></td>
      <td><?php echo date("Y-m-d", strtotime($banner->getBeginDate()))?></td>
      <td><?php echo date("Y-m-d", strtotime($banner->getEndDate()))?></td>
		  <td nowrap>
		    <?php echo link_to(image_tag("icons/edit.png", array("align"=>"absmiddle", "alt"=>__("Edit"), "title"=>__("Edit"))), 'banner/edit?id='.$banner->getId(), array("alt"=>__('Edit')))?>
		    <?php echo link_to(image_tag("icons/cross.png", array("align"=>"absmiddle", "border"=>0, "alt"=>__("Delete"), "title"=>__("Delete"))), 'banner/delete?id='.$banner->getId(), array('class' => __('delete'), 'confirm'=>__('Are you sure?'), 'post'=>true))?>
      </td>
    </tr>
    <?php endforeach; ?>
	</tbody>
</table>
</center>
<a href="<?php echo url_for('banner/new') ?>"><?php echo __('New') ?></a>