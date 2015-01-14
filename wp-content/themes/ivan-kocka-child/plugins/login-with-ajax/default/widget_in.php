<?php 
/*
 * This is the page users will see logged in. 
 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.
 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)
*/
?>
<div class="lwa">
	<?php 
		global $current_user;
		get_currentuserinfo();
	?>
	<div class="lwa-title with-image">
		<div class="lwa-avatar">
			<?php echo get_avatar( $current_user->ID, $size = '50' );  ?>
		</div>
		<span><?php echo __( 'Howdy,', 'ivan_domain' ) . " " . $current_user->display_name  ?></span>
		<div class="clearfix"></div>
	</div>
	<div class="lwa-in">
		

		<div class="lwa-info">
			<ul>
			<?php

				//WooCommerce My Account
				if( true == is_woocommerce_activated() ) {
					?>
					<li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php _e('My Account', 'ivan_domain'); ?></a></li>
					<?php
				}

				//Admin URL
				if ( $lwa_data['profile_link'] == '1' ) {
					if( function_exists('bp_loggedin_user_link') ){
						?>
						<li><a href="<?php bp_loggedin_user_link(); ?>"><?php _e('Profile','ivan_domain') ?></a></li>
						<?php	
					} else{
						?>
						<li><a href="<?php echo trailingslashit(get_admin_url()); ?>profile.php"><?php _e('Profile', 'ivan_domain') ?></a></li>
						<?php	
					}
				}
					//Logout URL
				?>
				<li><a id="wp-logout" href="<?php echo wp_logout_url('index.php') ?>"><?php _e( 'Log Out', 'ivan_domain') ?></a></li>
				<?php
				//Blog Admin
				if( current_user_can('list_users') ) {
					?>
					<li><a href="<?php echo get_admin_url(); ?>"><?php _e("Dashboard", 'ivan_domain'); ?></a></li>
					<?php
				}
			?>
			</ul>
		</div>

		<div class="clearfix"></div>

	</div><!-- .lwa-in -->
</div>