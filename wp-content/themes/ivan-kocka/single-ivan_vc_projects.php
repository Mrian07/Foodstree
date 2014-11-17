<?php
/**
 * The Template for displaying single version of project
 *
 * @package ivan_framework
 */

get_header(); ?>

	<?php

	$_classes = '';

	// Title Logic
	if( ( false == ivan_get_option('title-wrapper-enable-switch') && false == ivan_get_option('page-boxed-page') )
		OR ( true == ivan_get_option('header-negative-height') && false == ivan_get_option('title-wrapper-enable-switch') ) ) :
		do_action( 'ivan_title_wrapper' );
	else :

		if( false == ivan_get_option('header-negative-height') && true == ivan_get_option('title-wrapper-enable-switch') )
			echo apply_filters('ivan_blog_divider', '<div class="title-wrapper-divider blog-version"></div>');

		if( true == ivan_get_option('title-wrapper-enable-switch') && false == ivan_get_option('page-boxed-page') )
			$_classes .= ' no-title-wrapper';
	endif;

	/* @todo: adds who is being hooked */
	do_action( 'ivan_content_before' ); 
	?>

	<?php
	// Calls the_post to set post ready
	the_post();
	?>

	<div class="<?php echo apply_filters( 'iv_content_wrapper_classes', 'iv-layout content-wrapper content-full single-project' ); ?><?php echo $_classes ?>">
		<div class="container">

			<?php
			// Boxed Page Logic
			if( true == ivan_get_option('page-boxed-page') && false == ivan_get_option('header-negative-height') ) : ?>
			<div class="boxed-page-wrapper">

				<?php
				// Adds Title
				if( false == ivan_get_option('title-wrapper-enable-switch') && true == ivan_get_option('page-boxed-page')
					&& false == ivan_get_option('header-negative-height') ) :
					do_action( 'ivan_title_wrapper' );
				endif; ?>

				<div class="boxed-page-inner">
			<?php endif; ?>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 site-main" role="main">

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<div class="entry-content">
								<?php
								// Content
								the_content(); ?>
							</div><!-- .entry-content -->

							<?php
							if(true == ivan_get_option('project-nav')) :
								// Post Nav
								get_template_part('single-templates/parts/part', 'post-nav-fixed'); 
							endif; ?>
							
						</article>

					</div>
				</div><!-- .row -->

			<?php
			// Boxed Page Logic
			if( true == ivan_get_option('page-boxed-page') && false == ivan_get_option('header-negative-height') ) : ?>
				</div><!-- .boxed-page-inner -->
			</div><!-- .boxed-page-wrapper -->
			<?php endif; ?>

		</div>
	</div>

	<?php
	if(true == ivan_get_option('project-related')) : ?>
	<div class="ivan-related-projects-holder">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 site-main" role="main">
					<?php // Related Project
					get_template_part('single-templates/parts/part', 'project-related'); 
					?>
				</div>	
			</div>	
		</div>	
	</div>	
	<?php		
	endif; ?>

	<?php
	/* @todo: adds who is being hooked */
	do_action( 'ivan_content_after' ); 
	?>

<?php get_footer(); ?>