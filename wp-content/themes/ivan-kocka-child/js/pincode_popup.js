jQuery(document).ready(function(){


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










});