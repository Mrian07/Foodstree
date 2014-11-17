<?php
/*
 * Customizer
*/

$this->sections[] = array(
	'title' => __('Customizer', 'ivan_domain_redux'),
	'desc' => __('Check child sections to style properly the correct area of the theme.', 'ivan_domain_redux'),
	'icon' => 'el-icon-wrench',
	'fields' => array(

		array(
			'id'=>'remove-default-fonts',
			'type' => 'switch', 
			'title' => __('Remove default fonts?', 'ivan_domain_redux'),
			'description'=> __('If on, the theme will not include the default fonts linked. This can be used after customize the font sections and if you are not using the default fonts, you should check this option to improve performance.', 'ivan_domain_redux'),
			"default" => 0,
		),

	),
); // End Customizer Section

$this->sections[] = array(
	'title' => __('BG Colors', 'ivan_domain_redux'),
	'desc' => __('Body background and accent color configuration', 'ivan_domain_redux'),
	//'icon' => 'el-icon-wrench',
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'layout-body-bg',
			'type' => 'background',
			'output' => array('body'),
			'title' => __('Body Background', 'ivan_domain_redux'),
			'subtitle' => __('Body background with image, color and other options. Usually visible only when using boxed layout.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'layout-patterns',
			'type' => 'select_image',
			'tiles' => false,
			'title' => __('Body Background Pattern', 'ivan_domain_redux'),
			'subtitle' => __('Select a predefined background pattern. Usually visible only when using boxed layout.', 'ivan_domain_redux'),
			'options' => $default_patterns,
		),

		array(
			'id' => 'random-customizer-label',
			'type' => 'info',
			'desc' => __('Boxed Content Background', 'ivan_domain_redux')
		),

		array(
			'id' => 'layout-boxed-content-bg',
			'type' => 'background',
			'output' => array('.page .content-wrapper.page-boxed-style, .single-ivan_vc_projects .content-wrapper.page-boxed-style'),
			'title' => __('Pages: Boxed Content Background', 'ivan_domain_redux'),
			'subtitle' => __('Configuration used as background of boxed pages and projects.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'layout-boxed-patterns',
			'type' => 'select_image',
			'tiles' => false,
			'title' => __('Boxed Content Background Pattern', 'ivan_domain_redux'),
			'subtitle' => __('Select a predefined background pattern. Usually visible only when using content boxed style.', 'ivan_domain_redux'),
			'options' => $default_patterns,
		),

		array(
			'id' => 'blog-boxed-content-bg',
			'type' => 'background',
			'output' => array('.index.content-wrapper.page-boxed-style, .index.content-wrapper.page-boxed-style.boxed-style, .archives.content-wrapper.page-boxed-style, .search.content-wrapper.page-boxed-style'),
			'title' => __('Blog: Boxed Content Background', 'ivan_domain_redux'),
			'subtitle' => __('Configuration used as background of boxed blog and archives.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'single-boxed-content-bg',
			'type' => 'background',
			'output' => array('.single-post.content-wrapper.page-boxed-style, .single-post.content-wrapper.page-boxed-style.boxed-style'),
			'title' => __('Single Post: Boxed Content Background', 'ivan_domain_redux'),
			'subtitle' => __('Configuration used as background of boxed single posts.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'shop-boxed-content-bg',
			'type' => 'background',
			'output' => array('.shop-wrapper.content-wrapper.page-boxed-style, .single-product-wrapper.content-wrapper.page-boxed-style'),
			'title' => __('Shop: Boxed Content Background', 'ivan_domain_redux'),
			'subtitle' => __('Configuration used as background of boxed at shop and single product.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'random-customizer-label',
			'type' => 'info',
			'desc' => __('Blog/Single Backgrounds', 'ivan_domain_redux')
		),

		array(
			'id' => 'blog-special-content-bg',
			'type' => 'background',
			'output' => array('.blog-mansory, .blog-full, .index.content-wrapper.boxed-style, .index.content-wrapper.boxed-style .boxed-page-inner, .blog-mansory .boxed-page-inner, .blog-full .boxed-page-inner'),
			'title' => __('Blog: Content Background', 'ivan_domain_redux'),
			'subtitle' => __('Configuration used as background to blogs with boxed style activated or mansory and full layouts.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'single-special-content-bg',
			'type' => 'background',
			'output' => array('.single-post.content-wrapper.boxed-style, .single-post.content-wrapper.boxed-style .boxed-page-inner'),
			'title' => __('Single: Content Background', 'ivan_domain_redux'),
			'subtitle' => __('Configuration used as background to blogs with boxed style activated for single.', 'ivan_domain_redux'),
		),

	),
); // End Customizer Section

$this->sections[] = array(
	'title' => __('Content', 'ivan_domain_redux'),
	'desc' => __('Configure general content styles', 'ivan_domain_redux'),
	//'icon' => 'el-icon-wrench',
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'ivan-custom-accent',
			'type'	 => 'color',
			'title'	=> __('Accent Background', 'ivan_domain_redux'), 
			'subtitle' => __('Pick an accent color to overwrite the default from the theme. Usually used as link hover.', 'ivan_domain_redux'),
			'transparent' => false,
			'validate' => 'color',
		),

		array(
			'id' => 'ivan-custom-accent-color',
			'type'	 => 'color',
			'title'	=> __('Optional Constrast Accent Color', 'ivan_domain_redux'), 
			'subtitle' => __('Pick an accent color that fits with the Accent Background color. Usually something like white or dark according to accent background.', 'ivan_domain_redux'),
			'transparent' => false,
			'validate' => 'color',
		),

		array(
			'id' => 'ivan-link-color',
			'type'	 => 'color',
			'title'	=> __('Link Color', 'ivan_domain_redux'), 
			'subtitle' => __('Color used in links in normal state.', 'ivan_domain_redux'),
			'transparent' => false,
			'validate' => 'color',
		),

		array(
			'id' => 'random-customizer-label',
			'type' => 'info',
			'desc' => __('Typography', 'ivan_domain_redux')
		),

		array(
			'id' => 'base-font',
			'type' => 'typography_mod',
			'title' => __('Base Font', 'ivan_domain_redux'),
			'subtitle' => __('Font used in the content in general, usually overwrite by local layout fonts, but used in paragraphs, lists and others.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => false, // Only appears if google is true and subsets not set to false
			'font-size'=> false,
			'line-height'=> false,
			'word-spacing'=> false, // Defaults to false
			'letter-spacing'=> false, // Defaults to false
			'color'=> false,
			'font-weight' => false,
			'text-align' => false,
			'text-transform' => false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('body'),
			//'units' => 'px', // Defaults to px
		),

		array(
			'id' => 'heading-font',
			'type' => 'typography_mod',
			'title' => __('Heading Font', 'ivan_domain_redux'),
			'subtitle' => __('Font used in heading elements and a few others.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => false, // Only appears if google is true and subsets not set to false
			'font-size'=> false,
			'line-height'=> false,
			'word-spacing'=> false, // Defaults to false
			'letter-spacing'=> false, // Defaults to false
			'color'=> false,
			'font-weight' => false,
			'text-align' => false,
			'text-transform' => false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('h1, h2, h3, h4, h5, h6, 
				.woocommerce table.shop_table th, .woocommerce-page table.shop_table th,
				.woocommerce .cart-collaterals .cart_totals h2, .woocommerce-page .cart-collaterals .cart_totals h2,
				.woocommerce .coupon label, .woocommerce-page .coupon label,
				.woocommerce .shipping-calculator-button, .woocommerce-page .shipping-calculator-button
			'),
			//'units' => 'px', // Defaults to px
		),

		array(
			'id' => 'ivan-heading-color',
			'type'	 => 'color',
			'title'	=> __('Headings Color', 'ivan_domain_redux'), 
			'subtitle' => __('Color used in headings.', 'ivan_domain_redux'),
			'transparent' => false,
			'validate' => 'color',
		),

		array(
			'id' => 'ivan-heading-weight',
			'type' => 'select',
			'title' => __('Headings Weight', 'ivan_domain_redux'),
			'subtitle' => __('Not all listed weight are avaliable to the font you select. Usually normal and bold are avalible to almost all fonts, check Google Fonts details to see avaliable weights to your font.', 'ivan_domain_redux'),
			'options' => array( 
				'' => 'Theme Default',
				'100' => 'Thin 100',
				'200' => 'Extra Light 200',
				'300' => 'Light 300',
				'400' => 'Normal 400',
				'500' => 'Medium 500',
				'600' => 'Semi-Bold 600',
				'700' => 'Bold 700',
				'800' => 'Extra-Bold 800',
				'900' => 'Ultra-Bold 900',
				),
			'default' => '',
		),

		array(
			'id' => 'ivan-side-title-heading-weight',
			'type' => 'select',
			'title' => __('Widget Title and Post Title Weight', 'ivan_domain_redux'),
			'subtitle' => __('Not all listed weight are avaliable to the font you select. Usually normal and bold are avalible to almost all fonts, check Google Fonts details to see avaliable weights to your font.', 'ivan_domain_redux'),
			'options' => array( 
				'' => 'Theme Default',
				'100' => 'Thin 100',
				'200' => 'Extra Light 200',
				'300' => 'Light 300',
				'400' => 'Normal 400',
				'500' => 'Medium 500',
				'600' => 'Semi-Bold 600',
				'700' => 'Bold 700',
				'800' => 'Extra-Bold 800',
				'900' => 'Ultra-Bold 900',
				),
			'default' => '',
		),

		array(
			'id' => 'secondary-font',
			'type' => 'typography_mod',
			'title' => __('Secondary Font', 'ivan_domain_redux'),
			'subtitle' => __('Optional: Font used when a smoother font is necessary, used in entry meta at blog, product title and price.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => false, // Only appears if google is true and subsets not set to false
			'font-size'=> false,
			'line-height'=> false,
			'word-spacing'=> false, // Defaults to false
			'letter-spacing'=> false, // Defaults to false
			'color'=> false,
			'font-weight' => true,
			'text-align' => false,
			'text-transform' => false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('.post .entry-meta, 
				.woocommerce div.product .product_title, .woocommerce-page div.product .product_title,
				.ivan-product-popup .summary h3,
				.woocommerce div.product div.summary span.price, .woocommerce-page div.product div.summary span.price, 
				.woocommerce div.product div.summary p.price, .woocommerce-page div.product div.summary p.price
				.woocommerce ul.products li.product h3, .woocommerce-page ul.products li.product h3,
				.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price
				'),
			//'units' => 'px', // Defaults to px
		),

	),
); // End Customizer Section

$this->sections[] = array(
	'title' => __('Title Wrapper', 'ivan_domain_redux'),
	'desc' => __('Configure Title Wrapper styles', 'ivan_domain_redux'),
	//'icon' => 'el-icon-wrench',
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'title-wrapper-bg',
			'type' => 'background',
			'output' => array('#iv-layout-title-wrapper'),
			'title' => __('Title Wrapper Background', 'ivan_domain_redux'),
			//'subtitle' => __('Configure background of title wrapper.', 'ivan_domain_redux'),
		),

		array( 
		    'id'       => 'title-wrapper-border',
		    'type'     => 'border_mod',
		    'title'    => __('Title Wrapper Border', 'ivan_domain_redux'),
		    'all' => false,
		    'left' => false,
		    'right' => false,
		    'style' => false,
		    //'subtitle' => __('Only color validation can be done on this field type', 'ivan_domain_redux'),
		    'output' => array('#iv-layout-title-wrapper'),
		    //'desc'     => __('This is the description field, again good for additional info.', 'ivan_domain_redux'),
		    'default'  => array(
		    	'border-bottom' => '',
		    	'border-top' => '',
		    )
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Title Style', 'ivan_domain_redux'),
		),

		array(
			'id' => 'title-wrapper-color-scheme',
			'type' => 'select',
			'title' => __('Alternative Color Scheme', 'ivan_domain_redux'),
			'subtitle' => __('Select an alternative color scheme to title wrapper.', 'ivan_domain_redux'),
			'options' => array( 'standard' => 'Standard', 'light' => 'Light (great to dark backgrounds)', 'dark' => 'Dark (great to light backgrounds)' ),
			'default' => 'standard',
			'validate' => 'not_empty',
		),

		array(
			'id'=>'title-wrapper-padding',
			'type' => 'spacing_mod',
			'mode'=> 'padding', // absolute, padding, margin, defaults to padding
			//'top'=> false, // Disable the top
			'right' => false, // Disable the right
			//'bottom' => false, // Disable the bottom
			'left' => false, // Disable the left
			//'all' => true, // Have one field that applies to all
			'units' => 'px', // You can specify a unit value. Possible: px, em, %
			//'units_extended' => 'true', // Allow users to select any type of unit
			//'display_units' => 'false', // Set to false to hide the units if the units are specified
			'title' => __('Title Wrapper Padding', 'ivan_domain_redux'),
			//'subtitle' => __('Select a custom margin to the be applied to header top.', 'ivan_domain_redux'),
			//'desc' => __('If not set, default margin will be applied by theme.', 'ivan_domain_redux'),
			'default' => array(),
			'output' => array('#iv-layout-title-wrapper'),
		),

		array(
			'id' => 'title-wrapper-font',
			'type' => 'typography_mod',
			'title' => __('Title Typography', 'ivan_domain_redux'),
			//'subtitle' => __('Typography.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> true, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => true, // Only appears if google is true and subsets not set to false
			'font-size'=> true,
			'line-height'=> false,
			'word-spacing'=> true, // Defaults to false
			'letter-spacing'=> true, // Defaults to false
			'color'=> true,
			'font-weight' => true,
			'text-align' => true,
			'text-transform' => true,
			//'preview'=>false, // Disable the previewer
			//'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('#iv-layout-title-wrapper h2'),
			//'units' => 'px', // Defaults to px
		),

		array(
			'id' => 'title-wrapper-desc-font',
			'type' => 'typography_mod',
			'title' => __('Title Description Typography', 'ivan_domain_redux'),
			'subtitle' => __('Typography to optional description used in pages.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> true, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => true, // Only appears if google is true and subsets not set to false
			'font-size'=> true,
			'line-height'=> false,
			'word-spacing'=> true, // Defaults to false
			'letter-spacing'=> true, // Defaults to false
			'color'=> true,
			'font-weight' => true,
			'text-align' => true,
			'text-transform' => true,
			//'preview'=>false, // Disable the previewer
			//'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('#iv-layout-title-wrapper p'),
			//'units' => 'px', // Defaults to px
			'default' => array(),
		),
		
		array(
			'id' => 'random-customizer-label',
			'type' => 'info',
			'desc' => __('Specific Title Wrappers', 'ivan_domain_redux')
		),

		array(
			'id' => 'blog-title-wrapper-bg',
			'type' => 'background',
			'output' => array('.blog #iv-layout-title-wrapper, .archives #iv-layout-title-wrapper'),
			'title' => __('Blog: Title Wrapper Background', 'ivan_domain_redux'),
			'subtitle' => __('Overwrite title wrapper at blog and archives.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'single-title-wrapper-bg',
			'type' => 'background',
			'output' => array('.single-post #iv-layout-title-wrapper'),
			'title' => __('Single Post: Title Wrapper Background', 'ivan_domain_redux'),
			'subtitle' => __('Overwrite title wrapper at single post.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'shop-title-wrapper-bg',
			'type' => 'background',
			'output' => array('#iv-layout-title-wrapper.title-wrapper-shop'),
			'title' => __('Shop: Title Wrapper Background', 'ivan_domain_redux'),
			'subtitle' => __('Overwrite title wrapper at shop and single products when possible (header is usually hidden in single products).', 'ivan_domain_redux'),
		),
		
	),
); // End Customizer Section

$this->sections[] = array(
	'title' => __('Header', 'ivan_domain_redux'),
	'desc' => __('Configure header styles', 'ivan_domain_redux'),
	//'icon' => 'el-icon-wrench',
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'header-font',
			'type' => 'typography_mod',
			'title' => __('Header Typography', 'ivan_domain_redux'),
			//'subtitle' => __('Typography.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => false, // Only appears if google is true and subsets not set to false
			'font-size'=> false,
			'line-height'=> false,
			'word-spacing'=> false, // Defaults to false
			'letter-spacing'=> false, // Defaults to false
			'color'=> false,
			'font-weight' => false,
			'text-align' => false,
			'text-transform' => false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('.iv-layout.header'),
			//'units' => 'px', // Defaults to px
		),

		array(
			'id' => 'aside-header-bg',
			'type' => 'background',
			'output' => array('.ivan-main-layout-aside.aside-header-wrapper.ivan-main-layout-aside-right, .ivan-main-layout-aside.aside-header-wrapper.ivan-main-layout-aside-left'),
			'title' => __('Aside: Header Background', 'ivan_domain_redux'),
			'subtitle' => __('Works only in aside header styles. Do not forget to upload a correct logo that works better with the new background.', 'ivan_domain_redux'),
		),

		array(
			'id' => 'aside-header-color-scheme',
			'type' => 'select',
			'title' => __('Aside: Alternative Color Scheme', 'ivan_domain_redux'),
			'subtitle' => __('Select an alternative color scheme to aside header items. Works only in aside header styles.', 'ivan_domain_redux'),
			'options' => array( 'standard' => 'Standard', 'light' => 'Light (great to dark backgrounds)', 'dark' => 'Dark (great to light backgrounds)' ),
			'default' => 'standard',
		),

		array(
			'id'=>'aside-header-logo-spacing',
			'type' => 'spacing_mod',
			'output' => array('.simple-left-right .logo'), // Our theme uses custom output for this field
			'mode'=> 'padding', // absolute, padding, margin, defaults to padding
			//'top'=> false, // Disable the top
			//'right' => false, // Disable the right
			//'bottom' => false, // Disable the bottom
			//'left' => false, // Disable the left
			//'all' => true, // Have one field that applies to all
			'units' => 'px', // You can specify a unit value. Possible: px, em, %
			//'units_extended' => 'true', // Allow users to select any type of unit
			//'display_units' => 'false', // Set to false to hide the units if the units are specified
			'title' => __('Aside: Logo Margin', 'ivan_domain_redux'),
			'subtitle' => __('Select a custom margin padding) to the be applied in the logo in aside layouts.', 'ivan_domain_redux'),
			'desc' => __('If not set, default margin will be applied by theme.', 'ivan_domain_redux'),
			'default' => array(),
			'required' => array( 'logo', '!=', null ),
		),

		array(
			'id'=>'aside-header-remove-border',
			'type' => 'switch', 
			'title' => __('Aside: Remove Border', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a small border of aside header layout will be removed.', 'ivan_domain_redux'),
			"default" => 0,
		),

	),
); // End Customizer Section

$this->sections[] = array(
	'title' => __('Top Header', 'ivan_domain_redux'),
	'desc' => __('Configure top header styles', 'ivan_domain_redux'),
	//'icon' => 'el-icon-wrench',
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'top-header-font',
			'type' => 'typography_mod',
			'title' => __('Top Header Typography', 'ivan_domain_redux'),
			//'subtitle' => __('Typography.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => false, // Only appears if google is true and subsets not set to false
			'font-size'=> false,
			'line-height'=> false,
			'word-spacing'=> false, // Defaults to false
			'letter-spacing'=> false, // Defaults to false
			'color'=> false,
			'font-weight' => false,
			'text-align' => false,
			'text-transform' => false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('.iv-layout.top-header'),
			//'units' => 'px', // Defaults to px
		),

	),
); // End Customizer Section

$this->sections[] = array(
	'title' => __('Footer', 'ivan_domain_redux'),
	'desc' => __('Configure footer styles', 'ivan_domain_redux'),
	//'icon' => 'el-icon-wrench',
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'footer-font',
			'type' => 'typography_mod',
			'title' => __('Footer Typography', 'ivan_domain_redux'),
			//'subtitle' => __('Typography.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => false, // Only appears if google is true and subsets not set to false
			'font-size'=> false,
			'line-height'=> false,
			'word-spacing'=> false, // Defaults to false
			'letter-spacing'=> false, // Defaults to false
			'color'=> false,
			'font-weight' => false,
			'text-align' => false,
			'text-transform' => false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('.iv-layout.footer'),
			//'units' => 'px', // Defaults to px
		),

		array(
			'id' => 'footer-widget-font',
			'type' => 'typography_mod',
			'title' => __('Footer Widget Typography', 'ivan_domain_redux'),
			//'subtitle' => __('Typography.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => false, // Only appears if google is true and subsets not set to false
			'font-size'=> false,
			'line-height'=> false,
			'word-spacing'=> false, // Defaults to false
			'letter-spacing'=> false, // Defaults to false
			'color'=> false,
			'font-weight' => false,
			'text-align' => false,
			'text-transform' => false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('.iv-layout.footer .widget .widget-title '),
			//'units' => 'px', // Defaults to px
		),

	),
); // End Customizer Section

$this->sections[] = array(
	'title' => __('Bottom Footer', 'ivan_domain_redux'),
	'desc' => __('Configure bottom footer styles', 'ivan_domain_redux'),
	//'icon' => 'el-icon-wrench',
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'bottom-footer-font',
			'type' => 'typography_mod',
			'title' => __('Bottom Footer Typography', 'ivan_domain_redux'),
			//'subtitle' => __('Typography.', 'ivan_domain_redux'),
			//'compiler'=>true, // Use if you want to hook in your own CSS compiler
			'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets' => false, // Only appears if google is true and subsets not set to false
			'font-size'=> false,
			'line-height'=> false,
			'word-spacing'=> false, // Defaults to false
			'letter-spacing'=> false, // Defaults to false
			'color'=> false,
			'font-weight' => false,
			'text-align' => false,
			'text-transform' => false,
			//'preview'=>false, // Disable the previewer
			'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
			'output' => array('.iv-layout.bottom-footer'),
			//'units' => 'px', // Defaults to px
		),

	),
); // End Customizer Section