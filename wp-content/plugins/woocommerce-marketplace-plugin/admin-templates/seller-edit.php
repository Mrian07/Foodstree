<?php


$user_id = $_GET['seller'];

$action = $_GET['action'];

$current_user = wp_get_current_user();

if (get_user_meta( $user_id, 'seller_activate', true )=='1'){
	$activate='1';
}else{
	$activate='0';
}


wp_enqueue_script('user-profile');



switch ($action) {
case 'update':


if ( !current_user_can('edit_user', get_current_user_id()) )
	wp_die(__('You do not have permission to edit this seller.','wmp'));


	do_action( 'edit_user_profile_update', $user_id );



	$errors = edit_user($user_id);


if ( !is_wp_error( $errors ) ) {
	$redirect = '?page=edit-seller&action=update&updated=1&seller=' . $user_id;
	wp_redirect($redirect);
	exit;
}

default:
$profileuser = get_user_to_edit($user_id);

if ( !current_user_can('edit_user',get_current_user_id()) )
	wp_die(__('You do not have permission to edit this seller.'));


?>


<?php if ( isset($_GET['updated']) ) : ?>
	<div id="message" class="updated">
		<p><strong><?php _e('Seller updated.') ?></strong></p>
	</div>
<?php endif; ?>


<?php if ( isset( $errors ) && is_wp_error( $errors ) ) : ?>
<div class="error"><p><?php echo implode( "</p>\n<p>", $errors->get_error_messages() ); ?></p></div>
<?php endif; ?>



<div class="wrap">
<h2 id="edit-seller"> <?php
if ( current_user_can( 'edit_user', get_current_user_id()) ) {
	echo _x( 'Edit Seller', 'wmp' ).'<a class="add-new-h2">'.$profileuser->user_login.'</a>';
} ?>
</h2>
<?php
/**
 * Fires inside the your-profile form tag on the user editing screen.
 *
 * @since 3.0.0
 */
?>
<form id="your-profile" enctype="multipart/form-data" action="<?php echo '?page=edit-seller&action=update&updated=1&seller=' . $user_id; ?>" method="post" novalidate="novalidate"<?php do_action( 'user_edit_form_tag' ); ?>>
<?php wp_nonce_field('update-user_' . $user_id) ?>
<p>
<input type="hidden" name="from" value="profile" />
<input type="hidden" name="checkuser_id" value="<?php echo get_current_user_id(); ?>" />
</p>




<h3><?php _e('Name') ?></h3>

<table class="form-table">

    <?php
    	wp_enqueue_script(
		'jquery_form_js',
		plugins_url( '/js/form/jquery.form.js' , __FILE__ ),
		array( 'jquery' )
	);
    ?>
	<tr>
		<th><label for="seller_name"><?php _e('Seller Name'); ?></label></th>
		<td><input type="text" name="seller_name" id="seller_name" value="<?php echo get_user_meta( $user_id, 'seller_name', true ); ?>" class="regular-text" /> <span class="description"></span></td>
	</tr>

	<tr>
		<th><label for="user_login"><?php _e('Username'); ?></label></th>
		<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr($profileuser->user_login); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e('Usernames cannot be changed.'); ?></span></td>
	</tr>



<!-- <tr>
	<th><label for="first_name"><?php _e('First Name') ?></label></th>
	<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($profileuser->first_name) ?>" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="last_name"><?php _e('Last Name') ?></label></th>
	<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($profileuser->last_name) ?>" class="regular-text" /></td>
</tr> -->




</table>

<h3><?php _e('Contact Info') ?></h3>

<table class="form-table">
<tr>
	<th><label for="email"><?php _e('E-mail'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
	<td><input type="email" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ) ?>" class="regular-text ltr" />
	<?php
	$new_email = get_option( $current_user->ID . '_new_email' );
	if ( $new_email && $new_email['newemail'] != $current_user->user_email && $profileuser->ID == $current_user->ID ) : ?>
	<div class="updated inline">
	<p><?php printf( __('There is a pending change of your e-mail to <code>%1$s</code>. <a href="%2$s">Cancel</a>'), $new_email['newemail'], esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) ) ); ?></p>
	</div>
	<?php endif; ?>
	</td>
</tr>

	<tr class="form-field">
		<th><label for="seller_address"><?php _e('Address') ?></label></th>
		<td><textarea name="seller_address" id="seller_address"><?php echo get_user_meta( $user_id, 'seller_address', true ); ?></textarea></td>
	</tr>


<tr>
	<th><label for="url"><?php _e('Website') ?></label></th>
	<td><input type="url" name="url" id="url" value="<?php echo esc_attr( $profileuser->user_url ) ?>" class="regular-text code" /></td>
</tr>


</table>





<h3><?php _e('Option') ?></h3>

<table class="form-table">


	<tr>
		<th scope="row"><label for="seller_activate"><?php _e('Activate Seller?') ?></label></th>
		<td><input type="checkbox" name="seller_activate" id="seller_activate" <?php checked( get_user_meta( $user_id, 'seller_activate', true ) ); ?>  value="1" /><span class="description"><?php _e('Activate/deactivate the seller.'); ?></span></td>

	</tr>

	

	

</table>


<?php echo $_POST['seller_activate']; ?>


<h3><?php echo __('Password','wmp'); ?></h3>

<table class="form-table">


<?php
/** This filter is documented in wp-admin/user-new.php */
$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
if ( $show_password_fields ) :
?>
<tr id="password">
	<th><label for="pass1"><?php _e( 'New Password' ); ?></label></th>
	<td>
		<input class="hidden" value=" " /><!-- #24364 workaround -->
		<input type="password" name="pass1" id="pass1" class="regular-text" size="16" value="" autocomplete="off" /><br />
		<span class="description"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.' ); ?></span>
	</td>
</tr>
<tr>
	<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password' ); ?></label></th>
	<td>
	<input name="pass2" type="password" id="pass2" class="regular-text" size="16" value="" autocomplete="off" /><br />
	<span class="description" for="pass2"><?php _e( 'Type your new password again.' ); ?></span>
	<br />
	<div id="pass-strength-result"><?php _e( 'Strength indicator' ); ?></div>
	<p class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; ).' ); ?></p>
	</td>
</tr>
<?php endif; ?>
</table>

<?php
	if ( IS_PROFILE_PAGE ) {
		/**
		 * Fires after the 'About Yourself' settings table on the 'Your Profile' editing screen.
		 *
		 * The action only fires if the current user is editing their own profile.
		 *
		 * @since 2.0.0
		 *
		 * @param WP_User $profileuser The current WP_User object.
		 */
		do_action( 'show_user_profile', $profileuser );
	} else {
		/**
		 * Fires after the 'About the User' settings table on the 'Edit User' screen.
		 *
		 * @since 2.0.0
		 *
		 * @param WP_User $profileuser The current WP_User object.
		 */
		do_action( 'edit_user_profile', $profileuser );
	}
?>



<input type="hidden" name="action" value="update" />
<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($user_id); ?>" />

<?php submit_button( __('Update Seller') ); ?>





</form>
    
<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" enctype="multipart/form-data" id="pincode_csv_upload" >  
 <table class="form-table">
   
    <tr class="form-field">
                <?php wp_nonce_field('seller_pincode_upload','pincode_upload_ajax_nonce'); ?>
                 <input type='hidden' name='action' value='pincode_csv_upload'/>
                 <input type='hidden' name='csv_component' value='seller_pincodes'/>
		<th scope="row"><label for="seller_pincode_list"><?php _e('Update pincode list') ?></label></th>
		<td><input type="file" name="csv_file" id="seller_pincode_list" /><button type="submit" class="btn" id="pin-upload-submit">Upload</button><span class="description"><?php _e('Update pincode list where the seller ships items. Only CSV supported.'); ?></span></td>

	</tr>
 </table>
</form>
 
 <table class="form-table">
        <tr>
            <td id='csv-import-response' colspan="2">
                
            </td> 
        </tr>
 </table>    
    
</div>
<?php
break;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function() {        
    
        jQuery('#pincode_csv_upload').on('submit', function(e){
            
            var user_id =  jQuery('#your-profile #user_id').val();
            var options = { 
                  target:         '#csv-import-response',
                  resetForm:      true        // reset the form after successful submit    
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
                                      //jQuery("#log_view").html('Error CSV file already imported!!');                                      
                                      clearInterval(check_csv_import_progress);
                                  }else{
                                        if(data.totalparts == data.totalcompleted){ 
                                            jQuery(_this).prop('disabled', false);
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
        
        
    
    }); 
    
	if (window.location.hash == '#password') {
		document.getElementById('pass1').focus();
	}    
</script>
