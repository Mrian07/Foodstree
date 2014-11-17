<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		// Thumbnail - displays thumbnail if exists and considering the Post Format being used
		do_action( 'ivan_display_thumbnail', 'standard' ); 
	?>

	<div class="entry-inner">

		<?php
		// Content
		get_template_part('post-templates/parts/part', 'content'); ?>	

		<?php
		// Meta
		get_template_part('post-templates/parts/part', 'meta-small'); ?>

	</div><!-- .entry-inner -->

</article><!-- #post-## -->
