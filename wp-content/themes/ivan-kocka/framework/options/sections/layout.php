<?php
/*
 * Layout Section
*/

$this->sections[] = array(
	'title' => __('Layout Settings', 'ivan_domain_redux'),
	'desc' => __('Change the main theme\'s layout and configure it.', 'ivan_domain_redux'),
	'icon' => 'el-icon-adjust-alt',
	'fields' => array(

		array(
			'id'=>'main-layout',
			'type' => 'select',
			'title' => __('Main Layout', 'ivan_domain_redux'),
			'desc' => __('See that this layout is valid to the whole website, but you can overwrite it locally in a page, for example.', 'ivan_domain_redux'),
			'subtitle' => __('Select the layout to be used by the website.', 'ivan_domain_redux'),
			'options' => apply_filters('ivan_main_layouts', array( 
					'Ivan_Main_Layout_Normal' => 'Normal Layout',
					'Ivan_Main_Layout_Aside_Left' => 'Aside Layout with Header at Left',
					'Ivan_Main_Layout_Aside_Right' => 'Aside Layout with Header at Right',
					) ),
			'default' => 'Ivan_Main_Layout_Normal'
		),

		// Enable Fixed Height Header effect in website
		array(
			'id'=>'layout-header-fixed-height',
			'type' => 'switch', 
			'title' => __('Fixed Height Header', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the header will be fixed at screen top not scrolling together with page.', 'ivan_domain_redux'),
			'default' => 0,
			'required' => array( 'main-layout', '!=', 'Ivan_Main_Layout_Normal'),
		),

		// Disable Widget Area below header
		array(
			'id'=>'layout-header-widget-area',
			'type' => 'switch', 
			'title' => __('Disable Widget Area?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the header will not show the widget area below menu. Useful when you are using Fixed Height Header.', 'ivan_domain_redux'),
			'default' => 0,
			'required' => array( 'main-layout', '!=', 'Ivan_Main_Layout_Normal'),
		),

		array(
			'id'=>'wide-boxed-switch',
			'type' => 'select',
			'title' => __('Wide or Boxed', 'ivan_domain_redux'),
			'desc' => __('See that this configuration is valid to the whole website, but you can overwrite it locally in a page, for example.', 'ivan_domain_redux'),
			'subtitle' => __('Select if the layout will be boxed or wide.', 'ivan_domain_redux'),
			'options' => array(
					'wide' => 'Wide',
					'boxed' => 'Boxed',
					'boxed-laterals' => 'Boxed only Lateral Margins',
					),
			'default' => 'wide'
		),

		array(
			'id' => 'random-layout-label',
			'type' => 'info',
			'desc' => __('Container Configuration.', 'ivan_domain_redux')
		),

		array(
			'id'=>'header-container-type',
			'type' => 'select',
			'title' => __('Header Container Type', 'ivan_domain_redux'),
			'desc' => __('Define container configuration to be used, it can be normal, expanded or compact.', 'ivan_domain_redux'),
			'options' => array(
					'normal' => 'Normal',
					'expanded' => 'Expanded',
					'compact' => 'Compact',
					),
			'default' => 'normal',
			'required' => array( 'main-layout', '=', 'Ivan_Main_Layout_Normal'),
		),

		array(
			'id'=>'content-container-type',
			'type' => 'select',
			'title' => __('Content Container Type', 'ivan_domain_redux'),
			'desc' => __('Define container configuration to be used, it can be normal, expanded or compact.', 'ivan_domain_redux'),
			'options' => array(
					'normal' => 'Normal',
					'expanded' => 'Expanded',
					'compact' => 'Compact',
					),
			'default' => 'normal',
			'required' => array( 'main-layout', '=', 'Ivan_Main_Layout_Normal'),
		),

		array(
			'id'=>'footer-container-type',
			'type' => 'select',
			'title' => __('Footer Container Type', 'ivan_domain_redux'),
			'desc' => __('Define container configuration to be used, it can be normal, expanded or compact.', 'ivan_domain_redux'),
			'options' => array(
					'normal' => 'Normal',
					'expanded' => 'Expanded',
					'compact' => 'Compact',
					),
			'default' => 'normal',
			'required' => array( 'main-layout', '=', 'Ivan_Main_Layout_Normal'),
		),

		array(
			'id'=>'aside-container-type',
			'type' => 'select',
			'title' => __('Aside Container Type', 'ivan_domain_redux'),
			'desc' => __('Define container configuration to be used, it can be normal or compact.', 'ivan_domain_redux'),
			'options' => array(
					'normal' => 'Normal',
					'compact' => 'Compact',
					),
			'default' => 'normal',
			'required' => array( 'main-layout', '!=', 'Ivan_Main_Layout_Normal'),
		),

	),
);