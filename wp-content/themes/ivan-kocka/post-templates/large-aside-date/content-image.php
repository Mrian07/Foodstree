<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		// Thumbnail - displays thumbnail if exists and considering the Post Format being used
		do_action( 'ivan_display_thumbnail', 'image' ); 
	?>

	<div class="entry-inner">

		<?php
		// Date Block
		get_template_part('post-templates/parts/part', 'date-block'); ?>

		<div class="entry-infos-holder">

			<header class="entry-header">

				<?php
				// Title
				get_template_part('post-templates/parts/part', 'title'); ?>

				<?php
				// Meta
				get_template_part('post-templates/parts/part', 'meta-clean'); ?>

			</header><!-- .entry-header -->

			<?php
			// Content
			get_template_part('post-templates/parts/part', 'content'); ?>	

			<?php
			// Read More
			get_template_part('post-templates/parts/part', 'read-more'); ?>

		</div> <!-- .entry-infos-holder -->

	</div><!-- .entry-inner -->

</article><!-- #post-## -->