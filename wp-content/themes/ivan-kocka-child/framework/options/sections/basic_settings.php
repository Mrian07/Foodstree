<?php

$sections[] = array(
		'title' => __('Basic Settings', 'ivan_domain_redux'),
		'desc' => __('Redux Framework was created with the developer in mind. It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'ivan_domain_redux'),
		'icon' => 'el-icon-home',
	    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
		'fields' => array(	
			array(
				'id'=>'logo',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo', 'ivan_domain_redux'),
				'desc'=> __('Logo Dimensions in our demo: ', 'ivan_domain_redux') . apply_filters( 'ivan_logo_dimensions', '200x100' ),
				'subtitle' => __('Upload the logo that will be displayed in the header.', 'ivan_domain_redux'),
				),
			array(
				'id'=>'logo_retina',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo Retina', 'ivan_domain_redux'),
				'desc'=> __('The same logo image but with twice dimensions, e.g. your logo is 100x100, then your retina logo must be 200x200.', 'ivan_domain_redux'),
				'subtitle' => __('Optional retina version displayed in devices with retina display (high resolution display).', 'ivan_domain_redux'),
				'required' => array( 'logo', '!=', null ),
				),
			array(
				'id'=>'logo_spacing',
				'type' => 'spacing_mod',
				//'output' => array('.logo'), // An array of CSS selectors to apply this font style to
				'mode'=> 'margin', // absolute, padding, margin, defaults to padding
				'top'=> false, // Disable the top
				'right' => false, // Disable the right
				'bottom' => false, // Disable the bottom
				//'left' => false, // Disable the left
				//'all' => true, // Have one field that applies to all
				'units' => 'px', // You can specify a unit value. Possible: px, em, %
				//'units_extended' => 'true', // Allow users to select any type of unit
				//'display_units' => 'false', // Set to false to hide the units if the units are specified
				'title' => __('Logo Margin', 'ivan_domain_redux'),
				'subtitle' => __('Select a custom margin to the be applied in the logo.', 'ivan_domain_redux'),
				'desc' => __('If not set, default margin will be applied by theme.', 'ivan_domain_redux'),
				'default' => array('margin-left'=> '0' ),
				'required' => array( 'logo', '!=', null ),
				),

			array(
                        'id' => 'body-background',
                        'type' => 'background',
                        'output' => array('body'),
                        'title' => __('Body Background', 'ivan_domain_redux'),
                        'subtitle' => __('Body background with image, color, etc.', 'ivan_domain_redux'),
                    //'default' => '#FFFFFF',
                    ),

			),
		);