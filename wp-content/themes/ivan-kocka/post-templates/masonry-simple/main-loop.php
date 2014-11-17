<?php
/**
 * The template part for displaying blog posts with large posts in full width size
 *
 * @package ivan_framework
 */
?>

<?php
$ivan_counter = 0;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

global $ivan_current_col;
$ivan_current_col = 12 / ivan_get_option('blog-columns');
?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post();
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