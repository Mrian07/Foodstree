<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-inner">
		
		<div class="entry-content">

			<i class="quote-mark fa fa-quote-right pull-left"></i>

			<div class="quote-main">
				<?php the_content(); ?>
				<?php if( '' != get_the_title() ) : ?>
					<cite>— <?php the_title(); ?></cite>
				<?php endif; ?>
			</div>

			<?php
			// Meta
			get_template_part('post-templates/parts/part', 'meta-no-comments'); ?>

		</div><!-- .entry-content -->

	</div><!-- .entry-inner -->

</article><!-- #post-## -->