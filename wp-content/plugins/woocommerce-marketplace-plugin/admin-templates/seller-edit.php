<?php

print_r($_REQUEST);


$user_id = $_GET['seller'];

$action = $_GET['action'];

$current_user = wp_get_current_user();

if (get_user_meta( $user_id, 'seller_activate', true )=='1'){
	$activate='1';
}else{
	$activate='0';
}


wp_enqueue_script('wp-ajax-response');

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


<?php if ( isset( $errors ) && is_wp_error( $errors ) && count($errors)>1 ) : ?>
<div class="error"><p><?php echo implode( "</p>\n<p>", $errors->get_error_messages() ); ?></p></div>
<?php endif; ?>


<?php
//print_r($_POST);
?>


<div class="wrap">
<h2 id="edit-seller"> <?php
if ( current_user_can( 'edit_user', get_current_user_id()) ) {
	echo _x( 'Edit Seller', 'wmp' ).'<a class="add-new-h2">'.$profileuser->user_login.'</a>';
} ?>
</h2>
<?php

wp_enqueue_script(
        'jquery_form_js',
        plugins_url( '/js/form/jquery.form.js' , __FILE__ ),
        array( 'jquery' )
);

wp_enqueue_script(
        'custom_validate_js',
        plugins_url( '/js/form/jquery.validate.min.js' , __FILE__ ),
        array( 'jquery' )
);

wp_enqueue_script(
        'custom_js',
        plugins_url( '/js/custom.js' , __FILE__ ),
        array( 'jquery' )
);
?>
<?php
/**
 * Fires inside the your-profile form tag on the user editing screen.
 *
 * @since 3.0.0
 */
?>

<form id="your-profile" enctype="multipart/form-data" action="<?php echo '?page=edit-seller&action=update&updated=1&seller=' . $user_id; ?>" method="post" novalidate="novalidate"<?php do_action( 'user_edit_form_tag' ); ?>>

<?php submit_button( __('Update Seller') ); ?>



<h3><?php _e('Pincode Info') ?></h3>
<table class="form-table">
 	<tr>
            <th><?php _e('Pincode'); ?></th>
            <td><input type="text" name="pincode_str" id="pincode_str"  maxlength="6"  size="6"/>
	    <button type="button" class="btn" id="pin-search">Search</button><span class="description"><?php _e('Input a Pincode to find the seller info for the pincode.'); ?></span></td>
	</tr>   
        <tr>
            <td id='pin-search-response' colspan="2">
            </td> 
        </tr>
</table>




<?php wp_nonce_field('update-user_' . $user_id) ?>
<p>
<input type="hidden" name="from" value="profile" />
<input type="hidden" name="checkuser_id" value="<?php echo get_current_user_id(); ?>" />
</p>




<hr />

<h3><?php _e('Company Information') ?></h3>




<table class="form-table">

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_display_name"><?php _e('Display name'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="seller_display_name" type="text" id="seller_display_name" value="<?php echo get_user_meta( $user_id, 'seller_display_name', true ); ?>" aria-required="true" /></td>
	</tr>
	

	<tr class="form-field form-required">
		<th scope="row"><label for="first_name"><?php _e('First name'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="first_name" type="text" id="first_name" value="<?php echo esc_attr($profileuser->first_name) ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="last_name"><?php _e('Last name'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="last_name" type="text" id="last_name" value="<?php echo esc_attr($profileuser->last_name) ?>" aria-required="true" /></td>
	</tr>

	

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_name"><?php _e('Company name'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="seller_name" type="text" id="seller_name" value="<?php echo get_user_meta( $user_id, 'seller_name', true ); ?>" aria-required="true" /></td>
	</tr>

	

	<tr>
	<th><label for="email"><?php _e('Communication email'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
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

	<tr class="form-field form-required">
		<th scope="row"><label for="mobile_number"><?php _e('Mobile number') ?><span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="mobile_number" type="text" id="mobile_number" value="<?php echo get_user_meta( $user_id, 'mobile_number', true ); ?>" aria-required="true" /></td>
	</tr>
	
	</table>




<hr />

	<h3><?php _e('Communication Address') ?></h3>

	<table class="form-table">

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_address"><?php _e('Company registered address') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><textarea name="seller_address" id="seller_address"><?php echo get_user_meta( $user_id, 'seller_address', true ); ?></textarea></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_city"><?php _e('City') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_city" type="text" id="seller_city" value="<?php echo get_user_meta( $user_id, 'seller_city', true ); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_pincode"><?php _e('Pincode') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_pincode" type="text" id="seller_pincode" value="<?php echo get_user_meta( $user_id, 'seller_pincode', true ); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_state"><?php _e('State') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_state" type="text" id="seller_state" value="<?php echo get_user_meta( $user_id, 'seller_state', true ); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_country"><?php _e('Country') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td>
			<select name="seller_country" id="seller_country" aria-required="true">
				<option value="">Select Country..</option>
				<?php foreach(wmp_getCountries() as $key=>$value){ 
					$country = get_user_meta( $user_id, 'seller_country', true );
					if($country == ''){
						$country = 'India';
					}
					$selected = ($value == $country ? 'selected' : '');
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
		<td><input type="checkbox" name="seller_billing_yes" id="seller_billing_yes" value="1" <?php if(get_user_meta( $user_id, 'seller_billing_yes', true ) == '1') echo 'checked'; ?> /> <?php _e('Check if billing address same as registered address'); ?></td>
	</tr>

	</table>


	<table class="form-table" id="billing_adddress_wrap" style="display:nonee;">
	
	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_address"><?php _e('Billing address') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><textarea name="seller_billing_address" id="seller_billing_address"><?php echo get_user_meta( $user_id, 'seller_billing_address', true ); ?></textarea></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_city"><?php _e('City') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_billing_city" type="text" id="seller_billing_city" value="<?php echo get_user_meta( $user_id, 'seller_billing_city', true ); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_pincode"><?php _e('Pincode') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_billing_pincode" type="text" id="seller_billing_pincode" value="<?php echo get_user_meta( $user_id, 'seller_billing_pincode', true ); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_state"><?php _e('State') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_billing_state" type="text" id="seller_billing_state" value="<?php echo get_user_meta( $user_id, 'seller_billing_state', true ); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_billing_country"><?php _e('Country') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td>
			<select name="seller_billing_country" id="seller_billing_country" aria-required="true">
				<option value="">Select Country..</option>
				<?php foreach(wmp_getCountries() as $key=>$value){ 
					$country = get_user_meta( $user_id, 'seller_billing_country', true );
					if($country == ''){
						$country = 'India';
					}
					$selected = ($value == $country ? 'selected' : '');
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
		<th scope="row"><label for="seller_pan"><?php _e('PAN') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_pan" type="text" id="seller_pan" value="<?php echo get_user_meta( $user_id, 'seller_pan', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_vat"><?php _e('VAT/TIN/CST no.') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_vat" type="text" id="seller_vat" value="<?php echo get_user_meta( $user_id, 'seller_vat', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_rtgs"><?php _e('RTGS/NEFT/IFSC code') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_rtgs" type="text" id="seller_rtgs" value="<?php echo get_user_meta( $user_id, 'seller_rtgs', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_beneficiary"><?php _e('Beneficiary name') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_beneficiary" type="text" id="seller_beneficiary" value="<?php echo get_user_meta( $user_id, 'seller_beneficiary', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_account_number"><?php _e('Account number') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_account_number" type="text" id="seller_account_number" value="<?php echo get_user_meta( $user_id, 'seller_account_number', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_account_type"><?php _e('Account type') ?> <span class="description"><?php _e('(required)'); ?></label></th>
		<td><input name="seller_account_type" type="text" id="seller_account_type" value="<?php echo get_user_meta( $user_id, 'seller_account_type', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_bank_name"><?php _e('Bank name') ?></label></th>
		<td><input name="seller_bank_name" type="text" id="seller_bank_name" value="<?php echo get_user_meta( $user_id, 'seller_bank_name', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_branch_name"><?php _e('Branch name') ?></label></th>
		<td><input name="seller_branch_name" type="text" id="seller_branch_name" value="<?php echo get_user_meta( $user_id, 'seller_branch_name', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_registration"><?php _e('Company registration no.') ?></label></th>
		<td><input name="seller_registration" type="text" id="seller_registration" value="<?php echo get_user_meta( $user_id, 'seller_registration', true ); ?>" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_tan"><?php _e('TAN') ?></label></th>
		<td><input name="seller_tan" type="text" id="seller_tan" value="<?php echo get_user_meta( $user_id, 'seller_tan', true ); ?>" /></td>
	</tr>

	</table>


<hr />

	<table class="form-table">

	<tr>
	<th><label for="url"><?php _e('Website URL') ?></label></th>
	<td><input type="url" name="url" id="url" value="<?php echo esc_attr( $profileuser->user_url ) ?>" class="regular-text code" /></td>
</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_company_description"><?php _e('Company description') ?></label></th>
		<td><textarea name="seller_company_description" id="seller_company_description"><?php echo get_user_meta( $user_id, 'seller_company_description', true ); ?></textarea></td>
	</tr>

</table>

<hr />









<h3><?php _e('Shipping Info') ?></h3>


<?php
$value = maybe_unserialize(get_user_meta( $user_id, 'seller_shipping_methods', true ));
if( empty( $value ) ) {
	$value = array( array(
		'min_total'   => '',
		'max_total'     => '',
		'method'     => '',
		'rate'     => '',
		'cod_charges'     => '',
		
		));
}
?>

<table class='dynamic-shipping-methods-table'>
	<thead>
		<tr>
			<th class='text-left'>Minimum total</th>
			<th class='text-left'>Maximum total</th>
			<th class='text-left'>Method</th>
			<th class='text-left'>Delivery charges(for fixed method only)</th>
			<th class='text-left'>COD charges (if applicable)</th>
			<th class='text-left'>Remove</th>
		</tr>
	</thead>
	<tbody>

		<?php
		$i = 0;
		foreach( $value as $method ) :
			?>
		<tr class='pricing_methods'>
			<td>
				<input class='min_total' style='width:100px' name='seller_shipping_methods[<?php echo $i ?>][min_total]' value='<?php echo $method['min_total'] ?>' type='text' placeholder='Min. total'>
			</td>
			<td>
				<input class='max_total' name='seller_shipping_methods[<?php echo $i ?>][max_total]' value='<?php echo $method['max_total'] ?>' type='text' placeholder='Max. total'>
			</td>
			<td>
				
				<select name="seller_shipping_methods[<?php echo $i ?>][method]" class="method">
					<option value="fixed" <?php if($method['method'] == 'fixed') echo 'selected'; ?>>Fixed</option>
					<option value="pincode" <?php if($method['method'] == 'pincode') echo 'selected'; ?>>Pincode base</option>
				</select>
			</td>
			<td>
				<input class='rate' name='seller_shipping_methods[<?php echo $i ?>][rate]' value='<?php echo $method['rate'] ?>' type='text' placeholder='Rate'>
			</td>

			<td>
				<input class='cod_charges' name='seller_shipping_methods[<?php echo $i ?>][cod_charges]' value='<?php echo $method['cod_charges'] ?>' type='text' placeholder='COD charges'>
			</td>

			<td><a href='#' class='remove-shipping-method button'>Remove</a></td>
		</tr>
		<?php $i++; endforeach ?>
	</table>
	<br>
	<a href='#' id='add-shipping-method' class="button">+ Add</a>

	<hr />









<h3><?php _e('Uploads') ?></h3>

<table class="form-table">


	<tr class="form-field form-required">
		<th scope="row"><label for="seller_logo"><?php _e('Company logo') ?></label></th>
		<td><input name="seller_logo" type="file" id="seller_logo" /></td>
		<?php if(get_user_meta( $user_id, 'seller_logo', true ) !=''){
			$image_url = wp_get_attachment_image_src(get_user_meta( $user_id, 'seller_logo', true ), 'thumbnail' );
			?>
			<td><img src="<?php echo $image_url[0]; ?>" width="50" /></td>
			
		<?php } ?>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="seller_pan_copy"><?php _e('PAN registration copy') ?></label></th>
		<td><input name="seller_pan_copy" type="file" id="seller_pan_copy" /></td>
		<?php if(get_user_meta( $user_id, 'seller_pan_copy', true ) !=''){
			$pan_copy = get_user_meta( $user_id, 'seller_pan_copy', true );
			?>
			<td><a href="<?php echo wp_get_attachment_url( $pan_copy ); ?>">Download</a></td>
			
		<?php } ?>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="seller_cancelled_cheque"><?php _e('Cancelled cheque copy') ?></label></th>
		<td><input name="seller_cancelled_cheque" type="file" id="seller_cancelled_cheque" /></td>
		<?php if(get_user_meta( $user_id, 'seller_cancelled_cheque', true ) !=''){
			$cheque_copy = get_user_meta( $user_id, 'seller_cancelled_cheque', true );
			?>
			<td><a href="<?php echo wp_get_attachment_url( $cheque_copy ); ?>">Download</a></td>
			
		<?php } ?>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_tan_copy"><?php _e('TAN registration copy') ?></label></th>
		<td><input name="seller_tan_copy" type="file" id="seller_tan_copy" /></td>
		<?php if(get_user_meta( $user_id, 'seller_tan_copy', true ) !=''){
			$tan_copy = get_user_meta( $user_id, 'seller_tan_copy', true );
			?>
			<td><a href="<?php echo wp_get_attachment_url( $tan_copy ); ?>">Download</a></td>
			
		<?php } ?>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="seller_registration_copy"><?php _e('Company registration copy') ?></label></th>
		<td><input name="seller_registration_copy" type="file" id="seller_registration_copy" /></td>
		<?php if(get_user_meta( $user_id, 'seller_registration_copy', true ) !=''){
			$registration_copy = get_user_meta( $user_id, 'seller_registration_copy', true );
			?>
			<td><a href="<?php echo wp_get_attachment_url( $registration_copy ); ?>">Download</a></td>
			
		<?php } ?>
	</tr>

</table>







<h3><?php _e('Option') ?></h3>

<table class="form-table">


	<tr>
		<th scope="row"><label for="seller_activate"><?php _e('Activate seller?') ?></label></th>
		<td><input type="checkbox" name="seller_activate" id="seller_activate" <?php checked( get_user_meta( $user_id, 'seller_activate', true ) ); ?>  value="1" /><span class="description"><?php _e('Activate/deactivate the seller.'); ?></span></td>

	</tr>

	

	

</table>


<?php echo $_POST['seller_activate']; ?>


<h3><?php echo __('Password','wmp'); ?></h3>

<table class="form-table">


<tr>
		<th><label for="user_login"><?php _e('Username'); ?></label></th>
		<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr($profileuser->user_login); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e('Usernames cannot be changed.'); ?></span></td>
	</tr>


<?php
/** This filter is documented in wp-admin/user-new.php */
$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
if ( $show_password_fields ) :
?>


<!-- <tr id="password">
	<th><label for="pass1"><?php _e( 'New password' ); ?></label></th>
	<td>
		<input class="hidden" value=" " />
		<input type="password" name="pass1" id="pass1" class="regular-text" size="16" value="" autocomplete="off" /><br />
		<span class="description"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.' ); ?></span>
	</td>
</tr>
<tr>
	<th scope="row"><label for="pass2"><?php _e( 'Repeat new password' ); ?></label></th>
	<td>
	<input name="pass2" type="password" id="pass2" class="regular-text" size="16" value="" autocomplete="off" /><br />
	<span class="description" for="pass2"><?php _e( 'Type your new password again.' ); ?></span>
	<br />
	<div id="pass-strength-result"><?php _e( 'Strength indicator' ); ?></div>
	<p class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; ).' ); ?></p>
	</td>
</tr>
 -->


<tr id="password" class="user-pass1-wrap">
	<th><label for="pass1"><?php _e( 'New Password' ); ?></label></th>
	<td>
		<input class="hidden" value=" " />
		<button type="button" class="button wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password' ); ?></button>
		<div class="wp-pwd hide-if-js">
			<span class="password-input-wrapper">
				<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
			</span>
			<button type="button" class="button wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password' ); ?>">
				<span class="dashicons dashicons-hidden"></span>
				<span class="text"><?php _e( 'Hide' ); ?></span>
			</button>
			<button type="button" class="button wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change' ); ?>">
				<span class="text"><?php _e( 'Cancel' ); ?></span>
			</button>
			<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
		</div>
	</td>
</tr>
<tr class="user-pass2-wrap hide-if-js">
	<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password' ); ?></label></th>
	<td>
	<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
	<p class="description"><?php _e( 'Type your new password again.' ); ?></p>
	</td>
</tr>
<tr class="pw-weak">
	<th><?php _e( 'Confirm Password' ); ?></th>
	<td>
		<label>
			<input type="checkbox" name="pw_weak" class="pw-checkbox" />
			<span id="pw-weak-text-label"><?php _e( 'Confirm use of potentially weak password' ); ?></span>
		</label>
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
		//do_action( 'show_user_profile', $profileuser );
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
     
    <tr>
       <th scope="row"><label for="seller_pincode_reset"><?php _e('Reset seller pincodes') ?></label></th>
       <td><button type="button" name="reset-seller-pincode" id="reset-seller-pincode">Reset</button><span id="rst-response"></span></td>
   </tr>  
    <tr class="form-field" id="pincode_upload_block">
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
        <tr id='pre-loader-response' style='display:none'>
            <td colspan="2">
                <img src="<?php echo get_template_directory_uri()?>/images/loading.gif" /> 
            </td> 
        </tr>
 </table>    
    
</div>
<?php
break;
}
?>
<script type="text/javascript">
      
	if (window.location.hash == '#password') {
		document.getElementById('pass1').focus();
	}    
</script>

