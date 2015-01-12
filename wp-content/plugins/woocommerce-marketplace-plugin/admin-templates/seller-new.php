<?php
/**
 * New User Administration Screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
//require_once( ABSPATH . '\wp-admin\admin.php');

if ( ! current_user_can( 'create_users' ) ) {
	wp_die( __( 'Cheatin&#8217; uh?' ) );
}



if ( isset($_REQUEST['action']) && 'createuser' == $_REQUEST['action'] ) {
	check_admin_referer( 'create-user', '_wpnonce_create-user' );

	if ( ! current_user_can('create_users') )
		wp_die(__('Cheatin&#8217; uh?'));

	//if ( ! is_multisite() ) {
		$user_id = edit_user();

/*echo '<pre>';
print_r($_POST);
echo '</pre>';

echo '<pre>';
print_r($_FILES);
echo '</pre>';*/

//echo get_permalink( '296' );
		

		if ( is_wp_error( $user_id ) ) {
			$add_user_errors = $user_id;
		} else {

if ( is_multisite() ) {
$user = get_userdata( $user_id );
$user->set_role('seller');
}

			if ( current_user_can( 'list_users' ) )
				$redirect = '?page=sellers&update=add&id=' . $user_id;

			else
				$redirect = add_query_arg( 'update', 'add', '?page=add-new-seller' );
			wp_redirect( $redirect );
			die();
		}
	//} 
}


wp_enqueue_script('wp-ajax-response');
wp_enqueue_script('user-profile');



//require_once( ABSPATH . 'wp-admin/admin-header.php' );


?>
<div class="wrap">
<h2 id="add-new-user"> <?php
if ( current_user_can( 'create_users' ) ) {
	echo _x( 'Add New Seller', 'wmp' );
} ?>
</h2>

<?php if ( isset($errors) && is_wp_error( $errors ) ) : ?>
	<div class="error">
		<ul>
		<?php
			foreach ( $errors->get_error_messages() as $err )
				echo "<li>$err</li>\n";
		?>
		</ul>
	</div>
<?php endif;

if ( ! empty( $messages ) ) {
	foreach ( $messages as $msg )
		echo '<div id="message" class="updated"><p>' . $msg . '</p></div>';
} ?>

<?php if ( isset($add_user_errors) && is_wp_error( $add_user_errors ) ) : ?>
	<div class="error">
		<?php
			foreach ( $add_user_errors->get_error_messages() as $message )
				echo "<p>$message</p>";
		?>
	</div>
<?php endif; ?>
<div id="ajax-response"></div>



<?php

//echo get_admin_url().'users.php?update=add&id=' . $user_id;

if ( current_user_can( 'create_users') ) {
	
?>
<p><?php _e('Create a seller and add them to this store.'); ?></p>
<?php /** This action is documented in wp-admin/user-new.php */ ?>
<form action="" method="post" name="createuser" id="createuser" class="validate" enctype="multipart/form-data" novalidate="novalidate"<?php do_action( 'user_new_form_tag' );?>>
<input name="action" type="hidden" value="createuser" />
<?php wp_nonce_field( 'create-user', '_wpnonce_create-user' ); ?>
<?php
// Load up the passed data, else set to a default.
$creating = isset( $_POST['createuser'] );

$new_company_info = $creating && isset( $_POST['company_info'] ) ? wp_unslash( $_POST['company_info'] ) : '';
$new_seller_name = $creating && isset( $_POST['seller_name'] ) ? wp_unslash( $_POST['seller_name'] ) : '';
$new_first_name = $creating && isset( $_POST['first_name'] ) ? wp_unslash( $_POST['first_name'] ) : '';
$new_last_name = $creating && isset( $_POST['last_name'] ) ? wp_unslash( $_POST['last_name'] ) : '';
$new_user_login = $creating && isset( $_POST['user_login'] ) ? wp_unslash( $_POST['user_login'] ) : '';
$new_user_email = $creating && isset( $_POST['email'] ) ? wp_unslash( $_POST['email'] ) : '';
$new_mobile_number = $creating && isset( $_POST['mobile_number'] ) ? wp_unslash( $_POST['mobile_number'] ) : '';
$new_user_uri = $creating && isset( $_POST['url'] ) ? wp_unslash( $_POST['url'] ) : '';
$new_seller_address = $creating && isset( $_POST['seller_address'] ) ? wp_unslash( $_POST['seller_address'] ) : '';
$new_seller_city = $creating && isset( $_POST['seller_city'] ) ? wp_unslash( $_POST['seller_city'] ) : '';
$new_seller_pincode = $creating && isset( $_POST['seller_pincode'] ) ? wp_unslash( $_POST['seller_pincode'] ) : '';
$new_seller_state = $creating && isset( $_POST['seller_state'] ) ? wp_unslash( $_POST['seller_state'] ) : '';


$new_seller_pan = $creating && isset( $_POST['seller_pan'] ) ? wp_unslash( $_POST['seller_pan'] ) : '';
$new_seller_vat = $creating && isset( $_POST['seller_vat'] ) ? wp_unslash( $_POST['seller_vat'] ) : '';
$new_seller_rtgs = $creating && isset( $_POST['seller_rtgs'] ) ? wp_unslash( $_POST['seller_rtgs'] ) : '';
$new_seller_beneficiary = $creating && isset( $_POST['seller_beneficiary'] ) ? wp_unslash( $_POST['seller_beneficiary'] ) : '';
$new_seller_account_number = $creating && isset( $_POST['seller_account_number'] ) ? wp_unslash( $_POST['seller_account_number'] ) : '';
$new_seller_account_type = $creating && isset( $_POST['seller_account_type'] ) ? wp_unslash( $_POST['seller_account_type'] ) : '';
$new_seller_bank_name = $creating && isset( $_POST['seller_bank_name'] ) ? wp_unslash( $_POST['seller_bank_name'] ) : '';
$new_seller_branch_name = $creating && isset( $_POST['seller_branch_name'] ) ? wp_unslash( $_POST['seller_branch_name'] ) : '';
$new_seller_registration = $creating && isset( $_POST['seller_registration'] ) ? wp_unslash( $_POST['seller_registration'] ) : '';
$new_seller_tan = $creating && isset( $_POST['seller_tan'] ) ? wp_unslash( $_POST['seller_tan'] ) : '';
$new_seller_company_description = $creating && isset( $_POST['seller_company_description'] ) ? wp_unslash( $_POST['seller_company_description'] ) : '';


$new_seller_pincode_list = $creating && isset( $_POST['seller_pincode_list'] ) ? wp_unslash( $_POST['seller_pincode_list'] ) : '';
$new_seller_activate = $creating && isset( $_POST['seller_activate'] ) ? wp_unslash( $_POST['seller_activate'] ) : '';
$new_user_role = $creating && isset( $_POST['role'] ) ? wp_unslash( $_POST['role'] ) : '';
$new_user_send_password = $creating && isset( $_POST['send_password'] ) ? wp_unslash( $_POST['send_password'] ) : '';
$new_user_ignore_pass = $creating && isset( $_POST['noconfirmation'] ) ? wp_unslash( $_POST['noconfirmation'] ) : '';

?>
<table class="form-table">

	<tr class="form-field form-required">
		<th scope="row"><label for="company_info"><?php _e('Company Information'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="company_info" type="text" id="company_info" value="<?php echo esc_attr($new_company_info); ?>" aria-required="true" /></td>
	</tr>
	

	<tr class="form-field form-required">
		<th scope="row"><label for="first_name"><?php _e('First Name'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="first_name" type="text" id="first_name" value="<?php echo esc_attr($new_first_name); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="last_name"><?php _e('Last Name'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="last_name" type="text" id="last_name" value="<?php echo esc_attr($new_last_name); ?>" aria-required="true" /></td>
	</tr>

	

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_name"><?php _e('Company'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="seller_name" type="text" id="seller_name" value="<?php echo esc_attr($new_seller_name); ?>" aria-required="true" /></td>
	</tr>

	

	<tr class="form-field form-required">
		<th scope="row"><label for="email"><?php _e('Communication Email'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="email" type="email" id="email" value="<?php echo esc_attr( $new_user_email ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="mobile_number"><?php _e('Mobile Number') ?><span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="mobile_number" type="text" id="mobile_number" value="<?php echo esc_attr( $new_mobile_number ); ?>" aria-required="true" /></td>
	</tr>
	
	</table>

<hr />

	<h3><?php _e('Communication Address') ?></h3>

	<table class="form-table">

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_address"><?php _e('Company Registered Address') ?></label></th>
		<td><textarea name="seller_address" id="seller_address"><?php echo esc_attr( $new_seller_address ); ?></textarea></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_city"><?php _e('City') ?></label></th>
		<td><input name="seller_city" type="text" id="seller_city" value="<?php echo esc_attr($new_seller_city); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_pincode"><?php _e('Pincode') ?></label></th>
		<td><input name="seller_pincode" type="text" id="seller_pincode" value="<?php echo esc_attr($new_seller_pincode); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_state"><?php _e('State') ?></label></th>
		<td><input name="seller_state" type="text" id="seller_state" value="<?php echo esc_attr($new_seller_state); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_country"><?php _e('Country') ?></label></th>
		<td>
			<select name="seller_country" id="seller_country" aria-required="true">
				<option value="">Select Country..</option>
				<?php foreach(wmp_getCountries() as $key=>$value){ 
					$selected = ($value == 'India' ? 'selected' : '');
					?>
				<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
				<?php } ?>
			</select>
			</td>
	</tr>

	</table>



<hr />

<h3><?php _e('Billing Address') ?></h3>

	<table class="form-table">

	<tr>
		<th scope="row"><label for="seller_billing_yes"><?php _e('') ?></label></th>
		<td><input type="checkbox" name="seller_billing_yes" id="seller_billing_yes" value="1" <?php checked( $new_seller_activate ); ?> /> <?php _e('Check if billing address same as registered address'); ?></td>
	</tr>

	</table>


	<table class="form-table" id="billing_adddress_wrap" style="display:nonee;">
	
	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_address"><?php _e('Billing Address') ?></label></th>
		<td><textarea name="seller_billing_address" id="seller_billing_address"><?php echo esc_attr( $new_seller_billing_address ); ?></textarea></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_city"><?php _e('City') ?></label></th>
		<td><input name="seller_billing_city" type="text" id="seller_billing_city" value="<?php echo esc_attr($new_seller_billing_city); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_pincode"><?php _e('Pincode') ?></label></th>
		<td><input name="seller_billing_pincode" type="text" id="seller_billing_pincode" value="<?php echo esc_attr($new_seller_billing_pincode); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_state"><?php _e('State') ?></label></th>
		<td><input name="seller_billing_state" type="text" id="seller_billing_state" value="<?php echo esc_attr($new_seller_billing_state); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_country"><?php _e('Country') ?></label></th>
		<td>
			<select name="seller_billing_country" id="seller_billing_country" aria-required="true">
				<option value="">Select Country..</option>
				<?php foreach(wmp_getCountries() as $key=>$value){ 
					$selected = ($value == 'India' ? 'selected' : '');
					?>
				<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
				<?php } ?>
			</select>
			</td>
	</tr>

	
	</table>




<hr />


<h3><?php _e('Account Info') ?></h3>

<table class="form-table">


	<tr class="form-field form-required">
		<th scope="row"><label for="seller_pan"><?php _e('PAN') ?></label></th>
		<td><input name="seller_pan" type="text" id="seller_pan" value="<?php echo esc_attr( $new_seller_pan ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_vat"><?php _e('VAT/TIN/CST no.') ?></label></th>
		<td><input name="seller_vat" type="text" id="seller_vat" value="<?php echo esc_attr( $new_seller_vat ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_rtgs"><?php _e('RTGS/NEFT/IFSC Code') ?></label></th>
		<td><input name="seller_rtgs" type="text" id="seller_rtgs" value="<?php echo esc_attr( $new_seller_rtgs ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_beneficiary"><?php _e('Beneficiary name') ?></label></th>
		<td><input name="seller_beneficiary" type="text" id="seller_beneficiary" value="<?php echo esc_attr( $new_seller_beneficiary ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_account_number"><?php _e('Account number') ?></label></th>
		<td><input name="seller_account_number" type="text" id="seller_account_number" value="<?php echo esc_attr( $new_seller_account_number ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_account_type"><?php _e('Account type') ?></label></th>
		<td><input name="seller_account_type" type="text" id="seller_account_type" value="<?php echo esc_attr( $new_seller_account_type ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_bank_name"><?php _e('Bank Name') ?></label></th>
		<td><input name="seller_bank_name" type="text" id="seller_bank_name" value="<?php echo esc_attr( $new_seller_bank_name ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_branch_name"><?php _e('Branch Name') ?></label></th>
		<td><input name="seller_branch_name" type="text" id="seller_branch_name" value="<?php echo esc_attr( $new_seller_branch_name ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_registration"><?php _e('Company registration no.') ?></label></th>
		<td><input name="seller_registration" type="text" id="seller_registration" value="<?php echo esc_attr( $new_seller_registration ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_tan"><?php _e('TAN') ?></label></th>
		<td><input name="seller_tan" type="text" id="seller_tan" value="<?php echo esc_attr( $new_seller_tan ); ?>" /></td>
	</tr>

	</table>

	<hr />

	<table class="form-table">

	<tr class="form-field">
		<th scope="row"><label for="url"><?php _e('Website URL') ?></label></th>
		<td><input name="url" type="url" id="url" class="code" value="<?php echo esc_attr( $new_user_uri ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_company_description"><?php _e('Company Description') ?></label></th>
		<td><textarea name="seller_company_description" id="seller_company_description"><?php echo esc_attr( $new_seller_company_description ); ?></textarea></td>
	</tr>

</table>

<hr />

<h3><?php _e('Uploads') ?></h3>

<table class="form-table">


	<tr class="form-field form-required">
		<th scope="row"><label for="seller_logo"><?php _e('Company Logo') ?></label></th>
		<td><input name="seller_logo" type="file" id="seller_logo" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_pan_copy"><?php _e('PAN registration copy') ?></label></th>
		<td><input name="seller_pan_copy" type="file" id="seller_pan_copy" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_cancelled_cheque"><?php _e('Cancelled cheque copy') ?></label></th>
		<td><input name="seller_cancelled_cheque" type="file" id="seller_cancelled_cheque" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_tan_copy"><?php _e('TAN registration copy') ?></label></th>
		<td><input name="seller_tan_copy" type="file" id="seller_tan_copy" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_registration_copy"><?php _e('Company registration copy') ?></label></th>
		<td><input name="seller_registration_copy" type="file" id="seller_registration_copy" /></td>
	</tr>

</table>


<hr />



<table class="form-table">
	
<?php
if ( apply_filters( 'show_password_fields', true ) ) : ?>

	<tr class="form-field form-required">
		<th scope="row"><label for="user_login"><?php _e('Username'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="user_login" type="text" id="user_login" value="<?php echo esc_attr($new_user_login); ?>" aria-required="true" /></td>
	</tr>


	<tr class="form-field form-required">
		<th scope="row"><label for="pass1"><?php _e('Password'); ?> <span class="description"><?php /* translators: password input field */_e('(required)'); ?></span></label></th>
		<td>
			<input class="hidden" value=" " />
			<input name="pass1" type="password" id="pass1" autocomplete="off" />
		</td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"><label for="pass2"><?php _e('Repeat Password'); ?> <span class="description"><?php /* translators: password input field */_e('(required)'); ?></span></label></th>
		<td>
		<input name="pass2" type="password" id="pass2" autocomplete="off" />
		<br />
		<div id="pass-strength-result"><?php _e('Strength indicator'); ?></div>
		<p class="description indicator-hint"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; ).'); ?></p>
		</td>
	</tr>

	<tr>
		<th scope="row"><label for="seller_activate"><?php _e('Activate Seller?') ?></label></th>
		<td><input type="checkbox" name="seller_activate" id="seller_activate" value="1" <?php checked( $new_seller_activate ); ?> /> <?php _e('Activate the seller immediately.'); ?></td>
	</tr>


	<tr>
		<th scope="row"><label for="send_password"><?php _e('Send Password?') ?></label></th>
		<td><label for="send_password"><input type="checkbox" name="send_password" id="send_password" value="1" <?php checked( $new_user_send_password ); ?> /> <?php _e('Send this password to the new seller by email.'); ?></label></td>
	</tr>
<?php endif; ?>


	<input type="hidden" name="role" value="seller" />

	
	
</table>

<?php
/** This action is documented in wp-admin/user-new.php */
do_action( 'user_new_form', 'add-new-user' );
?>

<?php submit_button( __( 'Add New Seller '), 'primary', 'createuser', true, array( 'id' => 'createusersub' ) ); ?>

</form>
<?php } // current_user_can('create_users') ?>
</div>





<script type="text/javascript">
jQuery(document).ready(function(){

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

});
</script>