<?php
/**
 * @package ivan_framework
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-inner">
		
		<div class="entry-content">

			<i class="status-mark fa fa-twitch pull-left"></i>

			<div class="status-main">
				<?php the_content(); ?>
			</div>

			<?php
			// Meta
			get_template_part('post-templates/parts/part', 'meta-no-comments'); ?>

		</div><!-- .entry-content -->

	</div><!-- .entry-inner -->

</article><!-- #post-## -->