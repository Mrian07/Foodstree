<?php
/**
 * The Template for displaying all single posts.
 *
 * @package ivan_framework
 */

get_header(); ?>

	<?php

	$_classes = '';

	// Title Logic
	if( ( false == ivan_get_option('single-disable-title') && false == ivan_get_option('single-boxed-page') )
		OR ( false == ivan_get_option('single-disable-title') && true == ivan_get_option('header-negative-height') ) ) :
		do_action( 'ivan_title_wrapper' );
	else :

		echo apply_filters('ivan_single_divider', '<div class="title-wrapper-divider single-version"></div>');

		$_classes .= ' no-title-wrapper';
	endif;
	
	// Adds reduced Width
	if( true == ivan_get_option('single-reduced-width') )
		$_classes = ' reduced-width';

	/* @todo: adds who is being hooked */
	do_action( 'ivan_content_before' ); 
	?>

	<?php
	// Calls the_post to set post ready
	the_post();
	?>

	<?php
	// Get Layout Option
	$_layout = ivan_get_option('single-layout');

	$_sub_layout = ivan_get_option('single-sub-' . $_layout );

	?>

	<div class="<?php echo apply_filters( 'iv_content_wrapper_classes', 'iv-layout content-wrapper single-post', 'single' ); ?> single-<?php echo $_layout . ' style-' . $_sub_layout; ?><?php echo $_classes ?>">
		<div class="container">

			<?php
			// Boxed Page Logic
			if( true == ivan_get_option('single-boxed-page') && false == ivan_get_option('header-negative-height') ) : ?>
			<div class="boxed-page-wrapper">

				<?php
				// Adds Title
				if( false == ivan_get_option('single-disable-title') && true == ivan_get_option('single-boxed-page')
					&& false == ivan_get_option('header-negative-height') ) :
					do_action( 'ivan_title_wrapper' );
				endif; ?>

				<div class="boxed-page-inner">
			<?php endif; ?>

				<div class="row">

					<?php
						/* Include the selected blog listing display
						 */
						get_template_part( 'single-templates/layout', $_layout . '-' . $_sub_layout );
					?>

				</div>
			<?php
			// Boxed Page Logic
			if( true == ivan_get_option('single-boxed-page') && false == ivan_get_option('header-negative-height') ) : ?>
				</div><!-- .boxed-page-inner -->
			</div><!-- .boxed-page-wrapper -->
			<?php endif; ?>

		</div>
	</div>

	<?php
	/* @todo: adds who is being hooked */
	do_action( 'ivan_content_after' ); 
	?>

<?php get_footer(); ?>