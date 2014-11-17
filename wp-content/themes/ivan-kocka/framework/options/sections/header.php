<?php
/*
 * Layout Section
*/

$this->sections[] = array(
	'title' => __('Header', 'ivan_domain_redux'),
	'desc' => __('Change the header section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		// Disabled Header layout in the website
		array(
			'id' => 'header-enable-switch',
			'type' => 'switch', 
			'title' => __('Disable header?', 'ivan_domain_redux'),
			'subtitle' => __('If on, this layout part will not be displayed in website.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'header-layout',
			'type' => 'select',
			'title' => __('Header Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the layout to be used at header.', 'ivan_domain_redux'),
			'options' => apply_filters('ivan_header_layouts', array( 
					'Ivan_Layout_Header_Simple_Right_Menu' => 'Logo at left and Menu + Modules Aside',
					'Ivan_Layout_Header_Classic_Right_Area' => 'Logo and Modules + Menu Below',
					'Ivan_Layout_Header_Simple_Logo_Centered' => 'Logo Centered, Menu Left and Modules Right',
					'Ivan_Layout_Header_Classic_Logo_Centered' => 'Logo Centered, Modules at Left and Right + Menu Below',
					'Ivan_Layout_Header_Only_Menu' => 'Only Menu',
					) ),
			'default' => 'Ivan_Layout_Header_Simple_Right_Menu',
			'validate' => 'not_empty',
		),

		// Enable Fixed Header effect in website
		array(
			'id'=>'header-fixed-switch',
			'type' => 'switch', 
			'title' => __('Fixed Header', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the header will be fixed at screen top on page scroll.', 'ivan_domain_redux'),
			'default' => 1,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Header Layout Configuration.', 'ivan_domain_redux')
		),

		// Enables Negative Height Header
		array(
			'id'=>'header-negative-height',
			'type' => 'switch', 
			'title' => __('Negative Height', 'ivan_domain_redux'),
			'subtitle'=> __('If on, header will not have height and content will be showed behind it.', 'ivan_domain_redux'),
			"default" => 0,
		),

		// Enables Boxed Header Layout
		array(
			'id'=>'header-boxed-layout',
			'type' => 'switch', 
			'title' => __('Enabled Boxed Layout?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, header will look boxed in the website even when the layout is wide.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array(
				array('header-negative-height', 'equals', 1),
				),
		),

		array(
			'id'=>'header-bg-type',
			'type' => 'select',
			'title' => __('Header Background Type', 'ivan_domain_redux'), 
			'subtitle' => __('Select the type of background to be applied in header.', 'ivan_domain_redux'),
			'options' => array( 
					'transparent-bg' => 'Transparent',
					'semi-transparent-bg' => 'Semi Transparent',
					'solid' => 'Solid',
					),
			'default' => 'transparent-bg',
			'validate' => 'not_empty',
			'required' => array('header-negative-height', 'equals', 1),
		),

		array(
			'id' => 'header-color-scheme',
			'type' => 'select',
			'title' => __('Alternative Color Scheme', 'ivan_domain_redux'),
			'subtitle' => __('Select an alternative color scheme to header items.', 'ivan_domain_redux'),
			'options' => array( 'standard' => 'Standard', 'light' => 'Light (great to dark backgrounds)', 'dark' => 'Dark (great to light backgrounds)' ),
			'default' => 'standard',
			'validate' => 'not_empty',
			'required' => array('header-negative-height', 'equals', 1),
		),

		array(
			'id'=>'header-top-margin',
			'type' => 'spacing_mod',
			'mode'=> 'margin', // absolute, padding, margin, defaults to padding
			//'top'=> false, // Disable the top
			'right' => false, // Disable the right
			'bottom' => false, // Disable the bottom
			'left' => false, // Disable the left
			//'all' => true, // Have one field that applies to all
			'units' => 'px', // You can specify a unit value. Possible: px, em, %
			//'units_extended' => 'true', // Allow users to select any type of unit
			//'display_units' => 'false', // Set to false to hide the units if the units are specified
			'title' => __('Header Top Margin', 'ivan_domain_redux'),
			'subtitle' => __('Select a custom margin to the be applied to header top.', 'ivan_domain_redux'),
			'desc' => __('If not set, default margin will be applied by theme.', 'ivan_domain_redux'),
			'default' => array(),
			'required' => array('header-negative-height', 'equals', 1),
			'output' => array('.iv-layout.header'), // Our theme generates custom output for this field...
		),

		// Show only after page fold
		array(
			'id'=>'header-after-fold',
			'type' => 'switch', 
			'title' => __('Display Header after Page Fold?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, header will be displayed after user scroll until page fold.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array(
				array('header-negative-height', 'equals', 1),
				),
		),

			array(
				'id'=>'header-after-fold-logo',
				'type' => 'switch', 
				'title' => __('Keep showing logo before fold?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, only the logo will be showed before page fold.', 'ivan_domain_redux'),
				"default" => 0,
				'required' => array(
					array('header-after-fold', 'equals', 1),
					),
			),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('General Modules Configuration.', 'ivan_domain_redux')
		),

		// Option to pull menu to left in avaliable layouts
		array(
			'id'=>'header-menu-pull-left-switch',
			'type' => 'switch', 
			'title' => __('Pull Menu to Left Side', 'ivan_domain_redux'),
			'subtitle'=> __('If on and avaliable in the layout, the menu will be placed at left.', 'ivan_domain_redux'),
			'default' => 0,
			'required' => array(
				array('main-layout', 'equals', 'Ivan_Main_Layout_Normal'),
				array('header-layout', 'equals', array('Ivan_Layout_Header_Simple_Right_Menu') ),
			),
		),

		array(
			'id'=>'header-menu-pull-center-switch',
			'type' => 'switch', 
			'title' => __('Centralized Menu', 'ivan_domain_redux'),
			'subtitle'=> __('If on, menu will be centralized. Note that this option does not work with all layouts.', 'ivan_domain_redux'),
			'default' => 0,
			'required' => array(
				array('main-layout', 'equals', 'Ivan_Main_Layout_Normal'),
				array('header-layout', 'equals', 
					array('Ivan_Layout_Header_Classic_Right_Area', 'Ivan_Layout_Header_Classic_Logo_Centered', 'Ivan_Layout_Header_Only_Menu') ),
			),
		),

		array(
			'id'=>'header-aside-menu-centered-switch',
			'type' => 'switch', 
			'title' => __('Center Align Aside Menu Items', 'ivan_domain_redux'),
			'subtitle'=> __('If on the menu items will be centered, else default alignment left/right will be used.', 'ivan_domain_redux'),
			'default' => 1,
			'required' => array(
				array('main-layout', 'equals', array('Ivan_Main_Layout_Aside_Left', 'Ivan_Main_Layout_Aside_Right') ),
			),
		),

		// Adds Lateral Lines to Modules
		array(
			'id'=>'header-lateral-lines-switch',
			'type' => 'switch', 
			'title' => __('Lateral Lines', 'ivan_domain_redux'),
			'subtitle'=> __('If on, modules will have lateral lines to separate them.', 'ivan_domain_redux'),
			'default' => 0,
		),

		// Adds V sign after menu items
		array(
			'id'=>'header-v-sign-switch',
			'type' => 'switch', 
			'title' => __('Menu Arrow', 'ivan_domain_redux'),
			'subtitle'=> __('If on, menu items will get a arrow after text.', 'ivan_domain_redux'),
			'default' => 0,
		),

		// Use responsive menu in select mode
		array(
			'id'=>'header-select-menu-switch',
			'type' => 'switch', 
			'title' => __('Use select responsive menu instead default?', 'ivan_domain_redux'),
			'subtitle'=> __('If on and avaliable, responsive menu will be displayed in a select instead default.', 'ivan_domain_redux'),
			'desc' => __('Useful to single page layouts or small menus.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Logo Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'logo',
			'type' => 'media', 
			'url' => true,
			'title' => __('Logo', 'ivan_domain_redux'),
			'subtitle' => __('Upload the logo that will be displayed in the header.', 'ivan_domain_redux'),
		),

			array(
				'id'=>'logo-retina',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo Retina', 'ivan_domain_redux'),
				'desc'=> __('The same logo image but with twice dimensions, e.g. your logo is 100x100, then your retina logo must be 200x200.', 'ivan_domain_redux'),
				'subtitle' => __('Optional retina version displayed in devices with retina display (high resolution display).', 'ivan_domain_redux'),
				'required' => array( 'logo', '!=', null ),
				),

			//Overwrite logo margins if user wants
			array(
				'id'=>'header-logo-spacing',
				'type' => 'spacing_mod',
				'output' => array('.logo'), // Our theme uses custom output for this field
				'mode'=> 'margin', // absolute, padding, margin, defaults to padding
				//'top'=> false, // Disable the top
				'right' => false, // Disable the right
				//'bottom' => false, // Disable the bottom
				//'left' => false, // Disable the left
				//'all' => true, // Have one field that applies to all
				'units' => 'px', // You can specify a unit value. Possible: px, em, %
				//'units_extended' => 'true', // Allow users to select any type of unit
				//'display_units' => 'false', // Set to false to hide the units if the units are specified
				'title' => __('Logo Margin', 'ivan_domain_redux'),
				'subtitle' => __('Select a custom margin to the be applied in the logo.', 'ivan_domain_redux'),
				'desc' => __('If not set, default margin will be applied by theme.', 'ivan_domain_redux'),
				'default' => array(),
				'required' => array( 'logo', '!=', null ),
			),

		array(
			'id'=>'header-logo-light-switch',
			'type' => 'switch', 
			'title' => __('Light Logo', 'ivan_domain_redux'),
			'subtitle'=> __('Turn on to upload a light version of logo used in dark backgrounds.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'logo-light',
			'type' => 'media', 
			'url' => true,
			'title' => __('Logo (light)', 'ivan_domain_redux'),
			'subtitle' => __('Upload the logo that will be displayed in the header.', 'ivan_domain_redux'),
			'required' => array( 'header-logo-light-switch', '=', 1 ),
		),

			array(
				'id'=>'logo-retina-light',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo Retina (light)', 'ivan_domain_redux'),
				'desc'=> __('The same logo image but with twice dimensions, e.g. your logo is 100x100, then your retina logo must be 200x200.', 'ivan_domain_redux'),
				'subtitle' => __('Optional retina version displayed in devices with retina display (high resolution display).', 'ivan_domain_redux'),
				'required' => array( 'logo-light', '!=', null ),
				),

		array(
			'id'=>'header-logo-dark-switch',
			'type' => 'switch', 
			'title' => __('Dark Logo', 'ivan_domain_redux'),
			'subtitle'=> __('Turn on to upload a dark version of logo used in light backgrounds.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'logo-dark',
			'type' => 'media', 
			'url' => true,
			'title' => __('Logo (dark)', 'ivan_domain_redux'),
			'subtitle' => __('Upload the logo that will be displayed in the header.', 'ivan_domain_redux'),
			'required' => array( 'header-logo-dark-switch', '=', 1 ),
		),

			array(
				'id'=>'logo-retina-dark',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo Retina (dark)', 'ivan_domain_redux'),
				'desc'=> __('The same logo image but with twice dimensions, e.g. your logo is 100x100, then your retina logo must be 200x200.', 'ivan_domain_redux'),
				'subtitle' => __('Optional retina version displayed in devices with retina display (high resolution display).', 'ivan_domain_redux'),
				'required' => array( 'logo-dark', '!=', null ),
				),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Logo Dimensions', 'ivan_domain_redux')
		),

		array(
			'id' => 'header-logo-lg',
			'type' => 'slider',
			'title' => __('Logo Columns (Large)', 'ivan_domain_redux'),
			'desc' => __('Define how many columns of header is occupied by the logo in larger devices. More than 1200px.', 'ivan_domain_redux'),
			'subtitle' => __('Do not use too big values because this can break the layout.', 'ivan_domain_redux'),
			"default" => "2",
			"min" => "1",
			"step" => "1",
			"max" => "8",
		),

		array(
			'id' => 'header-logo-md',
			'type' => 'slider',
			'title' => __('Logo Columns (Medium)', 'ivan_domain_redux'),
			'desc' => __('Define how many columns of header is occupied by the logo in normal devices. More than 991px.', 'ivan_domain_redux'),
			'subtitle' => __('Do not use too big values because this can break the layout.', 'ivan_domain_redux'),
			"default" => "2",
			"min" => "1",
			"step" => "1",
			"max" => "8",
		),

		array(
			'id' => 'header-logo-sm',
			'type' => 'slider',
			'title' => __('Logo Columns (Tablets)', 'ivan_domain_redux'),
			'desc' => __('Define how many columns of header is occupied by the logo in tablet devices. Smaller than 991px. ', 'ivan_domain_redux'),
			'subtitle' => __('Do not use too big values because this can break the layout.', 'ivan_domain_redux'),
			"default" => "2",
			"min" => "1",
			"step" => "1",
			"max" => "8",
		),

		array(
			'id' => 'header-logo-xs',
			'type' => 'slider',
			'title' => __('Logo Columns (Mobile)', 'ivan_domain_redux'),
			'desc' => __('Define how many columns of header is occupied by the logo in small mobile devices. Smaller than 768px.', 'ivan_domain_redux'),
			'subtitle' => __('Do not use too big values because this can break the layout.', 'ivan_domain_redux'),
			"default" => "4",
			"min" => "1",
			"step" => "1",
			"max" => "8",
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Woo Cart Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-woo-cart-switch',
			'type' => 'switch', 
			'title' => __('Woo Cart', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a WooCommerce cart will be displayed. Requires WooCommerce plugin activated.', 'ivan_domain_redux'),
			'default' => 1,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Login AJAX Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-login-ajax-switch',
			'type' => 'switch', 
			'title' => __('Login AJAX', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a Login AJAX will be displayed. Requires Login With Ajax plugin activated.', 'ivan_domain_redux'),
			'default' => 1,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Search Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-search-switch',
			'type' => 'switch', 
			'title' => __('Search', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a search module will be displayed.', 'ivan_domain_redux'),
			'default' => 1,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Text Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-text-switch',
			'type' => 'switch', 
			'title' => __('Text Module', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a rich text module will be displayed.', 'ivan_domain_redux'),
			'default' => 0,
		),

			array(
				'id' => 'header-text-content',
				'type' => 'editor',
				'title' => __('Text Module Content', 'ivan_domain_redux'),
				'subtitle' => __('Place any text or shortcode to be displayed in header. Use [iv_separator] to add a separator in the text. Use [iv_icon icon="cogs"] to display Font Awesome icons. Use [iv_flags] to add WPML flags.', 'ivan_domain_redux'),
				'default' => '[iv_icon icon="phone"] 9854-888-021 <br />[iv_icon icon="home"] New York, NY',
				'required' => array( 'header-text-switch', '=', 1 ),
			),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Social Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-social-switch',
			'type' => 'switch', 
			'title' => __('Social Module', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a social icon module will be displayed.', 'ivan_domain_redux'),
			'default' => 0,
		),

			array(
				'id' => 'header-social-icons',
				'type' => 'social_select',
				'title' => __('Social Icons', 'ivan_domain_redux'),
				'subtitle' => __('Add and organize the icons to be displayed.', 'ivan_domain_redux'),
				'required' => array( 'header-social-switch', '=', 1 ),
				'placeholder' => array(
					'title' => __('Social Media URL', 'ivan_domain_redux'),
				),
			),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Menu Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-menu-module-switch',
			'type' => 'switch', 
			'title' => __('Header Menu Module', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a additional menu will be displayed together with modules.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Ads Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-ads-switch',
			'type' => 'switch', 
			'title' => __('Ads Module', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a ads module will be displayed. Note that it is not avaliable to all layouts.', 'ivan_domain_redux'),
			'default' => 0,
		),

			array(
				'id' => 'header-ads-content',
				'type' => 'textarea',
				'title' => __('Ads Module Content', 'ivan_domain_redux'),
				'subtitle' => __('Place your Ads code, it supports HTML code as well or even JavaScript.', 'ivan_domain_redux'),
				'default' => '',
				'required' => array( 'header-ads-switch', '=', 1 ),
				'validate' => false,
			),

		/*
		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('WPML Modules', 'ivan_domain_redux')
		),

			array(
				'id'=>'header-wpml-lang-switch',
				'type' => 'switch', 
				'title' => __('WPML Language Flags', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the avaliable languages flags will be displayed. Only works with WPML activated.', 'ivan_domain_redux'),
				"default" => 0,
			),

			array(
				'id'=>'header-wpml-currency-switch',
				'type' => 'switch', 
				'title' => __('WPML Shop Currencies', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the avaliable currencies flags will be displayed. Only works with WPML + WooCommerce Multilingual activated.', 'ivan_domain_redux'),
				"default" => 0,
			),
		*/

		array(
			'id' => 'random-header-da',
			'type' => 'info',
			'desc' => __('Dynamic Area', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-da-after-enable',
			'type' => 'switch', 
			'title' => __('Enable Dynamic Area After Header?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a dynamic area will be displayed after header.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'header-da-after',
			'type' => 'select',
			'title' => __('After Header Dynamic Content Page', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'header-da-after-enable', '=', 1),
		),

		array(
			'id'=>'header-da-after-blog',
			'type' => 'select',
			'title' => __('Blog: Header Dynamic Content', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed. Displayed only at blog.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'header-da-after-enable', '=', 1),
		),

		array(
			'id'=>'header-da-after-single',
			'type' => 'select',
			'title' => __('Single: Header Dynamic Content', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed. Displayed only at single.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'header-da-after-enable', '=', 1),
		),

		array(
			'id'=>'header-da-after-shop',
			'type' => 'select',
			'title' => __('Shop: Header Dynamic Content', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed. Displayed only at shop.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'header-da-after-enable', '=', 1),
		),

		array(
			'id'=>'header-da-after-single-product',
			'type' => 'select',
			'title' => __('Product: Header Dynamic Content', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed. Displayed only at product.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'header-da-after-enable', '=', 1),
		),

	), // #fields
);