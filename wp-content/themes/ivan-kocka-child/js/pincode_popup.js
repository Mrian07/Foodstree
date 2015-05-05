jQuery(document).ready(function(){



    if (pincode_data.hasOwnProperty("pincode")) {

        var pincode = pincode_data.pincode;

        var ship_to_different = jQuery("#ship-to-different-address-checkbox").val();

        if (jQuery("#ship-to-different-address-checkbox").is(':checked')) {
             jQuery("#shipping_postcode").val(pincode);
             jQuery("#shipping_postcode").attr("disabled", "disabled");
        }else{
           jQuery("#billing_postcode").val(pincode);
           jQuery("#billing_postcode").attr("disabled", "disabled"); 
        }

      }


    jQuery(document).on('click','#ship-to-different-address-checkbox',function(){
      if(jQuery(this).prop('checked')) {
            jQuery("#billing_postcode").val("");
            jQuery("#billing_postcode").removeAttr('disabled');

             jQuery("#shipping_postcode").val(pincode);
             jQuery("#shipping_postcode").attr("disabled", "disabled");
      } else {
        jQuery("#shipping_postcode").val("");
        jQuery("#shipping_postcode").removeAttr('disabled');

        jQuery("#billing_postcode").val(pincode);
        jQuery("#billing_postcode").attr("disabled", "disabled");
      }
   });






    /*if (jQuery.cookie('user_pincode') == null ){

        jQuery("#pincodepop").css('display', 'block');
        jQuery(".background_overlay").css('display', 'block');

    }



jQuery("#change-pincode").on('click', function(){
    jQuery("#pincodepop").css('display', 'block');
    jQuery(".background_overlay").css('display', 'block');

    jQuery( "#pincodepop" ).prepend( "<a id='pinpopclose'>X</a>" );
});



jQuery(document).on("click", '#pinpopclose', function(event) { 
    jQuery("#pincodepop").css('display', 'none');
    jQuery(".background_overlay").css('display', 'none');
});



jQuery("#pincode-city").on('keyup', function(){
    var min_length = 3;
    var keyword = jQuery('#pincode-city').val();
    var data = {
        'action': 'citylist',
        'keyword': keyword
    };

    var interval;
    clearTimeout(interval);
    interval = setTimeout(function() {

    if (keyword.length >= min_length) {

        jQuery('#pincode-city').css('background','url('+pincode_data.theme_url+'/images/pinloader.gif) no-repeat');
        jQuery('#pincode-city').css('background-position','right center');

        jQuery('#pincodelistwrap').hide();

        jQuery.ajax({
            url: pincode_data.ajax_url,
            type: 'POST',
            data: data,
            success:function(data){
                jQuery('#pincode-city').css('background','none');

                jQuery('#pincode_city_list').show();
                jQuery('#pincode_city_list').html(data);
            }
        });
    } else {
        jQuery('#pincode_city_list').hide();
    }

    }, 1000)

 });




jQuery(document).on("click", '.pin_city', function(event) { 

    var city = jQuery(this).attr("data-city");
    jQuery('#pincode-city').val(city);
    jQuery('#pincode_city_list').hide();

    var data = {
        'action': 'pinlist',
        'city': city
    };

    jQuery('#pincode_city_list').hide();

    jQuery('#pinlist_loader').show();

    jQuery.ajax({
            url: pincode_data.ajax_url,
            type: 'POST',
            data: data,
            success:function(data){
                jQuery('#pinlist_loader').hide();

                jQuery('#pincodelistwrap').show();

                jQuery('#pincodelistwrap').html(data);
            }
        });


});





jQuery(document).on("click", '.pin_code', function(event) { 

    var pincode = jQuery(this).attr("data-pincode");
    var city = jQuery('#pincode-city').val();

  // if (jQuery.cookie('user_pincode') == null ){
                jQuery.cookie('user_pincode', pincode, { expires: 365, path: '/' });
                jQuery.cookie('user_city', city, { expires: 365, path: '/' });
                jQuery("#pincodepop").css('display', 'none');
                jQuery(".background_overlay").css('display', 'none');
                
                jQuery("#content").html("<div id='pre-loader'></div>");
                
                location.reload();
           // }
});







jQuery("#set_all_seller").on('click', function(){
    var setseller = jQuery(this).attr("data-seller");
    var data = {
        'action': 'allseller',
        'setseller': setseller
    };

    jQuery("#content").html("<div id='pre-loader'></div>");

jQuery.ajax({
            url: pincode_data.ajax_url,
            type: 'POST',
            data: data,
            success:function(data){
               location.reload(); 
            }
        });


});
*/












jQuery(".checkout-button").on('click', function(event){

    event.preventDefault();

   if (pincode_data.hasOwnProperty("pincode")) {

    jQuery(".check-preload").css('display', 'inline-block');


   check_unavailable_pincodes(pincode_data.pincode);



}else{
   //event.preventDefault();
   jQuery("#pincodepop").css('display', 'block');
   jQuery(".background_overlay").css('display', 'block'); 
}

});







jQuery("#pincode-chk").on('click', function(){

    jQuery('#nonavailable-list').empty();

    var pincode = jQuery("#pincode").val();
    var reg = /^[0-9]+$/;

    if (pincode == ''){
        alert('Pincode cannot be empty.');
    }else if (!reg.test(pincode)){
        alert('Pincode should be numbers only.');
    }else if ((pincode.length)< 6 || (pincode.length)>6 ){
        alert('Pincode should only be 6 digits');
    }else{

        jQuery('#pinlist_loader').show();

        check_unavailable_products(pincode);

        

    }
});








function check_unavailable_products(pincode){
var data = {
            'action': 'pincode_session',
            'pincode': pincode
        };



        jQuery.ajax({
            url: pincode_data.ajax_url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success:function(response){
             
             jQuery('#pinlist_loader').hide();
             
             if(response.status == 'false'){

                jQuery('.product-unavailable').show();

                 jQuery('#nonavailable-list').empty();

                $.each(response.products, function(k, v) {
                    jQuery('#nonavailable-list').append('<li>'+v+'</li>');
                });

             }else{
                jQuery("#pincodepop").css('display', 'none');
                jQuery(".background_overlay").css('display', 'none');

                //jQuery("#cart-form").submit();
                window.location.replace(pincode_data.checkout_url);
             }

            
         }
     });
}










function check_unavailable_pincodes(pincode){
var data = {
            'action': 'pincode_session',
            'pincode': pincode
        };

        jQuery.ajax({
            url: pincode_data.ajax_url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success:function(response){

            jQuery(".check-preload").css('display', 'none');
             
             jQuery('#pinlist_loader').hide();
             
             if(response.status == 'false'){

                jQuery("#pincodepop").css('display', 'block');
                jQuery(".background_overlay").css('display', 'block');

                 jQuery('.product-unavailable').show();

                 jQuery('#nonavailable-list').empty();
                
                $.each(response.products, function(k, v) {
                    jQuery('#nonavailable-list').append('<li>'+v+'</li>');
                });

             }else{
                jQuery("#pincodepop").css('display', 'none');
                jQuery(".background_overlay").css('display', 'none');

                //jQuery("#cart-form").submit();
                window.location.replace(pincode_data.checkout_url);
             }

            
         }
     });
}









jQuery("#pincode-pop-close").on('click', function(){
    jQuery("#pincodepop").css('display', 'none');
    jQuery(".background_overlay").css('display', 'none');
});










jQuery(".wmp-cart-btn").on('click', function(event){
event.preventDefault();

var product_id = jQuery(this).attr("data-product-id");
var seller_id = jQuery(this).attr("data-seller-id");


 if (pincode_data.hasOwnProperty("pincode")) {

  //check if product available for pincode

jQuery(".product-avail-error").css('display', 'none');
jQuery("#pincode_ent2").css('display', 'none');


jQuery("#pinpop").css('display', 'block');
jQuery(".background_overlay").css('display', 'block');
jQuery('html, body').animate({ scrollTop: jQuery("#pinpop").offset().top }, 100);

var single_product = 'false';

wmp_add_to_cart(pincode_data.pincode,product_id, seller_id, single_product);

}else{

jQuery(".product-avail-error").empty();
jQuery(".product-avail-error").css('display', 'none');
jQuery("#pincode_ent2").css('display', 'block');

jQuery("#pinpop").css('display', 'block');
jQuery(".background_overlay").css('display', 'block');
jQuery('html, body').animate({ scrollTop: jQuery("#pinpop").offset().top }, 100);

 
jQuery("#pincode-chk-list").removeAttr("data-product-id");
jQuery("#pincode-chk-list").removeAttr("data-seller-id");
jQuery("#pincode-chk-list").removeAttr("data-single-product");

jQuery("#pincode-chk-list").attr("data-product-id",product_id);
jQuery("#pincode-chk-list").attr("data-seller-id",seller_id);
jQuery("#pincode-chk-list").attr("data-single-product",'false');

//set pincode session and check if product available for pincode

}

});






jQuery("#pincode-chk-list").on('click', function(){

    var product_id = jQuery(this).attr("data-product-id");
    var seller_id = jQuery(this).attr("data-seller-id");
    var single_product = jQuery(this).attr("data-single-product");

   
    jQuery('#nonavailable-list').empty();

    var pincode = jQuery("#pincode2").val();
    var reg = /^[0-9]+$/;

    if (pincode == ''){
        alert('Pincode cannot be empty.');
    }else if (!reg.test(pincode)){
        alert('Pincode should be numbers only.');
    }else if ((pincode.length)< 6 || (pincode.length)>6 ){
        alert('Pincode should only be 6 digits');
    }else{

         wmp_add_to_cart(pincode,product_id, seller_id, single_product);

         //jQuery.cookie('pincode', pincode, { expires: 365, path: '/' });

    }
});










function wmp_add_to_cart(pincode,product_id,seller_id,single_product){
var data = {
            'action': 'available_pincode_product',
            'pincode': pincode,
            'seller_id': seller_id,
            'product_id': product_id
        };

        jQuery('#pinlist_loader2').show();

        jQuery.ajax({
            url: pincode_data.ajax_url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success:function(response){

                

                      
             jQuery('#pinlist_loader2').hide();
             
             if(response.status == 'false'){

                console.log('false');


              
              jQuery("#pincode_ent2").css('display', 'none');


            jQuery(".product-avail-error").empty();
              jQuery(".product-avail-error").css('display', 'block');
              jQuery(".product-avail-error").append(response.message);

              var pinchange = response.pinchange;
               jQuery(".product-avail-error").append('<div class="pincode-btn"><button id="pincode-list-close" '+pinchange+'>CLOSE</button></div>');
                
              }else if(response.status == 'true'){

                
                jQuery("#pinpop").css('display', 'none');
                jQuery(".background_overlay").css('display', 'none');

                
                
                if (pincode_data.hasOwnProperty("product_id")) {
                    jQuery(".cart").submit();
                }else{
                   /*var urlWithoutHash = window.location.href.split("?")[0];
                window.location.replace(urlWithoutHash+'?add-to-cart='+product_id);*/ 


                var crtid = '.singlecart'+product_id;
                var ptype = jQuery(crtid).find('input[name="ptype"]').val();
                var plink = jQuery(crtid).find('input[name="plink"]').val();
                if(ptype == 'simple'){
                jQuery(crtid).submit();
            }else{
               var urlWithoutHash = window.location.href.split("?")[0];
                window.location.replace(plink); 
            }
                }

                /*if(single_product == 'false'){
                var urlWithoutHash = window.location.href.split("?")[0];
                window.location.replace(urlWithoutHash+'?add-to-cart='+product_id);
                           
                }else{
                    jQuery(".cart").submit();
                }*/

                
             }

            
         }
     });
}




//pincode change function
jQuery(document).on( 'click', '.pincode-change', function() {


var product_id = jQuery(this).attr("data-product-id");
    var seller_id = jQuery(this).attr("data-seller-id");

    jQuery("#pincode-chk-list").removeAttr("data-product-id");
jQuery("#pincode-chk-list").removeAttr("data-seller-id");

jQuery("#pincode-chk-list").attr("data-product-id",product_id);
jQuery("#pincode-chk-list").attr("data-seller-id",seller_id);

//jQuery("#pincode-chk-list").attr("data-single-product",'false');


    jQuery(".product-avail-error").empty();
    jQuery(".product-avail-error").css('display', 'none');
    jQuery("#pincode_ent2").css('display', 'block');
});



//popup close function
jQuery(document).on( 'click', '#pincode-list-close', function() {
    jQuery("#pinpop").css('display', 'none');
    jQuery(".background_overlay").css('display', 'none');
    var pinchanged = jQuery(this).attr("data-pinchanged");
    if(pinchanged == 'true'){
    var urlWithoutHash = window.location.href.split("?")[0];
    window.location.replace(urlWithoutHash);
    }
});



//popup close function
jQuery(document).on( 'click', '#pincode-chk-cancel', function() {
    jQuery("#pinchangepop").css('display', 'none');
    jQuery(".background_overlay").css('display', 'none');
});





jQuery("#change-pincode-list").on('click', function(){

jQuery("#pinchangepop").css('display', 'block');
jQuery(".background_overlay").css('display', 'block');
jQuery('html, body').animate({ scrollTop: jQuery("#pinchangepop").offset().top }, 100);

});





jQuery("#pincode-chk-list2").on('click', function(){

var pincode = jQuery("#pincode3").val();
    var reg = /^[0-9]+$/;

    if (pincode == ''){
        alert('Pincode cannot be empty.');
    }else if (!reg.test(pincode)){
        alert('Pincode should be numbers only.');
    }else if ((pincode.length)< 6 || (pincode.length)>6 ){
        alert('Pincode should only be 6 digits');
    }else{

         
         var data = {
            'action': 'wmp_change_pincode',
            'pincode': pincode            
        };

        jQuery('#pinlist_loader3').show();

        jQuery.ajax({
            url: pincode_data.ajax_url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success:function(response){
                jQuery('#pinlist_loader3').hide();
                jQuery("#pinchangepop").css('display', 'none');
                jQuery(".background_overlay").css('display', 'none');
                var urlWithoutHash = window.location.href.split("?")[0];
                window.location.replace(urlWithoutHash);
            }

        });

    }

});         









jQuery(".single_add_to_cart_button").on('click', function(event){
event.preventDefault();

var product_id = pincode_data.product_id;
var seller_id = pincode_data.seller_id;


if (pincode_data.hasOwnProperty("pincode")) {

  //check if product available for pincode

jQuery(".product-avail-error").css('display', 'none');
jQuery("#pincode_ent2").css('display', 'none');

jQuery("#pinpop").css('display', 'block');
jQuery(".background_overlay").css('display', 'block');
jQuery('html, body').animate({ scrollTop: jQuery("#pinpop").offset().top }, 100);

var single_product = 'true';

wmp_add_to_cart(pincode_data.pincode,product_id, seller_id, single_product);

}else{

jQuery(".product-avail-error").empty();
jQuery(".product-avail-error").css('display', 'none');
jQuery("#pincode_ent2").css('display', 'block');

jQuery("#pinpop").css('display', 'block');
jQuery(".background_overlay").css('display', 'block');
jQuery('html, body').animate({ scrollTop: jQuery("#pinpop").offset().top }, 100);

 
jQuery("#pincode-chk-list").removeAttr("data-product-id");
jQuery("#pincode-chk-list").removeAttr("data-seller-id");
jQuery("#pincode-chk-list").removeAttr("data-single-product");

jQuery("#pincode-chk-list").attr("data-product-id",product_id);
jQuery("#pincode-chk-list").attr("data-seller-id",seller_id);
jQuery("#pincode-chk-list").attr("data-single-product",'true');

//set pincode session and check if product available for pincode

}


});










});