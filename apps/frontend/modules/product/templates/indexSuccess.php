<div class="leftSidebar">

  <span class="button"><a title="<?php echo __('Add product') ?>" class="yellow" href="<?php echo url_for('manageProduct/step1')?>"><span style="color: #333"><?php echo __(' + Add product') ?> <font style="color: #666">(Free)</font></span></a></span>

  <br clear="all"/>

  <br clear="all"/>



  <div class="box boxSidebarBlue">

    <div class="boxHeader"><div><h3><?php echo __('Categories') ?></h3></div></div>

    <div class="boxContent">

      <ul class="cats privateCats">

        <li class="icon recent"><?php echo __('New') ?>

            <a title="" href="<?php echo url_for('@product_browse?xType=recent_hours') ?>"><?php echo __('24 hour') ?></a> |

            <a title="" href="<?php echo url_for('@product_browse?xType=recent_days') ?>"><?php echo __('3 days') ?></a>

        </li>

        <li class="icon buy_online"><a title="" href="<?php echo url_for('@product_browse?xType=buy_online') ?>"><?php echo __('Buy now') ?></a></li>

        <li class="icon paid"><a title="" href="<?php echo url_for('@product_browse?xType=paid') ?>"><?php echo __('Paid') ?></a></li>

        <li class="icon urgent"><a title="" href="<?php echo url_for('@product_browse?xType=urgent') ?>"><?php echo __('Urgent') ?></a></li>

        <li class="icon sale"><a title="" href="<?php echo url_for('@product_browse?xType=sale') ?>"><?php echo __('Sale') ?></a></li>

        <li class="icon icon3"><a title="" href="<?php echo url_for('@product_browse?xType=top') ?>"><?php echo __('Top 100 products') ?></a></li>

      </ul>

      

      <?php include_component('category', 'leftMenu')?>

    </div>

    <div class="boxFooter"><div></div></div>

  </div><!--box-->





  <?php //include_component('help','rightMenu')?>

  

</div><!--sidebar-->



<div class="contentColumn">



  <?php include_partial('banner/show', array("categoryId"=>$sf_params->get("categoryId")))?>



  <?php include_component('product','indexComment')?>



  <?php include_component('product','newProduct')?>

  

  

  <div class="box boxYellow">

    <div class="boxHeader">

    	<div>

    		<a href="/paid"><h3 style="width: 700px"><?php echo __('Homepage products'); ?> </h3></a>

    	</div>

    </div>

    <div class="boxContent">

      <?php $i = 0?>

      <?php foreach($products as $i => $product):?>

        <?php if ($i % 5 == 0):?>

	      <div class="five-col-one">

	    <?php endif?>

	    

	    <?php include_partial('homeItem', array('product' => $product, 'sf_cache_key'=> $product->getCacheKey()))?>

	    

		<?php if ($i % 5 == 4):?>

	        <div class="clear"></div>

	      </div>

        <?php endif;?>

        

      <?php endforeach?>

      <?php if (count($products) && $i % 5 != 4):?>

        <div class="clear"></div>

      </div>

      <?php endif?>

    </div>

    <div class="boxFooter"><div></div></div>

  </div><!--boxYellow-->

  

  <?php include_component('product', 'featured')?>

  

  <?php include_component('product', 'newProjects')?>



  <?php include_component('category','featured')?>



</div>

<div class="clear"></div>



<script type="text/javascript">

 

$(document).ready(function(){



	var first = 0;

	var speed = 20;

	var pause = 5500;



		function removeFirst(){

			first = $('ul#listticker li:first').html();

			$('ul#listticker li:first')

			.animate({opacity: 0}, speed)

			.fadeOut('slow', function() {$(this).remove();});

			addLast(first);

		}



		function addLast(first){

			last = '<li style="display:none">'+first+'</li>';

			$('ul#listticker').append(last)

			$('ul#listticker li:last')

			.animate({opacity: 1}, speed)

			.fadeIn('slow')

		}



	interval = setInterval(removeFirst, pause);

});

</script>









<script type="text/javascript">

function mycarousel_initCallback(carousel)

{

    // Disable autoscrolling if the user clicks the prev or next button.

    carousel.buttonNext.bind('click', function() {

        carousel.startAuto(0);

    });



    carousel.buttonPrev.bind('click', function() {

        carousel.startAuto(0);

    });



    // Pause autoscrolling if the user moves with the cursor over the clip.

    carousel.clip.hover(function() {

        carousel.stopAuto();

    }, function() {

        carousel.startAuto();

    });

};



jQuery(document).ready(function() {

    jQuery('#mycarousel').jcarousel({

        auto: 3,

        wrap: 'last',

		scroll: 1,

		initCallback: mycarousel_initCallback

    });



    jQuery('#mycarouselStore').jcarousel({

        auto: 3,

        wrap: 'last',

		scroll: 1,

		initCallback: mycarousel_initCallback

    });

});

function MM_findObj(n, d) { //v4.01

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && d.getElementById) x=d.getElementById(n); return x;

}



</script>







