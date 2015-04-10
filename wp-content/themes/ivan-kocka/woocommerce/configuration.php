<?php
/**
 * WooCommerce plugin configuration
 *
 * Define WooCommerce configuration, filters and everything necessary
 *
 * @package ivan_framework
 */

// Remove default styles and add theme support
if ( ! function_exists( 'ivan_woo_setup' ) ) :
function ivan_woo_setup() {

	//Disable Woo styles (will use customized compiled copy)
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );

	//Enable WooCommerce Support
	add_theme_support( 'woocommerce' );
}
endif; // flatsome_setup
add_action( 'after_setup_theme', 'ivan_woo_setup' );

// Remove default WooCommerce Filters

	// Archives
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

	add_action( 'woocommerce_display_sorting', 'woocommerce_result_count', 20 );
	add_action( 'woocommerce_display_sorting', 'woocommerce_catalog_ordering', 30 );

	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
	
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); // removes stars from product display

// Before/After Shop Loop
add_action( 'woocommerce_before_shop_loop', 'ivan_before_shop_loop', 10);
function ivan_before_shop_loop() {
	?>
	<div class="row">
	<?php
}

add_action( 'woocommerce_after_shop_loop', 'ivan_after_shop_loop', 10);
function ivan_after_shop_loop() {
	?>
	</div>
	<?php
}

// Products per Page
$ivan_woo_products_per_page = ivan_get_option('woo-per-page');
add_filter( 'loop_shop_per_page', create_function( '$cols', "return $ivan_woo_products_per_page;" ), 20 );

// Products Columns
add_filter('loop_shop_columns', 'ivan_woo_product_columns');
function ivan_woo_product_columns() {
	global $woocommerce;

	// Columns used by default
	$columns = ivan_get_option('woo-shop-columns');
	// In Product Listing...
	if ( is_product_category() ) :
		$columns = $columns; //@todo: add option...
	endif;

	// In Related Products...
	if ( is_product() ) :
	$columns = 1;
	endif;

	return $columns; 
}

// Enqueue scripts and styles
function ivan_woo_load_scripts() {

	// Defines prefix based in DEBUG constant to theme assets
	$prefix = '';
	if( false == IVAN_DEBUG ) {
		$prefix = '.min';
	}

	/**
	* Enqueue WooCommerce Styles and Scripts
	*/

	// Enqueue Custom Theme Styles
	wp_enqueue_style( 'woocommerce-layout', get_template_directory_uri() . '/css/woocommerce/css/woocommerce-layout'.$prefix.'.css', '', WC_VERSION, 'all' );

	wp_enqueue_style( 'woocommerce-smallscreen', get_template_directory_uri() . '/css/woocommerce/css/woocommerce-smallscreen'.$prefix.'.css', 'woocommerce-layout', WC_VERSION, 
		'only screen and (max-width: ' . apply_filters( 'woocommerce_style_smallscreen_breakpoint', $breakpoint = '768px' ) . ')' );

	wp_enqueue_style( 'woocommerce-general', get_template_directory_uri() . '/css/woocommerce/css/woocommerce'.$prefix.'.css', '', WC_VERSION, 'all' );

	// Enqueue Custom Theme Scripts

	/* remove woocommerce add-to-cart variation.js. Its added in theme.js */
	wp_deregister_script('wc-add-to-cart-variation');

	wp_enqueue_script( 'ivan_owl_carousel' );
	wp_enqueue_style( 'ivan_owl_carousel' );

	wp_enqueue_script( 'ivan-woo-scripts', get_template_directory_uri() . '/js/woocommerce/woo-scripts'.$prefix.'.js', array( 'jquery' ), '1', true );

	wp_localize_script( 'ivan-woo-scripts', 'wc_add_to_cart_variation_params', apply_filters( 'wc_add_to_cart_variation_params', array(
		'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
		'i18n_unavailable_text'			=> esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' )
		) )
	);

	// Remove Currency Switcher default style
	wp_deregister_style('currency-switcher');

}
add_action( 'wp_enqueue_scripts', 'ivan_woo_load_scripts', 150 );

// Quick View AJAX action
add_action('wp_ajax_ivan_woo_quick_view', 'ivan_woo_quick_view');
add_action('wp_ajax_nopriv_ivan_woo_quick_view', 'ivan_woo_quick_view');

function ivan_woo_quick_view() {
	global $product, $woocommerce, $post;

	$product_id = $_POST["product"];
	
	$post = get_post( $product_id );

	$product = get_product( $product_id );

	// After set global product and post, we start to output...
	ob_start();
	?>

	<?php
	// Call our template to display the product infos
	woocommerce_get_template( 'content-single-product-quick-view.php'); 
	?>

	<?php
	$output = ob_get_contents();
	ob_end_clean();

	// Display buffer content
	echo $output;

	// Bye bye :)
	die();
}

// Actions to style Quick View Content properly
//add_action( 'woocommerce_single_product_quick_view_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_quick_view_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_quick_view_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_quick_view_summary', 'woocommerce_template_single_add_to_cart', 30 );

// Single Products Hooks Organization
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

// Add Stacked thumbnail support
if( true == ivan_get_option('woo-thumbnail-stacked') ) {
	add_filter( 'ivan_woo_single_product_thumb_area', 'ivan_woo_stacked_thumbnail');
	add_filter( 'ivan_woo_single_product_summary_area', 'ivan_woo_stacked_thumbnail');
}

function ivan_woo_stacked_thumbnail( $col ) {
	return 'col-xs-12 col-sm-12 col-md-12 stacked';
}

if( true == ivan_get_option('woo-list-layout') ) {
	add_filter('ivan_woo_shop_template', 'ivan_woo_shop_list_template');
}
function ivan_woo_shop_list_template( $template ) {
	return 'product-list';
}

// Change Cross Sells at Cart - Columns
add_filter('woocommerce_cross_sells_columns', 'ivan_woo_cross_sells_columns');
function ivan_woo_cross_sells_columns( $cols ) {
	return 1;
}

// Change Cross Sells at Cart - Columns
add_filter('woocommerce_cross_sells_total', 'ivan_woo_cross_sells_total');
function ivan_woo_cross_sells_total( $items ) {
	return 12;
}

// Category Custom Header
if( true == ivan_get_option('woo-category-image') ) {
	add_action( 'custom_woocommerce_archive_description', 'ivan_woo_category_header', 2 );
}

function ivan_woo_category_header() {
	if ( is_product_category() ) :

		$_image = ivan_woo_get_category_image();

		if( false != $_image ) :

			echo '<div class="category-header">';
				echo do_shortcode( $_image );
			echo '</div>';

		endif;

	endif;
}

function ivan_woo_get_category_image() {
	global $wp_query;
	$cat_id = $wp_query->get_queried_object_id();
	$desc = term_description( $cat_id, 'product_cat' );

	if ( $desc != '' ) {
		return $desc;
	}

	return false;
}

/*
function ivan_woo_category_header() {
	if ( is_product_category() ) :

		$_image = ivan_woo_get_category_image();

		if( false != $_image ) :

			echo '<div class="category-header">';
				echo '<img src="' . $_image . '" alt="">';
			echo '</div>';

		endif;

	endif;
}

function ivan_woo_get_category_image() {
	global $wp_query;
	$cat = $wp_query->get_queried_object();
	$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	$image = wp_get_attachment_url( $thumbnail_id );

	if ( $image ) {
		return $image;
	}

	return false;
}
*/

// Avoid strip HTML tags in Category Descs
foreach ( array( 'pre_term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_filter_kses' );
}
 
foreach ( array( 'term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_kses_data' );
}

// Display Options
/*
if( true == ivan_get_option('woo-display-sorting') )
	add_action( 'custom_woocommerce_archive_description', 'ivan_woo_display_opts', 5 );
function ivan_woo_display_opts() {
	echo '<div class="sorting-opts">';
		do_action( 'woocommerce_display_sorting' ); 
	echo '<div class="clearfix"></div></div>';
}
*/

// Share Product
add_action('woocommerce_share', 'ivan_woo_custom_share', 10);
function ivan_woo_custom_share() {

	global $post, $product;
	?>

	<div class="share-icons">
		<?php
			$pinImg = '';
			if(has_post_thumbnail( $post->ID ) ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
				$pinImg = urlencode($image[0]);
			}

			$permalink = urlencode( get_permalink() );
			$title = urlencode( get_the_title() );

			?>
			<a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
			<a href="http://twitter.com/home?status=<?php echo $title; ?> - <?php echo $permalink; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
			<!-- <a href="https://plus.google.com/share?url=<?php echo $permalink; ?>&title=<?php echo $title; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
			<a href="http://linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $title; ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo $permalink; ?>&media=<?php echo $pinImg; ?>&description=<?php echo $title; ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
			<a href="mailto:?subject=<?php echo $title; ?>&body=<?php echo $permalink; ?>"><i class="fa fa-envelope"></i></a> -->

	</div>

	<?php
}

// Remove default Woo Cat thumbnail
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );

// Catalog Mode WooCommerce

if( true == ivan_get_option('woo-catalog-mode') ) {
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
	add_action('woocommerce_single_product_summary', 'ivan_woo_catalog_mode_msg', 30);

	remove_action('woocommerce_single_product_quick_view_summary', 'woocommerce_template_single_add_to_cart', 30);
	add_action('woocommerce_single_product_quick_view_summary', 'ivan_woo_catalog_mode_msg', 30);
}

function ivan_woo_catalog_mode_msg() {
	?>
	<div class="woo-catalog-mode">
		<div class="catalog-msg">
			<?php echo do_shortcode( ivan_get_option('woo-catalog-mode-text') ); ?>
		</div>
	</div>
	<?php
}

// Apply row class to shortcodes
add_filter('ivan_woo_loop_start', 'ivan_woo_loop_start_add_class');
function ivan_woo_loop_start_add_class($classes) {

	if( !is_shop() && !is_product_category() && !is_product() && !is_cart() && !is_checkout())
		$classes .= ' row';

	return $classes;
}

// AJAX Cart markup
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	
	ob_start();
	
	?>
	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
		<span class="cart-total"><?php echo $woocommerce->cart->get_cart_total(); ?></span>
		<div class="basket-wrapper">
			<div class="top"></div>
			<div class="basket"><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></div>
		</div>
	</a>
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}

/*
// AJAX Add to Cart from Quick View
add_action( 'wp_ajax_ivan_wc_add_to_cart', 'ivan_wc_add_to_cart' );
add_action( 'wp_ajax_nopriv_ivan_wc_add_to_cart', 'ivan_wc_add_to_cart' );
function ivan_wc_add_to_cart() {

	global $woocommerce;
	
	$data = $_POST;

	// Remove action
	unset($data['action']);
	

	if( isset($data['product_id']) ) {
		$product_id = $data['product_id'];
		unset($data['product_id']);
		unset($data['add-to-cart']);
	} else {

		if( isset($data['add-to-cart']) ) {
			$product_id = $data['add-to-cart'];
			unset($data['product_id']);
			unset($data['add-to-cart']);
		}
		else {
			echo 'No Product ID found...';
			die();
		}
	}

	$quantity = 1;
	if( isset($data['quantity']) ) {
		$quantity = $data['quantity'];
		unset($data['quantity']);
	}

	$variation_id = null;
	if( isset($data['variation_id']) ) {
		$variation_id = $data['variation_id'];
		unset($data['variation_id']);
	}

	if($variation_id == null) {
		if( $woocommerce->cart->add_to_cart( $product_id, $quantity) ) {
			// Notify by Action
			do_action( 'woocommerce_ajax_added_to_cart', $product_id );

			// Update Fragments
			do_action('woocommerce_get_refreshed_fragments');
		}
	} else {

		$att = array();

		if( $woocommerce->cart->add_to_cart( $product_id, $quantity, $variation_id, $data) ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id, $quantity, $variation_id, $data);

			// Update Fragments
			do_action('woocommerce_get_refreshed_fragments');
		}
	}

	// Print Notices
	wc_print_notices();
	wc_clear_notices();

	//var_dump($data);

	//echo 'Ok!';

	// Goodbye!
	die();
}
*/