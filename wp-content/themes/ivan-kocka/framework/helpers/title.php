<?php
/**
 * Function used to display title wrapper
 *
 */

function iv_display_title() {
	$tag = apply_filters('ivan_display_title_tag', 'h2');
	$wrap = apply_filters('ivan_display_title_wrap', 'span');
	$title = '';

	// Default Latest Posts page
	if( is_home() || is_singular('post') ) :
		$title = ivan_get_option('title-text-blog');

	// Singular
	elseif( is_singular() ) :
		$title = get_the_title();

	// Search
	elseif( is_search() ) :
		global $wp_query;
		$total_results = $wp_query->found_posts;
		$prefix = '';

		if( $total_results == 1 ){
			$prefix = __('1 search result for', 'ivan_domain');
		}
		else if( $total_results > 1 ) {
			$prefix = $total_results . ' ' . __('search results for', 'ivan_domain');
		}
		else {
			$prefix = __('Search results for', 'ivan_domain');
		}
		$title = $prefix . ': ' . get_search_query();

	// Category and other Taxonomies
	elseif ( is_category() ) :
		$title = single_cat_title('', false);

	elseif ( is_tag() ) :
		$title = single_tag_title('', false);

	elseif ( is_author() ) :
		$title = sprintf( __( 'Author: %s', 'ivan_domain' ), '<span class="vcard">' . get_the_author() . '</span>' );

	elseif ( is_day() ) :
		$title = sprintf( __( 'Day: %s', 'ivan_domain' ), '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		$title = sprintf( __( 'Month: %s', 'ivan_domain' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'ivan_domain' ) ) . '</span>' );

	elseif ( is_year() ) :
		$title = sprintf( __( 'Year: %s', 'ivan_domain' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'ivan_domain' ) ) . '</span>' );

	elseif( is_tax() ) :
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
		$title = $term->name;

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		$title = __( 'Asides', 'ivan_domain' );

	elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
		$title = __( 'Galleries', 'ivan_domain');

	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		$title = __( 'Images', 'ivan_domain');

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		$title = __( 'Videos', 'ivan_domain' );

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		$title = __( 'Quotes', 'ivan_domain' );

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		$title = __( 'Links', 'ivan_domain' );

	elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
		$title = __( 'Statuses', 'ivan_domain' );

	elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
		$title = __( 'Audios', 'ivan_domain' );

	elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
		$title = __( 'Chats', 'ivan_domain' );

	elseif( is_404() ) :
		$title = __( '404', 'ivan_domain' );

	else :
		$title = __( 'Archives', 'ivan_domain' );
	endif;

	// Display Title
	echo '<'. $tag .'>' . '<'. $wrap .'>' . $title . '</'. $wrap .'>' . '</'. $tag .'>';
}
add_action('ivan_display_title', 'iv_display_title', 10);