<?php
/**
 * The template part for displaying blog posts with large posts in full width size
 *
 * @package ivan_framework
 */

$containerCols = apply_filters('ivan_single_container', 'col-xs-12 col-sm-12 col-md-12');
?>

<?php
	// Used to print another 
	do_action('ivan_single_before');
?>

<div class="<?php echo $containerCols; ?> site-main" role="main">

	<?php
		/* Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'single-templates/large-simple/content', get_post_format() );
	?>

</div>

<?php
	do_action('ivan_single_after');
?>