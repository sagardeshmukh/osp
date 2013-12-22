<?php foreach($categories as $category): ?>
    <li><?php echo str_repeat('&nbsp;', $category->getLevel() * 7) ?>
        <?php if(!$category->isLeaf()): ?>
            <span onclick="Yozoa.Collapse.toggle(this)" class="icon icon10">&nbsp;</span>
        <?php endif ?>
        <?php echo $category->getName() ?>
        <input type="hidden" value="<?php echo $category->getId() ?>" name="cat_ids[]" />
        <span style="position:absolute;right:260px;"><?php echo ($category->getIsVisible() ? image_tag('icons/checked.png') : "") ?></span>
        <span style="position:absolute;right:180px;"><?php echo ($category->getIsFeatured() ? image_tag('icons/checked.png') : "") ?></span>
		 <span style="position:absolute;right:112px;"><?php echo link_to($category->getIsMap()?"Yes" : "No", 'category/editIsMap?id='.$category->getId()."&is_map=".$category->getIsMap(), array('class' => 'editIsMap', 'confirm' => 'Are you sure to change the status?')) ?></span>
        <span style="position:absolute;right:4px;"><?php echo 
            link_to("edit", 'category/edit?id='.$category->getId(), 'class=edit').'&nbsp;'.'&nbsp;'.
            link_to("delete", 'category/delete?id='.$category->getId(), 'class=delete confirm="Are you sure?"') ?></span>
            <?php if(!$category->isLeaf()): ?>
                <ul></ul>
            <?php endif; ?>
    </li>
<?php endforeach ?>