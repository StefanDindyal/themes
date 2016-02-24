/*
Plugin Name: RG M2 Cart
Description: A plugin to render a cart using M2.
Version: 3.0.0
Author: GENERATOR
Author URI: http://www.rgenerator.com/
License: GPL v2.0
Copyright 2014 SonyDADC

License:
 Copyright 2014 SonyDADC / GENERATOR
 
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.
 
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
 
  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*//////////// SETTINGS ////////////*/
var storename = m2store.storename;
var api = m2store.api;
var cartContainer = m2store.cartContainer;
var cartImageSize = m2store.cartImageSize;
var cartThumb = m2store.cartThumb;
var cartPrice = m2store.cartPrice;

var bundleID = 30374653;

/*//////////// DEFAULTS ////////////*/
var host = m2store.host;
var checkout_host = m2store.checkout_host;
var keyID = m2store.keyID; // Default API Key
var apiversion = m2store.version;
var country = m2store.country;
var cookieName = storename + "-cart-id";
var cartId = _getCookie(cookieName);
var removed = [];
var minutes = 60;
var errorTimeout = 700;
var retryAttempt = 0;
var retryMax = 10;
var addedCount = 0;
var directory = m2store.directory;

var loading = '<div class="product_loading"><div class="product_loading_inner"><div id="box_1" class="box" /><div id="box_2" class="box" /><div id="box_3" class="box" /></div></div>';
var waitTime = '<div class="loading_time"><div class="loading_time_inner"><img src="'+directory+'/images/rgenerator.png" /><span></span></div></div>';

function _m2resetCount() {
    retryAttempt = 0;
}
/*/////////////////////////////////////////////////////
    * Triggers for adding and removing products
/////////////////////////////////////////////////////*/
jQuery(document).on('product_added', function(){ 
    console.log('product_added %O', arguments[1]['productID']);
    var id = arguments[1]['productID'];         
    jQuery('.instance[item-id="'+id+'"] .add').removeClass('product_add').addClass('in_cart'); 
});

jQuery(document).on('product_removed', function(){
    console.log('product_removed %O', arguments[1]['productID']);
    var id = arguments[1]['productID'];
    
    if(id == bundleID){                 
        for ( var i = 0, len = removed.length; i < len; i += 1){
            var prod = removed[i];
            if ( prod == bundleID ) { continue; }
            
            jQuery(document).trigger('product_removed', { productID: prod });
        }
    }
    jQuery('.instance[item-id="'+id+'"] .add').addClass('product_add').removeClass('in_cart'); 
});

/*/////////////////////////////////////////////////////
    * Set cookie function
/////////////////////////////////////////////////////*/
function _setCookie(cname, cvalue, expire, path, domain) {
    var time = new Date();
    time.setTime(time.getTime() + (expire * 60 * 1000));
    var expires = "expires=" + time.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires + ((path == null) ? "; path=/" : "; path=" + path) + ((domain == null) ? "" : "; domain=" + domain);
}

/*/////////////////////////////////////////////////////
    * Get cookie function
/////////////////////////////////////////////////////*/
function _getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return;
}

/*/////////////////////////////////////////////////////
    * Create cart API call
    * Sets cookie to cart ID
    * Sets cart-created trigger event
/////////////////////////////////////////////////////*/
function _m2getCartId(){
    console.log("cart id "+cartId);
    if(typeof cartId == 'undefined'){
        jQuery.jsonp({
            "url": 'http://'+host+'/'+storename+'/'+apiversion+'/cart/create.json?key='+keyID+'&amp;current_country='+country,
            "callbackParameter": "callback",
            "success": function(response) {
                cartId = response.results[0].cart_id;
               _setCookie(cookieName, cartId, minutes);                 
               jQuery(document).trigger('cart-created', {cartId : cartId});
               return true;
            },
            "error": function(xOptions, textStatus){ 
                console.log(textStatus);
                if(retryAttempt < retryMax) { 
                    setTimeout( function() { console.log("Attempting to get cart Id"); _m2getCartId() }, errorTimeout);
                    retryAttempt++;
                } else { 
                    _m2resetCount();
                    alert('Unable to get cart id, please refresh your browsers.');;
                }
            }
        });
    } else {
        return true;
    }
}

/*/////////////////////////////////////////////////////
    * Add product API call
    * Runs _m2BuildCart function to update cart view
    * Removes loading screen
/////////////////////////////////////////////////////*/
function _m2AddProduct(productID, productTitle){
   if(productID){

    jQuery.jsonp({ 
        "url": 'http://'+host+'/'+storename+'/'+apiversion+'/cart/'+cartId+'/add/'+productID+'.json?key='+keyID+'&amp;current_country='+country,
        "callbackParameter": "callback",
        "success": function(response) {
            _m2resetCount();
            addedCount++;
            _m2BuildCart();
            
            jQuery('body').find('.loading_time').fadeOut(300, function() { jQuery(this).remove(); });
            
            /*
setTimeout(function(){
				var cart_count = jQuery('.cart-items ul').length;
				if(cart_count > 0){
				    jQuery('.cart-items').stop().slideDown(250);
				    setTimeout(function(){
				        jQuery('.cart-items').stop().slideUp(250);
				    }, 3000);
				}
            }, 1000);
*/
            
            var length = typeof response.results[0].items != 'undefined' ? response.results[0].items.length : 0;
            console.log(length+ ' Item Added');
            for (var i = 0; i < length; i++) {
                console.log('Product '+ response.results[0].items[i].title + ' added');
            }
        },
        "error": function(xOptions, textStatus){ 
            console.log(textStatus);
            if(retryAttempt < retryMax) { 
                setTimeout( function() { console.log("Attempting to add item"); _m2AddProduct(productID, productTitle) }, errorTimeout);
                retryAttempt++;
            } else { 
                _m2resetCount();
                alert('Something went wrong while adding '+productTitle+'. Please try again.');
                jQuery('body').find('.loading_time').fadeOut(300, function() { jQuery(this).remove(); });
                jQuery(document).trigger('product_removed', { productID: productID });
            }
        }
       });
  }
}

/*/////////////////////////////////////////////////////
    * Remove product API call
    * Runs _m2BuildCart function to update cart view
    * Sets cart-created trigger event
/////////////////////////////////////////////////////*/
function _m2RemoveProduct(productID, productTitle) {
    if (productID) {
        jQuery.jsonp({ 

        "url": 'http://'+host+'/'+storename+'/'+apiversion+'/cart/'+cartId+'/remove/'+productID+'.json?key='+keyID+'&amp;current_country='+country,
        "callbackParameter": "callback",
        "success": function(response) {
            _m2resetCount();
            addedCount--;
            _m2BuildCart();
    
            jQuery('body').find('.loading_time').fadeOut(300, function() { jQuery(this).remove(); });
			
			/*
setTimeout(function(){
				var cart_count = jQuery('.cart-items ul').length;
				if(cart_count > 0){
				    jQuery('.cart-items').stop().slideDown(250);
				    setTimeout(function(){
				        jQuery('.cart-items').stop().slideUp(250);
				    }, 3000);
				}
            }, 1000);
*/
            
            var length = typeof response.results[0].items != 'undefined' ? response.results[0].items.length : 0;
            console.log(length+ ' Item Added - item count = '+ addedCount);
            for (var i = 0; i < length; i++) {
                console.log('Product '+ response.results[0].items[i].title + ' added');
            }

        },
        "error": function(xOptions, textStatus){ 
            console.log(textStatus);
            if(retryAttempt < retryMax) { 
                setTimeout( function() { console.log("Attempting to remove item"); _m2RemoveProduct(productID, productTitle) }, errorTimeout);
                retryAttempt++;
            } else { 
                //console.log(productID);
                alert('Something went wrong while removing '+productTitle+'. Please try again.');
                _m2resetCount();
                jQuery('body').find('.loading_time').fadeOut(300, function() { jQuery(this).remove(); });
                jQuery(document).trigger('product_removed', { productID: productID });
            }
        }
       });
    }
}


/*/////////////////////////////////////////////////////
    * Show cart API call
    * Builds cart / updates cart view
    * Sets product_added trigger event
    * HTML output to cartContainer var
/////////////////////////////////////////////////////*/
function _m2BuildCart(){

    var output = '';
    var cartItems;
    var count;
    
    if ( typeof cartId == 'undefined' || cartId == null || cartId == '' ) {
        output += '<div id="m2-cart" class="closed">';
            output += '<a href="javascript:;" class="icon '+(count > 0 ? 'active' : '')+'"><span>1</span><div class="arrow"></div></a>';
            output += '<div class="mini-cart '+(count > 0 ? 'active' : '')+'">';
                output += '<div class="cart-items closed">';
                    output += '<div class="b-squeeze">';
                        output += '<p class="empty">Nothing in Cart</p>';
                    output += '</div>';
                output += '</div>';
            output += '</div>';
        output += '</div>';
        
        setTimeout(function(){
            if(jQuery(cartContainer).length > 0){
                jQuery(cartContainer).empty().html(output);
            } else {
                console.log('No cart element exist, please define your Cart Container setting to render the cart.');
            }
        },500);
        
    } else {
        _m2showCart();
    }
}
 
function _m2showCart() {
	var cartApi = 'http://'+host+'/'+storename+'/'+apiversion+'/cart/'+cartId+'/show.json?key='+keyID+'&amp;expand=items&amp;graphic_size='+cartImageSize+'&amp;current_country='+country;

    jQuery.jsonp({ 
        "url": cartApi,
        "callbackParameter": "callback",
        "success" : function(response) {
            var output = "";
           cartItems = ( response && ('results' in response) && response.results[0].items && (response.results[0].items.length > 0)) ? response.results[0].items : null;
           count = cartItems ? cartItems.length : 0;   
           console.log('items '+count + ' addedCount '+ addedCount); 
           if(count == 0 && addedCount > 0) {
                if(retryAttempt < retryMax) { 
                setTimeout( function() { console.log("Attempting to show cart"); _m2showCart() }, errorTimeout);
                retryAttempt++;
                } else {
                    _m2resetCount();
                    alert('Something went wrong while updating cart, please refresh your browser');
                }
           } else {
                _m2resetCount();
                output += '<div id="m2-cart" class="closed">';
                    output += '<a href="javascript:;" class="icon '+(count > 0 ? 'active' : '')+'"><span>1</span><div class="arrow"></div></a>';
                    output += '<div class="mini-cart '+(count > 0 ? 'active' : '')+'">';
                        output += '<div class="cart-items closed">';
                            output += '<div class="b-squeeze">';
                            if(count > 0){
                                jQuery.each( cartItems, function(i, item){
                                    jQuery(document).trigger('product_added', { productID: item.id });
                                    removed.push(item.id);
                                    var price = item.pricing.native_display;
                                    
                                    if(item.pricing.native_display.indexOf(' ') > 0){
                                    	var price = item.pricing.native_display.substring(0, item.pricing.native_display.indexOf(' '));
                                    }
                                                                        
                                    switch(item.price_override){
                                        case 0:
                                        count--;
                                      break;                                    
                                      default :
                                        output += '<ul id="'+item.id+'" class="cart-product" item-id="'+item.id+'">';
                                            output += '<div class="product_remove btn" item-id="'+item.id+'">';
                                                output += '<a href="javascript:;" title="Remove"><span>8</span></a>';
                                            output +='</div>';
                                            if(cartThumb == 'true'){
                                            	if(item.graphic) { output += '<li class="thumb"><img src="'+item.graphic+'" alt="'+item.title+'" /></li>'; }
                                            }
                                            output += '<li class="title">';
                                                output += '<h3>'+item.title+'</h3>';
                                                // output += '<span class="type-'+(item.product_type == 'CD Album' ? 'cd' : 'direct_download')+'">'+(item.product_type == 'CD Album' ? 'CD' : 'Direct Download')+'</span>';
                                                if(cartPrice == 'true'){
                                                    if(item.pricing.amount){ output += '<div class="cart-price">'+price+'</div>'; }
                                                }
                                            output += '</li>';                                            
                                        output += '</ul>';
                                        break;
                                    }//switch
                                
                                });
                                output += '<div class="checkout-container"><a href="javascript:;" title="Checkout" class="checkout_product">Checkout</a></div>';
                            } else {
                                output += '<p class="empty">Nothing in Cart</p>';
                            }
                            output += '</div>';
                        output += '</div>';
                        if(count > 0){ output += '<div class="cart-count">'+count+'</div>'; }
                    output += '</div>';
                output += '</div>';
                
                if(jQuery(cartContainer).length > 0){
                    jQuery(cartContainer).empty().html(output);
                } else {
                    console.log('No cart element exist, please define your Cart Container setting to render the cart.');
                }    
            }   
        },
        "error": function(xOptions, textStatus){ 
            console.log(textStatus);
            if(retryAttempt < retryMax) { 
                setTimeout( function() { console.log("Attempting to show cart"); _m2showCart() }, errorTimeout);
                retryAttempt++;
            } else { 
                _m2resetCount();
                alert('Something went wrong while updating cart, please refresh your browser');      
            }
        }
            
    });
}
jQuery(function($){
     
    $('.product_add').live('click', function(e){
		var button = $(this);
        var productID = button.attr('item-id');
        var productTitle = button.attr('item-title');
        if(!$(this).parents('.soldout').length){
            if ( typeof cartId == 'undefined' || cartId == null || cartId == '' ) {
                
                _m2getCartId();
                
                $(document).on('cart-created', function(){  
            
                    $.ajax({ beforeSend: function(xhr){
                            $('#m2-cart').removeClass('cartopen');
                            $('#m2-cart').find('.mini-cart').slideUp(300);
                            $('#load_txt').text('Adding to Cart');
                            $('.loading-cart').fadeIn(300);
                       }
                    }).done(function(response){                    
                        if(cartId){

                            _m2AddProduct(productID, productTitle);
                            
                            $('.loading-cart').delay(1000).fadeOut(300);
                            setTimeout(function(){
                              $('.instances').hide('slide', {direction: 'right'}, 300);
                              $('div.products .product .buy-block').removeClass('buying');
                              $('.blur').hide();
                            }, 1500);
                            
                            if(button.find('.digital_album-type').length > 0){                              
                                if ((navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i)) && jQuery('#m2-cart .type-direct_download').length > -1) {
                                        alert('Please note that Apple iOS does not support downloads of audio and video files. You can complete your purchase on your device, but will need to download the music and video on your desktop or non-iOS device.');
                                    };
                                }                       
                            $(document).trigger('product_added', { productID: productID });
                        } else {
                            console.log('No Cart ID Found.');
                        }
                    }).fail(function(jqxhr, textStatus){ console.log('Error Loading: '+ textStatus); });
                    e.preventDefault(); 
                
                    $(document).off('cart-created');
                
                }); 
            
            } else {
                $.ajax({ beforeSend: function(xhr){
                        $('#m2-cart').removeClass('cartopen');
                        $('#m2-cart').find('.mini-cart').slideUp(300);
                        $('#load_txt').text('Adding to Cart');
                        $('.loading-cart').fadeIn(300);
                   }
                }).done(function(response){                
                    _m2AddProduct(productID, productTitle);
                    
                    $('.loading-cart').delay(1000).fadeOut(300);
                    setTimeout(function(){
                      $('.instances').hide('slide', {direction: 'right'}, 300);
                      $('div.products .product .buy-block').removeClass('buying');
                      $('.blur').hide();
                    }, 1500);
                                    
                    if(button.find('.digital_album-type').length > 0){                              
                        if ((navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i)) && jQuery('#m2-cart .type-direct_download').length > -1) {
                                alert('Please note that Apple iOS does not support downloads of audio and video files. You can complete your purchase on your device, but will need to download the music and video on your desktop or non-iOS device.');
                            };
                        }                       
                    $(document).trigger('product_added', { productID: productID });

                }).fail(function(jqxhr, textStatus){ console.log('Error Loading: '+ textStatus); });
                e.preventDefault();
            
            }    
        }    
    });
    
    $('.product_remove').live('click', function(e){
        var button = $(this);
        var productID = button.attr('item-id');
        var productTitle = button.attr('item-title');
        
        $.ajax({ beforeSend: function(xhr){
                $('#m2-cart').removeClass('cartopen');
                $('#m2-cart').find('.mini-cart').slideUp(300);  
                $('#load_txt').text('Removing from Cart');
                $('.loading-cart').fadeIn(300);
              }
           }).done(function(response) {                
                _m2RemoveProduct(productID, productTitle);
                $('.loading-cart').delay(1000).fadeOut(300);
                setTimeout(function(){
                  $('#m2-cart').addClass('cartopen');
                  $('#m2-cart').find('.mini-cart').slideDown(300);
                }, 1500);
                setTimeout(function(){
                  $('#m2-cart').removeClass('cartopen');
                  $('#m2-cart').find('.mini-cart').slideUp(300);
                }, 2300);
    
                $(document).trigger('product_removed', { productID: productID });
           }).fail(function(jqxhr, textStatus){ console.log('Error Loading: '+ textStatus); });
        e.preventDefault();
    });
    checkout_host = 'store.disneymusicemporium.com';
    // $('.checkout_product').live('click', function(){
    //     window.open( document.location.protocol+'//'+checkout_host+'/'+storename+'/cart?cart_id='+cartId+'&current_country='+country, '_self' );
    //     return true;
    // });
    $('.checkout_product').live('click', function(){
        var url = document.location.protocol+'//'+checkout_host+'/cart?cart_id='+cartId+'&current_country='+country;                
        _gaq.push(['_link', url]);
        window.open(  url , '_self' );
        return true;
    });   
     
    $('.instance.in_cart, .instance.more-btn.in_cart').live('click', function(e){
        if($('#'+bundleID).length > 0){
            $.fancybox.open([ { 
                type: 'inline' 
            } ],{ 
                padding: 0, 
                afterLoad : function(){
                    this.content = '<p class="cart_message">This album is already included in the New Digital Bundle you have in your cart!</p>';
                } 
            });
        } else {
            $.fancybox.open([ { 
                type: 'inline' 
            } ],{ 
                padding: 0, 
                afterLoad : function(){
                    this.content = '<p class="cart_message">This album is already included in your cart!</p>';
                } 
            });
        }
    });
    
    _m2BuildCart();
});