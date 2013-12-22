    <input type="hidden" name="xarea_id" id="xarea_id" value="" />
    <div id="map-search-input">
                    <div id ="search_result"></div>
                    <input id="keywordMap" class="textinput" type="text" value="" name="keyword"/>
                    <input id="search_button" class="btn" type="submit" name="submit" value="Search" />
                    <img id="search-ajax-anim" style="display:none;" src="/images/ajaxload_1-6cc4ff.gif" alt="loading" />
                    <div id="map_auto_complete" class="auto_complete"></div>
                    <br/>
    </div>

    <div id="location_selector" class="input-map">
                <div style="padding-left: 5px;">
                  <?php foreach($xareas as $xarea): ?>
                    <div class="mainLocationList" class="mainLocationList">
                        <div class="subList" onclick="javascript:locationFind(this, <?php echo $xarea->getId() ?>)">
                                <?php echo $xarea->getName() ?>
                            <span class="nbNumber"><?php echo $xarea->getNbProduct() ?></span></div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>