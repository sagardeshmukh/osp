<?php if(!isset($selected_id)) $selected_id = 0;?>
<div class="progressive">
  <dl class="progressive-select">
    <?php foreach($categories as $category):?>
    <?php if ($category->getId() == 0) continue;?>
    <dd>
      <a href="#" onclick="return getChildElement(this, <?php echo $category->getId()?>, <?php echo $category->isLeaf() ? "true" :"false"?>)" class="<?php echo $category->getId() == $selected_id ? "link-click" : ""?>"><?php echo $category->getName() . ($category->isLeaf() ? "" :" &raquo;")?></a>
    </dd>
    <?php endforeach;?>
  </dl>
</div>