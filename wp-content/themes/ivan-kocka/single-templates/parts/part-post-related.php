<?php
if( true == ivan_get_option('single-related') ) :

	$thisID = get_the_ID();
	$tags = wp_get_post_tags( $thisID );

	$relatedPosts = 3; // Setup the column number of related
	$columns = 3; // Setup the column number of related
	$columnBootstrap = round( 12 / $columns );
	$thumbEnabled = true;

	// Check if tags exists before display related
	if ( !empty($tags) && is_array($tags) ) : ?>

		<?php
		// Get tag IDs to use in query
		$tag_ids = array();
		foreach( $tags as $tag ) {
			$tag_ids[] = (int)$tag->term_id;
		}

		// If tag IDs were found, we keep going...
		if( !empty( $tag_ids ) ) :

			// Query the related posts
			$related_query = get_posts( array(
				'tag__in' => $tag_ids,
				'post_type' => get_post_type( $thisID ),
				'showposts' => $relatedPosts,
				'ignore_sticky_posts'=>1,
				'orderby' => 'ASC',
				'post__not_in' => array( $thisID ),
				) );

			// If we found related posts, we keep going...
			if( !empty( $related_query ) ) : ?>

				<div class="entry-related-posts">
					<h3><?php _e('Related Articles', 'ivan_domain'); ?></h3>
					<div class="row">

						<?php
						foreach( $related_query as $related_post ) : ?>

							<div class="col-xs-12 col-sm-<?php echo $columnBootstrap; ?> col-md-<?php echo $columnBootstrap; ?> related-post">

								<?php
								$thumb = get_the_post_thumbnail( $related_post->ID, 'ivan_blog_related' );
								$title = htmlspecialchars ( $related_post->post_title );
								$permalink = get_permalink( $related_post->ID );
								?>

								<?php
								if( '' != $thumb && $thumbEnabled ) : ?>
								<div class="thumbnail-related"><a href="<?php echo $permalink; ?>"><?php echo $thumb; ?></a></div>
								<?php endif; ?>

								<div class="title">
									<h5><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h5>
								</div>

							</div>

						<?php endforeach; ?>
		
					</div><!-- .row -->
				</div> <!-- .related-posts -->

				<?php wp_reset_query(); ?>

			<?php endif; // !empty( $related_query ) ?>

		<?php endif; // !empty( $tag_ids ) ?>

	<?php endif; ?>

<?php endif; ?>