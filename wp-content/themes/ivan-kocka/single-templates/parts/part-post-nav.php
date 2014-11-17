<?php
if( true == ivan_get_option('single-post-nav') ) :
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( '' != $next OR '' != $previous ) {
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="hidden"><?php _e( 'Post navigation', 'ivan_domain' ); ?></h1>
		<div class="row nav-links">

			<div class="col-xs-6 col-md-6 next-link">
				<?php if( '' != $next ) : ?>
				<span><?php _e('Next', 'ivan_domain'); ?></span>
				<h4><a href="<?php echo get_permalink( $next->ID ); ?>"><?php echo $next->post_title; ?></a></h4>
				<?php endif; ?>
			</div>

			<div class="col-xs-6 col-md-6 previous-link">
				<?php if( '' != $previous ) : ?>
				<span><?php _e('Previous', 'ivan_domain'); ?></span>
				<h4><a href="<?php echo get_permalink( $previous->ID ); ?>"><?php echo $previous->post_title; ?></a></h4>
				<?php endif; ?>
			</div>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
	}
endif;