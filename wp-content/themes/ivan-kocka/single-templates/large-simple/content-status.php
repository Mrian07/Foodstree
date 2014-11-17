<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-inner">
		<div class="single-content-wrapper">

			<header class="entry-header">

				<?php
				// Meta
				get_template_part('post-templates/parts/part', 'meta-no-comments'); ?>

			</header><!-- .entry-header -->

			<div class="entry-content">

				<i class="status-mark fa fa-twitch pull-left"></i>

				<div class="status-main">
					<?php the_content(); ?>
				</div>

				<div class="inner-status">
					<?php
					// Dynamic Area
					get_template_part('single-templates/parts/part', 'dynamic-area'); ?>

					<?php
					// Tags
					get_template_part('single-templates/parts/part', 'tags'); ?>

					<?php
					// Post Nav
					get_template_part('single-templates/parts/part', 'post-nav-fixed'); ?>
				</div>

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