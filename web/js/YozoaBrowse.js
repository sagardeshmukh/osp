if (typeof window.Yozoa == "undefined") {
    var Yozoa = {};
}

Yozoa.Browse = {
    params: null,
    query_string: null,
    prevData: [],
    isChanged: [],
    width: null,
    gParams: [],
    height: null,
    DIV: null,

    initialize: function (E) {
        var I = this;
        this.params = E;
        this.DIV = E.DIV;
        this.query_string = E.query_string;
       $(window).scroll(function() {
            I.J();
        });
       $(window).resize(function() {
            I.J();
        });

    $('.asr-md a').click(function(){
        var params = I.pickAV(window.location.search);
      Yozoa.Browse.C({
          'sa': $(this).attr('id'),
          '_ssan': $(this).attr('id'),
          'params': params,
          'open': true
      });
   });
   this.I();
    },

    J: function(){
        var T = $('body').children('.ui-dialog');
        T.css("top", ( $(window).height() - T.height() ) / 2+$(window).scrollTop() + "px");
        T.css("left", ( $(window).width() - T.width() ) / 2+$(window).scrollLeft() + "px");
        return this;
    },

    D: function(){
        var I = this;
        $("#v4-12929852889205_CB, #e92").click(function(){
             $('#'+I.DIV).dialog("close");
          });
    },

    I: function(){
        $('#'+ this.DIV).dialog({
          autoOpen: false,
          modal: true,
          resizable: false,
          position: "fixed",
          width: 720,
          id: "v4-129300052703213",
          autoResize : false
        });
    },

    toString: function(P){
      var B ="av=";
      $.each(P, function(i, v){
            if(P[i]){
                B += this;
            }
        });

      return B;
    },

    pickAV: function(data){
      var U = {};
        var R = data.split("&");
           $.each(R, function () {
            var P = this.split("=");
            if(P[0] == "av"){
               if (U["av"]) {
                U["av"] += "|" + P[1];
               } else {
                U["av"] = P[1];
               }
             }
           });

           return this.toString(U);
    },

    getParams: function(E){
       var Q = this;

       if(E){
         var sa = E.sa;
         var _ssan = E._ssan;
         Q.gParams[_ssan] = E.params;
        }

       var U = {
           "ssav": sa
       };

       $.each(Q.gParams, function(i, val){
          if(Q.gParams[i]){
          var R = this.split("&");
           $.each(R, function () {
                var Pa = this.split("=");
                if (U["av"]) {
                    U["av"] += "|" + Pa[1];
                } else {
                    U["av"] = Pa[1];
                }
               });

          }

        });

        return U;
    },

    getUrl: function(){
      var Q = this;
      var url = "http://" + window.location.hostname + window.location.pathname + "?";
      var qstring = Q.query_string;
      return  url + qstring;
    },

    submit: function(){
        var Q = this;
        var params = decodeURIComponent($('.asf-c input').filter("input:enabled, input[type=hidden]").serialize());
        var _ssan = $('.asf-c input').attr('name');
        var sa = $(this).attr('id');
        var SParams = Q.getParams({
                        '_ssan' : _ssan,
                        'sa'    : sa,
                        'params': params
                    });

        var toString = Q.toString(SParams);

        var url = Q.getUrl();
        window.location = url + "&"+ toString;
        return false;

    },

    C: function(E){
        var Q = this;
        var url = Q.getUrl();
        var I = Q.getParams(E);

    $.ajax({
        url : url,
        data : I,
        dataType : 'json',
        cache : false,
        success :function(data){
            Q.isChanged[data.sa] = false;
            Q.prevData[data.sa] = [];
            Q.prevData[data.sa] = data;
            Q.processCResponse({
                'data': data,
                'open': E.open
            });
          }
        });
    },

    processCResponse: function(params){
        var Q = this;
        var data = params.data;

        $('#'+Q.DIV).html(data.content);

            if(params.open == true){
              $('#'+Q.DIV).dialog('open');
            }
             Q.D();
    }
}