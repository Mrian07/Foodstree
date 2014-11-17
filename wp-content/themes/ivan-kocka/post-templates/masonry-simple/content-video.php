<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		global $ivan_current_post;

		$ivan_current_post['content'] = get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'ivan_domain' ) );

		// Displays thumbnail if exists and considering the Post Format being used
		do_action( 'ivan_display_thumbnail', 'video' ); 
	?>

	<div class="entry-inner">

		<header class="entry-header">

			<?php
			// Title
			get_template_part('post-templates/parts/part', 'title'); ?>

		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php echo apply_filters( 'the_content', $ivan_current_post['content'] ); // Replaces the_content function call ?>
		</div><!-- .entry-content -->

		<?php
		// Meta
		get_template_part('post-templates/parts/part', 'meta-small'); ?>

	</div><!-- .entry-inner -->

</article><!-- #post-## -->