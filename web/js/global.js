$(document).ready( function(){
  
  // put all initilizers here. 
  vtip();
  
  //ajax indicator
  $("body").prepend('<div id="loading_indicator" style="display:none;">Түр xүлээнэ үү ...<img style="margin-bottom: -3px;" src="/images/loading.gif" alt="Loading"/></div>');
  $(".hideShowCat a").click(function(){
    $(this).addClass('hide').parent().siblings().removeClass('hide');
    return false;
  });
  
  $("#main-menu li.menu").mouseover(function(){
    $(this).addClass("hover");
  }).mouseout(function(){
    $(this).removeClass("hover");
  });
  
  $("#top-menu li").mouseover(function(){
	  $(this).addClass("hover");
	      }).mouseout(function(){
	  $(this).removeClass("hover");
   });  
})

function pagerNavigation(url, elementId){
  if (url.charAt(0) != '/'){
    url = '/' + url;
  }
  jQuery.ajax({
    url: url,
    beforeSend: function (){
      var elementOffset = $('#' + elementId).offset();
      var elementHeight = $('#' + elementId).height();
      var elementWidth  = $('#' + elementId).width();
      var indicatorHeight = $('#loading_indicator').height();
      var indicatorWidth  = $('#loading_indicator').width();
      $("#"+elementId).css({
        opacity : 0.3
      });
      $('#loading_indicator').css({
        position:'absolute',
        display: 'block',
        left: elementOffset.left + (elementWidth - indicatorWidth) / 2,
        top: elementOffset.top + (elementHeight - indicatorHeight) / 2
      });
    },
    success: function(html){
      $('#loading_indicator').hide();
      $("#"+elementId).css({
        opacity : 1
      }).html(html);
    }
  });
  return false
}

function toggleContainers(element){
  var element = $(element);
  if (element.hasClass('icon11')) {
    element.removeClass('icon11').addClass('icon10').next('div').toggle(500);
  } else {
    element.removeClass('icon10').addClass('icon11').next('div').toggle(500);
  }
}

var cookieManager = {
  getCookie : function(c_name){
    if (document.cookie.length > 0){
      c_start=document.cookie.indexOf(c_name + "=");
      if (c_start != -1) {
        c_start = c_start + c_name.length+1;
        c_end = document.cookie.indexOf(";",c_start);
        if (c_end==-1) c_end=document.cookie.length;
        return unescape(document.cookie.substring(c_start,c_end));
      }
    }
    return "";
  },
  setCookie : function(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie = c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toUTCString());
  }
};

function compareProductItem(items) {
  this.items = items || {};
  this.addItem = function(productId, imgSrc){
    this.items[productId] = imgSrc
  };
  this.getImgSrc = function(productId) {
    return this.items[productId];
  }
  this.deleteItem = function(productId){
    if (this.hasProductId(productId)) delete this.items[productId];
  };
  this.getItems = function(){
    return this.items;
  };
  this.setItems = function(items){
    this.items = items
  };
  this.hasProductId = function(productId){
    if (typeof this.items[productId] == 'undefined'){
      return false;
    }
    return true;
  }
  this.getProductIds = function(){
    var productIds = [];
    for(productId in this.items) productIds.push(productId);
    return productIds;
  };
  this.serialize = function(){
    var itemArray = [];
    for(productId in this.items) itemArray.push(productId+':"'+this.items[productId]+'"');
    return "{"+itemArray.join(",")+"}";
  };
  this.getLength = function(){
    var counter = 0;
    for(productId in this.items) counter++;
    return counter;
  };
}

var productCompare = {
  categoryId   : 0,
  compareItems : new compareProductItem(),
  gotoCompare : function(culture){
    if ($('#compare_ids').val().split("-", 5).length < 2) {
      alert('Та 2-оос болон түүнээс дээш бүтээгдxүүн сонгоно уу');
    } else {
      window.location = "/"+culture+"/productCompare?ids=" + $('#compare_ids').val();
    }
  } ,
  bindCompareItems : function (){
    $('.compare-select').attr('checked', false).each(function(){
      var productId = $(this).val();
      if (productCompare.compareItems.hasProductId(productId)){
        $(this).attr('checked', true);
      }
    });
    var nbProductItems = productCompare.compareItems.getLength();
    var productIds     = productCompare.compareItems.getProductIds();
    $('.compare-li').html('').each(function(index){
      if (index < nbProductItems) {
        $(this).html('<img src="'+productCompare.compareItems.getImgSrc(productIds[index])+'" class="compare-img" /><span><img src="/images/icons/remove.png" /></span>');
        $(this).find('span > img').click(function(){
          productCompare.compareItems.deleteItem(productIds[index]);
          cookieManager.setCookie('compareValues', "{categoryId:"+productCompare.categoryId+",items:"+productCompare.compareItems.serialize()+"}");
          productCompare.bindCompareItems();
        });
      } else {
        return false;
      }
    });
    $("#compare_ids").val(productCompare.compareItems.getProductIds().join('-'));
  }
}
//productCompare.compareItems = new productCompare.compareProductItem(),
function newGuestbook()
{ jQuery('.guestbook-dialog').dialog('close');
  jQuery('#guestbook_form_container').load('guestbook/new').dialog({
    title:  'Таны сэтгэгдэл',
    autoOpen: false,
    resizable: false,
    width: 450,
    autoResize : true
  });
  jQuery('.guestbook-dialog').dialog('open');
  return false;
}
function submitComment()
{
  jQuery.ajax({
    url: '/guestbook/create',
    type: 'POST',
    data: jQuery("#guestbook_form").serialize(),
    success: function(html){
      jQuery("#guestbook_form_container").html(html);
    }
  });

}

function warningDailog(type,id)
{
  jQuery('.product-warning-dialog').dialog('close');
  jQuery('#product_warning_container').load('/help/warning?type='+type+'&product_id='+id).dialog({
    title:  'Анхааруулга',
    autoOpen: false,
    resizable: false,
    width: 450,
    autoResize : true  
  });
  jQuery('.product-warning-dialog').dialog('open');
  return false;
}



function myStore(type)
{ 
  jQuery('.mystore-dialog').dialog('close');
  jQuery('#mystore_form_container').load('/mystore/edit').dialog({
    title:  type,
    autoOpen: false,
    resizable: false,
    width: 400,
    autoResize : true
  });
  jQuery('.mystore-dialog').dialog('open');
  return false;
}

function MailTo(product_id)
{ 
  jQuery('.sendFriend-dialog').dialog('close');
  jQuery('#sendFriend_form_container').load('/sendFriend/new?product_id='+product_id).dialog({
    title:  'Найздаа илгээх',
    autoOpen: false,
    resizable: false,
    width: 450,
    autoResize : true
  });
  jQuery('.sendFriend-dialog').dialog('open');
  return false;
}

function submitMail(product_id)
{
  jQuery.ajax({
    url: '/sendFriend/create?product_id='+product_id,
    type: 'POST',
    data: jQuery("#sendFriend_form").serialize(),
    success: function(html){
      jQuery("#sendFriend_form_container").html(html);
    }
  });

}


function AskQuestion(product_id)
{ 
  jQuery('.askQuestion-dialog').dialog('close');
  jQuery('#askQuestion_form_container').load('/askQuestion/ask?product_id='+product_id).dialog({
    title:  'Ask a Question',
    autoOpen: false,
    resizable: false,
    width: 550,
    autoResize : true
  });
  jQuery('.askQuestion-dialog').dialog('open');
  return false;
}


function sendAskQuestion(product_id)
{
  jQuery.ajax({
    url: '/askQuestion/create?product_id='+product_id,
    type: 'POST',
    data: jQuery("#askQuestion_form").serialize(),
    success: function(html){
      jQuery("#askQuestion_form_container").html(html);
    }
  });

}

/**
Vertigo Tip by www.vertigo-project.com
Requires jQuery
 */

this.vtip = function() {    
  this.xOffset = -10; // x distance from mouse
  this.yOffset = 10; // y distance from mouse
    
  $(".vtip").unbind().hover(
    function(e) {
      this.t = this.title;
      this.title = '';
      this.top = (e.pageY + yOffset);
      this.left = (e.pageX + xOffset);
      $('body').append('<p id="vtip"><img id="vtipArrow" src="/images/vtip_arrow.png" />' + this.t + '</p>' );
      $('p#vtip').css("top", this.top+"px").css("left", this.left+"px").fadeIn("slow");
    },
    function() {
      this.title = this.t;
      $("p#vtip").fadeOut("slow").remove();
    }
    ).mousemove(
    function(e){
      this.top = (e.pageY + yOffset);
      this.left = (e.pageX + xOffset);
                         
      $("p#vtip").css("top", this.top+"px").css("left", this.left+"px");
    }
    );
    
};
