<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	
	<?php
	global $_search_number;
	?>

	<div class="result-num">
		<span><?php echo $_search_number; ?></span>
	</div>

	<div class="result-content">
		<header class="entry-header">
			<?php // Title
				get_template_part('post-templates/parts/part', 'title'); ?>

			<?php 
			if ( 'post' == get_post_type() ) : 
				// Meta
				get_template_part('post-templates/parts/part', 'meta-clean');
			endif; ?>
		</header><!-- .entry-header -->

		<?php 
		if ( has_excerpt() ) :  ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php endif; ?>
	</div>
	
</article><!-- #post-## -->
