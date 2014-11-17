<?php
/**
 * Ivan Framework Init Files
 *
 * This will start the default configuration used by Ivan.
 * 
 * (Table of Contents)
 *	* - Contants - declare contants used by our theme.
 *	* - Helpers/Options - include general framework functions and theme options.
 *	* - Plugin Extensions
 *	* - Base Classes - classes made to be extended
 *	* - Modules
 *	* - Main Layouts
 *	* - Layouts
 *	* - Filters and Actions
 *	* - Main Render
 *
 */

/**
 * Define contants used by theme/framework
 */
	define( 'IVAN_THEME_NAME', '_s' );
	define( 'IVAN_FW_VERSION', '1.0.0' );
	define( 'IVAN_FW_THEME_OPTS', 'iv_aries' );
	define( 'IVAN_FW', get_template_directory() . '/framework' );
	define( 'IVAN_OPTS', get_template_directory() . '/framework/options' );
	define( 'IVAN_OPTS_ASSETS', get_template_directory() . '/framework/options/sections/assets' );

/**
 * Include helpers used by our theme/framework
 */

	// Metabox Options
	require_once IVAN_FW . '/metaboxes/config.php';
	// Redux Framework Core
	if ( !class_exists( 'ReduxFramework' ) && file_exists( IVAN_FW . '/options/ReduxFramework/ReduxCore/framework.php' ) ) {
		require_once IVAN_FW . '/options/ReduxFramework/ReduxCore/framework.php';
	}

	// ThemeConfigs
	require_once get_template_directory() . '/theme-configs/theme-configs.php';

	// Ivan Theme Options
	if ( file_exists( IVAN_FW . '/options/theme_options.php' ) ) {
		require_once IVAN_FW . '/options/theme_options.php';
	}

	// Helper: options related functions.
	require_once IVAN_FW . '/helpers/options.php';
	// Helper: post formats functions.
	require_once IVAN_FW . '/helpers/post-formats.php';
	// Helper: blog navigation, post pagination and custom comments markup.
	require_once IVAN_FW . '/helpers/template-tags.php';
	// Helper: custom title, nav fallback and few configurations.
	require IVAN_FW . '/helpers/extras.php';
	// Helper: title wrapper
	require IVAN_FW . '/helpers/title.php';

/**
 * Plugin Extensions
 */
	// WooCommerce configuration and extension
	if( class_exists('WooCommerce') )
		require get_template_directory() . '/woocommerce/configuration.php';

	if(function_exists('vc_set_as_theme'))
		vc_set_as_theme();

	// Login with AJAX configuration
	require_once IVAN_FW . '/helpers/plugin_login_with_ajax.php';

	// Ninja Forms configuration
	require_once IVAN_FW . '/helpers/plugin_ninja_forms.php';

 /**
 * Base classes, Modules, Main Layouts, Layouts
 */
	
	// Base Classes
	require_once IVAN_FW . '/base-classes/class-main-layout.php';
	require_once IVAN_FW . '/base-classes/class-module.php';
	require_once IVAN_FW . '/base-classes/class-layout.php';

	// Modules
	require_once IVAN_FW . '/modules/class-logo.php';
	require_once IVAN_FW . '/modules/class-menu.php';
	require_once IVAN_FW . '/modules/class-live-search.php';
	require_once IVAN_FW . '/modules/class-social-icons.php';
	require_once IVAN_FW . '/modules/class-custom-text.php';
	require_once IVAN_FW . '/modules/class-woo-cart.php';
	require_once IVAN_FW . '/modules/class-login-ajax.php';
	require_once IVAN_FW . '/modules/class-responsive-menu.php';
	require_once IVAN_FW . '/modules/class-responsive-menu-select.php';
	require_once IVAN_FW . '/modules/class-ads.php';
	require_once IVAN_FW . '/modules/class-wpml-lang.php';
	require_once IVAN_FW . '/modules/class-wpml-currency.php';

	// Main Layouts
	require_once ( IVAN_FW . '/main-layouts/class-normal.php' );
	require_once ( IVAN_FW . '/main-layouts/class-aside-left.php' );
	require_once ( IVAN_FW . '/main-layouts/class-aside-right.php' );

	// Layouts
		// Top Header
		require_once IVAN_FW . '/layouts/top_header/class-two-columns.php';

		// Header
		require_once IVAN_FW . '/layouts/header/class-simple-right-menu.php';
		require_once IVAN_FW . '/layouts/header/class-simple-logo-centered.php';
		require_once IVAN_FW . '/layouts/header/class-classic-logo-centered.php';
		require_once IVAN_FW . '/layouts/header/class-classic-right-area.php';
		require_once IVAN_FW . '/layouts/header/class-only-menu.php';

		// Title Wrapper
		require_once IVAN_FW . '/layouts/title_wrapper/class-layout-title-wrapper-normal.php';
		require_once IVAN_FW . '/layouts/title_wrapper/class-layout-title-wrapper-large.php';

		// Content
		require_once IVAN_FW . '/layouts/content/class-layout-content-normal.php';

		// Footer
		require_once IVAN_FW . '/layouts/footer/class-layout-footer-normal.php';

		// Bottom Footer
		require_once IVAN_FW . '/layouts/bottom_footer/class-layout-bottom-footer-two-columns.php';

/**
 * Framework actions and filters
 */
	// General actions and filters used by framework (custom CSS, custom JS, author profile and others)
	require_once IVAN_FW . '/helpers/actions_filters.php';
	if( false == function_exists('getPostLikeLink') )
		require_once IVAN_FW . '/helpers/like_post.php';
	require_once IVAN_FW . '/helpers/blog_actions_filters.php';

	// Nice fallback when not using MegaMain Menu Plugin
	if( false == class_exists('mmpm_primary_class') ) {
		require_once IVAN_FW . '/helpers/menu_fallback.php';
	}
				
// Render the layouts selected by user
add_action( 'wp', 'ivan_main_render', 100);
function ivan_main_render() {

	/*****
	 * Main Layouts
	 ****/
		$layout = ivan_get_option('main-layout');

		$main_layout = new $layout();

		ivan_set_current_caller('main-layout', $layout);

	/*****
	 * Top Header Layout
	 ****/
	
		//Check if layout is not disabled
		if( true != ivan_get_option('top-header-enable-switch')
			AND 'Ivan_Main_Layout_Aside_Right' != ivan_get_option('main-layout')
			AND 'Ivan_Main_Layout_Aside_Left' != ivan_get_option('main-layout') )  :

			//Get selected layout from theme options
			$top_header = ivan_get_option('top-header-layout');
			// Call class that will display the layout
			$topHeaderLayout = new $top_header();

			// Define current caller
			ivan_set_current_caller('layout', 'top-header');

		endif; // ends disable check

	/*****
	 * Header Layout
	 ****/
		//Check if layout is not disabled
		if( true != ivan_get_option('header-enable-switch') ) :

			//Get selected layout from theme options
			$header = ivan_get_option('header-layout');
			// Call class that will display the layout
			$headerLayout = new $header();

			// Define current caller
			ivan_set_current_caller('layout', 'header');

		endif; // ends disable check

	/*****
	 * Title Wrapper Layout
	 ****/
		//Check if layout is not disabled
		if( true != ivan_get_option('title-wrapper-enable-switch') ) :

			//Get selected layout from theme options
			$title_wrapper = ivan_get_option('title-wrapper-layout');
			// Call class that will display the layout
			$titleWrapperLayout = new $title_wrapper();

			// Define current caller
			ivan_set_current_caller('layout', 'title-wrapper');

		endif; // ends disable check

	// Content
	$content_wrapper = 'Ivan_Layout_Content_Normal';
	$contentWrapperLayout = new $content_wrapper();

	/*****
	 * Footer Layout
	 ****/
		// Footer is always called, check is made directly in template file.

			//Get selected layout from theme options
			$footer = ivan_get_option('footer-layout');
			// Call class that will display the layout
			$footerLayout = new $footer();

			// Define current caller
			ivan_set_current_caller('layout', 'footer');

	/*****
	 * Bottom Footer Layout
	 ****/
		// Footer is always called, check is made directly in template file.

			//Get selected layout from theme options
			$bottom_footer = ivan_get_option('bottom-footer-layout');
			// Call class that will display the layout
			$bottomFooterLayout = new $bottom_footer();

			// Define current caller
			ivan_set_current_caller('layout', 'bottom-footer');

	// Render Layout
	if( false == is_admin() ) {
		$main_layout->render();
	}
}