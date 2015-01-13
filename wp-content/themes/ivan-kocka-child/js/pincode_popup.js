jQuery(document).ready(function(){


    if (jQuery.cookie('user_pincode') == null ){

        jQuery("#pincodepop").css('display', 'block');
        jQuery(".background_overlay").css('display', 'block');
    }



    
    /*jQuery("#pincode-btn").on('click', function(){

        var pincode = jQuery("#pincode").val();
        var reg = /^[0-9]+$/;

        if (pincode == ''){
            alert('Pincode cannot be empty.');
        }else if (!reg.test(pincode)){
            alert('Pincode should be numbers only.');
        }else if ((pincode.length)< 6 || (pincode.length)>6 ){
            alert('Pincode should only be 6 digits');
        }else{

            if (jQuery.cookie('user_pincode') == null ){
                jQuery.cookie('user_pincode', pincode, { expires: 365, path: '/' });
                jQuery("#pincodepop").css('display', 'none');
                jQuery(".background_overlay").css('display', 'none');
                
                jQuery("#content").html("<div id='pre-loader'></div>");
                
                location.reload();
            }

        }


    });*/






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

   if (jQuery.cookie('user_pincode') == null ){
                jQuery.cookie('user_pincode', pincode, { expires: 365, path: '/' });
                jQuery.cookie('user_city', city, { expires: 365, path: '/' });
                jQuery("#pincodepop").css('display', 'none');
                jQuery(".background_overlay").css('display', 'none');
                
                jQuery("#content").html("<div id='pre-loader'></div>");
                
                location.reload();
            }
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





});