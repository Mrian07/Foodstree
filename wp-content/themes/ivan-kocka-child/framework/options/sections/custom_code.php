<?php
/*
 * Custom Code
*/

$this->sections[] = array(
	'title' => __('Custom JS/CSS', 'ivan_domain_redux'),
	'desc' => __('Easily add custom JS and CSS to your website.', 'ivan_domain_redux'),
	'icon' => 'el-icon-wrench',
	'fields' => array(

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Custom CSS', 'ivan_domain_redux')
		),

		array(
		    'id'       => 'css_editor',
		    'type'     => 'ace_editor',
		    'title'    => __('CSS Code', 'ivan_domain_redux'),
		    'subtitle' => __('Insert your custom CSS code right here. It will be displayed globally in the website.', 'ivan_domain_redux'),
		    'mode'     => 'css',
		    'theme'    => 'monokai',
		    'desc'     => '',
		    'default'  => ""
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Custom JS', 'ivan_domain_redux')
		),

		array(
		    'id'       => 'js_editor',
		    'type'     => 'ace_editor',
		    'title'    => __('JS Code', 'ivan_domain_redux'),
		    'subtitle' => __('Insert your custom JS code right here. It will be displayed globally in the website.', 'ivan_domain_redux'),
		    'mode'     => 'javascript',
		    'theme'    => 'monokai',
		    'desc'     => 'You can add custom JS code here, like your Google Analytics code or whatever you want.',
		    'default'  => ""
		),

		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Google Fonts and Favicon', 'ivan_domain_redux')
		),

		array(
		    'id'       => 'link_editor',
		    'type'     => 'ace_editor',
		    'title'    => __('Link Tags', 'ivan_domain_redux'),
		    'description' => __('You can insert aside link tags from Google Fonts, favicon code. We recommend this website to generate optimal markup:', 'ivan_domain_redux') . ' <a href="http://realfavicongenerator.net/" target="_blank">Real Favicon Generator</a>', 
		    'subtitle' => __('Insert your custom <link> tags to be displayed in the head, e.g. Google Fonts link tags and others.', 'ivan_domain_redux'),
		    'mode'     => 'html',
		    'theme'    => 'monokai',
		    'desc'     => '',
		    'default'  => ""
		),

	),
);