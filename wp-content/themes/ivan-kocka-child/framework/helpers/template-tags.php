<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 */

/**
 * Display columns number to header layout
 *
 * @return string
 */
function ivan_header_dimensions($type = 'logo', $cols = 2) {

	$logo_lg = ivan_get_option('header-logo-lg');
	$logo_md = ivan_get_option('header-logo-md');
	$logo_sm = ivan_get_option('header-logo-sm');
	$logo_xs = ivan_get_option('header-logo-xs');

	if( $cols == 3 ) {
		// If columns are divided by 3, the logo number should fit properly adding one to it.
		if( $logo_lg % 2 != 0 )
			$logo_lg += 1;

		if( $logo_md % 2 != 0 )
			$logo_md += 1;
	}

	if( 'logo' == $type ) {

		echo apply_filters('iv_logo_dimensions', 'col-xs-' . $logo_xs . ' col-sm-' . $logo_sm . ' col-md-' . $logo_md . ' col-lg-' . $logo_lg );
	}
	else {
		$col_lg = 12 - $logo_lg;
		$col_md = 12 - $logo_md;
		$col_sm = 12 - $logo_sm;
		$col_xs = 12 - $logo_xs;

		if( $cols == 3 ) {

			if( $logo_lg % 2 != 0 )
				$col_lg -= 1;

			if( $logo_md % 2 != 0 )
				$col_md -= 1;

			$col_lg = $col_lg / 2;
			$col_md = $col_md / 2;
		}

		echo apply_filters('iv_col_dimensions', 'col-xs-' . $col_xs . ' col-sm-' . $col_sm . ' col-md-' . $col_md . ' col-lg-' . $col_lg );
	}

}

if ( ! function_exists( 'ivan_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function ivan_paging_nav() {

	global $wp_query;

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="hidden"><?php _e( 'Posts navigation', 'ivan_domain' ); ?></h1>
			
		<div class="nav-links">

			<?php

			$prev_icon = 'fa-angle-left';
			$next_icon = 'fa-angle-right';

			if( true == is_rtl() ) {
				$prev_icon = 'fa-angle-right';
				$next_icon = 'fa-angle-left';
			}

			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'prev_text' 	=> '<i class="fa '.$prev_icon.'"></i>',
				'next_text' 	=> '<i class="fa '.$next_icon.'"></i>',
				'end_size'		=> 3,
				'mid_size'		=> 3,
				'type' 			=> 'plain',
			) );
			?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->

	<?php
}
endif;

if ( ! function_exists( 'ivan_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function ivan_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next	 = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'ivan_domain' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'ivan_domain' ) ); ?>
			<?php next_post_link(	 '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',	 'ivan_domain' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'ivan_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function ivan_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'ivan_domain' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'ivan_domain' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="row">

				<div class="comment-avatar-holder">
					<?php echo get_avatar( $comment, 100 ); ?>
					<?php if(get_the_author_meta('ID') == $comment->user_id) : ?>
					<span class="author-tag hidden-xs"><?php _e("Author", 'ivan_domain'); ?></span>
					<?php endif; ?>
				</div>
				<div class="comment-content-holder">

					<footer class="comment-meta">
						<div class="comment-author vcard">
							
							<?php printf( __( '%s', 'ivan_domain' ), sprintf( '<h5 class="fn">%s</h5>', get_comment_author_link() ) ); ?>

							<div class="comment-date">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="comment-time">
									<time datetime="<?php comment_time( 'c' ); ?>">
										<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'ivan_domain' ), get_comment_date(), get_comment_time() ); ?>
									</time>
								</a>
								<?php edit_comment_link( __( 'Edit', 'ivan_domain' ), '<span class="edit-link">', '</span>' ); ?>
							</div>

							

						</div><!-- .comment-author -->

						<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'ivan_domain' ); ?></p>
						<?php endif; ?>
					</footer><!-- .comment-meta -->

					<div class="comment-content">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->

					<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'	 => $depth,
							'max_depth' => $args['max_depth'],
							'before'	=> '<div class="reply">',
							'after'	 => '</div>',
							'reply_text'=> __('Reply', 'ivan_domain'),
						) ) );
					?>

				</div><!-- .col-md-# -->
				<div class="clearfix"></div>
			</div><!-- .row -->
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for ivan_comment()

// Custom Form Filter to adjust the forms properly.
function ivan_comment_form_fields($fields) {
 
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
 
	$fields['author'] = 
		'<div class="comment-form-field comment-form-author col-xs-12 col-sm-4 col-md-4 no-padding-left-xs no-padding-right-xs no-padding-left-sm no-padding-left-lg">
			<input required minlength="3" placeholder="'. __('Your Name', 'ivan_domain') .'*" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
	'"' . $aria_req . ' />
		</div>';
 
	$fields['email'] = 
		'<div class="comment-form-field comment-form-email col-xs-12 col-sm-4 col-md-4 no-padding-left-xs no-padding-right-xs ">
			<input required placeholder="'. __('Your Email', 'ivan_domain') .'*" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
	'"' . $aria_req . ' />
		</div>';
 
	$fields['url'] = 
		'<div class="comment-form-field comment-form-url col-xs-12 col-sm-4 col-md-4 no-padding-left-xs no-padding-right-xs no-padding-right-sm no-padding-right-lg">
			<input placeholder="'. __('Your Website', 'ivan_domain') .'" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
	'" />
		</div>';
 
	return $fields;
}
add_filter('comment_form_default_fields', 'ivan_comment_form_fields');

// Display Author box before post listing in author pages
add_action('ivan_before_post_loop', 'ivan_display_author_box', 10);
function ivan_display_author_box() {

	if( is_author() ) {
		// Author Box
		get_template_part('single-templates/parts/part', 'author-box');
	}

}