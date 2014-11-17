<?php
/**
 * Basic Customizer
 *
 * This is used to allow users customize primary font, heading font and accent color.
 *
 * Use: http://rvision.ws/cssextractor/
 *
 *
 */

// Customizer Output
function ivan_customizer_output() {

	$output = '';

	ob_start();

	// Link Color
	$linkColor = ivan_get_option('ivan-link-color');

	if($linkColor != '') :
	?>
		
	a,
	.btn-link,
	a.jm-post-like:hover,
	a.jm-post-like:active,
	a.jm-post-like:focus,
	a.liked:hover,
	a.liked:active,
	a.liked:focus {
	  color: <?php echo $linkColor; ?>;
	}

	.post .share-icons a:hover,
	.woocommerce table.cart a.remove:hover,
	.woocommerce-page table.cart a.remove:hover,
	.woocommerce-wishlist .share-icons a:hover,
	.woocommerce div.product div.summary .share-icons a:hover,
	.woocommerce-page div.product div.summary .share-icons a:hover,
	.woocommerce div.product .woocommerce-tabs ul.tabs.tabs-vertical li a:hover,
	.woocommerce-page div.product .woocommerce-tabs ul.tabs.tabs-vertical li a:hover {
	  color: <?php echo $linkColor; ?>;
	  border-color: <?php echo $linkColor; ?>;
	}

	.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
	.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a {
	  color: <?php echo $linkColor; ?>;
	  border-top-color: <?php echo $linkColor; ?>;
	}

	<?php
	endif;

	// Custom Accent BG
	$accentBG = ivan_get_option('ivan-custom-accent');
	$accentColor = '#fff'; // Default
	if( '' != ivan_get_option('ivan-custom-accent-color') )
		$accentColor = ivan_get_option('ivan-custom-accent-color');


	if($accentBG != '') :
	?>
	a:hover,
	a:focus,
	.btn:hover,
	.button:hover,
	button:hover,
	input[type="submit"]:hover,
	.btn:focus,
	.button:focus,
	button:focus,
	input[type="submit"]:focus,
	.btn:active,
	.button:active,
	button:active,
	input[type="submit"]:active,
	.btn.active,
	.button.active,
	button.active,
	input[type="submit"].active,
	.open .dropdown-toggle.btn,
	.open .dropdown-toggle.button,
	.open .dropdown-togglebutton,
	.open .dropdown-toggleinput[type="submit"],
	.btn-link:hover,
	.btn-link:focus,
	.entry-author-meta .author-social-icon:hover,
	#comments .comment-body .comment-meta .comment-reply-link:hover {
	  color: <?php echo $accentBG; ?>;
	}

	.btn:hover,
	.button:hover,
	button:hover,
	input[type="submit"]:hover,
	.btn:focus,
	.button:focus,
	button:focus,
	input[type="submit"]:focus,
	.btn:active,
	.button:active,
	button:active,
	input[type="submit"]:active,
	.btn.active,
	.button.active,
	button.active,
	input[type="submit"].active,
	.open .dropdown-toggle.btn,
	.open .dropdown-toggle.button,
	.open .dropdown-togglebutton,
	.open .dropdown-toggleinput[type="submit"],
	.btn-default:hover,
	.btn-default:focus,
	.btn-default:active,
	.btn-default.active,
	.open .dropdown-toggle.btn-default,
	.btn-primary,
	.btn-primary:hover,
	.btn-primary:focus,
	.btn-primary:active,
	.btn-primary.active,
	.open .dropdown-toggle.btn-primary,
	.btn-primary.disabled,
	.btn-primary[disabled],
	fieldset[disabled] .btn-primary,
	.btn-primary.disabled:hover,
	.btn-primary[disabled]:hover,
	fieldset[disabled] .btn-primary:hover,
	.btn-primary.disabled:focus,
	.btn-primary[disabled]:focus,
	fieldset[disabled] .btn-primary:focus,
	.btn-primary.disabled:active,
	.btn-primary[disabled]:active,
	fieldset[disabled] .btn-primary:active,
	.btn-primary.disabled.active,
	.btn-primary[disabled].active,
	fieldset[disabled] .btn-primary.active,
	.btn-primary .badge,
	.btn-warning:hover,
	.btn-warning:focus,
	.btn-warning:active,
	.btn-warning.active,
	.open .dropdown-toggle.btn-warning,
	.btn-danger:hover,
	.btn-danger:focus,
	.btn-danger:active,
	.btn-danger.active,
	.open .dropdown-toggle.btn-danger,
	.btn-success:hover,
	.btn-success:focus,
	.btn-success:active,
	.btn-success.active,
	.open .dropdown-toggle.btn-success,
	.btn-info:hover,
	.btn-info:focus,
	.btn-info:active,
	.btn-info.active,
	.open .dropdown-toggle.btn-info,
	.iv-mobile-menu-wrapper .current-menu-item > a,
	.iv-layout.top-header input[type="submit"]:hover,
	.iv-layout.top-header .woo-cart .buttons a:hover,
	.iv-layout.top-header .login-ajax .lwa input[type="submit"]:hover,
	.iv-layout.header input[type="submit"]:hover,
	.iv-layout.header .woo-cart .buttons a:hover,
	.iv-layout.header .login-ajax .lwa input[type="submit"]:hover,
	.iv-layout.footer .widget input[type="submit"]:hover,
	#infinite-handle span,
	.thumbnail-hover .overlay,
	#all-site-wrapper .mejs-controls .mejs-time-rail .mejs-time-current,
	#all-site-wrapper .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current
	.page-links a:hover span,
	.single-post .entry-tags a:hover,
	p.demo_store,
	.woocommerce a.button.alt,
	.woocommerce-page a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce-page button.button.alt,
	.woocommerce input.button.alt,
	.woocommerce-page input.button.alt,
	.woocommerce #respond input#submit.alt,
	.woocommerce-page #respond input#submit.alt,
	.woocommerce a.button.alt:hover,
	.woocommerce-page a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce-page button.button.alt:hover,
	.woocommerce input.button.alt:hover,
	.woocommerce-page input.button.alt:hover,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce-page #respond input#submit.alt:hover,
	.page-loader-spinner > div {
	  background-color: <?php echo $accentBG; ?>;
	  border-color: <?php echo $accentBG; ?>;
	  color: <?php echo $accentColor; ?>;
	}

	.woocommerce span.onsale,
	.woocommerce-page span.onsale,
	.woocommerce .widget_layered_nav_filters ul li a,
	.woocommerce-page .widget_layered_nav_filters ul li a {
		background-color: <?php echo $accentBG; ?>;
		color: <?php echo $accentColor; ?>;
	}

	.paging-navigation a:hover,
	.blog-full .paging-navigation a:hover,
	.blog-mansory .paging-navigation a:hover,
	.boxed-style .paging-navigation a:hover,
	.blog-full .paging-navigation span:hover,
	.blog-mansory .paging-navigation span:hover,
	.boxed-style .paging-navigation span:hover,
	.blog-full .paging-navigation a.current,
	.blog-mansory .paging-navigation a.current,
	.boxed-style .paging-navigation a.current,
	.blog-full .paging-navigation span.current,
	.blog-mansory .paging-navigation span.current,
	.boxed-style .paging-navigation span.current,
	.sidebar .widget.widget_tag_cloud a:hover {
		border-color: <?php echo $accentBG; ?>;
		color: <?php echo $accentBG; ?>;
	}
	<?php
	endif;

	// Heading Color
	$headingColor = ivan_get_option('ivan-heading-color');

	if($headingColor != '') :
	?>
		
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.woocommerce div.product div.summary span.price,
	.woocommerce-page div.product div.summary span.price,
	.woocommerce div.product div.summary p.price,
	.woocommerce-page div.product div.summary p.price,
	.woocommerce table.shop_table th,
	.woocommerce-page table.shop_table th,
	.woocommerce .cart-collaterals .cart_totals h2,
	.woocommerce-page .cart-collaterals .cart_totals h2,
	.woocommerce .coupon label,
	.woocommerce-page .coupon label,
	.woocommerce .shipping-calculator-button,
	.woocommerce-page .shipping-calculator-button {
		color: <?php echo $headingColor; ?>;
	}

	.sidebar .widget.widget_tag_cloud a {
		color: <?php echo $headingColor; ?>;
		border-color: <?php echo $headingColor; ?>;
	}

	<?php
	endif;

	// Heading Weight
	$headingWeight = ivan_get_option('ivan-heading-weight');

	if($headingWeight != '') :
	?>
		
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.sidebar .widget.widget_tag_cloud a,
	.woocommerce div.product div.summary span.price,
	.woocommerce-page div.product div.summary span.price,
	.woocommerce div.product div.summary p.price,
	.woocommerce-page div.product div.summary p.price,
	.woocommerce table.shop_table th,
	.woocommerce-page table.shop_table th,
	.woocommerce .cart-collaterals .cart_totals h2,
	.woocommerce-page .cart-collaterals .cart_totals h2,
	.woocommerce .coupon label,
	.woocommerce-page .coupon label,
	.woocommerce .shipping-calculator-button,
	.woocommerce-page .shipping-calculator-button {
		font-weight: <?php echo $headingWeight; ?>;
	}

	<?php
	endif;

	// Heading Weight Widget and Title
	$headingWidgetWeight = ivan_get_option('ivan-side-title-heading-weight');

	if($headingWidgetWeight != '') :
	?>
		
	.post .entry-title,
	.sidebar .widget .widget-title {
		font-weight: <?php echo $headingWidgetWeight; ?>;
	}

	<?php
	endif;

	// Custom Title Wrapper Color and Height Calcs
	$titleTypo = ivan_get_option('title-wrapper-font');

	if( is_array($titleTypo) && isset($titleTypo['color']) ) {
		if( $titleTypo['color'] != '' ) : ?>

		.iv-layout.title-wrapper a, .iv-layout.title-wrapper a:hover {
			color: <?php echo $titleTypo['color']; ?>;
		}

		<?php
		endif;
	}

	// Remove aside border of header
	if( ivan_get_option('aside-header-remove-border') == true ) :
	?>
		.ivan-m-l-aside.ivan-m-l-aside-left .ivan-main-layout-aside-left {
			border-right: none;
		}

		.ivan-m-l-aside.ivan-m-l-aside-right .ivan-main-layout-aside-right {
			border-left: none;
		}
	<?php
	endif;

	$output = ob_get_contents();
	ob_end_clean();
	// Check if can print something...
	if('' != $output) :
		echo '<style type="text/css">' . $output . '</style>';
	endif;// end main check

}
add_action('wp_head', 'ivan_customizer_output', 210);

// Add Presets to Options

