<?php
/*
 * Layout Section
*/

$this->sections[] = array(
	'title' => __('Title Wrapper', 'ivan_domain_redux'),
	'desc' => __('Change the title wrapper section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id'=>'title-wrapper-enable-switch',
			'type' => 'switch', 
			'title' => __('Disable this layout part?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, this layout part will not be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'title-wrapper-layout',
			'type' => 'select',
			'title' => __('Title Wrapper Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the top layout to be used at title wrapper.', 'ivan_domain_redux'),
			'options' => apply_filters('ivan_title_wrapper_layouts', array( 
					'Ivan_Layout_Title_Wrapper_Normal' => 'Classic with Description Text',
					'Ivan_Layout_Title_Wrapper_Large' => 'Large with Description Text',
					) ),
			'default' => 'Ivan_Layout_Title_Wrapper_Normal',
			'validate' => 'not_empty',
		),

		array(
			'id'=>'title-large-align',
			'type' => 'switch', 
			'title' => __('Align Large Title to Left?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the large title wrapper layout will be aligned to left.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'title-wrapper-layout', '=', array('Ivan_Layout_Title_Wrapper_Large') ),
		),

		array(
			'id'=>'breadcrumb-enable',
			'type' => 'switch', 
			'title' => __('Enable Breadcrumb?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a breadcrumb will be displayed aside of title wrapper.', 'ivan_domain_redux'),
			"default" => 1,
			'required' => array( 'title-wrapper-layout', '=', array('Ivan_Layout_Title_Wrapper_Normal') ),
		),

		array(
			'id'=>'breadcrumb-proj-disable',
			'type' => 'switch', 
			'title' => __('Disable Projects Breadcrumb?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, breadcrumbs will not be displayed in projects.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'breadcrumb-enable', '=', true ),
		),

		array(
			'id'=>'breadcrumb-shop-disable',
			'type' => 'switch', 
			'title' => __('Disable Shop Breadcrumb?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, breadcrumbs will not be displayed in shop pages.', 'ivan_domain_redux'),
			"default" => 0,
		),

		/*
		array(
			'id'=>'breadcrumb-product-disable',
			'type' => 'switch', 
			'title' => __('Disable Products Breadcrumb?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, breadcrumbs will not be displayed in products.', 'ivan_domain_redux'),
			"default" => 0,
			'required' => array( 'breadcrumb-enable', '=', true ),
		),
		*/

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Default Titles.', 'ivan_domain_redux')
		),

		array(
			'id' => 'title-text-blog',
			'type' => 'text',
			'title' => __('Default Blog Title', 'ivan_domain_redux'),
			'subtitle' => __('Title used in index post listing.', 'ivan_domain_redux'),
			'default' => 'Our Blog',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'title-desc-blog',
			'type' => 'textarea',
			'title' => __('Default Blog Description', 'ivan_domain_redux'),
			'subtitle' => __('Place any text or shortcode to be displayed below blog title.', 'ivan_domain_redux'),
			'validate' => 'html_custom',
			'allowed_html' => array(
					'a' => array(
						'href' => array(),
						'title' => array(),
						'target' => array(),
					),
					'br' => array(),
					'em' => array(),
					'strong' => array()
				),
			'default' => '',
		),

		array(
			'id' => 'title-text-shop',
			'type' => 'text',
			'title' => __('Default Shop Title', 'ivan_domain_redux'),
			'subtitle' => __('Title used in single product title when avaliable.', 'ivan_domain_redux'),
			'default' => 'Our Shop',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'title-desc-shop',
			'type' => 'textarea',
			'title' => __('Default Shop Description', 'ivan_domain_redux'),
			'subtitle' => __('Place any text or shortcode to be displayed below shop title.', 'ivan_domain_redux'),
			'validate' => 'html_custom',
			'allowed_html' => array(
					'a' => array(
						'href' => array(),
						'title' => array(),
						'target' => array(),
					),
					'br' => array(),
					'em' => array(),
					'strong' => array()
				),
			'default' => '',
		),

	), // #fields
);