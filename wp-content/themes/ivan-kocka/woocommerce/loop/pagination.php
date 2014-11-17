<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query;

if ( $wp_query->max_num_pages < 1 )
	return;
?>

<nav class="navigation paging-navigation woo-navigation" role="navigation">
	<h1 class="hidden"><?php _e( 'Products navigation', 'ivan_domain' ); ?></h1>
			
	<div class="nav-links">
		<?php

			$prev_icon = 'fa-angle-left';
			$next_icon = 'fa-angle-right';

			if( true == is_rtl() ) {
				$prev_icon = 'fa-angle-right';
				$next_icon = 'fa-angle-left';
			}
			
			$pagination_markup = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base' 			=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
				'format' 		=> '',
				'current' 		=> max( 1, get_query_var('paged') ),
				'total' 		=> $wp_query->max_num_pages,
				'prev_text' 	=> '<i class="fa '.$prev_icon.'"></i>',
				'next_text' 	=> '<i class="fa '.$next_icon.'"></i>',
				'type'			=> 'plain',
				'end_size'		=> 1,
				'mid_size'		=> 1
			) ) );

			if( $pagination_markup != null && $pagination_markup != '' )
				echo $pagination_markup;
			else {
				echo '<span class="page-numbers current">1</span>';
			}
		?>
	</div><!-- .nav-links -->
</nav><!-- .navigation -->