<?php
/*
 * Layout Section
*/

$this->sections[] = array(
	'title' => __('Top Header', 'ivan_domain_redux'),
	'desc' => __('Change the top header section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id'=>'top-header-enable-switch',
			'type' => 'switch', 
			'title' => __('Disable this layout part?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, this layout part will not be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'top-header-layout',
			'type' => 'select',
			'title' => __('Top Header Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the top layout to be used at header.', 'ivan_domain_redux'),
			'options' => apply_filters('ivan_top_header_layouts', array( 
					'Ivan_Layout_Top_Header_Two_Columns' => 'Two Columns',
					) ),
			'default' => 'Ivan_Layout_Top_Header_Two_Columns',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'top-header-left-width',
			'type' => 'slider',
			'title' => __('Left Area Width', 'ivan_domain_redux'),
			'desc' => __('Define columns number of top header left side.', 'ivan_domain_redux'),
			'subtitle' => __('The left and right side combined should not be greater than 12! Otherwise the layout will break.', 'ivan_domain_redux'),
			"default" => "4",
			"min" => "1",
			"step" => "1",
			"max" => "11",
		),

		array(
			'id' => 'top-header-right-width',
			'type' => 'slider',
			'title' => __('Right Area Width', 'ivan_domain_redux'),
			'desc' => __('Define columns number of top header left side.', 'ivan_domain_redux'),
			'subtitle' => __('The left and right side combined should not be greater than 12! Otherwise the layout will break.', 'ivan_domain_redux'),
			"default" => "8",
			"min" => "1",
			"step" => "1",
			"max" => "11",
		),

		array(
			'id'=>'top-header-menu-disable',
			'type' => 'switch', 
			'title' => __('Disable Menu?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, menu will not be displayed.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id'=>'top-header-menu-left-switch',
			'type' => 'switch', 
			'title' => __('Display Menu at Left Area', 'ivan_domain_redux'),
			'subtitle'=> __('If on, menu will display at left side of top header.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'top-header-menu-disable', '=', 0),
		),

		array(
			'id'=>'top-header-v-sign-switch',
			'type' => 'switch', 
			'title' => __('Menu Arrow', 'ivan_domain_redux'),
			'subtitle'=> __('If on, menu items will get a arrow after text.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'top-header-menu-disable', '=', 0),
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Woo Cart Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'top-header-woo-cart-switch',
			'type' => 'switch', 
			'title' => __('Woo Cart', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a WooCommerce cart will be displayed. Requires WooCommerce plugin activated.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Login AJAX Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'top-header-login-ajax-switch',
			'type' => 'switch', 
			'title' => __('Login AJAX', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a Login AJAX will be displayed. Requires Login With Ajax plugin activated.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Search Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'top-header-search-switch',
			'type' => 'switch', 
			'title' => __('Search', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a search module will be displayed.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Text Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'top-header-text-switch',
			'type' => 'switch', 
			'title' => __('Text Module', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a rich text module will be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

			array(
				'id' => 'top-header-text-content',
				'type' => 'editor',
				'title' => __('Text Module Content', 'ivan_domain_redux'),
				'subtitle' => __('Place any text or shortcode to be displayed in header. Use [iv_separator] to add a separator in the text. Use [iv_icon icon="cogs"] to display Font Awesome icons. Use [iv_flags] to add WPML flags.', 'ivan_domain_redux'),
				'default' => '[iv_icon icon="phone"] 9854-888-021 [iv_separator] [iv_icon icon="home"] New York, NY',
				'required' => array( 'top-header-text-switch', '=', 1 ),
			),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Social Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'top-header-social-switch',
			'type' => 'switch', 
			'title' => __('Social Module', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a social icon module will be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

			array(
				'id' => 'top-header-social-icons',
				'type' => 'social_select',
				'title' => __('Social Icons', 'ivan_domain_redux'),
				'subtitle' => __('Add and organize the icons to be displayed.', 'ivan_domain_redux'),
				'required' => array( 'top-header-social-switch', '=', 1 ),
				'placeholder' => array(
					'title' => __('Social Media URL', 'ivan_domain_redux'),
				),
			),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('WPML Modules', 'ivan_domain_redux')
		),

			array(
				'id'=>'top-header-wpml-lang-switch',
				'type' => 'switch', 
				'title' => __('WPML Language Flags', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the avaliable languages flags will be displayed. Only works with WPML activated.', 'ivan_domain_redux'),
				"default" => 0,
			),

			array(
				'id'=>'top-header-wpml-currency-switch',
				'type' => 'switch', 
				'title' => __('WPML Shop Currencies', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the avaliable currencies flags will be displayed. Only works with WPML + WooCommerce Multilingual activated.', 'ivan_domain_redux'),
				"default" => 0,
			),

	), // #fields
);