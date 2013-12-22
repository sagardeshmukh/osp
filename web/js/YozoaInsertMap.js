if (typeof window.Yozoa == "undefined") {
    var Yozoa = {};
}

Yozoa.InsertMap = {
    params: null,
    map: null,
    zoom: null,
    mapContainer: null,
    geocoder: null,
    marker: null,
    is_new: true,
    lat: null,
    lng: null,
    latid: null,
    lngid: null,
    myLatLng: null,
    marker_icon: null,

    initialize: function (E) {
        Q = this;
        Q.lat = E.lat;
        Q.lng = E.lng;
        Q.zoom = E.zoom;

        Q.marker_icon = E.marker_icon;
        Q.latid = E.latid;
        Q.lngid = E.lngid;
        Q.mapContainer = E.mapContainer;

        Q.initMap();
        Q.initMarker();
        Q.initMarkerListener();

          google.maps.event.addListener(Q.map, 'rightclick', function(event) {
            if (Q.marker == null){
              Q.initMarker();
            } else {
              Q.marker.setPosition(event.latLng);
            }
            Q.setMarkerLocation(event.latLng);
          });
    },

    initMap: function(){
      var Q = this;
      var myLatLng = new google.maps.LatLng(Q.lat, Q.lng );
      Q.myLatLng = myLatLng;

      var myOptions = {
        zoom: Q.zoom,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };

        this.geocoder = new google.maps.Geocoder();
        this.map = new google.maps.Map(document.getElementById(Q.mapContainer), myOptions);
    },

    setMarkerLocation: function(L){
        var Q = this;
        $("#"+Q.latid).val(L.lat());
        $("#"+Q.lngid).val(L.lng());
    },

    initMarkerListener: function(){
      google.maps.event.addListener(Q.marker, 'dragend', function(event) {
              Q.setMarkerLocation(event.latLng);
            });
    },

    initMarker: function(p){
        var Q = this;
        if(Q.marker){
           Q.marker.setMap(null);
        }
        var LatLng;
        if(p){
            LatLng = p;
        }else{
            LatLng = Q.myLatLng;
        }

        Q.marker = new google.maps.Marker({
              position: LatLng,
              draggable: true,
              map: Q.map,
              icon: Q.marker_icon
            });

        if(Q.is_new == true){
            Q.setMarkerLocation(Q.map.getCenter());
            Q.initMarkerListener();
        }
    },

    parse: function(A){
        var Q = this;
        var addressArray = new Array();
        if(A){
            addressArray = $(A).val();
        }else{
            jQuery('#location_selector select').each(function(){
              addressArray.push(jQuery(this).find("option[value='" + jQuery(this).val() + "']").text());
            });
            addressArray = addressArray.join(", ");
        }
            
            Q.geocoder.geocode({ 'address': addressArray }, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                Q.map.setCenter(results[0].geometry.location);
                Q.is_new = true;
                Q.initMarker(Q.map.getCenter());
              }
            });
    }
};