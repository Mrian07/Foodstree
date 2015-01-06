<?php
/**
 * Filters and actions used by framework
 *
 */

// Activation theme hook
add_action("after_switch_theme", "ivan_activation_theme", 10 , 2);
function ivan_activation_theme($oldname, $oldtheme=false) {

	// Set default sizes
	//update_option( 'thumbnail_size_h', 80 );
	//update_option( 'thumbnail_size_w', 80 );

	update_option( 'medium_size_w',480 );
	update_option( 'medium_size_h', 480 );

	update_option( 'large_size_w', 1200 );
	update_option( 'large_size_h', 1200 );

	// WooCommerce
	update_option('shop_catalog_image_size', array('width'=>480, 'height'=>600, 'crop' => false) );
	update_option('shop_single_image_size', array('width'=>510, 'height'=>600, 'crop' => true) );
	update_option('shop_thumbnail_image_size', array('width'=>120, 'height'=>120, 'crop' => true) );

}

// Negative Height Wrapper
add_action('ivan_header', 'ivan_neg_wrapper_before', 15);
function ivan_neg_wrapper_before() {

	if( 'Ivan_Main_Layout_Normal' == ivan_get_option('main-layout') ) :

		if( true == ivan_get_option( 'header-negative-height' ) ) :		
	?>
		<div class="smooth-opening-holder">
	<?php
		endif; // negative height enabled

	endif; // layout if...
}

add_action('ivan_content_before', 'ivan_neg_wrapper_after', 15);
function ivan_neg_wrapper_after() {
	
	if( 'Ivan_Main_Layout_Normal' == ivan_get_option('main-layout') ) :

		if( true == ivan_get_option( 'header-negative-height' ) ) :	
	?>
		</div><!-- .smooth-opening-holder -->
	<?php
		endif; // negative height enabled

	endif; // layout if...
}

// Boxed/Wide Layouts Action
add_filter( 'body_class', 'ivan_boxed_wide_classes', 1 );
function ivan_boxed_wide_classes( $classes ) {

	$layout_mode = ivan_get_option('wide-boxed-switch');

	//var_dump(ivan_get_option('wide-boxed-switch'));

	if( $layout_mode != null ){
		$classes[] = $layout_mode;
	}

	// Check if menus are activated
	/*
	if(!class_exists('mmpm_primary_class'))
		$classes[] = 'no-mega-menu';
	*/

	if( 'Ivan_Main_Layout_Normal' == ivan_get_option('main-layout') && 
		true == ivan_get_option('header-negative-height') && 'semi-transparent-bg' != ivan_get_option('header-bg-type') )
		$classes[] = 'negative-header-active';

	if( 'Ivan_Main_Layout_Normal' == ivan_get_option('main-layout') && 
		true == ivan_get_option('header-negative-height') && 'semi-transparent-bg' == ivan_get_option('header-bg-type') )
		$classes[] = 'semi-negative-header-active';

	if( 'Ivan_Main_Layout_Normal' == ivan_get_option('main-layout') && 
		true == ivan_get_option('header-negative-height') && true == ivan_get_option('header-boxed-layout') )
		$classes[] = 'header-boxed';

	if( true == ivan_get_option('header-negative-height') && true == ivan_get_option('title-wrapper-enable-switch') )
		$classes[] = 'moz-negative-adjust';

	$headerLayout = ivan_get_option('header-layout');
	if('Ivan_Layout_Header_Classic_Right_Area' == $headerLayout OR
		'Ivan_Layout_Header_Classic_Logo_Centered' == $headerLayout)
		$classes[] = 'classic-menu-activated';

	// Check if title wrapper is customized
	//var_dump(ivan_get_option('title-wrapper-body-bg'));
	/*
	$title_bg = ivan_get_option('title-wrapper-body-bg');
	if( '' == $title_bg['background-color'] && '' == $title_bg['background-image'] )
		$classes[] = 'no-custom-title';
	*/

	return $classes;
}

// Insert Custom CSS Global Code in wp_head
add_action('wp_head', 'ivan_global_custom_css', 200);
function ivan_global_custom_css() {
	?>
<?php echo ivan_get_option('link_editor'); ?>
<?php
	if( is_singular() )
		echo ivan_get_post_option('link_editor_local'); 
?>
<style type="text/css">
<?php echo ivan_get_option('css_editor'); ?>
<?php
	if( is_singular() )
		echo ivan_get_post_option('css_editor_local'); 
?>
</style>
	<?php
}

// Insert Custom JS Global Code in wp_head
add_action('wp_footer', 'ivan_global_custom_js', 200);
function ivan_global_custom_js() {
	?>
<script type="text/javascript">
<?php echo ivan_get_option('js_editor'); ?>
<?php
	if( is_singular() )
		echo ivan_get_post_option('js_editor_local'); 
?>
</script>
	<?php
}

// Set menu orientation in aside layouts
add_filter( 'ivan_set_menu_orientation', 'ivan_header_menu_orientation', 10, 2 );
function ivan_header_menu_orientation( $orientation, $location ) {

	if( ivan_get_current_caller('main-layout') == 'Ivan_Main_Layout_Aside_Left' OR
	ivan_get_current_caller('main-layout') == 'Ivan_Main_Layout_Aside_Right' ) {

		if( $location == 'primary' )
			$orientation = 'vertical';
	}

	return $orientation;
}

// Set menu drop side in aside layouts
add_filter( 'ivan_menu_drops_side', 'ivan_header_menu_drops_side', 10, 1 );

function ivan_header_menu_drops_side( $side ) {

	if( ivan_get_current_caller('main-layout') == 'Ivan_Main_Layout_Aside_Right' ) {
		$side = 'drop_to_left';
	}
	else if( ivan_get_current_caller('main-layout') == 'Ivan_Main_Layout_Aside_Left' ) {
		$side = 'drop_to_right';
	}
	else if( ivan_get_option('header-menu-pull-center-switch') != true && 
		( ivan_get_option('header-layout') == 'Ivan_Layout_Header_Classic_Right_Area' OR ivan_get_option('header-layout') == 'Ivan_Layout_Header_Classic_Logo_Centered'
		OR ivan_get_option('header-layout') == 'Ivan_Layout_Header_Only_Menu' OR ivan_get_option('header-layout') == 'Ivan_Layout_Header_Simple_Logo_Centered' ) ) {

		$side = 'drop_to_right';

	}

	return $side;
}

// Add custom background pattern
add_action( 'wp_head', 'ivan_custom_pattern_css', 180 );
function ivan_custom_pattern_css() {

	$content = '';

	if( ivan_get_option('layout-patterns') != null && !is_array( ivan_get_option('layout-patterns') ) ) {
		$content .= '
		body {
			background-image: url('. ivan_get_option('layout-patterns') .');
			background-repeat: repeat;
			background-size: auto;
			background-attachment: scroll;
		}';
	}

	if( ivan_get_option('layout-boxed-patterns') != null && !is_array( ivan_get_option('layout-boxed-patterns') ) ) {
		$content .= '
		.page .content-wrapper.page-boxed-style, 
		.single-ivan_vc_projects .content-wrapper.page-boxed-style {
			background-image: url('. ivan_get_option('layout-boxed-patterns') .');
			background-repeat: repeat;
			background-size: auto;
			background-attachment: scroll;
		}';
	}

	echo '<style type="text/css">'. apply_filters('ivan_custom_css_content', $content) .'</style>';
}

// Add Favicon Support
add_action( 'wp_head', 'ivan_favicons', 5 );
function ivan_favicons() {
?>
<?php 
$favicon_16 = ivan_get_option('favicon-16');
if( is_array($favicon_16) && $favicon_16['url'] != '' ) : ?>
	<link rel="icon" type="image/png" href="<?php echo $favicon_16['url']; ?>" sizes="16x16">
<?php endif; ?>
<?php 
$favicon_32 = ivan_get_option('favicon-32');
if( is_array($favicon_32) && $favicon_32['url'] != '' ) : ?>
	<link rel="icon" type="image/png" href="<?php echo $favicon_32['url']; ?>" sizes="32x32">
<?php endif; ?>
<?php 
$favicon_96 = ivan_get_option('favicon-96'); 
if( is_array($favicon_96) && $favicon_96['url'] != '' ) : ?>
	<link rel="icon" type="image/png" href="<?php echo $favicon_96['url']; ?>" sizes="96x96">
<?php endif; ?>
<?php 
$favicon_160 = ivan_get_option('favicon-160');
if( is_array($favicon_160) && $favicon_160['url'] != '' ) : ?>
	<link rel="icon" type="image/png" href="<?php echo $favicon_160['url']; ?>" sizes="160x160">
<?php endif; ?>
<?php 
$favicon_192 = ivan_get_option('favicon-192');
if( is_array($favicon_192) && $favicon_192['url'] != '' ) : ?>
	<link rel="icon" type="image/png" href="<?php echo $favicon_192['url']; ?>" sizes="192x192">
<?php endif; ?>
<?php 
$favicon_a_57 = ivan_get_option('favicon-a-57');
if( is_array($favicon_a_57) && $favicon_a_57['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $favicon_a_57['url']; ?>">
<?php endif; ?>
<?php 
$favicon_a_114 = ivan_get_option('favicon-a-114');
if( is_array($favicon_a_114) && $favicon_a_114['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $favicon_a_114['url']; ?>">
<?php endif; ?>
<?php 
$favicon_a_72 = ivan_get_option('favicon-a-72');
if( is_array($favicon_a_72) && $favicon_a_72['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $favicon_a_72['url']; ?>">
<?php endif; ?>
<?php 
$favicon_a_144 = ivan_get_option('favicon-a-144');
if( is_array($favicon_a_144) && $favicon_a_144['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $favicon_a_144['url']; ?>">
<?php endif; ?>
<?php 
$favicon_a_60 = ivan_get_option('favicon-a-60');
if( is_array($favicon_a_60) && $favicon_a_60['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $favicon_a_60['url']; ?>">
<?php endif; ?>
<?php 
$favicon_a_120 = ivan_get_option('favicon-a-120');
if( is_array($favicon_a_120) && $favicon_a_120['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $favicon_a_120['url']; ?>">
<?php endif; ?>
<?php 
$favicon_a_76 = ivan_get_option('favicon-a-76');
if( is_array($favicon_a_76) && $favicon_a_76['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $favicon_a_76['url']; ?>">
<?php endif; ?>
<?php 
$favicon_a_152 = ivan_get_option('favicon-a-152');
if( is_array($favicon_a_152) && $favicon_a_152['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $favicon_a_152['url']; ?>">
<?php endif; ?>
<?php 
$favicon_a_180 = ivan_get_option('favicon-a-180');
if( is_array($favicon_a_180) && $favicon_a_180['url'] != '' ) : ?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $favicon_a_180['url']; ?>">
<?php endif; ?>
<?php if( ivan_get_option('favicon-win-color') != '' ) : ?>
	<meta name="msapplication-TileColor" content="<?php echo ivan_get_option('favicon-win-color'); ?>" />
<?php endif; ?>
<?php 
$favicon_win_70 = ivan_get_option('favicon-win-70');
if( is_array($favicon_win_70) && $favicon_win_70['url'] != '' ) : ?>
	<meta name="msapplication-square70x70logo" content="<?php echo $favicon_win_70['url']; ?>" />
<?php endif; ?>
<?php 
$favicon_win_150 = ivan_get_option('favicon-win-150');
if( is_array($favicon_win_150) && $favicon_win_150['url'] != '' ) : ?>
	<meta name="msapplication-square150x150logo" content="<?php echo $favicon_win_150['url']; ?>" />
<?php endif; ?>
<?php 
$favicon_win_310 = ivan_get_option('favicon-win-310');
if( is_array($favicon_win_310) && $favicon_win_310['url'] != '' ) : ?>
	<meta name="msapplication-wide310x150logo" content="<?php echo $favicon_win_310['url']; ?>" />
<?php endif; ?>
<?php 
$favicon_win_310_quad = ivan_get_option('favicon-win-310-quad');
if( is_array($favicon_win_310_quad) && $favicon_win_310_quad['url'] != '' ) : ?>
	<meta name="msapplication-square310x310logo" content="<?php echo $favicon_win_310_quad['url']; ?>" />
<?php endif; ?>	
<?php
}

// Add Favicon Support
add_action( 'wp_head', 'ivan_disable_responsiveness', 100 );
function ivan_disable_responsiveness() {
	if( true == ivan_get_option('disable-responsiveness') ) :
	?>
	<script type="text/javascript">
		jQuery(window).ready(function(){
		   jQuery('meta[name="viewport"]').prop('content', 'width=1349');
		});
	</script>
	<?php
	endif;
}

/*
// Archives template overwrite system
function ivan_st_template_switch() {

	$id = ivan_get_option('archives-page-overload');

	if( null != $id ) :

		if( !is_archive() ) {
			return;
		}

		$pageToRedirect = $id;

		$custom_args = array(
			'post_type' => 'page',
			'page_id' => $pageToRedirect,
		);
		$customQuery = new WP_Query( $custom_args );

		while( $customQuery->have_posts() ) {
			$customQuery->the_post();

			global $ivan_archives_page;

			$ivan_archives_page = get_the_ID();

			//add_filter('body_class', )

			include( @get_page_template() );

			exit();
		}

	endif;
}
//add_action( 'template_redirect', 'ivan_st_template_switch' );
*/

// Replace Sidebars Per Page
add_filter('ivan_replace_sidebars', 'ivan_replace_sidebars');
function ivan_replace_sidebars( $sidebar ) {
	if( is_singular() ) {

		if( null != ivan_get_post_option( $sidebar . '-replace' ) ) {
			return ivan_get_post_option( $sidebar . '-replace' );
		} 
	}

	return $sidebar;
}

// Custom icons in user profile
global $ivan_user_profile_media;

$ivan_user_profile_media = apply_filters('iv_user_profile_icons', array(
	'facebook', 'twitter', 'linkedin', 'pinterest', 'google-plus', 'tumblr', 'instagram',
	'vk', 'flickr', 'youtube', 'dribbble', 'vimeo-square', 'github', 'weibo',
	) );

add_filter( 'user_contactmethods', 'ivan_custom_user_profile_social' );
function ivan_custom_user_profile_social($profile_fields) {

	// Adding Social Profiles to User
	$profile_fields['facebook'] = 'Facebook URL';
	$profile_fields['twitter'] = 'Twitter URL';
	$profile_fields['linkedin'] = 'LinkedIn URL';
	$profile_fields['pinterest'] = 'Pinterest URL';
	$profile_fields['google_plus'] = 'Google+ URL';
	$profile_fields['tumblr'] = 'Tumblr URL';
	$profile_fields['instagram'] = 'Instagram URL';
	$profile_fields['vk'] = 'VK URL';
	$profile_fields['flickr'] = 'Flickr URL';
	$profile_fields['youtube'] = 'Youtube URL';
	$profile_fields['dribbble'] = 'Dribbble URL';
	$profile_fields['vimeo_square'] = 'Vimeo URL';
	$profile_fields['github'] = 'GitHub URL';
	$profile_fields['weibo'] = 'Weibo URL';

	return $profile_fields;

}

// Custom Menu Fallback
function ivan_menu_fb($args) {
	if(isset($args['container_class']))
		echo '<div class="'.$args['container_class'].'"><div class="menu_holder centered">';

		wp_page_menu($args);

	if(isset($args['container_class']))
		echo '</div></div>';
}

// Dynamic Areas
function ivan_display_dynamic_area($ID, $header = false) {

	// runs specific code to header only...
	if($header) {

		$_id = '';

		if( is_home() ) {
			$_id = ivan_get_option('header-da-after-blog');
		}
		else if( is_singular('post') ) {
			$_id = ivan_get_option('header-da-after-single');
		}
		else if( true == is_woocommerce_activated() ) {
			if( is_shop() || is_product_category() ) {
				$_id = ivan_get_option('header-da-after-shop');
			} else if( is_product() ) {
				$_id = ivan_get_option('header-da-after-single-product');
			} 
		}

		if( $_id != '' )
			$ID = $_id;
	}

	if('' != $ID) :

		$page_data = get_page( $ID );
		if ($page_data) {
			$result = apply_filters('the_content', $page_data->post_content);

			echo apply_filters('ivan_dynamic_area_result', $result, $header);

			// Display custom row CSS by VC
			if( function_exists('ivan_vc_customizer_get_style') ) {
				$customCSS = get_post_meta( $ID , '_wpb_shortcodes_custom_css', true );
				if('' != $customCSS) {
					global $ivan_custom_css;

					$ivan_custom_css .= $customCSS;
				}
			}
		}
	endif;
}

// Enqueue Visual Composer Styles when using Dynamic Areas
add_action( 'wp_enqueue_scripts', 'ivan_enqueue_vc_to_dynamic', 40 );
function ivan_enqueue_vc_to_dynamic() {

	// Check if any dynamic area is enabled in order to enqueue the Visual Composer Style
	// ... when necessary
	if( true == ivan_get_option('header-da-after-enable') OR 
		true == ivan_get_option('footer-da-before-enable') OR
		true == ivan_get_option('footer-da-after-enable') ) :
		wp_enqueue_style('js_composer_front');
	endif;

	if( is_singular() && true == ivan_get_option('single-da-after-enable') )
		wp_enqueue_style('js_composer_front');
}

// Extended / Compact Headers
add_filter('iv_top_header_classes', 'ivan_expanded_compact_header');
add_filter('iv_header_classes', 'ivan_expanded_compact_header');
add_filter('iv_dynamic_header_classes', 'ivan_expanded_compact_header');
function ivan_expanded_compact_header( $classes ) {
	
	if( 'normal' != ivan_get_option('header-container-type') ) {
		$classes .= ' ' . ivan_get_option('header-container-type');
	}

	return $classes;
}

// Extended / Compact Content
add_filter('iv_title_wrapper_classes', 'ivan_expanded_compact_content');
add_filter('iv_content_wrapper_classes', 'ivan_expanded_compact_content');
function ivan_expanded_compact_content( $classes ) {
	
	if( 'normal' != ivan_get_option('content-container-type') ) {
		$classes .= ' ' . ivan_get_option('content-container-type');
	}

	return $classes;
}

// Extended / Compact Footer
add_filter('iv_footer_classes', 'ivan_expanded_compact_footer');
add_filter('iv_bottom_footer_classes', 'ivan_expanded_compact_footer');
add_filter('iv_dynamic_footer_classes', 'ivan_expanded_compact_footer');
function ivan_expanded_compact_footer( $classes ) {
	
	if( 'normal' != ivan_get_option('footer-container-type') ) {
		$classes .= ' ' . ivan_get_option('footer-container-type');
	}

	return $classes;
}

// Extended / Compact Aside
add_filter('iv_aside_container', 'ivan_expanded_compact_aside');
function ivan_expanded_compact_aside( $classes ) {
	
	if( 'normal' != ivan_get_option('aside-container-type') ) {
		$classes .= ' aside-' . ivan_get_option('aside-container-type');
	}

	return $classes;
}

// Boxed Style Classes
add_filter('iv_content_wrapper_classes', 'ivan_content_wrapper_boxed_style', 5, 2);
function ivan_content_wrapper_boxed_style( $classes, $location = 'page' ) {

	if( ivan_get_option('header-negative-height') == false ) {
	
		if( 'page' == $location && true == ivan_get_option('page-boxed-page') ) {
			$classes .= ' page-boxed-style';
		}

		else if( 'blog' == $location && true == ivan_get_option('blog-boxed-page') ) {
			$classes .= ' page-boxed-style';
		}

		else if( 'single' == $location && true == ivan_get_option('single-boxed-page') ) {
			$classes .= ' page-boxed-style';
		}

		else if( 'shop' == $location && true == ivan_get_option('shop-boxed-page') ) {
			$classes .= ' page-boxed-style';
		}

	}

	return $classes;
}