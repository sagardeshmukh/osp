<div id="CategoryItems">
    <?php include_partial('list', array('price_formats' => $price_formats)) ?>
</div>
<img id="search-ajax-anim" style="display:none;" src="/images/ajaxload_1-6cc4ff.gif" alt="loading" />
<div class="clear"></div>
<br />
<fieldset>
<legend>New Price format</legend>
<div id="priceForm">
    <?php include_partial('form', array('form' => $form)) ?>
</div>
</fieldset>
<script type="text/javascript">
if (typeof window.Price == "undefined") {
    var Price = {};
}

Price.App = {
    params: null,
    initial_data: [],
    url1: null,
    url2: null,
    load_indicator: $('#search-ajax-anim'),
    initialize: function (E) {
        var url1 = E.url1;
        var url2 = E.url2;
        if(url1 || url2){
            this.url1 = url1;
            this.url2 = url2;
        }
        var AA = this;
        $('#price_format_category_id').change(function(){
            AA.change(this);
        });

        $('#PriceFormatForm').submit(function(){
            AA.add();
            return false;
        });
    },
    
    change: function(div){
        var App = this;
           jQuery.ajax({
            type: "POST",
            url: this.url1,
            data: { catId : $(div).val() },
            dataType : 'json',
            cache : false,
            beforeSend: function(){
              App.load_indicator.show();
            },
            success : function(data){
                App.load_indicator.hide();
               $("#" + data.update).html(data.content);
            }
          });
        /* onchange*/
    },

    add: function(){
     var App= this;
        $.ajax({
          type : "POST",
          url: this.url2,
          data: $("#PriceFormatForm").serialize(),
          dataType: "json",
          beforeSend: function(){
            App.load_indicator.show();
          },
          success: function(data){
            App.load_indicator.hide();
            $("#" + data.update).html(data.content);
            var E = {
              'url1': this.url1,
              'url2': this.url2
            };
            Price.App.initialize(E);
          }
        });
        return false;
    }
    
};
    
    
    jQuery(document).ready(function(){
        /* start onchange*/
        Price.App.initialize({
          "url1": "<?php echo url_for('priceFormat/onChangeCategory') ?>",
          "url2": "<?php echo url_for("priceFormat/create") ?>"
        });

    });
</script>