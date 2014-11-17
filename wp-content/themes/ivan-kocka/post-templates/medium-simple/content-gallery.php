<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="row">

		<div class="col-md-6 post-left-area">
			<?php
				global $ivan_current_post;

				$ivan_current_post['content'] = get_the_content( '' );

				// Displays thumbnail if exists and considering the Post Format being used
				do_action( 'ivan_display_thumbnail', 'gallery' ); 
			?>
		</div>

		<div class="col-md-6 post-right-area">

			<div class="entry-inner">

				<header class="entry-header">

					<?php
					// Title
					get_template_part('post-templates/parts/part', 'title'); ?>

					<?php
					// Meta
					get_template_part('post-templates/parts/part', 'meta'); ?>

				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php echo apply_filters( 'the_content', $ivan_current_post['content'] ); // Replaces the_content function call ?>
				</div><!-- .entry-content -->

				<?php
				// Read More
				get_template_part('post-templates/parts/part', 'read-more'); ?>

			</div><!-- .entry-inner -->
			
		</div>

	</div><!-- row -->

</article><!-- #post-## -->