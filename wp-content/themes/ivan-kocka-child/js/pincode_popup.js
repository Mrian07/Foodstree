jQuery(document).ready(function(){


    if (jQuery.cookie('user_pincode') == null ){

        jQuery("#pincodepop").css('display', 'block');
        jQuery(".background_overlay").css('display', 'block');
    }
    
    jQuery("#pincode-btn").on('click', function(){

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


    });

});