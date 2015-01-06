<?php
/*
 * Content Section
*/

$this->sections[] = array(
	'title' => __('Content', 'ivan_domain_redux'),
	'desc' => __('Change the content configurations.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id'=>'page-boxed-page',
			'type' => 'switch', 
			'title' => __('Display Pages/Projects Boxed?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the pages will be displayed in a boxed layout. Can be overloaded per page.', 'ivan_domain_redux'),
			"default" => 0,
		),

		/*

		*
		*
		* TO BE TRANSFERED...
		*
		*

		array(
			'id' => 'layout-content-bg',
			'type' => 'background',
			'output' => array('.page .content-wrapper, .single-ivan_vc_projects .content-wrapper'),
			'title' => __('Content Background', 'ivan_domain_redux'),
			'subtitle' => __('Content background with image, color and other options.', 'ivan_domain_redux'),
			'required' => array('page-boxed-page', 'equals', 1),
		),

		array(
			'id' => 'content-patterns',
			'type' => 'select_image',
			'tiles' => false,
			'title' => __('Content Background Pattern', 'ivan_domain_redux'),
			'subtitle' => __('Select a predefined background pattern.', 'ivan_domain_redux'),
			'options' => $default_patterns,
			'required' => array('page-boxed-page', 'equals', 1),
		),

		*/

	),
);