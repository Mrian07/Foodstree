<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="row">

		<div class="col-md-6 post-left-area">
			<?php
				// Thumbnail - displays thumbnail if exists and considering the Post Format being used
				do_action( 'ivan_display_thumbnail', 'standard' ); 
			?>
		</div>

		<div class="col-md-6 post-right-area">

			<div class="entry-inner">

				<?php
				// Content
				get_template_part('post-templates/parts/part', 'content'); ?>	

				<?php
				// Read More
				get_template_part('post-templates/parts/part', 'read-more'); ?>

			</div><!-- .entry-inner -->

		</div>

	</div><!-- row -->

</article><!-- #post-## -->
