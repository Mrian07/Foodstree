<?php
/**
 * @package ivan_framework
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		global $ivan_current_post;

		$ivan_current_post['content'] = get_the_content( '');
		$ivan_current_post['title_href'] = get_permalink();

		// Displays thumbnail if exists and considering the Post Format being used
		do_action( 'ivan_display_thumbnail', 'link'); 
	?>

	<div class="entry-inner">
		
		<header class="entry-header">

			<?php
			// Meta
			get_template_part('post-templates/parts/part', 'meta'); ?>

		</header><!-- .entry-header -->

		<div class="entry-content">

			<i class="link-mark fa fa-chain pull-left"></i>

			<div class="link-main">

				<header class="entry-header">

					<h1 class="entry-title"><a href="<?php echo $ivan_current_post['title_href']; ?>" rel="bookmark" target="_blank"><?php the_title(); ?></a></h1>

				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php echo apply_filters( 'the_content', $ivan_current_post['content'] ); // Replaces the_content function call ?>
				</div><!-- .entry-content -->

			</div>
		</div><!-- .entry-content -->

	</div><!-- .entry-inner -->

</article><!-- #post-## -->