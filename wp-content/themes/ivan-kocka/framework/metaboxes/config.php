<?php

// INCLUDE THIS BEFORE you load your ReduxFramework object config file.

// The metabox opt name should be the same as our main theme options
// name to allow it overwrite the values.
$redux_opt_name = IVAN_FW_THEME_OPTS;

if ( !function_exists( "ivan_redux_add_metaboxes" ) ) :
	function ivan_redux_add_metaboxes($metaboxes) {

	// Variable used to store the configuration array of metaboxes
	$metaboxes = array();
	$boxSections = array();

	// Metabox used to overwrite theme options by page
	// Get default patterns
	$default_patterns_path = get_template_directory() . '/images/patterns/';
	$default_patterns_url = get_template_directory_uri() . '/images/patterns/';
	$default_patterns = array();

	if (is_dir($default_patterns_path)) :

		if ($default_patterns_dir = opendir($default_patterns_path)) :
			$default_patterns = array();

			while (( $default_patterns_file = readdir($default_patterns_dir) ) !== false) {

				if (stristr($default_patterns_file, '.png') !== false || stristr($default_patterns_file, '.jpg') !== false) {
					$name = explode(".", $default_patterns_file);
					$name = str_replace('.' . end($name), '', $default_patterns_file);
					$default_patterns[] = array('alt' => $name, 'img' => $default_patterns_url . $default_patterns_file);
				}
			}
		endif;
	endif;

	$boxSections[] = array(
		'title' => __('Layout Settings', 'ivan_domain_redux'),
		'desc' => __('Change the main theme\'s layout and configure it.', 'ivan_domain_redux'),
		'icon' => 'el-icon-adjust-alt',
		'fields' => array(

			array(
				'id'=>'main-layout-local',
				'type' => 'select',
				'title' => __('Main Layout', 'ivan_domain_redux'),
				'desc' => __('See that this layout is valid to the whole website, but you can overwrite it locally in a page, for example.', 'ivan_domain_redux'),
				'subtitle' => __('Select the layout to be used by the website.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_main_layouts', array( 
						'Ivan_Main_Layout_Normal' => 'Normal Layout',
						'Ivan_Main_Layout_Aside_Left' => 'Aside Layout with Header at Left',
						'Ivan_Main_Layout_Aside_Right' => 'Aside Layout with Header at Right',
						) ),
				'default' => ''
			),

			// Enable Fixed Height Header effect in website
			array(
				'id'=>'layout-header-fixed-height-local',
				'type'	 => 'button_set_mod',
				'title' => __('Fixed Height Header', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the header will be fixed at screen top not scrolling together with page.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
				'required' => array( 'main-layout-local', '!=', array('Ivan_Main_Layout_Normal') ),
			),

			// Disable Widget Area below header
			array(
				'id'=>'layout-header-widget-area-local',
				'type'	 => 'button_set_mod',
				'title' => __('Disable Widget Area?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the header will not show the widget area below menu. Useful when you are using Fixed Height Header.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
				'required' => array( 'main-layout-local', '!=', array('Ivan_Main_Layout_Normal') ),
			),

			array(
				'id'=>'wide-boxed-switch-local',
				'type' => 'select',
				'title' => __('Wide or Boxed', 'ivan_domain_redux'),
				'desc' => __('See that this configuration is valid to the whole website, but you can overwrite it locally in a page, for example.', 'ivan_domain_redux'),
				'subtitle' => __('Select if the layout will be boxed or wide.', 'ivan_domain_redux'),
				'options' => array(
						'wide' => 'Wide',
						'boxed' => 'Boxed',
						'boxed-laterals' => 'Boxed only Lateral Margins',
						),
				'default' => ''
			),

			array(
				'id' => 'layout-body-bg-local',
				'type' => 'background',
				'output' => array('body'),
				'title' => __('Body Background', 'ivan_domain_redux'),
				'subtitle' => __('Body background with image, color and other options. Usually visible only when using boxed layout.', 'ivan_domain_redux'),
			),

			array(
				'id' => 'layout-patterns-local',
				'type' => 'select_image',
				'tiles' => false,
				'title' => __('Body Background Pattern', 'ivan_domain_redux'),
				'subtitle' => __('Select a predefined background pattern. Usually visible only when using boxed layout.', 'ivan_domain_redux'),
				'options' => $default_patterns,
			),

		),
	);

	$boxSections[] = array(
		'title' => __('Header', 'ivan_domain_redux'),
		'desc' => __('Change the header section configuration.', 'ivan_domain_redux'),
		'icon' => 'el-icon-cog',
		'fields' => array(

			// Disabled Header layout in the website
			array(
				'id'=>'header-enable-switch-local',
				'type'	 => 'button_set',
				'title' => __('Disable header?', 'ivan_domain_redux'),
				'subtitle' => __('If on, this layout part will not be displayed in website.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'header-layout-local',
				'type' => 'select',
				'title' => __('Header Layout', 'ivan_domain_redux'), 
				'subtitle' => __('Select the layout to be used at header.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_header_layouts', array( 
						'Ivan_Layout_Header_Simple_Right_Menu' => 'Logo at left and Menu + Modules Aside',
						'Ivan_Layout_Header_Classic_Right_Area' => 'Logo and Modules + Menu Below',
						'Ivan_Layout_Header_Simple_Logo_Centered' => 'Logo Centered, Menu Left and Modules Right',
						'Ivan_Layout_Header_Classic_Logo_Centered' => 'Logo Centered, Modules at Left and Right + Menu Below',
						'Ivan_Layout_Header_Only_Menu' => 'Only Menu',
						) ),
				'default' => '',
			),

			// Enable Fixed Header effect in website
			array(
				'id'=>'header-fixed-switch-local',
				'type'	 => 'button_set',
				'title' => __('Fixed Header', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the header will be fixed at screen top on page scroll.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id' => 'random-number',
				'type' => 'info',
				'desc' => __('Header Layout Configuration.', 'ivan_domain_redux')
			),

			// Enables Negative Height Header
			array(
				'id'=>'header-negative-height-local',
				'type'	 => 'button_set',
				'title' => __('Negative Height', 'ivan_domain_redux'),
				'subtitle'=> __('If on, header will not have height and content will be showed behind it.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			// Enables Boxed Header Layout
			array(
				'id'=>'header-boxed-layout-local',
				'type'	 => 'button_set',
				'title' => __('Enabled Boxed Layout?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, header will look boxed in the website even when the layout is wide.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
				'required' => array('header-negative-height-local', 'equals', 1),
			),

			array(
				'id'=>'header-bg-type-local',
				'type' => 'select',
				'title' => __('Header Background Type', 'ivan_domain_redux'), 
				'subtitle' => __('Select the type of background to be applied in header.', 'ivan_domain_redux'),
				'options' => array( 
						'' => 'Theme Default',
						'transparent-bg' => 'Transparent',
						'semi-transparent-bg' => 'Semi Transparent',
						'solid' => 'Solid',
						),
				'default' => '',
				'required' => array('header-negative-height-local', 'equals', 1),
			),

			array(
				'id' => 'header-color-scheme-local',
				'type' => 'select',
				'title' => __('Alternative Color Scheme', 'ivan_domain_redux'),
				'subtitle' => __('Select an alternative color scheme to header items.', 'ivan_domain_redux'),
				'options' => array( '' => 'Theme Default', 'standard' => 'Standard', 'light' => 'Light (great to dark backgrounds)', 'dark' => 'Dark (great to light backgrounds)' ),
				'default' => '',
				'required' => array('header-negative-height-local', 'equals', 1),
			),

			array(
				'id'=>'header-top-margin-local',
				'type' => 'spacing_mod',
				'mode'=> 'margin', // absolute, padding, margin, defaults to padding
				//'top'=> false, // Disable the top
				'right' => false, // Disable the right
				'bottom' => false, // Disable the bottom
				'left' => false, // Disable the left
				//'all' => true, // Have one field that applies to all
				'units' => 'px', // You can specify a unit value. Possible: px, em, %
				//'units_extended' => 'true', // Allow users to select any type of unit
				//'display_units' => 'false', // Set to false to hide the units if the units are specified
				'title' => __('Header Top Margin', 'ivan_domain_redux'),
				'subtitle' => __('Select a custom margin to the be applied to header top.', 'ivan_domain_redux'),
				'desc' => __('If not set, default margin will be applied by theme.', 'ivan_domain_redux'),
				'required' => array('header-negative-height-local', 'equals', 1),
				'output' => array('.iv-layout.header'),
			),

			// Enables Boxed Header Layout
			array(
				'id'=>'header-after-fold-local',
				'type'	 => 'button_set',
				'title' => __('Display Header after Page Fold?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, header will be displayed after user scroll until page fold.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
				'required' => array('header-negative-height-local', 'equals', 1),
			),

				array(
					'id'=>'header-after-fold-logo-local',
					'type' => 'button_set', 
					'title' => __('Keep showing logo before fold?', 'ivan_domain_redux'),
					'subtitle'=> __('If on, only the logo will be showed before page fold.', 'ivan_domain_redux'),
					'options' => array(
						'1' => 'On',
						'' => 'Default',
						'0' => 'Off',
					),
					"default" => '',
					'required' => array(
						array('header-after-fold-local', 'equals', 1),
						),
				),

			array(
				'id' => 'random-number',
				'type' => 'info',
				'desc' => __('General Modules Configuration.', 'ivan_domain_redux')
			),

			// Option to pull menu to left in avaliable layouts
			array(
				'id'=>'header-menu-pull-left-switch-local',
				'type'	 => 'button_set',
				'title' => __('Pull Menu to Left Side', 'ivan_domain_redux'),
				'subtitle'=> __('If on and avaliable in the layout, the menu will be placed at left. Works with "Normal Layout" and "Logo at left and Menu + Modules Aside" only.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'header-menu-pull-center-switch-local',
				'type'	 => 'button_set',
				'title' => __('Centralized Menu', 'ivan_domain_redux'),
				'subtitle'=> __('If on, menu will be centralized. Note that this option does not work with all layouts. Works with "Normal Layout" and with all "Menu Below" + "Only Menu" header layouts.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'header-aside-menu-centered-switch-local',
				'type' => 'button_set', 
				'title' => __('Center Align Aside Menu Items', 'ivan_domain_redux'),
				'subtitle'=> __('If on the menu items will be centered, else default alignment left/right will be used. Works only with "Aside Layout".', 'ivan_domain_redux'),
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			// Adds Lateral Lines to Modules
			array(
				'id'=>'header-lateral-lines-switch-local',
				'type'	 => 'button_set',
				'title' => __('Lateral Lines', 'ivan_domain_redux'),
				'subtitle'=> __('If on, modules will have lateral lines to separate them.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			// Adds V sign after menu items
			array(
				'id'=>'header-v-sign-switch-local',
				'type'	 => 'button_set',
				'title' => __('Menu Arrow', 'ivan_domain_redux'),
				'subtitle'=> __('If on, menu items will get a arrow after text.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			// Use responsive menu in select mode
			array(
				'id'=>'header-select-menu-switch-local',
				'type'	 => 'button_set',
				'title' => __('Use select responsive menu instead default?', 'ivan_domain_redux'),
				'subtitle'=> __('If on and avaliable, responsive menu will be displayed in a select instead default.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id' => 'random-number',
				'type' => 'info',
				'desc' => __('Modules Configuration.', 'ivan_domain_redux')
			),

			array(
				'id'=>'header-woo-cart-switch-local',
				'type'	 => 'button_set',
				'title' => __('Woo Cart', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a WooCommerce cart will be displayed. Requires WooCommerce plugin activated.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'header-login-ajax-switch-local',
				'type'	 => 'button_set',
				'title' => __('Login AJAX', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a Login AJAX will be displayed. Requires Login With AJAX plugin activated.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'header-search-switch-local',
				'type'	 => 'button_set',
				'title' => __('Search', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a search module will be displayed.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'header-text-switch-local',
				'type'	 => 'button_set',
				'title' => __('Text Module', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a rich text module will be displayed.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

				array(
					'id' => 'header-text-content-local',
					'type' => 'editor',
					'title' => __('Text Module Content', 'ivan_domain_redux'),
					'subtitle' => __('Place any text or shortcode to be displayed in header. Use [iv_separator] to add a separator in the text. Use [iv_icon icon="cogs"] to display Font Awesome icons. Use [iv_flags] to add WPML flags.', 'ivan_domain_redux'),
					'default' => '',
					'required' => array( 'header-text-switch-local', '=', 1 ),
				),

			array(
				'id'=>'header-social-switch-local',
				'type'	 => 'button_set',
				'title' => __('Social Module', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a social icon module will be displayed.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),
			array(
				'id'=>'header-menu-module-switch-local',
				'type'	 => 'button_set',
				'title' => __('Header Menu Module', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a additional menu will be displayed together with modules.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'header-ads-switch-local',
				'type'	 => 'button_set',
				'title' => __('Ads Module', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a ads module will be displayed. Note that it is not avaliable to all layouts.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id' => 'random-header',
				'type' => 'info',
				'desc' => __('Dynamic Areas', 'ivan_domain_redux')
			),

			array(
				'id'=>'header-da-after-enable-local',
				'type'	 => 'button_set',
				'title' => __('Enable Dynamic Area After Header?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a dynamic area will be displayed after header.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

		), // #fields
	);

	$boxSections[] = array(
		'title' => __('Title Wrapper', 'ivan_domain_redux'),
		'desc' => __('Change the title wrapper section configuration.', 'ivan_domain_redux'),
		'icon' => 'el-icon-cog',
		'fields' => array(

			array(

				'id'=>'title-wrapper-enable-switch-local',
				'type'	 => 'button_set',
				'title' => __('Disable this layout part?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, this layout part will not be displayed.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'title-wrapper-layout-local',
				'type' => 'select',
				'title' => __('Title Wrapper Layout', 'ivan_domain_redux'), 
				'subtitle' => __('Select the top layout to be used at title wrapper.', 'ivan_domain_redux'),
				'options' => apply_filters('ivan_title_wrapper_layouts', array( 
						'Ivan_Layout_Title_Wrapper_Normal' => 'Classic with Description Text',
						'Ivan_Layout_Title_Wrapper_Large' => 'Large with Description Text',
						) ),
				'default' => '',
				//'validate' => 'not_empty',
			),

			array(
				'id'=>'title-large-align-local',
				'type'	 => 'button_set',
				'title' => __('Align Large Title to Left?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, the large title wrapper layout will be aligned to left. Only works wiht Large with Description Text.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'breadcrumb-enable-local',
				'type'	 => 'button_set',
				'title' => __('Enable Breadcrumb?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a breadcrumb will be displayed aside of title wrapper. Only works with Classic with Description Text.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id' => 'title-sub-text',
				'type' => 'textarea',
				'title' => __('Title Optional Description', 'ivan_domain_redux'),
				'subtitle' => __('You can use a, strong, br, em and strong HTML tags.', 'ivan_domain_redux'),
				'description' => __('Use this field to display an optional text below main page title.', 'ivan_domain_redux'),
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
				'id' => 'title-wrapper-bg-local',
				'type' => 'background',
				'output' => array('#iv-layout-title-wrapper'),
				'title' => __('Title Wrapper Background', 'ivan_domain_redux'),
				//'subtitle' => __('Configure background of title wrapper.', 'ivan_domain_redux'),
			),

			array( 
			    'id'       => 'title-wrapper-border-local',
			    'type'     => 'border_mod',
			    'title'    => __('Title Wrapper Border', 'ivan_domain_redux'),
			    'all' => false,
			    'left' => false,
			    'right' => false,
			    'style' => false,
			    //'subtitle' => __('Only color validation can be done on this field type', 'ivan_domain_redux'),
			    'output' => array('#iv-layout-title-wrapper'),
			    //'desc'     => __('This is the description field, again good for additional info.', 'ivan_domain_redux'),
			    'default'  => array(
			    	'border-bottom' => '',
			    	'border-top' => '',
			    )
			),

			array(
				'id' => 'title-wrapper-color-scheme-local',
				'type' => 'select',
				'title' => __('Alternative Color Scheme', 'ivan_domain_redux'),
				'subtitle' => __('Select an alternative color scheme to title wrapper.', 'ivan_domain_redux'),
				'options' => array( '' => 'Theme Default', 'standard' => 'Standard', 'light' => 'Light (great to dark backgrounds)', 'dark' => 'Dark (great to light backgrounds)' ),
				'default' => '',
				//'validate' => 'not_empty',
			),

			array(
				'id'=>'title-wrapper-padding-local',
				'type' => 'spacing_mod',
				'mode'=> 'padding', // absolute, padding, margin, defaults to padding
				//'top'=> false, // Disable the top
				'right' => false, // Disable the right
				//'bottom' => false, // Disable the bottom
				'left' => false, // Disable the left
				//'all' => true, // Have one field that applies to all
				'units' => 'px', // You can specify a unit value. Possible: px, em, %
				//'units_extended' => 'true', // Allow users to select any type of unit
				//'display_units' => 'false', // Set to false to hide the units if the units are specified
				'title' => __('Title Wrapper Padding', 'ivan_domain_redux'),
				//'subtitle' => __('Select a custom margin to the be applied to header top.', 'ivan_domain_redux'),
				//'desc' => __('If not set, default margin will be applied by theme.', 'ivan_domain_redux'),
				'default' => array(),
				'output' => array('#iv-layout-title-wrapper'),
			),

			array(
				'id' => 'title-wrapper-font-local',
				'type' => 'typography_mod',
				'title' => __('Title Typography', 'ivan_domain_redux'),
				//'subtitle' => __('Typography.', 'ivan_domain_redux'),
				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => true, // Select a backup non-google font in addition to a google font
				'font-style'=> true, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => true, // Only appears if google is true and subsets not set to false
				'font-size'=> true,
				'line-height'=> false,
				'word-spacing'=> true, // Defaults to false
				'letter-spacing'=> true, // Defaults to false
				'color'=> true,
				'font-weight' => true,
				'text-align' => true,
				'text-transform' => true,
				//'preview'=>false, // Disable the previewer
				//'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
				'output' => array('#iv-layout-title-wrapper h2'),
				//'units' => 'px', // Defaults to px
			),

			array(
				'id' => 'title-wrapper-desc-font-local',
				'type' => 'typography_mod',
				'title' => __('Title Description Typography', 'ivan_domain_redux'),
				'subtitle' => __('Typography to optional description used in pages.', 'ivan_domain_redux'),
				//'compiler'=>true, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => true, // Select a backup non-google font in addition to a google font
				'font-style'=> true, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => true, // Only appears if google is true and subsets not set to false
				'font-size'=> true,
				'line-height'=> false,
				'word-spacing'=> true, // Defaults to false
				'letter-spacing'=> true, // Defaults to false
				'color'=> true,
				'font-weight' => true,
				'text-align' => true,
				'text-transform' => true,
				//'preview'=>false, // Disable the previewer
				//'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
				'output' => array('#iv-layout-title-wrapper p'),
				//'units' => 'px', // Defaults to px
				'default' => array(),
			),			

		), // #fields
	);

	$boxSections[] = array(
	'title' => __('Content', 'ivan_domain_redux'),
	'desc' => __('Change the content section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

			array(
				'id'=>'page-boxed-page-local',
				'type'	 => 'button_set',
				'title' => __('Display Page/Project inside Box?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, this page will be displayed inside a box.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id' => 'layout-boxed-content-bg-local',
				'type' => 'background',
				'output' => array('.page .content-wrapper.page-boxed-style, .single-ivan_vc_projects .content-wrapper.page-boxed-style'),
				'title' => __('Pages: Boxed Content Background', 'ivan_domain_redux'),
				'subtitle' => __('Configuration used as background of boxed pages and projects.', 'ivan_domain_redux'),
			),

			array(
				'id' => 'layout-boxed-patterns-local',
				'type' => 'select_image',
				'tiles' => false,
				'title' => __('Boxed Content Background Pattern', 'ivan_domain_redux'),
				'subtitle' => __('Select a predefined background pattern. Usually visible only when using content boxed style.', 'ivan_domain_redux'),
				'options' => $default_patterns,
			),

		), // #fields
	);

	$boxSections[] = array(
	'title' => __('Top Header', 'ivan_domain_redux'),
	'desc' => __('Change the top header section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

			array(
				'id'=>'top-header-enable-switch-local',
				'type'	 => 'button_set',
				'title' => __('Disable this layout part?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, this layout part will not be displayed.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),
		), // #fields
	);

	$boxSections[] = array(
	'title' => __('Footer', 'ivan_domain_redux'),
	'desc' => __('Change the footer section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

			array(
				'id'=>'footer-enable-switch-local',
				'type'	 => 'button_set',
				'title' => __('Disable this layout part?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, this layout part will not be displayed.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id' => 'random-footer',
				'type' => 'info',
				'desc' => __('Dynamic Areas', 'ivan_domain_redux')
			),

			array(
				'id'=>'footer-da-before-enable-local',
				'type'	 => 'button_set',
				'title' => __('Enable Dynamic Area Before Footer?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a dynamic area will be displayed above the layout.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'footer-da-after-enable-local',
				'type'	 => 'button_set',
				'title' => __('Enable Dynamic Area After Footer?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a dynamic area will be displayed below the layout.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

		), // #fields
	);

	$boxSections[] = array(
	'title' => __('Bottom Footer', 'ivan_domain_redux'),
	'desc' => __('Change the bottom footer section configuration.', 'ivan_domain_redux'),
	'icon' => 'el-icon-cog',
	'fields' => array(

			array(
				'id'=>'bottom-footer-enable-local',
				'type'	 => 'button_set',
				'title' => __('Disable this layout part?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, this layout part will not be displayed.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id' => 'random-bottom-footer',
				'type' => 'info',
				'desc' => __('Dynamic Areas', 'ivan_domain_redux')
			),

			array(
				'id'=>'bottom-footer-da-before-enable-local',
				'type'	 => 'button_set',
				'title' => __('Enable Dynamic Area Before Bottom Footer?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a dynamic area will be displayed above the layout.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

			array(
				'id'=>'bottom-footer-da-after-enable-local',
				'type'	 => 'button_set',
				'title' => __('Enable Dynamic Area After Bottom Footer?', 'ivan_domain_redux'),
				'subtitle'=> __('If on, a dynamic area will be displayed below the layout.', 'ivan_domain_redux'),
				//Must provide key => value pairs for options
				'options' => array(
					'1' => 'On',
					'' => 'Default',
					'0' => 'Off',
				),
				'default' => '',
			),

		), // #fields
	);

	$boxSections[] = array(
		'title' => __('Menus/Sidebars', 'ivan_domain_redux'),
		'desc' => __('Replace the menus and sidebars to be displayed in the avaliable areas.', 'ivan_domain_redux'),
		'icon' => 'el-icon-magic',
		'fields' => array(

			array(
				'id'=>'menu-replace-primary',
				'type' => 'select',
				'title' => __('Primary Menu', 'ivan_domain_redux'),
				'desc' => __('Select a menu to overwrite the header menu location.', 'ivan_domain_redux'),
				'data' => 'menus',
				'default' => '',
			),

			array(
				'id'=>'menu-replace-primary_module',
				'type' => 'select',
				'title' => __('Module Menu', 'ivan_domain_redux'),
				'desc' => __('Select a menu to overwrite the module menu location.', 'ivan_domain_redux'),
				'data' => 'menus',
				'default' => '',
			),

			array(
				'id'=>'menu-replace-secondary',
				'type' => 'select',
				'title' => __('Secondary Menu', 'ivan_domain_redux'),
				'desc' => __('Select a menu to overwrite the top header menu location.', 'ivan_domain_redux'),
				'data' => 'menus',
				'default' => '',
			),

			array(
				'id'=>'menu-replace-bottom_footer',
				'type' => 'select',
				'title' => __('Bottom Footer Menu', 'ivan_domain_redux'),
				'desc' => __('Select a menu to overwrite the bottom footer menu location.', 'ivan_domain_redux'),
				'data' => 'menus',
				'default' => '',
			),

			array(
				'id' => 'random-number',
				'type' => 'info',
				'desc' => __('Sidebars', 'ivan_domain_redux')
			),

			array(
				'id'=>'sidebar-primary-replace',
				'type' => 'select',
				'title' => __('Primary Sidebar', 'ivan_domain_redux'),
				'desc' => __('Select a sidebar to overwrite the sidebar location.', 'ivan_domain_redux'),
				'data' => 'sidebars',
				'default' => '',
			),

			array(
				'id'=>'sidebar-secondary-replace',
				'type' => 'select',
				'title' => __('Secondary Sidebar', 'ivan_domain_redux'),
				'desc' => __('Select a sidebar to overwrite the sidebar location.', 'ivan_domain_redux'),
				'data' => 'sidebars',
				'default' => '',
			),

		), // #fields
	);

	$boxSections[] = array(
		'title' => __('Custom JS/CSS', 'ivan_domain_redux'),
		'desc' => __('Easily add custom JS and CSS to your website.', 'ivan_domain_redux'),
		'icon' => 'el-icon-wrench',
		'fields' => array(

			array(
				'id'	   => 'css_editor_local',
				'type'	 => 'ace_editor',
				'title'	=> __('CSS Code', 'ivan_domain_redux'),
				'subtitle' => __('Insert your custom CSS code right here. It will be displayed globally in the website.', 'ivan_domain_redux'),
				'mode'	 => 'css',
				'theme'	=> 'monokai',
				'desc'	 => '',
				'default'  => ""
			),

			array(
				'id'	   => 'js_editor_local',
				'type'	 => 'ace_editor',
				'title'	=> __('JS Code', 'ivan_domain_redux'),
				'subtitle' => __('Insert your custom JS code right here. It will be displayed globally in the website.', 'ivan_domain_redux'),
				'mode'	 => 'javascript',
				'theme'	=> 'monokai',
				'desc'	 => 'You can add custom JS code here, like your Google Analytics code or whatever you want.',
				'default'  => ""
			),

			array(
				'id'	   => 'link_editor_local',
				'type'	 => 'ace_editor',
				'title'	=> __('Link Tags', 'ivan_domain_redux'),
				'subtitle' => __('Insert your custom <link> tags to be displayed in the head, e.g. Google Fonts link tags and others.', 'ivan_domain_redux'),
				'mode'	 => 'html',
				'theme'	=> 'monokai',
				'desc'	 => '',
				'default'  => ""
			),

		),
	);


	$metaboxes[] = array(
		'id' => 'ivan-theme-options',
		'title' => __('Theme Options', 'ivan_domain_redux'),
		'post_types' => array('page'),
		//'page_template' => array('page-test.php'),
		//'post_format' => array('image'),
		'position' => 'normal', // normal, advanced, side
		'priority' => 'high', // high, core, default, low
		//'sidebar' => false, // enable/disable the sidebar in the normal/advanced positions
		'sections' => $boxSections
	);

	// Removes main layout options only to projects
	unset($boxSections[0]['fields'][0]);
	unset($boxSections[0]['fields'][1]);
	unset($boxSections[0]['fields'][2]);
	unset($boxSections[0]['fields'][3]);

	$boxSections[0]['fields'][] = array(
			'id'=>'project-nav-local',
			'type'	 => 'button_set',
			'title' => __('Display Navigation in Projects?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, next and previous project will be displayed in single project pages.', 'ivan_domain_redux'),
			'options' => array(
				'1' => 'On',
				'' => 'Default',
				'0' => 'Off',
			),
			//'default' => 1,
		);

	$boxSections[0]['fields'][] = array(
			'id'=>'project-related-local',
			'type'	 => 'button_set',
			'title' => __('Display Related Projects?', 'ivan_domain_redux'),
			'subtitle'=> __('If on, the related projects will be displayed below project contents.', 'ivan_domain_redux'),
			'options' => array(
				'1' => 'On',
				'' => 'Default',
				'0' => 'Off',
			),
		);

	$metaboxes[] = array(
		'id' => 'ivan-theme-options',
		'title' => __('Theme Options', 'ivan_domain_redux'),
		'post_types' => array('ivan_vc_projects'),
		//'page_template' => array('page-test.php'),
		//'post_format' => array('image'),
		'position' => 'normal', // normal, advanced, side
		'priority' => 'high', // high, core, default, low
		//'sidebar' => false, // enable/disable the sidebar in the normal/advanced positions
		'sections' => $boxSections
	);

	/*
	$mansorySections = array();

	$mansorySections[] = array(
		//'title' => __('Home Settings', 'ivan_domain_redux'),
		//'desc' => __('Redux Framework was created with the developer in mind. It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'ivan_domain_redux'),
		'icon_class' => 'icon-large',
		'icon' => 'el-icon-home',
		'fields' => array(
			array(
				'id'=>'mansory-columns',
				'type' => 'slider', 
				'title' => __('Mansory Columns', 'ivan_domain_redux'),
				'desc'=> __('Define alternative column size if this post is used in our mansory modules. 12 Columns means 100% of width, if 0 is selected, default column of module will be used.', 'ivan_domain_redux'),
				'default'   => "0",
				"min"	   => "0",
				"step"	  => "1",
				"max"	   => "12",
			   ),
		)
	);
  
	$metaboxes[] = array(
		'id' => 'ivan-mansory-options',
		'title' => __('Mansory Options', 'ivan_domain_redux'),
		'post_types' => array('post'),
		//'page_template' => array('page-test.php'),
		//'post_format' => array('image'),
		'position' => 'normal', // normal, advanced, side
		'priority' => 'core', // high, core, default, low
		'sections' => $mansorySections
	);
	*/

	// Filter to child themes
	$metaboxes = apply_filters( 'ivan_redux_metabox_filter', $metaboxes );

	return $metaboxes;
  }

  add_action('redux/metaboxes/'.IVAN_FW_THEME_OPTS.'/boxes', 'ivan_redux_add_metaboxes');

endif;

// The loader will load all of the extensions automatically based on your $redux_opt_name
require_once(dirname(__FILE__).'/loader.php');