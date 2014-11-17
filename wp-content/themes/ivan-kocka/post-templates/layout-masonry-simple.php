<?php
/**
 * The template part for displaying blog posts with large posts in full width size
 *
 * @package ivan_framework
 */

$containerCols = apply_filters('ivan_blog_container', 'col-xs-12 col-sm-12 col-md-12');
?>

<?php
	// Used to print another 
	do_action('ivan_blog_before');
?>

<div class="<?php echo $containerCols; ?> site-main" role="main">

	<?php do_action('ivan_before_post_loop'); ?>

	<?php if ( have_posts() ) : 
	?>
		<?php
		// Check to margins disabled
		if(false == ivan_get_option('blog-no-margin')) : ?>
			<div class="row ivan-mansory-blog" id="post-list">
		<?php else : ?>
			<div class="ivan-mansory-blog blog-no-margin" id="post-list">
		<?php endif; ?>
			<?php /* Start the Loop */ ?>
			<?php
			$ivan_counter = 0;
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			global $ivan_current_col;
			$ivan_current_col = 12 / ivan_get_option('blog-columns');

			while ( have_posts() ) : the_post();

				$ivan_local_col = $ivan_current_col;

				$ivan_local_col_sm = 6;
				if(12 == $ivan_local_col)
					$ivan_local_col_sm = 12;

				$ivan_counter++;
				if( $paged <= 1 && 1 == $ivan_counter && true == ivan_get_option('blog-first-featured') ) :

					$ivan_local_col = $ivan_current_col * 2;

				endif;

				$class = '';
				$format = get_post_format();

				if('link' != $format && 'quote' != $format && 'status' != $format) {
					if(0 != $ivan_counter % 2)
						$class = ' odd-post';
				}

			?>
				<div class="col-xs-12 col-sm-<?php echo $ivan_local_col_sm; ?> col-md-<?php echo $ivan_local_col; ?> post-wrapper<?php echo $class; ?>">
				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'post-templates/masonry-simple/content', get_post_format() );
				?>
				</div>

			<?php endwhile; ?>
		</div>

		<div class="clearfix"></div>

		<?php ivan_paging_nav(); ?>

	<?php else : ?>

		<?php get_template_part( 'post-templates/content', 'none' ); ?>

	<?php endif; ?>

</div>

<?php
	do_action('ivan_blog_after');
?>