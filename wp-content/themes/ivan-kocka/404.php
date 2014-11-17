<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package ivan_framework
 */

get_header(); ?>

	<?php

	// Removes title wrapper if negative header is enabled
	if( true != ivan_get_option( 'header-negative-height' ) ) :
		echo '<div class="title-wrapper-divider"></div>';
	endif;

	/* @todo: adds who is being hooked */
	do_action( 'ivan_content_before' ); 
	?>

	<div class="<?php echo apply_filters( 'iv_content_wrapper_classes', 'iv-layout content-wrapper not-found ' ); ?>">
		<div class="container">
			<div class="row">

				<div class="col-md-12">

					<h2 class="not-found-number"><?php _e('Error 404', 'ivan_domain'); ?><span class="error-dot">.</span></h2>
					<h4 class="not-found-text"><?php _e( 'It looks like nothing was found at this location. Try use the search.', 'ivan_domain' ); ?></h4>

				</div>

			</div>	
		</div>
	</div>

	<?php
	/* @todo: adds who is being hooked */
	do_action( 'ivan_content_after' ); 
	?>

<?php get_footer(); ?>