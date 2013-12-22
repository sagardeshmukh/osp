<h1><?php echo __($title) ?></h1>
<div class="steps-area">
  <div class="step-list">
    <ul>
      <li class="first <?php echo $checked >= 0 ? 'checked ': '' ?><?php echo $current == 1 ? 'current': '' ?>"><span class="number">1</span><strong><?php echo __('Select category') ?></strong><span class="right-c"></span></li>
	  
      <li class="<?php echo $checked >= 2 ? 'checked ': '' ?><?php echo $current == 2 ? 'current': '' ?>"><span class="number">2</span><strong><?php echo isset($xType) ? __('Insert ').strtolower($xType):__('Insert Product') ?></strong><span class="right-c"></span></li>
      <li class="<?php echo $checked >= 3 ? 'checked ': '' ?><?php echo $current == 3 ? 'current': '' ?>"><span class="number">3</span><strong><?php echo __('Review') ?></strong><span class="right-c"></span></li>
      <!--<li><span class="number">4</span><strong><?php echo __('Advertising') ?></strong><span class="right-c"></span></li>-->
      <li class="<?php echo $checked >= 4 ? 'checked ': '' ?><?php echo $current == 4 ? 'current': '' ?>"><span class="number">4</span><strong><?php echo __('Finish') ?></strong><span class="right-c"></span></li>
    </ul>
  </div>
</div>