if (typeof window.Yozoa == "undefined") {

    var Yozoa = {};

}



Yozoa.MapApp = {

    params: null,

    initial_data: [],

    map: null,

    infoWindow: null,

    geocoder: null,

    is_initial: true,

    markers: [],

    markerClusterer: null,

    points: [],

    delayTimer: null,

    load_indicator: null,

    url: "/product/getRealEstateObject",

    initialize: function (E) {

        this.params = E;

        this.initial_data = this.params.initial_data;

        var AA = this;

        this.load_indicator = $('#load_indicator');

        var myLatLng = new google.maps.LatLng(this.params.coordinates[0], this.params.coordinates[1]);

        var myOptions = {

            zoom: 6,

            center: myLatLng,

            mapTypeId: google.maps.MapTypeId.ROADMAP

          };

        this.geocoder = new google.maps.Geocoder();

        this.map = new google.maps.Map(document.getElementById("gMapContainer"), myOptions);



        $(window).resize(function() {

            AA.updateSize();

        });



         // bounds changed

        google.maps.event.addListener(this.map, 'dragend', function() {

                AA.mapChanged(50);

         });

         // zoom changed

        google.maps.event.addListener(this.map, 'zoom_changed', function() {

                AA.setInitial();

                AA.mapChanged(50);

         });

        Yozoa.Menu.initialize();

        $('#tabMember_search').click(function(){

            Yozoa.Menu.toggle('search');

        });

        $('#tabMember_option').click(function(){

            Yozoa.Menu.toggle('option');

        });

        //initial data

        this.parseData(this.initial_data);

    },



    //set initial

    setInitial: function(){

        this.clearOverlays();

        this.markerClusterer.clearMarkers();

        this.is_initial = true;

        this.points = [];

    },

    // Removes the overlays from the map, but keeps them in the array

    clearOverlays: function() {

        for (i in this.markers) {

          this.markers[i].setMap(null);

        }

        this.markers = [];

    },



    getParams: function(){

    var bounds = this.map.getBounds();

    var southWest = bounds.getSouthWest();

    var northEast = bounds.getNorthEast();

    // Calculating the distance from the top to the bottom of the map

    var latSpan = northEast.lat() - southWest.lat();

    // Calculating the distance from side to side

    var lngSpan = northEast.lng() - southWest.lng();

    var lat = southWest.lat() + latSpan;

    var lng = southWest.lng() + lngSpan;



    var I = "";

        I += "minX=" + southWest.lat();

        I += "&minY=" + southWest.lng();

        I += "&maxX=" + lat;

        I += "&maxY=" + lng;

        return I;

  },



    //click marker event

    clickMarker: function(marker, id){

    var AA = this;

    $.ajax({

        type: "POST",

        url : AA.url,

        data : { id : id },

        dataType: 'json',

        cache : false,

        success : function(data){

                // Check to see if an InfoWindow already exists

                if (!AA.infoWindow){

                  AA.infoWindow = new google.maps.InfoWindow();

                }

                // Creating the content

                var content = data.poiValue;

                // Setting the content of the InfoWindow

                AA.infoWindow.setContent(content);

                // Opening the InfoWindow

                AA.infoWindow.open(AA.map, marker);

          }

      });

    },



    parseData: function(data){

        $.each(data.main, function(idx, itm){

            Yozoa.MapApp.checkMarkers(itm.product);

        });

       var southWest = new google.maps.LatLng(data.avr['min_lat'],data.avr['min_lng']);

       var northEast = new google.maps.LatLng(data.avr['max_lat'],data.avr['max_lng']);

       var bounds = new google.maps.LatLngBounds(southWest, northEast);

       this.map.fitBounds(bounds);

    },



    checkMarkers: function(data){

      var check = false;

      var AA = this;



    $.each(data, function(idx, itm){

         if(AA.is_initial == true && jQuery.inArray(itm.id, AA.points)=== -1 || AA.points.length > 0 && jQuery.inArray(itm.id, AA.points)=== -1){

             var marker = new google.maps.Marker({

                   position: new google.maps.LatLng(itm.lat, itm.lng),

                   map: AA.map,

                   title: itm.name,

                   icon: itm.image

          });

          google.maps.event.addListener(marker, 'click', function() {

              AA.clickMarker(marker, itm.id);

                });

          AA.points.push(itm.id);

          AA.markers.push(marker);

          check = true;

         }

     });

     if(check == true){

        AA.markerClusterer = new MarkerClusterer(AA.map, AA.markers);

     }

      AA.is_initial =  false;

    },



    mapChanged: function(A){

            var AA = this;

            var params = this.getParams();

            var dataString = $("#realEstateMapForm input, #realEstateMapForm select").filter("select:enabled, input:enabled, input[type=hidden]").serialize();

            var L = "/product/getAjax";

            var J = params + "&"+dataString;

            var G = J.split("&");

            var I = {};

            $.each(G, function () {

                var P = this.split("=");

                if (I[P[0]]) {

                    I[P[0]] += ";" + P[1];

                } else {

                    I[P[0]] = P[1];

                }

            });



            clearTimeout(this.delayTimer);

            $(".loaderfeedback").show();

            if (A && typeof A == "number") {

                this.delayTimer = setTimeout(function () {

                    Yozoa.MapApp.mapChanged();

                }, A);

                return;

            }



             $.ajax({

                type: "POST",

                url : L,

                data : I,

                dataType: 'json',

                cache : false,

                beforeSend: function(){

                    AA.load_indicator.show(); alert(0);

                },

                success : function(data){ alert(data);
alert(1);
                    AA.load_indicator.hide();

                    $(".loaderfeedback").remove();

                    if(data != null){

                     AA.checkMarkers(data);

                    } else{

                      return false;

                    }

                }

          });

  },



    locationFind: function(element, id){

      var AA = this;

      $(element).nextAll('.subList').remove();

      var img = '<img style="float: right;" src="/images/ajaxload_1-6cc4ff.gif" alt="loading" />';

          $.ajax({

            type: "POST",

            url : "/product/getRealEstateArea/",

            data : { id : id },

            dataType: 'json',

            cache : false,

            beforeSend: function(){

               AA.clearOverlays();

               AA.markerClusterer.clearMarkers();

               AA.load_indicator.show();

               $(element).append(img);

            },

            success : function(data){

                $(element).find('img').remove();

                AA.load_indicator.hide();

                if(data != null){

                AA.parseData(data);

                 var resultSet = '';

                 $.each(data.main, function(i, itm){

                     if(itm.total > 0){

                       resultSet += '<div class="subList subs" onclick="Yozoa.MapApp.locationFind(this,'+ itm.id +')" >';

                       resultSet +=  itm.name;

                       resultSet +=  '<span class="nbNumber">'+itm.total+'</span>';

                       resultSet +=  '</div>';

                     }

                 });

                 $('.subList:last').after(resultSet);

                } else{

                 $('#ResultTip').text("No Result. Try again.");

                }

            }

        });

    },



    searchLocation: function(){

        var AA = this;

        var C= $('#keywordMap').val();

        if (!C) {

          return;

        }

          Yozoa.Menu.full();

          AA.geocoder.geocode({ 'address': C }, function(results, status) {

                  if (status == google.maps.GeocoderStatus.OK) {

                    AA.map.setCenter(results[0].geometry.location);

                  }

                });

      if (C.length >= 2){

          $.ajax({

          type: "POST",

          url : "/product/getRealEstateSearch/",

          data : { keyword : C },

          dataType: 'json',

          cache : false,

         beforeSend: function(){

            AA.clearOverlays();

            AA.markerClusterer.clearMarkers();

            $('#search-ajax-anim').show();

           },

         success : function(data){

            $('#search-ajax-anim').hide();

            if(data != null){

              $('#ResultTip').text("");

              AA.parseData(data);

             }else{

              $('#ResultTip').text("No Result. Try again.");

             }

           }

         });

      }else{

          //length less than 2

          $('#ResultTip').text("Insert your keyword.");

        }

        AA.setInitial();

        AA.mapChanged(1000);

        $('#addressContainer').css("display", "block");

    },





    getViewportHeight: function () {

        var A = 0;

        if (typeof(window.innerHeight) == "number") {

            A = window.innerHeight;

        } else {

            if (document.documentElement && document.documentElement.clientHeight) {

                A = document.documentElement.clientHeight;

            }

        }

        if (window.orientation !== undefined) {

            A = window.innerHeight;

        }

        return A;

    },

    getViewportWidth: function () {

        if (typeof(window.innerWidth) == "number") {

            return window.innerWidth;

        } else {

            if (document.documentElement && document.documentElement.clientWidth) {

                return document.documentElement.clientWidth;

            }

        }

    },



    updateSize: function () {

        var A = this.getOrientationMode();

        var B = 36;

        if (A && A != this.deviceOrientation) {

            this.deviceOrientation = A;

            this.scrollAwayAddressBar();

        }

        this.heightTotal = this.getViewportHeight();

        this.heightHead = $("#top_header").height();

        this.heightMain = this.heightTotal - this.heightHead;

        $("#map_main").height(this.heightMain - B);

        if (this.bannerLoaded) {

            this.handleBanner();

        }

    },



    getOrientationMode: function () {

        if (window.orientation == undefined) {

            return;

        }

        return ((window.orientation % 180) === 0 ? "portrait" : "landscape");

    },



    resizeSideBar: function () {

        var A = this.heightMain;

            if ($("#map_main").is(Finn.Menu.FULL)) {

                $("#map_container").height("");

                A = A - $("#map_container").height() - 8;

            } else {

                if ($("#map_main").is(Finn.Menu.MINI)) {

                    $("#map_container").height(this.heightMain - $("#map_menu").height() - 36);

                } else {

                    $("#map_container").height("100%");

                }

            }

        this.heightMenu = A;

        $("#map_menu").height(this.heightMenu - 36);

    }



};



Yozoa.Menu = {

    FULL: "sidemenu",

    MINI: "minimenu",

    items: {},

    selectedId: "",

    div: null,

    divId: "#map_options",

    width: 0,

    state: null,

    searchId: "tabMember_search",

    optionId: "tabMember_option",

    initialize: function () {

        this.div = $(this.divId).get(0);

        $(".close-leftmenu").click(function () {

            Yozoa.Menu.hide();

        });

        Yozoa.Filters.init();

    },



    addMenuItem: function (A) {

        this.items[A] = new Yozoa.MenuItem("tab_" + A);

    },



    toggle: function (B, A) {

        if (!this.validateTab(B)) {

            return;

        }

        if (this.hasActiveTabMember(B)) {

            this.hide(B, A);

        } else {

            this.show(B, A);

        }

    },



    validateTab: function(B) {

        var A = this.items[B];

        return true;

    },



    getAllTabIds: function () {

        var A = [];

        for (var B in this.items) {

            A.push(B);

        }

        return A;

    },



    show:function (C, B, A){

        if (!this.validateTab(C)) {

            return;

        }

        if (!this.isTabActive(C)) {

            this.triggerShowMenuItemEvent(C);

        }

        this.removeMenuActiveTabClasses();

        $("#tabMember_" + C).addClass("tab-active");

        $("#map_menu").addClass("tab-" + C);

            if ($("#tab_" + C + " > *").size() == 0) {

                $("#tab_" + C).html("<div id='tabLoadingDesc'>Vennligst vent. Laster innhold... <img src='/images/ajaxload_1-6cc4ff.gif' alt='' /></div>");

                $.get("/tabs/" + C + "/", function (D) {

                    $("#tab_" + C).html(D);

                    Yozoa.MapApp.updateSize();

                    if (C == "option") {

                        Yozoa.Filters.init();

                    }

                    if (B && typeof B == "function") {

                        B();

                    }

                });

            } else {

                if (B && typeof B == "function") {

                    B();

                }

            }



        this.selectedId = C;

        if (!A) {

            this.full();

        } else {

            this.mini();

        }

        $("#map_menu div").removeClass("selectedMenuItem");

        $("#tab_" + C).addClass("selectedMenuItem");

    },



    isTabActive: function (A) {

        return $("div#tabMember_" + A).hasClass("tab-active");

    },



    keepMapInPosition: function (A) {

        if (this.state == A || (!this.state && A == this.MINI)) {

            return;

        }

            this.width = $("#map_menu").width();

            var B = this.width / 2 * -1;

            if (A == this.FULL) {

                B *= -1;

            }



        Yozoa.MapApp.updateSize();

    },



    mini: function () {

        $("#map_main").removeClass(this.FULL);

        $("#map_main").addClass(this.MINI);

        this.keepMapInPosition(this.MINI);

        this.state = this.MINI;

    },

    full: function () {

        $("#map_main").removeClass(this.MINI);

        $("#map_main").addClass(this.FULL);

        this.state = this.FULL;

    },



    removeMenuActiveTabClasses: function () {

        var A = this.getAllTabIds();

        $("#map_menu").removeClass("tab-" + A.join(" tab-"));

        $("#map_options .tab-active").removeClass("tab-active");

    },



    hide: function (A) {

        if (A && !$("#tab_" + A).hasClass("selectedMenuItem")) {

            return;

        }

        $("#map_main").removeClass(this.FULL).removeClass(this.MINI);

        this.removeMenuActiveTabClasses();

        this.state = null;

        Yozoa.MapApp.updateSize();

    },





    hasActiveTabMember: function (A) {

        if (!A && this.selectedId) {

            A = this.selectedId;

        }

        return A && $("#tabMember_" + A).hasClass("tab-active");

    },



    triggerShowMenuItemEvent: function (B) {

        if (!B) {

            return;

        }

        var A;

        if (B == "search") {

            A = this.searchId;

        } else {

            if (B == "option") {

                A = this.optionId;

            }

        }

        if (A) {

            $("#" + A).trigger("showmenuitem");

        }

    }

};

Yozoa.MenuItem = function (A) {

    this.id = A;

    this.element = $("#" + A).get(0);

};



Yozoa.Search = (function () {



    function U() {

        S();

        B();

    }

    function S() {

        //autocomplete

        var options, a;

        $(function(){

          options = { serviceUrl:'/product/autocomplete' };

          a = $('#keywordMap').autocomplete(options);

        });

    }



    function B() {

        $('#search_button').click(function(){

            Yozoa.MapApp.searchLocation();

        });

    }



    return {

        init: U

    };

}());



Yozoa.Filters = (function () {



    function U() {

        D();

        M();

        O();

        W();

        I();

        L();

        F();

        R();



    $("#tabMember_option,#map-iad-verticals").hover(function () {

    $("#map-iad-verticals").show();

    }, function () {

        $("#map-iad-verticals").hide();

    });

    $("#map-iad-verticals li").click(function () {

        Yozoa.Menu.show("option");

        var Y = $(this);

        var X = Y.attr("data-value");

        $("#tabMember_option").attr("data-value", X);

        Y.addClass("selected").siblings(".selected").removeClass("selected");

        $("div#tabMember_option").html(Y.text() + " <span class='down-arrow'>&#9660;</span>");

        $("div#map_menu").removeClass("realestate rental").addClass(X);

        K();

        O();

        $("#map-iad-verticals").hide();

    });



    }



    function D() {

        //options form-iin uurchlult

        $("#realEstateMapForm").delegate("input", "change", function(){

                J($(this));

                A($(this));

         });

    }



    function R() {

        $("#realEstateMapForm").bind("change", function (X) {

            Yozoa.MapApp.setInitial();

            Yozoa.MapApp.mapChanged(1000);

        });

    }



    function J(Y) {

        var Z = Y.closest(".filtergroup");

        Z.find(".activefilter").remove();

        var X = Z.has("input:checkbox:checked, input:text[value!=''], select>option:selected[value!='']");

        X.find("h4").append('<div class="activefilter"></div>');

        X.find(".filter-content").show();

    }



    function A(X) {

        if ($("span.loaderfeedback").length === 0) {

            X.closest(".filtergroup").find("H4").append('<span class="loaderfeedback" style="display:none">&nbsp;</span>');

        }

    }



    function O() {

        var X = $("#tabMember_option").attr("data-value");

        $("#realEstateMapForm ." + X + " select").removeAttr("disabled").trigger("change");

    }

    function K() {

        $("#realEstateMapForm div.categorywrap select").attr("disabled", true);

    }

    function M() {

        $("#realEstateMapForm input, #realEstateMapForm select").attr("disabled", true);

    }

    function E(X) {

        $("#realEstateMapForm select").find("option[value=" + X + "]").closest(".categorywrap").find("input, select").removeAttr("disabled").show();

        $("#realEstateMapForm .categoryselect select").val(X).trigger("change");

    }

    function B() {

        $("#realEstateMapForm .resetbutton").click(function () {

            $(":input", "#realEstateMapForm").not(":button, :submit, :reset, :hidden, .categoryselect select").val("").removeAttr("checked").removeAttr("selected");

            $(".activefilter").remove();

            $("#realEstateMapForm").trigger("change");

        });

    }

    function F() {

        $("#realEstateMapForm .filtergroup").delegate("input:checkbox", "change", function () {

            $(this).closest("label").removeClass("highlight-label");

            $(this).closest("label").has("input:checked").closest("label").addClass("highlight-label");

        });

    }

    function W() {

        $(".categoryselect select").live("change", function (Y) {

            $(".categoryselect select").find("option:first").text("Select");

            $(this).find("option:first").text("Collapse all");

            $("#realEstateMapForm .filtergroup-wrapper").find("input,select").attr("disabled", true);

            $("#realEstateMapForm .filtergroup-wrapper").hide();

            var X = $(this).val();

            if (!X) {

                return;

            }

            $("#" + X).find("input,select").attr("disabled", false);

            $("#" + X).show();

        });

    }

    function L() {

        $("#realEstateMapForm input:text").bind("keyup", function (X) {

            $(this).trigger("change");

        });

    }



    function I() {

        $("#realEstateMapForm h4").click(function () {

            $(this).next(".filter-content").slideToggle("fast", function () {

                $(this).closest(".filtergroup").addClass("collapsed");

            });

        });

    }



    return {

        init: U,

        enableIadForm: O,

        disableIadForm: F

    };

}());

  