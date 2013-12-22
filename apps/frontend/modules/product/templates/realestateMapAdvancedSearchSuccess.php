<div class="wrapper">

<div id="top_header">

    <div class="search_top">

        <div style="float: left;"></div>

            <ul class="SearchView">

                <li class="list selected">

                         Map view

                    <i class="view_corner tl"></i>

                    <i class="view_corner tr"></i>

                    <i class="view_corner bl"></i>

                    <i class="view_corner br"></i>

                </li>

                <li class="list">

                    <span class="search_icon list"></span>

                   <a href="<?php echo url_for('@product_browse?xType=realestates') ?>"><span class="search_icon list"></span> List view </a>

                </li>

            </ul>



        <div id="map_options" style="display: none;">

        <div id="tabMember_search" class="tabmenu tab-active">Search</div>

        <div id="tabMember_option" class="tabmenu" data-value="realestate">Real Estate <span class="down-arrow">▼</span></div>

        </div>



    </div>

</div>

<div id="map-iad-verticals" style="display: none;">

    <div class="map-iad-verticals-wrapper">

        <ul>

            <li data-value="realestate" class="iad-eiendom selected">Real Estate</li>

            <li data-value="rental" class="iad-motor">Rental</li>

        </ul>

    </div>

</div>

<div id="map_main" class="minimenu">

    <div id="map_container">

    <div id="load_indicator">

              <div class="roller">

                <img alt="roller" src="/images/roller.gif">

              </div>

            </div>
<div class="tabs"></div>
<div id="gMapContainer"></div>

</div>

<div id="map_menu">

<div id="tab_search" class="selectedMenuItem">

    <div id="map-search-input">

                <input id="keywordMap" class="textinput" type="text" value="" name="keyword"/>

                <input id="search_button" class="btn" type="submit" name="submit" value="Search" />

                <img id="search-ajax-anim" style="display:none;" src="/images/ajaxload_1-6cc4ff.gif" alt="loading" />

                <div id="map_auto_complete" class="auto_complete"></div>

</div>

 <div id="map-search-content" style="height: 268px;">

  <div id="addressContainer">

    <div id="location_selector" class="input-map">

                <div style="padding-left: 5px;">

                  <?php foreach($xareas as $xarea): ?>

                    <div class="mainLocationList">

                        <div class="subList" onclick="javascript:Yozoa.MapApp.locationFind(this, <?php echo $xarea->getId() ?>)">

                                <?php echo $xarea->getName() ?>

                            <span class="nbNumber"><?php echo $xarea->getNbProduct() ?></span>

                        </div>

                    </div>

                <?php endforeach; ?>

                </div>

            </div>

    <div id="map-search-results">

        <div class="stats">

            <span class="plotted">Results</span>

        </div>

        <div id="ResultTip"></div>

      </div>

   </div>

 </div>

</div>

<div id="tab_option"></div>

</div>

<!--<div class="close-leftmenu"></div>-->

</div>



    </div>

<script type="text/javascript">

    $(document).ready(function(){
	
		Yozoa.Menu.toggle('option');
        //Yozoa.Menu.addMenuItem('search');

       //Yozoa.Menu.addMenuItem('option');

        Yozoa.MapApp.initialize({

                "zoom": 6,

                "coordinates": [<?php echo $avr_lat ?>, <?php echo $avr_lat ?>],

                "initial_data": <?php echo json_encode($initial_data) ?>

            });

        Yozoa.MapApp.updateSize();

        Yozoa.Search.init();
		Yozoa.MapApp.mapChanged(50);

    });

</script>



