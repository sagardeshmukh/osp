

<?php use_javascript('ui/ui.core.min.js')?>

<?php use_javascript('ui/ui.dialog.min.js')?>

<?php use_javascript('ui/ui.draggable.min.js');?>

<?php use_stylesheet('flick/jquery-ui-1.7.2.custom.css')?>

<?php

$store = null;

$comment_error=0;

$productss=null;?>


<?php include_partial('product/show', array(

        'product' => $product,

        'sf_cache_key' => $product->getCacheKey() . $sf_user->getCulture(),

        ))?>





<?php

    if($xType != 'jobs'){
		
        include_component('product', 'similarProducts', array('productId' => $product->getId(),'categoryId'=>$product->getCategoryId()));

    }

?>





<div id="product_warning_container" class="product-warning-dialog"></div>

<div id="sendFriend_form_container" class="sendFriend-dialog"></div>

<div id="askQuestion_form_container" class="askQuestion-dialog"></div>

<div id="comment_form_container" class="guestbook-dialog"></div>

<div id="login_form_container" class="login-dialog"></div>

<div class="div_counter">

<?php product_counter($productStat)?>

    <br />times opened.

</div>

<script type="text/javascript">

    function deleteComment(id,user_id) {

        jQuery.ajax({

            url: "/product/deleteComment?id="+id+"&user_id="+user_id,

            success: function(html){

                jQuery("#comment").html(html);

            }

        });

    }



    function newProductCommentSubmit(product_id)

    {

        jQuery.ajax({

            url: '/product/createComment?id='+ product_id,

            type: 'POST',

            data: jQuery("#product_comment").serialize(),

            success: function(html){

                jQuery("#comment").html(html);

            }

        });



    }

    function replyComment(comment_id,product_id)

    {

        jQuery('.guestbook-dialog').dialog('close');

        jQuery('#comment_form_container').load('/product/reply?commentId='+comment_id+'&product_id='+product_id).dialog({

            title:  'Reply a question',

            autoOpen: false,

            resizable: false,

            width: 440,

            height: 50,

            autoResize : true

        });

        jQuery('.guestbook-dialog').dialog('open');



        return false;

    }

    function submitComment(comment_id)

    {

        jQuery.ajax({

            url: '/product/replyComment',

            type: 'POST',

            data: jQuery("#replay_comment").serialize(),

            dataType: 'json',

            success: function(data){

                jQuery("#comment_form_container").html(data.msg);

                setTimeout(function(){jQuery('.guestbook-dialog').dialog('close')}, 2500);



            }

        });

        successNote(comment_id);

    }



    function successNote(comment_id)

    {

        jQuery.ajax({

            url: '/product/note?commentId='+comment_id,

            success: function(html){

                jQuery("#comment_note_container_"+comment_id).html(html);

            }

        });

    }



    function noteLeft(note,n)

    {

        $('#comment_note_'+n+'_'+note).hide();

        $('#comment_note_'+n+'_'+(note-1)).show();

    }



    function noteRight(note,n)

    {

        $('#comment_note_'+n+'_'+(note)).show();

        $('#comment_note_'+n+'_'+(note-1)).hide();



    }

    function loginDialog(productId)

    {

        jQuery('.login-dialog').dialog('close');

        jQuery('#login_form_container').load('/user/loginForm?product_id='+productId).dialog({

            title:  'Login Form',

            autoOpen: false,

            resizable: false,

            width: 490,

            autoResize : true

        });

        jQuery('.login-dialog').dialog('open');



        return false;

    }



    function limitText(limitField, limitCount, limitNum) {

        if (limitField.value.length > limitNum) {

            limitField.value = limitField.value.substring(0, limitNum);

        } else {

            limitCount.value = limitNum - limitField.value.length;

        }

    }



</script>



