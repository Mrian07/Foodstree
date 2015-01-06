<?php
/*
 * Layout Section
*/

$this->sections[] = array(
	'title' => __('Footer', 'ivan_domain_redux'),
	'desc' => __('Change the footer section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id'=>'footer-enable-switch',
			'type' => 'switch', 
			'title' => __('Disable this layout part?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, this layout part will not be displayed.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'footer-layout',
			'type' => 'select',
			'title' => __('Footer Layout', 'ivan_domain_redux'), 
			'subtitle' => __('Select the footer to be used at header.', 'ivan_domain_redux'),
			'options' => apply_filters('ivan_footer_layouts', array( 
					'Ivan_Layout_Footer_Normal' => 'Customizable Columns',
					) ),
			'default' => 'Ivan_Layout_Footer_Normal',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'footer-column-1',
			'type' => 'slider',
			'title' => __('#1 Column Width', 'ivan_domain_redux'),
			'desc' => __('Define column width, max is 12 parts, set as 0 to disable this area.', 'ivan_domain_redux'),
			'subtitle' => __('The four columns width combined should be equal to 12! Otherwise the layout will break.', 'ivan_domain_redux'),
			"default" => "3",
			"min" => "0",
			"step" => "1",
			"max" => "12",
		),

		array(
			'id' => 'footer-column-2',
			'type' => 'slider',
			'title' => __('#2 Column Width', 'ivan_domain_redux'),
			'desc' => __('Define column width, max is 12 parts, set as 0 to disable this area.', 'ivan_domain_redux'),
			'subtitle' => __('The four columns width combined should be equal to 12! Otherwise the layout will break.', 'ivan_domain_redux'),
			"default" => "3",
			"min" => "0",
			"step" => "1",
			"max" => "12",
		),

		array(
			'id' => 'footer-column-3',
			'type' => 'slider',
			'title' => __('#3 Column Width', 'ivan_domain_redux'),
			'desc' => __('Define column width, max is 12 parts, set as 0 to disable this area.', 'ivan_domain_redux'),
			'subtitle' => __('The four columns width combined should be equal to 12! Otherwise the layout will break.', 'ivan_domain_redux'),
			"default" => "3",
			"min" => "0",
			"step" => "1",
			"max" => "12",
		),

		array(
			'id' => 'footer-column-4',
			'type' => 'slider',
			'title' => __('#4 Column Width', 'ivan_domain_redux'),
			'desc' => __('Define column width, max is 12 parts, set as 0 to disable this area.', 'ivan_domain_redux'),
			'subtitle' => __('The four columns width combined should be equal to 12! Otherwise the layout will break.', 'ivan_domain_redux'),
			"default" => "3",
			"min" => "0",
			"step" => "1",
			"max" => "12",
		),

		array(
			'id' => 'random-footer',
			'type' => 'info',
			'desc' => __('Dynamic Areas', 'ivan_domain_redux')
		),

		array(
			'id'=>'footer-da-before-enable',
			'type' => 'switch', 
			'title' => __('Enable Dynamic Area Before Footer?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a dynamic area will be displayed above the layout.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'footer-da-before',
			'type' => 'select',
			'title' => __('Before Dynamic Content Page', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'footer-da-before-enable', '=', 1),
		),

		array(
			'id'=>'footer-da-after-enable',
			'type' => 'switch', 
			'title' => __('Enable Dynamic Area After Footer?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a dynamic area will be displayed below the layout.', 'ivan_domain_redux'),
			"default" => 0,
		),

		array(
			'id'=>'footer-da-after',
			'type' => 'select',
			'title' => __('After Dynamic Content Page', 'ivan_domain_redux'), 
			'subtitle' => __('Select the page from where the content will be loaded and displayed.', 'ivan_domain_redux'),
			'data' => 'pages',
			'required' => array( 'footer-da-after-enable', '=', 1),
		),

	), // #fields
);