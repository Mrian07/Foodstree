<?php
/**
 * The template part for displaying blog posts with large posts in full width size
 *
 * @package ivan_framework
 */
?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post();

?>

	<?php
		/* Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'post-templates/full-polaroid/content', get_post_format() );
	?>

<?php endwhile; ?>		