<?php
/**
 * Main functions and definitions
 *
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170; /* pixels */
}

/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 */
load_theme_textdomain( 'ivan_domain', get_template_directory() . '/languages' );

/**
 * Set Google Fonts API KEY to use web fonts in the panel.
 */
define( 'IVAN_GFONTS_API_KEY', 'AIzaSyC22UYGQi493gzi_KXXz_6gwfEmnluMONY' );
define( 'USING_IVAN_THEME', true ); // used by a few plugins provided by us... do not modify.
define( 'IVAN_DEBUG', false );

/**
 * Set Elite Addons VC Support
 */
global $elite_addons_vc_support;
$elite_addons_vc_support = true;

/**
 * Include Ivan Framework main init file.
 */
require get_template_directory() . '/framework/ivan-framework.php';

if ( ! function_exists( 'ivan_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ivan_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'infinite-scroll', array(
		'container' => 'post-list',
		'type' => 'click',
		//'type' => 'scroll',
		'wrapper' => false,
		'render' => 'ivan_custom_render_infine',
		//'posts_per_page' => 2,
		) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size('ivan_blog_quad', 480, 480, true);

	add_image_size('ivan_blog_medium', 880, 880, false);
	add_image_size('ivan_blog_medium_crop', 880, 880, true);
	add_image_size('ivan_blog_large', 1200, 675, false);
	add_image_size('ivan_blog_large_crop', 1200, 675, true);
	add_image_size('ivan_blog_related', 360, 170, true);

	// Uncomment the following line to enable custom image size...
	//define('IVAN_CUSTOM_POST_FORMAT', 'full');

	global $ivan_menu_locations;

	$ivan_menu_locations = array(
		'primary' => __( 'Primary Menu', 'ivan_domain_redux' ),
		'primary_module' => __( 'Header Module Menu', 'ivan_domain_redux' ),
		'secondary' => __( 'Secondary Menu', 'ivan_domain_redux' ),
		'bottom_footer' => __( 'Bottom Footer Menu', 'ivan_domain_redux' ),
	);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( $ivan_menu_locations );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio' ) );

}
endif; // ivan_setup
add_action( 'after_setup_theme', 'ivan_setup' );

add_filter('ivan_megamenu_get_option', 'ivan_megamenu_get_option', 10, 2);
function ivan_megamenu_get_option($key, $return) {
	if('mega_menu_locations' == $key) {
		$return[] = 'primary';
		$return[] = 'primary_module';
		$return[] = 'secondary';
		$return[] = 'bottom_footer';
	}

	return $return;
}

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function ivan_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at right side of content.', 'ivan_domain_redux' ),
		'id'            => 'sidebar-primary',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Sidebar', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at left side of content when the layout supports it.', 'ivan_domain_redux' ),
		'id'            => 'sidebar-secondary',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Aside Sidebar', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at aside layout left or right.', 'ivan_domain_redux' ),
		'id'            => 'sidebar-aside',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar #1', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at footer.', 'ivan_domain_redux' ),
		'id'            => 'widgets-footer-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar #2', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at footer.', 'ivan_domain_redux' ),
		'id'            => 'widgets-footer-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar #3', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at footer.', 'ivan_domain_redux' ),
		'id'            => 'widgets-footer-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Sidebar #4', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at footer.', 'ivan_domain_redux' ),
		'id'            => 'widgets-footer-4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at shop.', 'ivan_domain_redux' ),
		'id'            => 'shop-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Product Sidebar', 'ivan_domain_redux' ),
		'description'   => __( 'Widgets displayed at single product.', 'ivan_domain_redux' ),
		'id'            => 'product-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}
add_action( 'widgets_init', 'ivan_widgets_init' );

//add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode'); /* Allow use of shortcodes inside widget content */

add_filter('cs_sidebar_params', 'ivan_adjust_new_sidebars');
function ivan_adjust_new_sidebars($sidebar) {

	$sidebar['before_widget'] = '<aside id="%1$s" class="widget %2$s">';
	$sidebar['after_widget']  = '</aside>';
	$sidebar['before_title'] = '<h3 class="widget-title">';
	$sidebar['after_title']  = '</h3>';

	return $sidebar;
}

define('CUSTOM_SIDEBAR_DISABLE_METABOXES', true);

/**
 * Enqueue scripts and styles.
 */
function ivan_scripts() {

	// Defines prefix based in DEBUG constant to theme assets
	$prefix = '';
	if( false == IVAN_DEBUG ) {
		$prefix = '.min';
	}

	$protocol = is_ssl() ? 'https://' : 'http://';

	/**
	* Local Owl Carousel Version
	**/
		wp_register_script( 'ivan_owl_carousel', get_template_directory_uri() . '/css/libs/owl-carousel/owl.carousel.min.js', array('jquery'), '1.0', true );
		wp_register_style( 'ivan_owl_carousel', get_template_directory_uri() . '/css/libs/owl-carousel/owl.carousel.min.css' );

	/**
	* Enqueue theme default WebFonts
	*/
	if( false == ivan_get_option('remove-default-fonts') ) :
		// Webfont
		//wp_enqueue_style( 'iv-muli-webfont', $protocol . 'fonts.googleapis.com/css?family=Muli:300,400', array(), '1' );

		// Webfont
		wp_enqueue_style( 'iv-open-sans-webfont', $protocol . 'fonts.googleapis.com/css?family=Open+Sans:400,600,300,700', array(), '1' );

		// Webfont
		wp_enqueue_style( 'iv-raleway-webfont', $protocol . 'fonts.googleapis.com/css?family=Raleway:300', array(), '1' );
		
	endif;

	/**
	* Enqueue theme stylesheets
	*/

		// Register Font Awesome and enqueue it.
		// Source: http://fortawesome.github.io/Font-Awesome/
		wp_register_style( 'ivan-font-awesome', get_template_directory_uri() . '/css/libs/font-awesome-css/font-awesome.min.css', array(), '4.1.0' );
		wp_enqueue_style( 'ivan-font-awesome' );

		// Register Elegant Icons and enqueue it.
		// Infos: 100 icons
		wp_register_style( 'ivan-elegant-icons', get_template_directory_uri() . '/css/libs/elegant-icons/elegant-icons.min.css', array(), '1.0' );
		wp_enqueue_style( 'ivan-elegant-icons' );

		// Register Magnific Popup and enqueue it.
		// Source: http://github.com/dimsemenov/Magnific-Popup
		wp_register_style( 'magnific-popup', get_template_directory_uri() . '/css/libs/magnific-popup/magnific-popup.min.css', array(), '0.9.9' );
		wp_enqueue_style( 'magnific-popup' );

		// Enqueue Dashicons font family used in Post Formats.
		// Only post formats icons are used by our theme
		if( true == is_home() OR true == is_archive() OR true == is_single() ) { // Only enqueue it when the blog is being displayed
			//wp_enqueue_style( 'dashicons' );
			wp_enqueue_script( 'ivan_owl_carousel' );
			wp_enqueue_style( 'ivan_owl_carousel' );
		}

		// Register main theme styles and enqueue it.
		// Hint: you can unregister it and replace by your own compiled version in a child theme.
		wp_register_style( 'ivan-theme-styles', get_template_directory_uri() . '/css/theme-styles'.$prefix.'.css', array(), '1' );
		wp_enqueue_style('ivan-theme-styles');

		// Enqueue default style.css stylesheet.
		// Hint: use it to create a child theme or add simple custom rules.
		wp_enqueue_style( 'ivan-default-style', get_stylesheet_uri() );

		// Enqueue IE conditional styles
		global $wp_styles;
		wp_enqueue_style('ie-ivan-theme-styles', get_template_directory_uri() . '/css/ie.css', array(), null);
		$wp_styles->add_data( 'ie-ivan-theme-styles', 'conditional', 'IE' );

	/**
	* Enqueue theme scripts
	*/

		// Enqueue default WordPress jQuery lib
		wp_enqueue_script( 'jquery' );

		wp_deregister_script('waypoints');
		wp_deregister_script( 'prettyphoto' );
		wp_deregister_style( 'prettyphoto' );

		// Register theme scripts and enqueue it.
		wp_register_script( 'ivan-theme-scripts', get_template_directory_uri() . '/js/theme-scripts'.$prefix.'.js', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'ivan-theme-scripts');

		// Localize Args
		$localizeArgs = array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ), 
			'nonce' => wp_create_nonce( 'ajax-nonce' ),
			'preload' => false
		);

		if(true == ivan_get_option('enable-preloader'))
			$localizeArgs['preload'] = true;

		wp_localize_script( 'ivan-theme-scripts', 'ivan_theme_scripts', $localizeArgs );

		// Enqueue reply comment default script in single posts, if possible.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
}
add_action( 'wp_enqueue_scripts', 'ivan_scripts', 99 );

/**
 * Enqueue scripts and styles.
 */
function ivan_styles_rtl() {

	// Defines prefix based in DEBUG constant to theme assets
	$prefix = '';
	if( false == IVAN_DEBUG ) {
		$prefix = '.min';
	}

	// RTL Only: Enqueue rtl.css stylesheet if locale is RTL
	if( true == is_rtl() ) {
		wp_enqueue_style( 'ivan-theme-styles-rtl', get_template_directory_uri() . '/css/rtl'.$prefix.'.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'ivan_styles_rtl', 200 );

function ivan_vc_remove_waypoints() {
	wp_deregister_script('waypoints');
}
add_action( 'admin_enqueue_scripts', 'ivan_vc_remove_waypoints', 99);
add_action( 'template_redirect', 'ivan_vc_remove_waypoints', 99);

function ivan_megamenu_fonts() {
	// Register Font Awesome and enqueue it.
	// Source: http://fortawesome.github.io/Font-Awesome/
	wp_register_style( 'ivan-font-awesome', get_template_directory_uri() . '/css/libs/font-awesome-css/font-awesome.min.css', array(), '4.1.0' );

	// Register Elegant Icons and enqueue it.
	// Infos: 100 icons
	wp_register_style( 'ivan-elegant-icons', get_template_directory_uri() . '/css/libs/elegant-icons/elegant-icons.min.css', array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'ivan_megamenu_fonts');

// Ensures Ivan Visual Composer use Local CSS Files
define('IVAN_VC_LOCAL_GRID', true);
define('IVAN_VC_LOCAL_STYLES', true);
define('IVAN_VC_LOCAL_FONTS', true);
define('IVAN_VC_LOCAL_OWL', true);

// Ivan VC Container
add_filter('ivan_vc_container_selector', 'ivan_vc_container_selector_theme');
function ivan_vc_container_selector_theme($container) {

	if(false == ivan_get_option('page-boxed-page'))
		$container = '.content-wrapper';
	else
		$container = '.boxed-page-wrapper';

	return $container;
}