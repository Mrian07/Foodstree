<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		global $ivan_current_post;

		$ivan_current_post['content'] = get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'ivan_domain' ) );
		$ivan_current_post['title_href'] = get_permalink();

		// Displays thumbnail if exists and considering the Post Format being used
		do_action( 'ivan_display_thumbnail', 'link'); 
	?>

	<div class="entry-inner">
		<div class="single-content-wrapper">

			<header class="entry-header">

				<?php
				// Meta
				get_template_part('post-templates/parts/part', 'meta-no-comments'); ?>

			</header><!-- .entry-header -->

			<div class="entry-content">

				<i class="link-mark fa fa-chain pull-left"></i>

				<div class="link-main">

					<header class="entry-header">

						<h1 class="entry-title"><a href="<?php echo $ivan_current_post['title_href']; ?>" rel="bookmark" target="_blank"><?php the_title(); ?></a></h1>

					</header><!-- .entry-header -->

					<div class="">
						<?php echo apply_filters( 'the_content', $ivan_current_post['content'] ); // Replaces the_content function call ?>
						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">',
								'after'  => '</div>',
								'link_before' => '<span>',
								'link_after' => '</span>',
							) );
						?>
					</div><!-- .entry-content -->

				</div>

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