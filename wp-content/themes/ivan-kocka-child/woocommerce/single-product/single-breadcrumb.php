<?php
/**
 * Single Product breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

$shop_page_id = wc_get_page_id( 'shop' );
$shop_page    = get_post( $shop_page_id );
$delimiter = '<span>/</span>';
$wrap_before = '<div class="breadcrumb">';
$wrap_after = '</div>';
$home = __('Home', 'ivan_domain');
$before = '';
$after = '';
$prepend = $before . '<a href="' . get_permalink( $shop_page ) . '">' . $shop_page->post_title . '</a>' . $after . $delimiter;

echo $wrap_before;

if ( ! empty( $home ) ) {
	echo $before . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) . '">' . $home . '</a>' . $after . $delimiter;
}

echo $prepend;

if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {

	$main_term = $terms[0];

	$ancestors = get_ancestors( $main_term->term_id, 'product_cat' );

	$ancestors = array_reverse( $ancestors );

	foreach ( $ancestors as $ancestor ) {
		$ancestor = get_term( $ancestor, 'product_cat' );

		if ( ! is_wp_error( $ancestor ) && $ancestor )
			echo $before . '<a href="' . get_term_link( $ancestor->slug, 'product_cat' ) . '">' . $ancestor->name . '</a>' . $after . $delimiter;
	}

	echo $before . '<a href="' . get_term_link( $main_term->slug, 'product_cat' ) . '">' . $main_term->name . '</a>' . $after . $delimiter;

}

echo $wrap_after;