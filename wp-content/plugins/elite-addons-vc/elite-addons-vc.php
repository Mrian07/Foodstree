<?php
/*
Plugin Name: Elite Addons for Visual Composer
Plugin URI: http://code9rs.com/
Description: Extend Visual Composer with useful modules and customizer capabilities.
Version: 1.0
Author: CodeNiners
Author URI: http://code9rs.com/
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

/*
Display notice if Visual Composer is not installed or activated.
*/

add_action('init','ivan_vc_init_addons', 5);
function ivan_vc_init_addons()
{
	$required_vc = '3.7.4';
	if(defined('WPB_VC_VERSION')){

		if( version_compare( $required_vc, WPB_VC_VERSION, '>' )){
			add_action( 'admin_notices', 'ivan_vc_admin_notice_for_version');
			define('IVAN_VC_NOT_ENABLED', true);
		}

		if( version_compare( '3.7.4', WPB_VC_VERSION, '==') ) {
			// Running 3.7.4 must remove a few options like call to action 2
			define("IVAN_VC_RUN_OLD", true);
		}

		// Var used to enqueue updated files instead old to keep backwards compatibility...
		if ( version_compare( '4.2.3', WPB_VC_VERSION, '<') ) {
			define("IVAN_VC_RUN_LATEST", true);
		}

	} else {
		define('IVAN_VC_NOT_ENABLED', true);
		add_action( 'admin_notices', 'ivan_vc_admin_notice_for_vc_activation');
	}
}// end init_addons

function ivan_vc_admin_notice_for_version()
{
	echo '<div class="updated"><p>The <strong>Elite Addons for Visual Composer</strong> plugin requires <strong>Visual Composer</strong> version 3.7.4 or greater.</p></div>';
}
function ivan_vc_admin_notice_for_vc_activation()
{
	echo '<div class="updated"><p>The <strong>Elite Addons for Visual Composer</strong> plugin requires <strong>Visual Composer</strong> Plugin installed and activated.</p></div>';
}

// Define contants used to register and enqueue styles/scripts and require our files as well
define('IVAN_VC_DIR', plugin_dir_path( __FILE__ ) );
define('IVAN_VC_URL', plugins_url('', __FILE__ ) );

// Adds dashboard options page
require_once IVAN_VC_DIR . 'admin.php';

// Start custom global variable used by our customizer to output the CSS at page end!
global $ivan_custom_css;

// Global init action to require our frontend codes
function ivan_vc_cpt_init() {
	// Include Custom Post Types
	require_once IVAN_VC_DIR . 'cpt.php';
}
add_action('setup_theme', 'ivan_vc_cpt_init');


function ivan_vc_cpt_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.

    // Register Projects Post Type
    register_post_type( 'ivan_vc_projects', array(
    	'menu_icon' => 'dashicons-feedback',
    	'labels' => array(
    		'name' => __( 'Projects', '_sdomain' ),
    		'singular_name' => __( 'Project', '_sdomain' ),
    		'add_new' => __( 'Add Project', '_sdomain' ),
    		'add_new_item' => __( 'Add Project', '_sdomain' ),
    		'edit' => __( 'Edit', '_sdomain' ),
    		'edit_item' => __( 'Edit Project', '_sdomain' ),
    		'new_item' => __( 'New Project', '_sdomain' ),
    		'view' => __( 'View Project', '_sdomain' ),
    		'view_item' => __( 'View Project', '_sdomain' ),
    		'search_items' => __( 'Search Project', '_sdomain' ),
    		'not_found' => __( 'No Project found', '_sdomain' ),
    		'not_found_in_trash' => __( 'No Project found in Trash', '_sdomain' ),
    		'parent' => __( 'Parent Project', '_sdomain' ),
    	),
    	//'has_archive' => true,
    	'publicly_queryable' => true,
    	'public' => true,
    	'rewrite' => array( 'slug' => apply_filters('ivan_vc_project_slug', 'project') ),
    	'supports' => array( 'title', 'excerpt', 'editor', 'thumbnail', ''  ),
    	//'taxonomies' => array('post_tag'),
    ));	

    ivan_vc_cpt_init();

    // ATTENTION: This is *only* done during plugin activation hook
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ivan_vc_cpt_flush' );


// Global init action to require our frontend codes
function ivan_vc_init() {
	if(!defined('IVAN_VC_NOT_ENABLED')) {

		// Include Customizer functions and libs necessary to the use of Customizer.
		require_once IVAN_VC_DIR . 'param/ivan_customizer.php';
		require_once IVAN_VC_DIR . 'param/ivan_customizer_id.php';

		// Require Modules
		require_once IVAN_VC_DIR . 'modules/shortcodes.php';

		require_once IVAN_VC_DIR . 'modules/row.php';
		require_once IVAN_VC_DIR . 'modules/text.php';
		require_once IVAN_VC_DIR . 'modules/projects.php';
		require_once IVAN_VC_DIR . 'modules/posts.php';
		require_once IVAN_VC_DIR . 'modules/title_wrapper.php';
		require_once IVAN_VC_DIR . 'modules/counter.php';
		require_once IVAN_VC_DIR . 'modules/image_block.php';
		require_once IVAN_VC_DIR . 'modules/carousel.php';
		require_once IVAN_VC_DIR . 'modules/pricing_table.php';
		require_once IVAN_VC_DIR . 'modules/contact_form.php';
		require_once IVAN_VC_DIR . 'modules/testimonial.php';
		require_once IVAN_VC_DIR . 'modules/staff.php';
		require_once IVAN_VC_DIR . 'modules/button.php';
		require_once IVAN_VC_DIR . 'modules/table.php';
		require_once IVAN_VC_DIR . 'modules/woo.php';
		require_once IVAN_VC_DIR . 'modules/tweet.php';
		require_once IVAN_VC_DIR . 'modules/gmap.php';

		require_once IVAN_VC_DIR . 'modules/separator.php';
		require_once IVAN_VC_DIR . 'modules/toggle.php';
		require_once IVAN_VC_DIR . 'modules/tabs.php';
		require_once IVAN_VC_DIR . 'modules/accordion.php';
		require_once IVAN_VC_DIR . 'modules/gallery.php';

		require_once IVAN_VC_DIR . 'modules/blockquote.php';
		require_once IVAN_VC_DIR . 'modules/message.php';
		require_once IVAN_VC_DIR . 'modules/list.php';
		require_once IVAN_VC_DIR . 'modules/icon_list.php';
		require_once IVAN_VC_DIR . 'modules/icon.php';
		require_once IVAN_VC_DIR . 'modules/icon_box.php';
		require_once IVAN_VC_DIR . 'modules/progress_bar.php';
		require_once IVAN_VC_DIR . 'modules/service.php';
		require_once IVAN_VC_DIR . 'modules/image_flip.php';
		require_once IVAN_VC_DIR . 'modules/pie_chart.php';

		require_once IVAN_VC_DIR . 'modules/call_to_action.php';

		require_once IVAN_VC_DIR . 'modules/widget.php';
		require_once IVAN_VC_DIR . 'modules/single_image.php';

		// Require map of shortcodes
		require_once IVAN_VC_DIR . 'map.php';

		// Useful Icon Shortcode
		add_shortcode('iv_icon', 'iv_code_icon_func');
	}
}
add_action('init', 'ivan_vc_init', 100);

// Global admin_init action to require back-end codes
function ivan_vc_admin_init() {
	if(!defined('IVAN_VC_NOT_ENABLED')) {

		// Add new VC param to our customizer
		add_shortcode_param('ivan_customizer', 'ivan_vc_customizer_field', IVAN_VC_URL . '/assets/param/ivan_customizer.js');
		add_shortcode_param('ivan_customizer_id', 'ivan_vc_customizer_id_field', IVAN_VC_URL . '/assets/param/ivan_customizer_id.js');
	}
}
add_action('admin_init', 'ivan_vc_admin_init', 2);

/*
Load Customizer Styles
*/
if( (isset($_GET['vc_action']) && $_GET['vc_action'] === 'vc_inline') ) {
	add_action('admin_enqueue_scripts', 'ivan_customizer_styles');

	function ivan_customizer_styles() {
		wp_enqueue_style('ivan-vc-customizer', IVAN_VC_URL . '/assets/param/ivan_customizer.css');

		// Running versions before latest...
		if( false == defined("IVAN_VC_RUN_LATEST") ) :
			wp_enqueue_script('ivan-vc-custom-views', IVAN_VC_URL . '/assets/param/ivan_custom_views.js', array( 'vc_inline_build_js' ), '1.0', true);
		else :
			wp_enqueue_script('ivan-vc-custom-views', IVAN_VC_URL . '/assets/param/ivan_custom_views_newest.js', array( 'vc_inline_build_js' ), '1.1', true);
		endif;
	}
}

if( !isset($_GET['vc_action']) ) {
	add_action('admin_print_styles', 'ivan_customizer_styles_back', 300);
	function ivan_customizer_styles_back() {
		wp_enqueue_style('ivan-vc-customizer-back', IVAN_VC_URL . '/assets/param/ivan_customizer_back.css', array('js_composer') );
	}
}

if( (isset($_GET['vc_editable']) && $_GET['vc_editable'] === 'true') || (isset($_GET['vceditor']) && $_GET['vceditor'] === 'true') ) {
	add_action('wp_enqueue_scripts', 'ivan_inline_styles_front');

	function ivan_inline_styles_front() {
		// Running versions before latest...
		if( false == defined("IVAN_VC_RUN_LATEST") ) :
			wp_enqueue_style('ivan-vc-inline', IVAN_VC_URL . '/assets/param/ivan_inline.css');
		else :
			wp_enqueue_style('ivan-vc-inline', IVAN_VC_URL . '/assets/param/ivan_inline_newest.css');
		endif;

		wp_enqueue_script('ivan-vc-custom-vc-iframe', IVAN_VC_URL . '/assets/param/ivan_custom_vc_iframe.js', array( 'vc_inline_iframe_js' ), '1.0', true);
	}
}

// Adds custom class to body, this will be used by our scripts for a few checks.
function ivan_vc_add_body_classes($classes) {
	$classes[] = 'ivan-vc-enabled';

	return $classes;
}
add_filter( 'body_class', 'ivan_vc_add_body_classes');

// Output Customizer final CSS to footer (before all other styles as well!)
function ivan_vc_custom_css() {
	global $ivan_custom_css;
	echo '<style type="text/css">' . $ivan_custom_css . '</style>';
}
add_action('wp_footer', 'ivan_vc_custom_css', 2);

/*
Load plugin css and javascript files
*/
add_action('wp_enqueue_scripts', 'vc_extend_js_css', 50);
/*add_action('admin_enqueue_scripts', 'vc_extend_js_css');*/
function vc_extend_js_css() {

	if( false == defined('IVAN_VC_LOCAL_GRID') ) {
		wp_register_style( 'ivan_vc_grid', IVAN_VC_URL . '/assets/libs/bootstrap/ivan_grid.css' );
		wp_enqueue_style( 'ivan_vc_grid' );
	}

	if( false == defined('IVAN_VC_LOCAL_STYLES') ) {
		wp_register_style( 'ivan_vc_modules', IVAN_VC_URL . '/assets/modules.min.css' );
		wp_enqueue_style( 'ivan_vc_modules' );
	}

	if( false == defined('IVAN_VC_LOCAL_FONTS') ) {
		// Register Font Awesome and enqueue it.
		// Source: http://fortawesome.github.io/Font-Awesome/
		wp_register_style( 'ivan-font-awesome', IVAN_VC_URL . '/assets/libs/font-awesome-css/font-awesome.min.css', array(), '4.1.0' );
		wp_enqueue_style( 'ivan-font-awesome' );

		// Register Elegant Icons and enqueue it.
		// Infos: 100 icons
		wp_register_style( 'ivan-elegant-icons', IVAN_VC_URL . '/assets/libs/elegant-icons/elegant-icons.css', array(), '1.0' );
		wp_enqueue_style( 'ivan-elegant-icons' );

		/*
		// Register PE 7 Icons
		// Infos: 170 icons - http://themes-pixeden.com/font-demos/7-stroke/index.html
		wp_register_style( 'ivan-pe7-icons', IVAN_VC_URL . '/assets/libs/pe-icons/css/pe-icon-7-stroke.css', array(), '1.0' );
		wp_enqueue_style( 'ivan-pe7-icons' );
		*/
		
	}

	// If you need any javascript files on front end, here is how you can load them.
	wp_register_script( 'ivan_vc_modules_js', IVAN_VC_URL . '/assets/modules.min.js', array('jquery'), '1.1', true );
	wp_enqueue_script( 'ivan_vc_modules_js' );

	// Localize Args
	$localizeArgs = array( 
		'isAdmin' => is_admin(),
		'container' => apply_filters('ivan_vc_container_selector', 'window'),
	);

	wp_localize_script( 'ivan_vc_modules_js', 'ivan_vc', $localizeArgs );

	// Projects Assets
	if( false == defined('IVAN_VC_LOCAL_OWL') ) {
		wp_register_script( 'ivan_owl_carousel', IVAN_VC_URL . '/assets/owl-carousel/owl.carousel.min.js', array('jquery'), '1.0', true );
		wp_register_style( 'ivan_owl_carousel', IVAN_VC_URL . '/assets/owl-carousel/owl.carousel.min.css' );
	}

	// Register Magnific Popup and enqueue it.
	// Source: http://github.com/dimsemenov/Magnific-Popup
	wp_register_style( 'magnific-popup', IVAN_VC_URL . '/assets/libs/magnific-popup/magnific-popup.min.css', array(), '0.9.9' );
	wp_enqueue_style( 'magnific-popup' );

	// Projects and Posts
	wp_register_script( 'ivan_vc_projects', IVAN_VC_URL . '/assets/projects.min.js', array('jquery'), '1.1', true );

	// Maps
	wp_register_script( 'ivan_vc_gmap_api', 'http://maps.google.com/maps/api/js?sensor=true', array('jquery') );
	wp_register_script( 'ivan_vc_gmaps', IVAN_VC_URL . '/assets/libs/gmaps/gmaps.js', array('ivan_vc_gmap_api'), '0.4.13', true );
}

function ivan_style_val( $value ) {
	if(ctype_digit($value))
		return $value . 'px';
	else
		return $value;
}

/* Define Support Social Icons by Staff */
function ivan_vc_staff_icons() {
	return apply_filters('ivan_vc_staff_icons', array(
		'envelope' => 'Mail',
		'facebook' => 'Facebook',
		'twitter' => 'Twitter',
		'pinterest' => 'Pinterest',
		'linkedin' => 'LinkedIn',
		"dribbble" => "Dribbble",
		'youtube' => 'Youtube',
		'instagram' => 'Instagram',
		"flickr" => "Flickr",
		"tumblr" => "Tumblr",
		"vk" => "VK",
		"vimeo_square" => "Vimeo",
		"google_plus" => "Google+",
		"foursquare" => "FourSquare",
		"yahoo" => "Yahoo",
		"wordpress" => "WordPress",
		"stumbleupon" => "StumbleUpon",
		"soundcloud" => "SoundCloud",
		"skype" => "Skype",
		"vine" => "Vine",
		"xing" => "Xing",
		"weibo" => "Weibo",
		"tencent_weibo" => "Tecent Weibo",
		"twitch" => "Twitch",
		"renren" => "RenRen",
		"github" => "GitHub",
		"bitbucket" => "BitBucket",		
	) );
}