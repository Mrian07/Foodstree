<?php
	if( !is_archive() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'page-templates/content', 'page' ); ?>

		<?php
		if( true == ivan_get_option('page-comments-switch') ) :
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		endif;
		?>

	<?php endwhile; // end of the loop. ?>
<?php
	else :

		global $ivan_archives_page;

		$pageToRedirect = $ivan_archives_page;

		$custom_args = array(
			'post_type' => 'page',
			'page_id' => $pageToRedirect,
		);
		$customQuery = new WP_Query( $custom_args );

		while( $customQuery->have_posts() ) {
			$customQuery->the_post();
			
			the_content();
		}

	endif; ?>