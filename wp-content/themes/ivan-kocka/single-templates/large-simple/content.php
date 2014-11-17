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
		<div class="single-content-wrapper">

			<header class="entry-header">

				<?php
				// Title
				get_template_part('post-templates/parts/part', 'title'); ?>

				<?php
				// Meta
				get_template_part('post-templates/parts/part', 'meta-no-comments'); ?>

			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php
				// Content
				the_content(); ?>
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">',
						'after'  => '</div>',
						'link_before' => '<span>',
						'link_after' => '</span>',
					) );
				?>

				<?php
				// Dynamic Area
				get_template_part('single-templates/parts/part', 'dynamic-area'); ?>

				<?php
				// Tags
				get_template_part('single-templates/parts/part', 'tags'); ?>

				<?php
				// Post Nav
				get_template_part('single-templates/parts/part', 'post-nav-fixed'); ?>

			</div><!-- .entry-content -->

		</div><!-- .single-content-wrapper -->
	</div><!-- .entry-inner -->

	<?php
	// Author Box
	get_template_part('single-templates/parts/part', 'author-box'); ?>

	<?php
	// Related
	get_template_part('single-templates/parts/part', 'post-related'); ?>

	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	?>

</article><!-- #post-## -->
