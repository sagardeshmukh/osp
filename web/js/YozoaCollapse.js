if(typeof window.Yozoa == "undefined") {
    var Yozoa = {};
}

Yozoa.Collapse = {
    params: null,
    url: null,
    initialize: function (E) {
        if(E.url){
          this.url = E.url;
        }
    },

    toggle: function(B){
        if (this.hasActiveTabMember(B)) {
            this.hide(B);
        } else {
            this.show(B);
        }
    },

    show: function(C){
        var AA = this;
        var B = $(C).parent().find('ul').html();
        $(C).removeClass("icon10");
        $(C).addClass("icon11");
          if ($(B + " > *").size() == 0) {
              var id = $(C).parent().find("input").val();
            $.ajax({
                  url: AA.url,
                  type : "post",
                  dataType: "json",
                  data: {id : id },
                  beforeSend: function(){
                      $(C).parent().addClass("loading");
                  },
                  success: function(data){
                      $(C).parent().removeClass('loading');
                      $(C).parent().find("ul").html(data.content);
                  }
                });
            }
            $(C).parent().addClass("selected");
    },

    hide: function(A){
        if (A && !$(A).hasClass("icon11")) {
            return;
        }
        this.removeMenuActiveTabClasses(A);
    },

    hasActiveTabMember: function (A) {
        return A && $(A).hasClass("icon11");
    },

    removeMenuActiveTabClasses: function (A) {
        var B = $(A).parent().find('ul');
        $(A).removeClass("icon11");
        $(A).addClass("icon10");
        $(A).parent().removeClass("selected");
    }
};