    jQuery(document).ready(function() { 


      //check if form submitted and billing clone checked, then hide biling address wraper
      if(jQuery('#seller_billing_yes').prop('checked')){
        jQuery('#billing_adddress_wrap').hide();
      }       
    
        jQuery('#pincode_upload_block').css('display','none');
        
        jQuery('#pincode_csv_upload').on('submit', function(e){
           jQuery('#pre-loader-response').show();
            var options = { 
                  target:         '#csv-import-response',
                  resetForm:      true,        // reset the form after successful submit    
                  success: function(){
                      jQuery('#pre-loader-response').hide();
                  },
              }
              
              jQuery(this).ajaxSubmit(options);
              
            e.preventDefault();
        });  
        
        jQuery('#confirm_csv_import').live('submit', function(e){
            jQuery(this).attr('action', ajaxurl);
            var user_id =  jQuery('#your-profile #user_id').val();
            data ={};
            data['user_id'] = user_id;
            data['action'] = 'pincode_csv_upload_confirm';
            jQuery('#pre-loader-response').show();
            //console.log(data);
            var options = { // target element(s) to be updated with server response
                  data : data,
                  resetForm:      true,        // reset the form after successful submit    
                  dataType: 'json',
                  success: afterConfirmSuccess,
              }
              
            jQuery(this).ajaxSubmit(options);
              
            e.preventDefault();
         }); 
         
         function afterConfirmSuccess (response){
             jQuery('#pre-loader-response').hide();
             console.log(response.csv_id);
             var html_markup = "<div><p>To Start import click on the 'Import Start' button</p><input type='hidden' name='csv-master-id' id='csv-master-id' value='"+response.csv_id+"' /><input type='button' name='import-csv-start' id='import-csv-start' value='Import Start' /><div id='log_view'></div></div>";
        
            jQuery('#csv-import-response').html(html_markup);
         }
         
         jQuery("#import-csv-start").live('click',function(){
                 jQuery(this).prop('disabled', true); 
                 jQuery("#log_view").html('Please Wait Import in progress..'); 
                 var csv_id = jQuery('#csv-master-id').val();
                 var _this = jQuery(this);
                 var check_csv_import_progress = setInterval(function()
                              {
                                jQuery.post( ajaxurl,
                                {
                                  action    : 'ajci_csv_check_progress',
                                  csv_id    : csv_id,
                                },
                                function(data) { 
                                  console.log(data);
                                  if(data.code ==='ERROR'){
                                      jQuery(_this).prop('disabled', false);
                                      jQuery("#log_view").html('Error CSV file already imported!!');                                      
                                      clearInterval(check_csv_import_progress);
                                  }else{
                                        if(data.totalparts == data.totalcompleted){ 
                                            jQuery(_this).prop('disabled', false);
                                            jQuery('#pincode_upload_block').css('display','none');
                                            var logstable = '<table>';
                                            if(data.log_paths.success != ''){
                                                logstable = logstable+'<tr><td>Successfull Import</td><td><a href="'+data.log_paths.success+'" target="_blank">View Log</a></td></tr>';
                                            }
                                            if(data.log_paths.error != ''){
                                                logstable = logstable+'<tr><td>Failed Import</td><td><a href="'+data.log_paths.error+'" target="_blank">View Log</a></td></tr>';
                                            }
                                            logstable = logstable+'</table>';
                                            jQuery("#log_view").html(data.totalcompleted+' parts out of '+data.totalparts+' completed'+logstable); 
                                            clearInterval(check_csv_import_progress);
                                        }else{
                                            jQuery("#log_view").html(data.totalcompleted+' parts out of '+data.totalparts+' completed'); 
                                        } 
                                    }
                                },'json');  

                              }, 15000);                         

           });
        
         jQuery('#reset-seller-pincode').on('click', function(e){
            var r = confirm("Confirm Reset Seller Pincodes.");
            if(r == true){
                jQuery(this).prop('disabled', true); 
                var _this = jQuery(this);
                jQuery("#rst-response").html('Please Wait Resetting in progress..'); 

                var user_id =  jQuery('#your-profile #user_id').val();
                jQuery.post( ajaxurl,
                  {
                    action    : 'reset_seller_pincodes',
                    user_id    : user_id,
                  },
                  function(data) { 
                    console.log(data);
                    if(data.code ==='ERROR'){
                        jQuery(_this).prop('disabled', false);
                        jQuery("#rst-response").html('Error reseting seller pincodes'); 
                    }else{
                        jQuery('#pincode_upload_block').css('display','');
                        jQuery(_this).prop('disabled', false);
                        jQuery("#rst-response").html('Pincodes reseted for seller'); 
                      }
                  },'json');  
           }
        }); 
        
        jQuery('#pin-search').on('click', function(e){
            var pincode = jQuery('#pincode_str').val();
            var user_id =  jQuery('#your-profile #user_id').val();
            
            var reg = /^[0-9]+$/;

            if (pincode == ''){
                alert('Pincode cannot be empty.');
                return false;
            }else if (!reg.test(pincode)){
                alert('Pincode should be numbers only.');
                return false;
            }else if ((pincode.length)< 6 || (pincode.length)>6 ){
                alert('Pincode should only be 6 digits');
                return false;
            }else{
            
            jQuery.post( ajaxurl,
             {
               action    : 'get_seller_pincode_info',
               user_id    : user_id,
               pincode : pincode
             },
             function(data) { 
               console.log(data);
               if(data.code ==='OK'){
                   jQuery("#pin-search-response").html(data.msg); 
               }
             },'json');  
             
            }
            
        });






jQuery('#seller_billing_yes').change(function() {
    jQuery('#billing_adddress_wrap').toggle(!this.checked);

    if (jQuery(this).prop('checked')==true){ 
      jQuery('#seller_billing_address').val(jQuery('#seller_address').val());
      jQuery('#seller_billing_city').val(jQuery('#seller_city').val());
      jQuery('#seller_billing_pincode').val(jQuery('#seller_pincode').val());
      jQuery('#seller_billing_state').val(jQuery('#seller_state').val());
      var country = jQuery('#seller_country option:selected').val();
      jQuery('#seller_billing_country option[value=' + country + ']').attr('selected','selected');
    }else{
      jQuery('#seller_billing_address').val("");
      jQuery('#seller_billing_city').val("");
      jQuery('#seller_billing_pincode').val("");
      jQuery('#seller_billing_state').val("");
      jQuery('#seller_billing_country option[value=India]').attr('selected','selected');
    }


  });






jQuery("#your-profile").validate({
  
rules: {
            seller_display_name: "required",
            first_name: "required",
            last_name: "required",
            seller_name: "required",
            email: {
                required: true,
                email: true
            },
            mobile_number: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            seller_address: "required",
            seller_city: "required",
            seller_pincode: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 6
            },
            seller_billing_pincode: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 6
            },
            seller_state: "required",
            seller_country: "required",
            seller_billing_address: "required",
            seller_billing_city: "required",
            seller_billing_state: "required",
            seller_billing_country: "required",
            seller_pan: "required",
            seller_vat: "required",
            seller_rtgs: "required",
            seller_beneficiary: "required",
            seller_account_number: {
                required: true,
                number: true
             },
            seller_account_type: "required",
            seller_company_description: {
                  required: false,
                  minlength: 50
            }

            },

             
        submitHandler: function(form) {
            form.submit();
        }

});







  jQuery("#createuser").validate({
  
rules: {
            seller_display_name: "required",
            first_name: "required",
            last_name: "required",
            seller_name: "required",
            email: {
                required: true,
                email: true
            },
            mobile_number: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            seller_address: "required",
            seller_city: "required",
            seller_pincode: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 6
            },
            seller_billing_pincode: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 6
            },
            seller_state: "required",
            seller_country: "required",
            seller_billing_address: "required",
            seller_billing_city: "required",
            seller_billing_state: "required",
            seller_billing_country: "required",
            seller_pan: "required",
            seller_vat: "required",
            seller_rtgs: "required",
            seller_beneficiary: "required",
            seller_account_number: {
                required: true,
                number: true
             },
            seller_account_type: "required",
            seller_company_description: {
                  required: false,
                  minlength: 50
            },
            //seller_pan_copy: "required",
            //seller_cancelled_cheque: "required",
            user_login: "required",
            pass1: "required",
            pass2: "required"
            },

               
        submitHandler: function(form) {
            form.submit();
        }

});




    
    }); 