<?php
/**
 * Filters and actions used by framework in blog, single and archives
 *
 */

// Container Filter of Blog
add_filter( 'ivan_blog_container', 'ivan_blog_container' );
function ivan_blog_container( $cols ) {

	$sidebarLeft = ivan_get_option('blog-sidebar-left');
	$sidebarRight = ivan_get_option('blog-sidebar-right');

	if($sidebarLeft && $sidebarRight)
		$cols = 'col-xs-12 col-sm-6 col-md-6 sidebar-enabled sidebar-right sidebar-left';
	else if($sidebarRight)
		$cols = 'col-xs-12 col-sm-9 col-md-9 sidebar-enabled sidebar-right';
	else if($sidebarLeft)
		$cols = 'col-xs-12 col-sm-9 col-md-9 pull-right sidebar-enabled sidebar-left';

	return $cols;
}

// Display Sidebar before blog Container
add_action("ivan_blog_before", "ivan_blog_before");
function ivan_blog_before() {

	if(ivan_get_option('blog-sidebar-left'))
		get_sidebar('secondary');
}

// Display Sidebar after blog Container
add_action("ivan_blog_after", "ivan_blog_after");
function ivan_blog_after() {

	if(ivan_get_option('blog-sidebar-right'))
		get_sidebar();
}

// Add custom background pattern to our div
add_action( 'wp_head', 'ivan_blog_custom_pattern_css', 180 );
function ivan_blog_custom_pattern_css() {

	$content = '';

	if( ivan_get_option('blog-patterns') != null && !is_array( ivan_get_option('blog-patterns') ) ) {
		$content .= '
		.content-wrapper.index, .content-wrapper.archives, .content-wrapper.search {
			background-image: url('. ivan_get_option('blog-patterns') .');
			background-repeat: repeat;
			background-size: auto;
			background-attachment: scroll;
		}';
	}

	echo '<style type="text/css">'. apply_filters('ivan_custom_blog_css_content', $content) .'</style>';
}

// Custom List Function to Infinite Scroll
function ivan_custom_render_infine() {
	
	// Get Layout Option
	$_layout = ivan_get_option('blog-layout');

	$_sub_layout = ivan_get_option('blog-sub-' . $_layout );

	get_template_part( 'post-templates/' .  $_layout . '-' . $_sub_layout . '/main', 'loop' );
}

/***
 * Single Post
*****/

// Container Filter of Blog
add_filter( 'ivan_single_container', 'ivan_single_container' );
function ivan_single_container( $cols ) {

	$sidebarLeft = ivan_get_option('single-sidebar-left');
	$sidebarRight = ivan_get_option('single-sidebar-right');

	if($sidebarLeft && $sidebarRight)
		$cols = 'col-xs-12 col-sm-6 col-md-6 sidebar-enabled sidebar-right sidebar-left';
	else if($sidebarRight)
		$cols = 'col-xs-12 col-sm-9 col-md-9 sidebar-enabled sidebar-right';
	else if($sidebarLeft)
		$cols = 'col-xs-12 col-sm-9 col-md-9 pull-right sidebar-enabled sidebar-left';

	return $cols;
}

// Display Sidebar before blog Container
add_action("ivan_single_before", "ivan_single_before");
function ivan_single_before() {

	if(ivan_get_option('single-sidebar-left'))
		get_sidebar('secondary');
}

// Display Sidebar after blog Container
add_action("ivan_single_after", "ivan_single_after");
function ivan_single_after() {

	if(ivan_get_option('single-sidebar-right'))
		get_sidebar();
}

// Add custom background pattern to our div
add_action( 'wp_head', 'ivan_single_custom_pattern_css', 180 );
function ivan_single_custom_pattern_css() {

	$content = '';

	if( ivan_get_option('single-patterns') != null && !is_array( ivan_get_option('single-patterns') ) ) {
		$content .= '
		.content-wrapper.single-post {
			background-image: url('. ivan_get_option('single-patterns') .');
			background-repeat: repeat;
			background-size: auto;
			background-attachment: scroll;
		}';
	}

	echo '<style type="text/css">'. apply_filters('ivan_custom_single_css_content', $content) .'</style>';
}

// Increase results of search page
add_action( 'pre_get_posts',	'ivan_set_posts_per_page'	);
function ivan_set_posts_per_page( $query ) {

	global $wp_the_query;

	if ( ( ! is_admin() ) && ( $query === $wp_the_query ) && ( $query->is_search() ) ) {
		$query->set( 'posts_per_page', 10 );
	}

	return $query;
}

/*
// Customize Single DA Output Sample
// Use it to display single with thumbnail as background image + gradient...
add_filter('ivan_dynamic_area_result', 'ivan_dynamic_area_result_single', 5, 2);
function ivan_dynamic_area_result_single($result, $header) {
	if( is_singular('post')  && $header) {

		$largeImage = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
		?>
		<div class="ivan-custom-wrapper full_width parallax-none" style="padding-top: 450px; 
		background-image: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%), url(<?php echo $largeImage; ?>);
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(100%,rgba(255,255,255,1))), url(<?php echo $largeImage; ?>);
		background-image: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%), url(<?php echo $largeImage; ?>);
		background-image: -o-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%), url(<?php echo $largeImage; ?>);
		background-image: -ms-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%), url(<?php echo $largeImage; ?>);
		background-image: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%), url(<?php echo $largeImage; ?>);
		background-size: cover; background-repeat: no-repeat;">

		</div>
		<?php
	} else {

		return $result;

	}
}
*/