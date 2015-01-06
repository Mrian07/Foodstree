<?php
/*
 * WooCommerce Section
*/

$this->sections[] = array(
	'title' => __('Shop', 'ivan_domain_redux'),
	'desc' => __('Change shop templates and configurations.', 'ivan_domain_redux'),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id' => 'random-woo-templates',
			'type' => 'info',
			'desc' => __('General Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'woo-shop-layout',
			'type' => 'select',
			'title' => __('Shop Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the layout to be used in shop.', 'ivan_domain_redux'),
			'options' => array( 
				'left' => 'Sidebar at Left',
				'right' => 'Sidebar at Right',
				'full' => 'Without Sidebar (Wide)',
				),
			'default' => 'left',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'woo-per-page',
			'type' => 'text',
			'title' => __('Products per Page', 'ivan_domain_redux'),
			'subtitle' => __('Define the number of products displayed per page.', 'ivan_domain_redux'),
			'default' => '8',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'woo-shop-columns',
			'type' => 'slider',
			'title' => __('Columns', 'ivan_domain_redux'),
			'subtitle' => __('Define columns number at shop.', 'ivan_domain_redux'),
			"default" => "3",
			"min" => "1",
			"step" => "1",
			"max" => "4",
		),

		array(
			'id'=>'woo-list-layout',
			'type' => 'switch', 
			'title' => __('Display Products in List', 'ivan_domain_redux'),
			'subtitle'=> __('If on, products will be displayed as list instead thumbs at shop.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'woo-catalog-mode',
			'type' => 'switch', 
			'title' => __('Enable Catalog Mode?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, Add to Cart buttons will not be displayed to users.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'woo-catalog-mode-text',
			'type' => 'textarea', 
			'title' => __('Catalog Mode Text', 'ivan_domain_redux'),
			'subtitle'=> __('What will be displayed instead default Add to Cart button.', 'ivan_domain_redux'),
			'default' => 'Get in <a href="#">touch</a> to more details.',
			'required' => array( 'woo-catalog-mode', '=', 1 ),
		),	

		array(
			'id'=>'woo-category-image',
			'type' => 'switch', 
			'title' => __('Enable Category Image?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the uploaded image will be displayed above the products in shop listing.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'woo-display-sorting',
			'type' => 'switch', 
			'title' => __('Enable Sorting Options?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the sorting options will be displayed in the shop, this way users can order by price or others.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'woo-disable-quick-view',
			'type' => 'switch', 
			'title' => __('Disable Quick View Feature?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the quick view feature will not be avaliable.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'woo-disable-front-back',
			'type' => 'switch', 
			'title' => __('Disable Front/Back Feature?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the front and back images will not be avaliable.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'woo-disable-title',
			'type' => 'switch', 
			'title' => __('Disable Title Wrapper?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, title wrapper will not be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id' => 'random-woo-templates',
			'type' => 'info',
			'desc' => __('Single Product Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'woo-product-layout',
			'type' => 'select',
			'title' => __('Product Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the layout to be used in single products.', 'ivan_domain_redux'),
			'options' => array( 
				'left' => 'Sidebar at Left',
				'right' => 'Sidebar at Right',
				'full' => 'Without Sidebar (Wide)',
				),
			'default' => 'full',
			'validate' => 'not_empty',
		),

		array(
			'id'=>'woo-thumbnail-stacked',
			'type' => 'switch', 
			'title' => __('Display Wide Thumbnail', 'ivan_domain_redux'),
			'subtitle'=> __('If on, instead two columns in single products, they will appear as one column.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'woo-product-tabs-layout',
			'type' => 'select',
			'title' => __('Product Tabs Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the layout to be used in single products tabs.', 'ivan_domain_redux'),
			'options' => array( 
				'default' => 'Horizontal Tabs',
				'vertical' => 'Vertical Tabs',
				'block' => 'Without Tabs (blocks)',
				),
			'default' => 'default',
			'validate' => 'not_empty',
		),

		array(
			'id'=>'woo-product-extra-tab',
			'type' => 'switch', 
			'title' => __('Enable Extra Tab?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, an additional global tab will be displayed in products tabs.', 'ivan_domain_redux'),
			'default' => 0,
		),

			array(
				'id' => 'woo-product-extra-tab-title',
				'type' => 'text',
				'title' => __('Extra Tab Title', 'ivan_domain_redux'),
				'subtitle' => __('Define the extra tab title.', 'ivan_domain_redux'),
				'default' => 'Extra Tab',
				'validate' => 'not_empty',
				'required' => array('woo-product-extra-tab', '=', 1),
			),

			array(
				'id' => 'woo-product-extra-tab-content',
				'type' => 'editor',
				'title' => __('Extra Tab Content', 'ivan_domain_redux'),
				'subtitle' => __('Define the extra tab content.', 'ivan_domain_redux'),
				'default' => 'Content',
				'validate' => 'not_empty',
				'required' => array('woo-product-extra-tab', '=', 1),
			),

		array(
			'id'=>'woo-disable-breadcrumb',
			'type' => 'switch', 
			'title' => __('Disable Breadcrumb?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, breadcrumb above product title will not be displayed.', 'ivan_domain_redux'),
			'default' => 0,
		),

		/*
		@todo: add this feature in the future :)
		array(
			'id'=>'woo-disable-carousel',
			'type' => 'switch', 
			'title' => __('Use Default Image View?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the custom carousel will not be used to display the single image.', 'ivan_domain_redux'),
			'default' => 0,
		),
		*/

		array(
			'id' => 'random-woo-templates',
			'type' => 'info',
			'desc' => __('Shop and Product Settings.', 'ivan_domain_redux')
		),

		array(
			'id'=>'shop-boxed-page',
			'type' => 'switch', 
			'title' => __('Display Shop/Products Boxed?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the shop and products will be displayed in a boxed layout.', 'ivan_domain_redux'),
			"default" => 0,
		),

		/*

		*
		*
		* TO BE TRANSFERED...
		*
		*

		array(
			'id' => 'shop-content-bg',
			'type' => 'background',
			'output' => array('.archive.woocommerce .content-wrapper, .single-product .content-wrapper'),
			'title' => __('Shop Content Background', 'ivan_domain_redux'),
			'subtitle' => __('Content background with image, color and other options.', 'ivan_domain_redux'),
			'required' => array('shop-boxed-page', 'equals', 1),
		),

		array(
			'id' => 'shop-patterns',
			'type' => 'select_image',
			'tiles' => false,
			'title' => __('Shop Content Background Pattern', 'ivan_domain_redux'),
			'subtitle' => __('Select a predefined background pattern.', 'ivan_domain_redux'),
			'options' => $default_patterns,
			'required' => array('shop-boxed-page', 'equals', 1),
		),
		*/

	), // #fields
);