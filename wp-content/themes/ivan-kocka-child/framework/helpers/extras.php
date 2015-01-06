<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 */

/**
 * Shortcodes used in header to add separator or icon.
 */
add_shortcode('iv_separator', 'iv_code_separator');
function iv_code_separator() {
	return '<div class="iv-separator">&nbsp;</div>';
}

// Used to display the flags with a shortcode
add_shortcode('iv_flags', 'iv_code_flags');
function iv_code_flags() {
	return ivan_language_selector_flags_return();
}

// Icon
add_shortcode('iv_icon', 'iv_code_icon_func');
function iv_code_icon_func( $atts ) {
	extract(shortcode_atts(array(
		'prefix' => 'fa fa-',
		'icon' => 'anchor',
		'size' => '', // fg-lg, fg-2x for example...
		'custom' => '',
		'color' => '',
    ), $atts));

    $style = '';

    if('' != $color)
    	$style .= ' style="color: '.$color.';"';

	$markup = '<i class="'. $prefix . $icon . ' ' . $size .' iv-icon"'.$style.'></i>';

	if('' != $custom)
		$markup = '<i class="'.$custom.' ' . $size .'"'.$style.'></i>';

	return $markup;
}

// Social
add_shortcode('iv_social', 'iv_code_social_func');
function iv_code_social_func( $atts ) {
	extract(shortcode_atts(array(
		'prefix' => 'fa fa-',
		'icon' => 'twitter',
		'custom' => '',
		'color' => '',
		'target' => '_blank',
		'type' => 'circle', // circle or square
		'size' => '',
		'link' => '#',
    ), $atts));

    $style = '';
    $classes = '';

    if( $type == 'none' || $type == '') {
    	$classes .= ' iv-social-icon-none';	

    	$icon .= ' ' .$size;
    } else {
    	$classes .= ' style-'. $style . ' fa-stack ' . $size . ' ' . $type;
    }

    if('' != $color)
    	$style .= ' style="color: '.$color.';"';

	$markup = '<i class="'. $prefix . $icon . '"'.$style.'></i>';

	if('' != $custom)
		$markup = '<i class="'.$custom.'"'.$style.'></i>';

	return '<a class="iv-social-icon '.$classes.'" href="'.$link.'" target="'. $target .'">'. $markup . '</a>';
}

// Br
function iv_code_br_func( $atts, $content = null ) {
	return '<br>';
}
add_shortcode('iv_br', 'iv_code_br_func');

/**
 * Check if WooCommerce plugin is activated.
 *
 * @return bool
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'WooCommerce' ) ) { return true; } else { return false; }
	}
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function ivan_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'ivan_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ivan_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'ivan_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function ivan_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'ivan_domain' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'ivan_wp_title', 10, 2 );

/* WPML Compatibility added to home URL used in logo */
function iv_get_home_url() {
	// Adds WPML compatibility to logo URL
	if( function_exists('icl_get_home_url') )
		return icl_get_home_url();
	else
		return home_url() . '/';
}

/* Display Flag Selectors */
function ivan_language_selector_flags(){
	if( function_exists('icl_get_languages') ) : 
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			foreach($languages as $l){
				if(!$l['active']) echo '<a href="'.$l['url'].'">';
				echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
				if(!$l['active']) echo '</a>';
			}
		}
	endif;
}

function ivan_language_selector_flags_return(){
	$output = '';
	if( function_exists('icl_get_languages') ) : 
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			foreach($languages as $l){
				if(!$l['active']) $output .= '<a href="'.$l['url'].'">';
				$output .= '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
				if(!$l['active']) $output .= '</a>';
			}
		}
	endif;

	return $output;
}

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function ivan_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'ivan_setup_author' );
