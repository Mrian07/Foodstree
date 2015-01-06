<?php
/*
 * General Section
*/

$this->sections[] = array(
	'title' => __('General Settings', 'ivan_domain_redux'),
	'desc' => __('Configure easily the basic theme\'s settings.', 'ivan_domain_redux'),
	'icon' => 'el-icon-magic',
	'fields' => array(

		array(
			'id'=>'page-comments-switch',
			'type' => 'switch', 
			'title' => __('Enable Comments in Pages?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the comment form will be avaliable in all pages.', 'ivan_domain_redux'),
			'default' => 0,
		),
		
		array(
			'id'=>'search-shop-switch',
			'type' => 'switch', 
			'title' => __('Enable Shop Search instead default Search?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the search forms of Live Search modules will be for shop products instead default.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'enable-preloader',
			'type' => 'switch', 
			'title' => __('Enable Loader Effect?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, a loader will appear before loading the page.', 'ivan_domain_redux'),
			'default' => 0,
		),

		array(
			'id'=>'disable-responsiveness',
			'type' => 'switch', 
			'title' => __('Disable Responsive Layout?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the website will not adapt in smaller devices like tablets or smartphones.', 'ivan_domain_redux'),
			'default' => 0,
		),

	),
);