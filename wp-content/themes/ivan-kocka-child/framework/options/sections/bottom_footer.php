<?php
/*
 * Layout Section
*/

$this->sections[] = array(
	'title' => __('Bottom Footer', 'ivan_domain_redux'),
	'desc' => __('Change the bottom footer section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id'=>'bottom-footer-enable',
			'type' => 'switch', 
			'title' => __('Disable this layout part?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, this layout part will not be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'bottom-footer-layout',
			'type' => 'select',
			'title' => __('Top Header Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the bottom footer to be used at header.', 'ivan_domain_redux'),
			'options' => apply_filters('ivan_bottom_footer_layouts', array( 
					'Ivan_Layout_Bottom_Footer_Two_Columns' => 'Two Columns',
					) ),
			'default' => 'Ivan_Layout_Bottom_Footer_Two_Columns',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'bottom-footer-left-width',
			'type' => 'slider',
			'title' => __('Left Area Width', 'ivan_domain_redux'),
			'desc' => __('Define columns number of top header left side.', 'ivan_domain_redux'),
			'subtitle' => __('The left and right side combined should not be greater than 12! Otherwise the layout will break.', 'ivan_domain_redux'),
			"default" => "6",
			"min" => "0",
			"step" => "1",
			"max" => "12",
		),

		array(
			'id' => 'bottom-footer-right-width',
			'type' => 'slider',
			'title' => __('Right Area Width', 'ivan_domain_redux'),
			'desc' => __('Define columns number of top header left side.', 'ivan_domain_redux'),
			'subtitle' => __('The left and right side combined should not be greater than 12! Otherwise the layout will break.', 'ivan_domain_redux'),
			"default" => "6",
			"min" => "0",
			"step" => "1",
			"max" => "12",
		),

		array(
			'id'=>'bottom-footer-menu-disable',
			'type' => 'switch', 
			'title' => __('Disable Menu?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, menu will not be displayed.', 'ivan_domain_redux'),
			"default" => 1,
		),

		array(
			'id'=>'bottom-footer-menu-left-switch',
			'type' => 'switch', 
			'title' => __('Display Menu at Left Area', 'ivan_domain_redux'),
			'subtitle'=> __('If on, menu will display at left side of bottom footer.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'bottom-footer-menu-disable', '=', 0),
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Text Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'bottom-footer-text-switch',
			'type' => 'switch', 
			'title' => __('Text Module', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a rich text module will be displayed.', 'ivan_domain_redux'),
			"default" => 1,
		),

			array(
				'id' => 'bottom-footer-text-content',
				'type' => 'editor',
				'title' => __('Text Module Content', 'ivan_domain_redux'),
				'subtitle' => __('Place any text or shortcode to be displayed in header. Use [iv_separator] to add a separator in the text. Use [iv_icon icon="cogs"] to display Font Awesome icons. Use [iv_flags] to add WPML flags.', 'ivan_domain_redux'),
				'default' => 'All rights reserved.',
				'required' => array( 'bottom-footer-text-switch', '=', 1 ),
			),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Social Module Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'bottom-footer-social-switch',
			'type' => 'switch', 
			'title' => __('Social Module', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a social icon module will be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

			array(
				'id' => 'bottom-footer-social-icons',
				'type' => 'social_select',
				'title' => __('Social Icons', 'ivan_domain_redux'),
				'subtitle' => __('Add and organize the icons to be displayed.', 'ivan_domain_redux'),
				'required' => array( 'bottom-footer-social-switch', '=', 1 ),
				'placeholder' => array(
					'title' => __('Social Media URL', 'ivan_domain_redux'),
				),
			),

		/*
		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('WPML Modules', 'ivan_domain_redux')
		),

			array(
				'id'=>'bottom-footer-wpml-lang-switch',
				'type' => 'switch', 
				'title' => __('WPML Language Flags', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the avaliable languages flags will be displayed. Only works with WPML activated.', 'ivan_domain_redux'),
				"default" => 0,
			),

			array(
				'id'=>'bottom-footer-wpml-currency-switch',
				'type' => 'switch', 
				'title' => __('WPML Shop Currencies', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the avaliable currencies flags will be displayed. Only works with WPML + WooCommerce Multilingual activated.', 'ivan_domain_redux'),
				"default" => 0,
			),
		*/

		array(
			'id' => 'random-bottom-footer',
			'type' => 'info',
			'desc' => __('Dynamic Areas', 'ivan_domain_redux')
		),

		array(
			'id'=>'bottom-footer-da-before-enable',
			'type' => 'switch', 
			'title' => __('Enable Dynamic Area Before Bottom Footer?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a dynamic area will be displayed above the layout.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'bottom-footer-da-before',
			'type' => 'select',
			'title' => __('Before Dynamic Content Page', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'bottom-footer-da-before-enable', '=', 1),
		),

		array(
			'id'=>'bottom-footer-da-after-enable',
			'type' => 'switch', 
			'title' => __('Enable Dynamic Area After Bottom Footer?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a dynamic area will be displayed below the layout.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'bottom-footer-da-after',
			'type' => 'select',
			'title' => __('After Dynamic Content Page', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'bottom-footer-da-after-enable', '=', 1),
		),

	), // #fields
);