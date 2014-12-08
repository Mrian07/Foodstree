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

$new_seller_name = $creating && isset( $_POST['seller_name'] ) ? wp_unslash( $_POST['seller_name'] ) : '';
/*$new_first_name = $creating && isset( $_POST['first_name'] ) ? wp_unslash( $_POST['first_name'] ) : '';
$new_last_name = $creating && isset( $_POST['last_name'] ) ? wp_unslash( $_POST['last_name'] ) : '';*/
$new_user_login = $creating && isset( $_POST['user_login'] ) ? wp_unslash( $_POST['user_login'] ) : '';
$new_user_email = $creating && isset( $_POST['email'] ) ? wp_unslash( $_POST['email'] ) : '';
$new_user_uri = $creating && isset( $_POST['url'] ) ? wp_unslash( $_POST['url'] ) : '';
$new_seller_address = $creating && isset( $_POST['seller_address'] ) ? wp_unslash( $_POST['seller_address'] ) : '';
$new_seller_pincode_list = $creating && isset( $_POST['seller_pincode_list'] ) ? wp_unslash( $_POST['seller_pincode_list'] ) : '';
$new_seller_activate = $creating && isset( $_POST['seller_activate'] ) ? wp_unslash( $_POST['seller_activate'] ) : '';
$new_user_role = $creating && isset( $_POST['role'] ) ? wp_unslash( $_POST['role'] ) : '';
$new_user_send_password = $creating && isset( $_POST['send_password'] ) ? wp_unslash( $_POST['send_password'] ) : '';
$new_user_ignore_pass = $creating && isset( $_POST['noconfirmation'] ) ? wp_unslash( $_POST['noconfirmation'] ) : '';

?>
<table class="form-table">
	<tr class="form-field form-required">
		<th scope="row"><label for="seller_name"><?php _e('Seller Name'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="seller_name" type="text" id="seller_name" value="<?php echo esc_attr($new_seller_name); ?>" aria-required="true" /></td>
	</tr>

	<!-- <tr class="form-field">
		<th scope="row"><label for="first_name"><?php _e('First Name'); ?> <span class="description"></span></label></th>
		<td><input name="first_name" type="text" id="first_name" value="<?php echo esc_attr($new_first_name); ?>" /></td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="last_name"><?php _e('Last Name'); ?> <span class="description"></span></label></th>
		<td><input name="last_name" type="text" id="last_name" value="<?php echo esc_attr($new_last_name); ?>" /></td>
	</tr> -->

	<tr class="form-field form-required">
		<th scope="row"><label for="user_login"><?php _e('Username'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="user_login" type="text" id="user_login" value="<?php echo esc_attr($new_user_login); ?>" aria-required="true" /></td>
	</tr>

	<tr class="form-field form-required">
		<th scope="row"><label for="email"><?php _e('E-mail'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
		<td><input name="email" type="email" id="email" value="<?php echo esc_attr( $new_user_email ); ?>" /></td>
	</tr>
	
	<tr class="form-field">
		<th scope="row"><label for="url"><?php _e('Website') ?></label></th>
		<td><input name="url" type="url" id="url" class="code" value="<?php echo esc_attr( $new_user_uri ); ?>" /></td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="seller_address"><?php _e('Address') ?></label></th>
		<td><textarea name="seller_address" id="seller_address"><?php echo esc_attr( $new_seller_address ); ?></textarea></td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="seller_pincode_list"><?php _e('Upload pincode list CSV') ?></label></th>
		<td><input type="file" name="seller_pincode_list" id="seller_pincode_list" /></td>
	</tr>

	<tr>
		<th scope="row"><label for="seller_activate"><?php _e('Activate Seller?') ?></label></th>
		<td><input type="checkbox" name="seller_activate" id="seller_activate" value="1" <?php checked( $new_seller_activate ); ?> /> <?php _e('Activate the seller immediately.'); ?></td>
	</tr>


<?php
if ( apply_filters( 'show_password_fields', true ) ) : ?>
	<tr class="form-field form-required">
		<th scope="row"><label for="pass1"><?php _e('Password'); ?> <span class="description"><?php /* translators: password input field */_e('(required)'); ?></span></label></th>
		<td>
			<input class="hidden" value=" " /><!-- #24364 workaround -->
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