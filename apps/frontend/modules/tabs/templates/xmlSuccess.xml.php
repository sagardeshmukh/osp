<?php echo('<?xml version="1.0" encoding="utf-8"?>'); ?>
<gallery>
    <album title="<?php echo $product->getName() ?>" description="" updated="<?php echo date('Y-m-d') ?>" lgpath="<?php echo $productImages[0]->getFolder() ?>" fspath="<?php echo $productImages[0]->getFolder() ?>" tnpath="<?php echo $productImages[0]->getFolder() ?>">
  	<?php foreach ($productImages as $productImage): ?>
            <?php if (is_file(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename())): ?>
              <img src="<?php echo $productImage->getFilename() ?>" title="<?php echo $product->getName() ?>" caption="<?php echo $product->getName() ?>" link=""/>
            <?php endif; ?>
  	<?php endforeach; ?>
    </album>
 </gallery>