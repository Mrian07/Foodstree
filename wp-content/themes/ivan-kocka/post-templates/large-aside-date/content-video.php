<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		global $ivan_current_post;

		$ivan_current_post['content'] = get_the_content( '' );

		// Displays thumbnail if exists and considering the Post Format being used
		do_action( 'ivan_display_thumbnail', 'video' ); 
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

			<div class="entry-content">
				<?php echo apply_filters( 'the_content', $ivan_current_post['content'] ); // Replaces the_content function call ?>
			</div><!-- .entry-content -->	

			<?php
			// Read More
			get_template_part('post-templates/parts/part', 'read-more'); ?>

		</div> <!-- .entry-infos-holder -->

	</div><!-- .entry-inner -->

</article><!-- #post-## -->