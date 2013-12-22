<?php use_javascript('/js/YozoaCollapse.js') ?>
<h1>Categorys List</h1>

<div style="position: relative">
  <ul>
    <li style="background:none repeat scroll 0 0 #F0F0F0;color:#5494AF;font-size:12px;font-weight:bold;">
      Name
      <span style="position: absolute; right: 240px;">Is Visible</span>
      <span style="position: absolute; right: 160px;">Is Featured</span>
	  <span style="position: absolute; right: 100px;">Is Map</span>
      <span style="position: absolute; right: 40px;">#</span>
    </li>
    <?php
    include_partial('category', array('categories'=> $categories))
    ?>
  </ul>
</div>
<script type="text/javascript">
  function expandCollapseThis(element) {
    var element = $(element);
    if (element.hasClass('icon11')) {
      element.removeClass('icon11').addClass('icon10').siblings('ul').toggle();
    } else {
      element.removeClass('icon10').addClass('icon11').siblings('ul').toggle();
    }
  }
  $(function() {
    $("ul").sortable({
      stop: function(event, ui) {
        var ids = ui.item.parent().children('li').children('input').map(function(){
          return $(this).val();
        }).get().join(",");
        $.ajax({
          url: "<?php echo url_for("category/sort")?>",
          type : "post",
          data: {ids : ids}
        });
      }
    });
  });

$(document).ready(function(){
    Yozoa.Collapse.initialize({
      'url': "<?php echo url_for("category/ajax")?>"
    });
});
</script>
