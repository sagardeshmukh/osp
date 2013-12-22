<h1><?php echo __('My information') ?></h1>
<div class="box boxSidebar">
    <div class="boxHeader"><div><h3>Edit Form</h3></div></div>
<?php include_partial('form', array(
                            'form' => $form,
                            'submit' => 'Submit',
                            'areas' => $areas,
                            'xarea_table' => $xarea_table)) ?>

    </div>