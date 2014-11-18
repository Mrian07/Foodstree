<?php
/***
 * File used to map all our shortcodes attributes to Visual Composer use
 * all attributes and Customizer Params are all placed here as well.
 * 
 * This file is called at ivan_vc_extend.php inside init WP filter.
 **/

/***
 * Useful Infos
***/
	$iv_categories = get_terms("ivan_vc_projects_cats");
	$iv_cats = array('All' => '');

	if(0 < count($iv_categories)) {
		foreach ($iv_categories as $cat) {
			$iv_cats[$cat->name] = $cat->slug;
		}
	}

	$iv_portfolios = get_terms("ivan_vc_projects_portfolios");
	$iv_ports = array('All' => '');
	if(0 < count($iv_portfolios)) {
		foreach ($iv_portfolios as $port) {
			$iv_ports[$port->name] = $port->slug;
		}
	}

	$iv_post_types = get_post_types( array( 'public' => true ), 'objects' );
	$iv_cpts = array('Default' => '');
	if(0 < count($iv_post_types)) {
		foreach ($iv_post_types as $cpt) {
			if( $cpt->name != 'ivan_vc_projects' )
				$iv_cpts[$cpt->name] = $cpt->name;
		}
	}

	$ivan_add_css_animation = array(
		'type' => 'dropdown',
		'heading' => __( 'CSS Animation', 'iv_js_composer' ),
		'param_name' => 'css_animation',
		'admin_label' => true,
		'value' => array(
			__( 'No', 'iv_js_composer' ) => '',
			__( 'Top to bottom', 'iv_js_composer' ) => 'top-to-bottom',
			__( 'Bottom to top', 'iv_js_composer' ) => 'bottom-to-top',
			__( 'Left to right', 'iv_js_composer' ) => 'left-to-right',
			__( 'Right to left', 'iv_js_composer' ) => 'right-to-left',
			__( 'Appear from center', 'iv_js_composer' ) => "appear"
		),
		'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'iv_js_composer' )
	  );

/***
 * Remove Useless Params
***/
if( function_exists('vc_remove_param') ) {

	// Separator default fields
	vc_remove_param('vc_separator', 'style');
	vc_remove_param('vc_separator', 'color');
	vc_remove_param('vc_separator', 'accent_color');
	vc_remove_param('vc_separator', 'el_width');

	// Separator with text default fields
	vc_remove_param('vc_text_separator', 'style');
	vc_remove_param('vc_text_separator', 'color');
	vc_remove_param('vc_text_separator', 'accent_color');
	//vc_remove_param('vc_text_separator', 'el_width');

	// Removes default font color from row
	vc_remove_param('vc_row', 'font_color');
	vc_remove_param('vc_row_inner', 'font_color');

}

/***
 * Image Block
***/
	// Call global var to use selectors array
	global $ivan_vc_image_block;

	vc_map(
		array(
			'name' => __('Image Block', 'iv_js_composer'),
			'base' => 'ivan_image_block',
			'icon' => 'vc_info_box',
			'class' => 'ivan_image_block',
			'category' => 'Elite Addons',
			'description' => 'Display a block with image as background and an editable cover.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Background Image", 'iv_js_composer'),
					"param_name" => "ivan_bg_img",
					"value" => "",
					"description" => __("Upload or select background image from media gallery.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"heading" => __("Image Size", 'iv_js_composer'),
					"param_name" => "ivan_img_size",
					"value" => ivan_vc_img_sizes(),
					"description" => __("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Leave empty to use default size.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Item Height", 'iv_js_composer'),
					"param_name" => "ivan_custom_height",
					"description" => __("Enter a custom height to the items like '300' or '250'", 'iv_js_composer')
				),

				//
				// Frontal Block
				//
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Icon Family", 'iv_js_composer'),
						"param_name" => "ico_family",
						"value" => array(
							'Font Awesome' => '',
							'Elegant Icons' => 'el el-',
							'Custom' => 'custom',
						),
						"description" => __("Select the icon family.", 'iv_js_composer'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Custom Icon Class", 'iv_js_composer'),
						"param_name" => "ico_custom",
						"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
						'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
					),

					array(
						"type" => "textfield",
						"heading" => __("Icon Name", 'iv_js_composer'),
						"param_name" => "ico",
						"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => "Icon Size",
						"param_name" => "ico_size",
						"value" => array(
							"Default" => '',
							"Tiny" => "fa-lg",
							"Small" => "fa-2x",
							"Medium" => "fa-3x",	
							"Large" => "fa-4x",
							"Very Large" => "fa-5x",
						),
						"description" => "Define the icon size.",
					),

					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Heading", 'iv_js_composer'),
						"param_name" => "heading",
						"value" => '',
					),

					array(
						"type" => "dropdown",
						"heading" => "Heading Tag",
						"param_name" => "heading_tag",
						"value" => array(
							"Default"   => "",
							"h2" => "h2",
							"h3" => "h3",
							"h4" => "h4",	
							"h5" => "h5",	
							"h6" => "h6",	
						),
						"description" => "Custom and optional heading tag to pie chart heading.",
						'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
					),

					array(
						"type" => "textarea",
						"class" => "",
						"heading" => __("Description", 'iv_js_composer'),
						"param_name" => "description",
						"value" => '',
					),

					array(
						"type" => "textfield",
						"heading" => __("Button Text", 'iv_js_composer'),
						"param_name" => "btn_text",
						"description" => __("Optional text to be displayed in the button.", 'iv_js_composer'),
						'value' => __('', 'iv_js_composer'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Button Link", 'iv_js_composer'),
						"param_name" => "btn_link",
						"description" => __("Defines the button link URL or anchor.", 'iv_js_composer'),
						'value' => '',
						'dependency' => array( 'element' => 'btn_text', 'not_empty' => true ),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Button Target", 'iv_js_composer'),
						"param_name" => "btn_target",
						"value" => array(
							'Same Page' => '',
							'Blank Page' => 'yes',
						),
						"description" => __("Define button link target.", 'iv_js_composer'),
						'dependency' => array( 'element' => 'btn_text', 'not_empty' => true ),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => "Align",
						"param_name" => "align",
						"value" => array(
							"Center" => '',
							"Left" => "to-left",
							"Right" => "to-right",
						),
						"description" => "Define the horizontal alignment of the content.",
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => "Vertical Align",
						"param_name" => "v_align",
						"value" => array(
							"Middle" => '',
							"Top" => "v-top",
							"Bottom" => "v-bottom",
						),
						"description" => "Define the vertical alignment of the content.",
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => "Overlay Layer?",
						"param_name" => "overlay",
						"value" => array(
							"Yes" => '',
							"No" => "no",
						),
						"description" => "Adds an overlay layer above the image to darken it a bit.",
					),

				// Normal Fields
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),

				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_image_block', array(
						__( 'Default', 'iv_js_composer' ) => '',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),	

				//
				// Flip Block
				//

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Icon Family", 'iv_js_composer'),
						"param_name" => "f_ico_family",
						"value" => array(
							'Font Awesome' => '',
							'Elegant Icons' => 'el el-',
							'Custom' => 'custom',
						),
						"description" => __("Select the icon family.", 'iv_js_composer'),
						"group" => __('Flip', 'iv_js_composer'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Custom Icon Class", 'iv_js_composer'),
						"param_name" => "f_ico_custom",
						"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
						'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "textfield",
						"heading" => __("Icon Name", 'iv_js_composer'),
						"param_name" => "f_ico",
						"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => "Icon Size",
						"param_name" => "f_ico_size",
						"value" => array(
							"Default" => '',
							"Tiny" => "fa-lg",
							"Small" => "fa-2x",
							"Medium" => "fa-3x",	
							"Large" => "fa-4x",
							"Very Large" => "fa-5x",
						),
						"description" => "Define the icon size.",
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Heading", 'iv_js_composer'),
						"param_name" => "f_heading",
						"value" => '',
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "dropdown",
						"heading" => "Heading Tag",
						"param_name" => "f_heading_tag",
						"value" => array(
							"Default"   => "",
							"h2" => "h2",
							"h3" => "h3",
							"h4" => "h4",	
							"h5" => "h5",	
							"h6" => "h6",	
						),
						"description" => "Custom and optional heading tag to pie chart heading.",
						'dependency' => array( 'element' => 'f_heading', 'not_empty' => true ),
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "textarea",
						"class" => "",
						"heading" => __("Description", 'iv_js_composer'),
						"param_name" => "content",
						"value" => '',
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "textfield",
						"heading" => __("Button Text", 'iv_js_composer'),
						"param_name" => "f_btn_text",
						"description" => __("Optional text to be displayed in the button.", 'iv_js_composer'),
						'value' => __('', 'iv_js_composer'),
						"group" => __('Flip', 'iv_js_composer'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Button Link", 'iv_js_composer'),
						"param_name" => "f_btn_link",
						"description" => __("Defines the button link URL or anchor.", 'iv_js_composer'),
						'value' => '',
						'dependency' => array( 'element' => 'f_btn_text', 'not_empty' => true ),
						"group" => __('Flip', 'iv_js_composer'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Button Target", 'iv_js_composer'),
						"param_name" => "f_btn_target",
						"value" => array(
							'Same Page' => '',
							'Blank Page' => 'yes',
						),
						"description" => __("Define button link target.", 'iv_js_composer'),
						'dependency' => array( 'element' => 'f_btn_text', 'not_empty' => true ),
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => "Align",
						"param_name" => "f_align",
						"value" => array(
							"Center" => '',
							"Left" => "to-left",
							"Right" => "to-right",
						),
						"description" => "Define the horizontal alignment of the content.",
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => "Vertical Align",
						"param_name" => "f_v_align",
						"value" => array(
							"Middle" => '',
							"Top" => "v-top",
							"Bottom" => "v-bottom",
						),
						"description" => "Define the vertical alignment of the content.",
						"group" => __('Flip', 'iv_js_composer'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => "Overlay Layer?",
						"param_name" => "f_overlay",
						"value" => array(
							"Yes" => '',
							"No" => "no",
						),
						"description" => "Adds an overlay layer above the image to darken it a bit.",
						"group" => __('Flip', 'iv_js_composer'),
					),
						
				////

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Block", 'iv_js_composer'),
					"param_name" => "block_css",
					"customize" => $ivan_vc_image_block->selectors['block_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Overlay", 'iv_js_composer'),
					"param_name" => "overlay_css",
					"customize" => $ivan_vc_image_block->selectors['overlay_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "icon_css",
					"customize" => $ivan_vc_image_block->selectors['icon_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Heading", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_image_block->selectors['title_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Description", 'iv_js_composer'),
					"param_name" => "desc_css",
					"customize" => $ivan_vc_image_block->selectors['desc_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Button", 'iv_js_composer'),
					"param_name" => "btn_css",
					"customize" => $ivan_vc_image_block->selectors['btn_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				// Flip Customization

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Overlay", 'iv_js_composer'),
					"param_name" => "f_overlay_css",
					"customize" => $ivan_vc_image_block->selectors['f_overlay_css'],
					"value" => "",
					"group" => __('Flip Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "f_icon_css",
					"customize" => $ivan_vc_image_block->selectors['f_icon_css'],
					"value" => "",
					"group" => __('Flip Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Heading", 'iv_js_composer'),
					"param_name" => "f_title_css",
					"customize" => $ivan_vc_image_block->selectors['f_title_css'],
					"value" => "",
					"group" => __('Flip Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Description", 'iv_js_composer'),
					"param_name" => "f_desc_css",
					"customize" => $ivan_vc_image_block->selectors['f_desc_css'],
					"value" => "",
					"group" => __('Flip Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Button", 'iv_js_composer'),
					"param_name" => "f_btn_css",
					"customize" => $ivan_vc_image_block->selectors['f_btn_css'],
					"value" => "",
					"group" => __('Flip Customization', 'iv_js_composer'),
				),
				
			),					
		)
	);

/***
 * Pie Charts
***/

global $ivan_vc_pie_chart;

// Pie Chart
vc_map( array(
	'name' => __('Pie Chart', 'iv_js_composer'),
	'base' => 'ivan_pie_chart',
	'icon' => 'vc_info_box',
	'class' => 'ivan_pie_chart',
	'category' => 'Elite Addons',
	'description' => 'Show a pie chart with counter functions.',
	'controls' => 'full',
	'show_settings_on_create' => true,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => "Percentage",
			"param_name" => "percent",
			"description" => "Define how much of the bar is filled, max is 100. Only number."
		),
		array(
			"type" => "colorpicker",
			"heading" => "Pie Chart Normal Color",
			"param_name" => "normal_color", // noactive_color
			"description" => "Define the color of the pie circle."
		),
		array(
			"type" => "colorpicker",
			"heading" => "Pie Chart Active Color",
			"param_name" => "active_color",
			"description" => "Define the color of the filled pie circle."
		),
		array(
			"type" => "textfield",
			"heading" => "Pie Chart Line Width",
			"param_name" => "line_width",
			"description" => "Define custom line width of pie circle. Only numbers!"
		),
		array(
			"type" => "textfield",
			"heading" => "Optional Pie Chart Size",
			"param_name" => "width",
			"description" => "Define a custom size to the pie chart. Only numbers!"
		),
		array(
			"type" => "textfield",
			"heading" => "Heading",
			'admin_label' => true,
			"param_name" => "heading",
			"description" => "Optional heading placed below pie chart."
		),
		array(
			"type" => "dropdown",
			"heading" => "Heading Tag",
			"param_name" => "heading_tag",
			"value" => array(
				"Default"   => "",
				"h2" => "h2",
				"h3" => "h3",
				"h4" => "h4",	
				"h5" => "h5",	
				"h6" => "h6",	
			),
			"description" => "Custom and optional heading tag to pie chart heading."
		),
		array(
			"type" => "textarea",
			"heading" => "Text / Description",
			"param_name" => "content",
			"description" => "Optiona text placed below heading or pie chart."
		),
		array(
			"type" => "dropdown",
			"heading" => "Separator below Heading?",
			"param_name" => "separator",
			"value" => array(
				"No" => "",
				"Yes" => "yes",
			),
			"description" => "Adds an optional separator below heading."
		),

		array(
			"type" => "textfield",
			"heading" => __("Extra class name", 'iv_js_composer'),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'iv_js_composer' ),
			'param_name' => 'template',
			'admin_label' => true,
			'value' => apply_filters( 'ivan_vc_pie_chart', array(
				__( 'Default', 'iv_js_composer' ) => '',
				'Gray' => 'gray-bg',
				'Dark' => 'dark-bg',
				'Clean' => 'clean-color',
				//'Light' => 'light-bg',
				'Primary' => 'primary-bg',
			) ),
			'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
		),

		array(
			"type" => "ivan_customizer_id",
			"heading" => __("Customization ID", 'iv_js_composer'),
			"param_name" => "c_id",
			"value" => "",
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Main Block", 'iv_js_composer'),
			"param_name" => "block_css",
			"customize" => $ivan_vc_pie_chart->selectors['block_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Counter/Percentage", 'iv_js_composer'),
			"param_name" => "counter_css",
			"customize" => $ivan_vc_pie_chart->selectors['counter_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Heading", 'iv_js_composer'),
			"param_name" => "title_css",
			"customize" => $ivan_vc_pie_chart->selectors['title_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Separator", 'iv_js_composer'),
			"param_name" => "sep_css",
			"customize" => $ivan_vc_pie_chart->selectors['sep_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "text_css",
			"customize" => $ivan_vc_pie_chart->selectors['text_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

	)
) );


/***
 * Image Hover
***/

vc_map( array(

	'name' => __('Image Flip', 'iv_js_composer'),
	'base' => 'ivan_image_flip',
	'icon' => 'vc_info_box',
	'class' => 'ivan_image_flipt',
	'category' => 'Elite Addons',
	'description' => 'Show an image that changes on hover.',
	'controls' => 'full',
	'show_settings_on_create' => true,
	"params" => array(
		array(
			"type" => "attach_image",
			"heading" => "Image",
			"param_name" => "image",
			'description' => 'Define the main image displayed by default.',
		),
		array(
			"type" => "attach_image",
			"heading" => "Flip Image",
			"param_name" => "flip_image",
			'description' => 'The flip image displayed on hover only.',
		),
		array(
			"type" => "textfield",
			"heading" => "Link",
			"param_name" => "link",
			"description" => "Optional link to apply in the module."
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Link Target", 'iv_js_composer'),
			"param_name" => "target",
			"value" => array(
				'Same Page' => '',
				'Blank Page' => 'yes',
			),
			"description" => __("Define link target.", 'iv_js_composer'),
		),
		
		$ivan_add_css_animation,

		array(
			"type" => "textfield",
			"heading" => __("Extra class name", 'iv_js_composer'),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'iv_js_composer' ),
			'param_name' => 'template',
			'admin_label' => true,
			'value' => apply_filters( 'ivan_vc_image_flip', array(
				__( 'Default', 'iv_js_composer' ) => '',
			) ),
			'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
		),
	)
) );

/***
 * Team Member
***/

	// Call global var to use selectors array
	global $ivan_vc_staff;

	// Social Icon List
	$ivan_icon_array = ivan_vc_staff_icons();

	$staff_icons_fields = array();

	foreach ($ivan_icon_array as $key => $value) {

		$staff_icons_fields[] = array(
			"type" => "textfield",
			"heading" => $value,
			"param_name" => $key,
			"description" => __("Type your social address with http:// prefix or other.", 'iv_js_composer'),
			"group" => __('Social Icons', 'iv_js_composer'),
		);
	}

	vc_map(
		array(
			'name' => __('Team Member', 'iv_js_composer'),
			'base' => 'ivan_staff',
			'icon' => 'vc_info_box',
			'class' => 'ivan_staff',
			'category' => 'Elite Addons',
			'description' => 'Display a team member with effects and social icons.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array_merge( array(
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Description", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Optional description to this staff member.", 'iv_js_composer'),
					'value' => '',
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display Description Inside?", 'iv_js_composer'),
					"param_name" => "content_inside",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Select yes to show the content inside the thumbnail/image.", 'iv_js_composer'),
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Staff Image", 'iv_js_composer'),
					"param_name" => "image_id",
					"value" => "",
					"description" => __("Upload or select a photo from media gallery.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Name", 'iv_js_composer'),
					"param_name" => "name",
					'admin_label' => true,
					"description" => __("Type your staff member name.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Job Title", 'iv_js_composer'),
					"param_name" => "job_title",
					"description" => __("Type your staff member job title, e.g. Manager.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Infos Position", 'iv_js_composer'),
					"param_name" => "infos_inside",
					"value" => array(
						'Outside' => 'no',
						'Inside Thumbnail' => 'yes',
					),
					"description" => __("Select the name and job title position.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Social Icons Position", 'iv_js_composer'),
					"param_name" => "social_inside",
					"value" => array(
						'Outside' => 'no',
						'Inside Thumbnail' => 'yes',
					),
					"description" => __("Select the social icons position.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display Separator?", 'iv_js_composer'),
					"param_name" => "sep",
					"value" => array(
						'Auto' => '',
						'Yes' => 'yes',
						'No' => 'no',
					),
					"description" => __("When Auto is selected, the code will decide when is better display the separator.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => "Effect: Social Auto Colors?",
					"param_name" => "social_auto",
					"value" => array(
						"Yes" => "",
						"No" => "no",
					),
					"description" => "If yes, social icons will receive auto colors respective to the social brand.",
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Overlay", 'iv_js_composer'),
					"param_name" => "overlay",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Enable the effect on this modules.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Opacity", 'iv_js_composer'),
					"param_name" => "opacity",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Enable the effect on this modules.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Grayscale", 'iv_js_composer'),
					"param_name" => "grayscale",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("Enable the effect on this modules.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Align", 'iv_js_composer'),
					"param_name" => "align",
					"value" => array(
						'Center' => '',
						'Default (Left/Right)' => ' to-default',
					),
					"description" => __("Define alignment of infos.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_staff', array(
						__( 'Default', 'iv_js_composer' ) => '',
						__( 'White Boxed', 'iv_js_composer' ) => 'white-boxed',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),			
				//
				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Block", 'iv_js_composer'),
					"param_name" => "block_css",
					"customize" => $ivan_vc_staff->selectors['block_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Overlay", 'iv_js_composer'),
					"param_name" => "overlay_css",
					"customize" => $ivan_vc_staff->selectors['overlay_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Infos", 'iv_js_composer'),
					"param_name" => "infos_css",
					"customize" => $ivan_vc_staff->selectors['infos_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title/Name", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_staff->selectors['title_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Job Position", 'iv_js_composer'),
					"param_name" => "job_css",
					"customize" => $ivan_vc_staff->selectors['job_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Description", 'iv_js_composer'),
					"param_name" => "desc_css",
					"customize" => $ivan_vc_staff->selectors['desc_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Separator", 'iv_js_composer'),
					"param_name" => "sep_css",
					"customize" => $ivan_vc_staff->selectors['sep_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Social Icons", 'iv_js_composer'),
					"param_name" => "social_css",
					"customize" => $ivan_vc_staff->selectors['social_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				
			), 
			$staff_icons_fields
			),// #params end				
		)// #setting array end
	);// #map end

/***
 * Service Block
***/

	global $ivan_vc_service;

	vc_map( array(
		'name' => __('Service Block', 'iv_js_composer'),
		'base' => 'ivan_service',
		'icon' => 'vc_info_box',
		'class' => 'ivan_service',
		'category' => 'Elite Addons',
		'description' => 'Display a block where you can showcase services.',
		'controls' => 'full',
		'show_settings_on_create' => true,
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => "Heading Text",
				"param_name" => "heading",
				"admin_label" => true,
				"value" => "",
				'description' => 'The heading text that will be displayed at box top.',
			),

			array(
				"type" => "dropdown",
				"heading" => "Heading Tag",
				"param_name" => "heading_tag",
				"value" => array(
					"Default"   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",   
					"h5" => "h5",   
					"h6" => "h6",   
				),
				"description" => "The heading tag that will be used in the heading text.",
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon Family", 'iv_js_composer'),
				"param_name" => "ico_family",
				"value" => array(
					'Font Awesome' => '',
					'Elegant Icons' => 'el el-',
					'Custom' => 'custom',
				),
				"description" => __("Select the icon family.", 'iv_js_composer'),
			),

			array(
				"type" => "textfield",
				"heading" => __("Custom Icon Class", 'iv_js_composer'),
				"param_name" => "ico_custom",
				"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
				'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
			),

			array(
				"type" => "textfield",
				"heading" => __("Icon Name", 'iv_js_composer'),
				"param_name" => "ico",
				"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
			),

			array(
				"type" => "dropdown",
				"heading" => "Icon Size",
				"param_name" => "ico_size",
				"value" => array(
					"Default" => '',
					"Tiny" => "fa-lg",
					"Small" => "fa-2x", // this is default size
					"Medium" => "fa-3x",	
					"Large" => "fa-4x",
					"Very Large" => "fa-5x" 
				),
				"description" => "Icon Size that will be applied to the icon.",
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Style",
				"param_name" => "icon_style",
				"value" => array(
					"Only Icon" => "normal", // normal
					"Inside Circle" => "circle", // circle
					"Inside Square" => "square", // square
				),
				"description" => "Define how the icon will be displayed."
			),

			array(
				"type" => "textarea_html",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<li>Web Development</li><li>Security Research</li><li>Advanced Topics</li>",
				"description" => "The list that will be showed as the box content.",
			),

			$ivan_add_css_animation,

			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Template', 'iv_js_composer' ),
				'param_name' => 'template',
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_service', array(
					__( 'Default', 'iv_js_composer' ) => '',
					'Gray' => 'gray-bg',
					'Dark' => 'dark-bg',
					//'Clean' => 'clean-color',
					'Light' => 'light-bg',
					'Primary' => 'primary-bg',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Main Block", 'iv_js_composer'),
				"param_name" => "main_css",
				"customize" => $ivan_vc_service->selectors['main_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Icon", 'iv_js_composer'),
				"param_name" => "icon_css",
				"customize" => $ivan_vc_service->selectors['icon_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Title", 'iv_js_composer'),
				"param_name" => "title_css",
				"customize" => $ivan_vc_service->selectors['title_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Content", 'iv_js_composer'),
				"param_name" => "content_css",
				"customize" => $ivan_vc_service->selectors['content_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
		)
	) );

/***
 * Pricing Table
***/
	// Call global var to use selectors array
	global $ivan_vc_pricing_table;

	vc_map(
		array(
			'name' => __('Pricing Table', 'iv_js_composer'),
			'base' => 'ivan_pricing',
			'icon' => 'vc_info_box',
			'class' => 'ivan_pricing_table',
			'category' => 'Elite Addons',
			'description' => 'Display a styled pricing table.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Style", 'iv_js_composer'),
					"param_name" => "template",
					"value" => array(
						'Sub Title' => 'subtitle',
						'Sub Title After Price' => 'small-desc',
						'Big Price' => 'big-price',
						'Simple with Image' => 'simple-image',
						'Description' => 'description-support',
						'Simple' => 'default',
						//'Big Button' => 'big-button',
					),
					"description" => __("Select the style to be applied in the pricing table.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Alternative Color", 'iv_js_composer'),
					"param_name" => "scheme",
					"value" => array(
						'Default' => '',
						'Dark' => 'dark-bg',
						'Black' => 'black-bg',
						'Light' => 'light-bg',
						'Primary' => 'primary-bg',
					),
					'dependency' => array('element' => 'template', 'value' => array('default', 'subtitle', 'small-desc') ),
					"description" => __("Select an alternative color scheme to be used. Light turns background white to darker backgrounds.", 'iv_js_composer'),
				),
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Items", 'iv_js_composer'),
					"param_name" => "content",
					"value" => '<ul><li>Item</li><li>Item</li><li>Item</li></ul>',
					"description" => __("Insert here an unordered list/ul to display the items.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Image?", 'iv_js_composer'),
					"param_name" => "image_support",
					"value" => array(
						'No' => 'no',
						'Yes' => 'yes',
					),
					"description" => __("If enabled, you can upload an image to appear at top.", 'iv_js_composer'),
				),
					array(
						"type" => "attach_image",
						"class" => "",
						"heading" => __("Background Image", 'iv_js_composer'),
						"param_name" => "image_id",
						"value" => "",
						"description" => __("Upload or select background image from media gallery.", 'iv_js_composer'),
						'dependency' => array('element' => 'image_support', 'value' => 'yes'),
					),
				array(
					"type" => "textfield",
					"heading" => __("Plan Title", 'iv_js_composer'),
					"param_name" => "title",
					"value" => "Starter",
					"admin_label" => true,
					"description" => __("The main plan title displayed at top.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Sub Title", 'iv_js_composer'),
					"param_name" => "subtitle",
					"value" => "Unlimited support and updates",
					"description" => __("Displayed below title or after price.", 'iv_js_composer'),
					'dependency' => array('element' => 'template', 'value' => array('subtitle', 'small-desc') ),
				),
				array(
					"type" => "textfield",
					"heading" => __("Price Value ", 'iv_js_composer'),
					"param_name" => "price",
					"value" => "19",
					"description" => __("Price without currency.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Currency", 'iv_js_composer'),
					"param_name" => "currency",
					"value" => "$",
					"description" => __("The currency displayed aside price.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Period", 'iv_js_composer'),
					"param_name" => "period",
					"value" => "/month",
					"description" => __("The plan period that is displayed when supported by template.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Button Link", 'iv_js_composer'),
					"param_name" => "link",
					"value" => "#",
					"description" => __("Button link. Leave blank and the button won't be displayed.", 'iv_js_composer')
				),
				array(
					"type" => "textfield",
					"heading" => __("Button Text", 'iv_js_composer'),
					"param_name" => "button_text",
					"value" => "Get this now",
					"description" => __("Button text to be displayed.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Featured?", 'iv_js_composer'),
					"param_name" => "featured",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					'dependency' => array('element' => 'template', 'value' => array('default', 'subtitle', 'small-desc') ),
					"description" => __("Select yes to turn this table featured, this allow you add a little text above like 'Best Price', for example.", 'iv_js_composer'),
				),
					array(
						"type" => "textfield",
						"heading" => __("Featured Text", 'iv_js_composer'),
						"param_name" => "featured_text",
						"value" => "",
						'dependency' => array('element' => 'featured', 'value' => array('yes') ),
						"description" => __("Text displayed in featured box, e.g. 'Best Price'.", 'iv_js_composer')
					),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template_theme',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_pricing_table', array(
						__( 'Default', 'iv_js_composer' ) => '',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),		
				// Customizer
				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Table", 'iv_js_composer'),
					"param_name" => "table_css",
					"customize" => $ivan_vc_pricing_table->selectors['table_css'],
					"value" => "",
					"group" => __('Main Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Top Section", 'iv_js_composer'),
					"param_name" => "top_section_css",
					"customize" => $ivan_vc_pricing_table->selectors['top_section_css'],
					"value" => "",
					"group" => __('Main Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Content Section", 'iv_js_composer'),
					"param_name" => "content_section_css",
					"customize" => $ivan_vc_pricing_table->selectors['content_section_css'],
					"value" => "",
					"group" => __('Main Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Bottom Section", 'iv_js_composer'),
					"param_name" => "bottom_section_css",
					"customize" => $ivan_vc_pricing_table->selectors['bottom_section_css'],
					"value" => "",
					"group" => __('Main Table', 'iv_js_composer'),
				),
				// -- Inner Elements
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Plan Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_pricing_table->selectors['title_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Plan Subtitle", 'iv_js_composer'),
					"param_name" => "subtitle_css",
					"customize" => $ivan_vc_pricing_table->selectors['subtitle_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Currency", 'iv_js_composer'),
					"param_name" => "currency_css",
					"customize" => $ivan_vc_pricing_table->selectors['currency_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Price", 'iv_js_composer'),
					"param_name" => "price_css",
					"customize" => $ivan_vc_pricing_table->selectors['price_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Period", 'iv_js_composer'),
					"param_name" => "period_css",
					"customize" => $ivan_vc_pricing_table->selectors['period_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Items", 'iv_js_composer'),
					"param_name" => "items_css",
					"customize" => $ivan_vc_pricing_table->selectors['items_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Strong", 'iv_js_composer'),
					"param_name" => "strong_css",
					"customize" => $ivan_vc_pricing_table->selectors['strong_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Signup Button", 'iv_js_composer'),
					"param_name" => "signup_css",
					"customize" => $ivan_vc_pricing_table->selectors['signup_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Featured Block", 'iv_js_composer'),
					"param_name" => "featured_css",
					"customize" => $ivan_vc_pricing_table->selectors['featured_css'],
					"value" => "",
					"group" => __('Inner Table', 'iv_js_composer'),
				),

			),// #params end				
		)// #setting array end
	);// #map end

/***
 * Progress Bar
***/

	global $ivan_vc_progress;

	// Horizontal progress bar shortcode
	vc_map( array(
		'name' => __('Progress Bar', 'iv_js_composer'),
		'base' => 'ivan_progress',
		'icon' => 'vc_info_box',
		'class' => 'ivan_progress_bar',
		'category' => 'Elite Addons',
		'description' => 'Display a progress bar with percentage support.',
		'controls' => 'full',
		'show_settings_on_create' => true,
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => "Title",
				"param_name" => "title",
				'admin_label' => true,
				"description" => "Select the skill title that will be placed above the skill bar.",
			),
			array(
				"type" => "dropdown",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
					"Default"   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",	
					"h5" => "h5",	
					"h6" => "h6",	
				),
				"description" => "Select the heading tag used in the title.",
			),
			array(
				"type" => "textfield",
				"heading" => "Percentage",
				"param_name" => "percent",
				"value" => '',
				"description" => "The progress percentage, only numbers. E.g.: 50, 60 up to 100."
			),

			array(
				"type" => "dropdown",
				"heading" => "Hide Percentage Counter?",
				"param_name" => "hide_per",
				"value" => array(
					"No"   => "",
					"Yes" => 'yes',
				),
				"description" => "Select Yes to hide percentage number.",
			),

			array(
				"type" => "textfield",
				"heading" => "Progress Bar Height",
				"param_name" => "height",
				"description" => "Define a custom height to the progress bar. Leave empty to use default."
			),
			
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Template', 'iv_js_composer' ),
				'param_name' => 'template',
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_progress', array(
					__( 'Default', 'iv_js_composer' ) => '',
					'Gray' => 'gray-bg',
					'Dark' => 'dark-bg',
					//'Clean' => 'clean-color',
					'Light' => 'light-bg',
					'Primary' => 'primary-bg',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Main Block", 'iv_js_composer'),
				"param_name" => "block_css",
				"customize" => $ivan_vc_progress->selectors['block_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Heading", 'iv_js_composer'),
				"param_name" => "title_css",
				"customize" => $ivan_vc_progress->selectors['title_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Outer Bar", 'iv_js_composer'),
				"param_name" => "outer_css",
				"customize" => $ivan_vc_progress->selectors['outer_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Inner Bar", 'iv_js_composer'),
				"param_name" => "inner_css",
				"customize" => $ivan_vc_progress->selectors['inner_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
		)
	) );

/***
 * Call to Action
***/

global $ivan_vc_call_action;

vc_map( array(
	'name' => __('Call to Action', 'iv_js_composer'),
	'base' => 'ivan_call_action',
	'icon' => 'vc_info_box',
	'class' => 'ivan_call_action',
	'category' => 'Elite Addons',
	'description' => 'Display a heading text with button to get user focus.',
	'controls' => 'full',
	'show_settings_on_create' => true,
	"as_parent" => array('only' => array( 'ivan_button', 'ivan_dual_btn' ) ),
	"is_container" => true,
	"content_element" => true,
	"params" => array(

		array(
			"type" => "textfield",
			"heading" => "Heading",
			"param_name" => "heading",
			'admin_label' => true,
			"value" => "",
			'description' => "Define the text that will be used in the call to action.",
		),

		array(
			"type" => "dropdown",
			"heading" => "Heading Tag",
			"param_name" => "heading_tag",
			"value" => array(
				"Default"   => "",
				"h2" => "h2",
				"h3" => "h3",
				"h4" => "h4",
				"h5" => "h5",
				"h6" => "h6",
			),
			"description" => "Define a custom tag that will be used to display the heading title.",
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Background Style", 'iv_js_composer'),
			"param_name" => "style",
			"value" => array(
				'Boxed' => '',
				'Opaque' => 'opaque',
			),
			"description" => __("Define a style to call to action background. Opaque is transparent bg to use in full rows.", 'iv_js_composer'),
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Type",
			"param_name" => "type",
			"value" => array(
				"Only Text" => "",
				"With Icon" => "with-icon",
			),
			"description" => "Define if icon will be supported in the call to action."
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon Family", 'iv_js_composer'),
			"param_name" => "ico_family",
			"value" => array(
				'Font Awesome' => '',
				'Elegant Icons' => 'el el-',
				'Custom' => 'custom',
			),
			"description" => __("Select the icon family.", 'iv_js_composer'),
			"dependency" => array('element' => "type", 'value' => array('with-icon'))
		),
		array(
			"type" => "textfield",
			"heading" => __("Custom Icon Class", 'iv_js_composer'),
			"param_name" => "ico_custom",
			"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
			'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
		),
		array(
			"type" => "textfield",
			"heading" => __("Icon Name", 'iv_js_composer'),
			"param_name" => "ico",
			"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
			"dependency" => array('element' => "type", 'value' => array('with-icon'))
		),

		array(
			"type" => "attach_image",
			"heading" => "Image Icon",
			"param_name" => "ico_image",
			'description' => 'Replace font icon with an image file.',
			"dependency" => array('element' => "type", 'value' => array('with-icon'))
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon Size",
			"param_name" => "size",
			"value" => array(
				"Default" => '',
				"Tiny" => "fa-lg",
				"Small" => "fa-2x",
				"Medium" => "fa-3x",	
				"Large" => "fa-4x",
				"Very Large" => "fa-5x",
			),
			"description" => "Define the icon size.",
			"dependency" => array('element' => "type", 'value' => array('with-icon'))
		),

		array(
			"type" => "textarea",
			"class" => "",
			"heading" => __("Optional Description", 'iv_js_composer'),
			"param_name" => "desc",
			"description" => __("Define the text that will be displayed below the heading. HTML tags accepted.", 'iv_js_composer'),
			'value' => '',
		),

		array(
			"type" => "textfield",
			"heading" => __("Extra class name", 'iv_js_composer'),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'iv_js_composer' ),
			'param_name' => 'template',
			'admin_label' => true,
			'value' => apply_filters( 'ivan_vc_call_action', array(
				__( 'Default', 'iv_js_composer' ) => '',
				'Gray' => 'gray-bg',
				'Dark' => 'dark-bg',
				'Light' => 'light-bg',
				'Primary' => 'primary-bg',
			) ),
			'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
		),

		array(
			"type" => "ivan_customizer_id",
			"heading" => __("Customization ID", 'iv_js_composer'),
			"param_name" => "c_id",
			"value" => "",
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Main Block", 'iv_js_composer'),
			"param_name" => "block_css",
			"customize" => $ivan_vc_call_action->selectors['block_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Heading", 'iv_js_composer'),
			"param_name" => "title_css",
			"customize" => $ivan_vc_call_action->selectors['title_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Description", 'iv_js_composer'),
			"param_name" => "desc_css",
			"customize" => $ivan_vc_call_action->selectors['desc_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Icon", 'iv_js_composer'),
			"param_name" => "icon_css",
			"customize" => $ivan_vc_call_action->selectors['icon_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Button Holder", 'iv_js_composer'),
			"param_name" => "btn_css",
			"customize" => $ivan_vc_call_action->selectors['btn_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),
	),
	"js_view" => 'VcColumnView'
) );

/***
 * Icon Box
***/

	global $ivan_vc_icon_box;

	vc_map( array(
		'name' => __('Icon Box', 'iv_js_composer'),
		'base' => 'ivan_icon_box',
		'icon' => 'vc_info_box',
		'class' => 'ivan_icon_box',
		'category' => 'Elite Addons',
		'description' => 'Display a combined icon with heading and text.',
		'controls' => 'full',
		'show_settings_on_create' => true,
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => "Main Style",
				"param_name" => "box_type",
				"value" => array(
					"Default" => "", // normal
					"Inside Box" => "inside-box",
				),
				"description" => "Define main presentation of the icon box.",
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon Family", 'iv_js_composer'),
				"param_name" => "ico_family",
				"value" => array(
					'Font Awesome' => '',
					'Elegant Icons' => 'el el-',
					'Custom' => 'custom',
				),
				"description" => __("Select the icon family.", 'iv_js_composer'),
			),
			array(
				"type" => "textfield",
				"heading" => __("Custom Icon Class", 'iv_js_composer'),
				"param_name" => "ico_custom",
				"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
				'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
			),
			array(
				"type" => "textfield",
				"heading" => __("Icon Name", 'iv_js_composer'),
				"param_name" => "ico",
				"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
			),

			array(
				"type" => "attach_image",
				"heading" => "Image Icon",
				"param_name" => "ico_image",
				'description' => 'Replace font icon with an image file.',
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Style",
				"param_name" => "icon_style",
				"value" => array(
					"Inside Circle" => "", // circle
					"Only Icon" => "normal", // normal
					"Inside Square" => "square", // square
				),
				"description" => "Define how the icon will be displayed."
			),

			array(
				"type" => "dropdown",
				"heading" => "Icon/Image Position",
				"param_name" => "icon_pos",
				"value" => array(
					"Top" => "", // top
					"Left" => "left",
					"Left From Title" => "left-title",
					//"Right" => "right",
					//"Right From Title" => "right-title",
				),
				"description" => "Define icon position. Only valid to Default Box Type.",
				"dependency" => array('element' => "box_type", 'value' => array('') )
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Size",
				"param_name" => "size",
				"value" => array(
					"Default" => '',
					"Tiny" => "fa-lg",
					"Small" => "fa-2x",
					"Medium" => "fa-3x",	
					"Large" => "fa-4x",
					"Very Large" => "fa-5x",
				),
				"description" => "Define the icon size.",
			),

			array(
				"type" => "textfield",
				"heading" => "Icon Box Title",
				"param_name" => "title",
				'admin_label' => true,
				"value" => "",
				'description' => "Define icon box heading text that will be displayed.",
			),

			array(
				"type" => "dropdown",
				"heading" => "Icon Box Title Tag",
				"param_name" => "title_tag",
				"value" => array(
					"Default"   => "",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",
					"h5" => "h5",
					"h6" => "h6",
				),
				"description" => "Define a custom tag that will be used to display the heading title.",
			),

			array(
				"type" => "textarea",
				"class" => "",
				"heading" => __("Content", 'iv_js_composer'),
				"param_name" => "content",
				"description" => __("Define the text that will be displayed below the heading. Shortcodes and HTML tags accepted.", 'iv_js_composer'),
				'value' => '',
			),

			array(
				"type" => "textfield",
				"heading" => "Link Text",
				"param_name" => "link_text",
				"value" => "",
				"dependency" => array('element' => "box_type", 'value' => array('') ),
				'description' => "Adds a link at the bottom of the icon box.",
			),

			array(
				"type" => "textfield",
				"heading" => __("Link", 'iv_js_composer'),
				"param_name" => "link",
				"description" => __("Defines the link URL or anchor.", 'iv_js_composer'),
				'value' => '',
				"dependency" => array( 'element' => 'link_text', 'not_empty' => true ),
			),
			
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Target", 'iv_js_composer'),
				"param_name" => "target",
				"value" => array(
					'Same Page' => '',
					'Blank Page' => 'yes',
				),
				"description" => __("Define link target.", 'iv_js_composer'),
				"dependency" => array( 'element' => 'link_text', 'not_empty' => true ),
			),

			array(
				"type" => "dropdown",
				"heading" => "Show Separator Above Link?",
				"param_name" => "show_sep",
				"value" => array(
					"No"   => "",
					"Yes" => 'yes',
				),
				"description" => "Select Yes to display a separator above the link.",
				"dependency" => array( 'element' => 'link_text', 'not_empty' => true ),
			),

			$ivan_add_css_animation,

			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Template', 'iv_js_composer' ),
				'param_name' => 'template',
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_icon_box', array(
					__( 'Default', 'iv_js_composer' ) => '',
					'Gray' => 'gray-bg',
					'Dark' => 'dark-bg',
					'Clean' => 'clean-color',
					'Light' => 'light-bg',
					'Primary' => 'primary-bg',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Main Block", 'iv_js_composer'),
				"param_name" => "main_css",
				"customize" => $ivan_vc_icon_box->selectors['main_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Icon", 'iv_js_composer'),
				"param_name" => "icon_css",
				"customize" => $ivan_vc_icon_box->selectors['icon_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Title", 'iv_js_composer'),
				"param_name" => "title_css",
				"customize" => $ivan_vc_icon_box->selectors['title_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Content", 'iv_js_composer'),
				"param_name" => "content_css",
				"customize" => $ivan_vc_icon_box->selectors['content_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Read More", 'iv_js_composer'),
				"param_name" => "btn_css",
				"customize" => $ivan_vc_icon_box->selectors['btn_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Separator", 'iv_js_composer'),
				"param_name" => "sep_css",
				"customize" => $ivan_vc_icon_box->selectors['sep_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
		)
	));

/***
 * Icon
***/

	global $ivan_vc_icon;

	vc_map( array(
		'name' => __('Icon', 'iv_js_composer'),
		'base' => 'ivan_icon',
		'icon' => 'vc_info_box',
		'class' => 'ivan_icon',
		'category' => 'Elite Addons',
		'description' => 'Display a font icon with more options.',
		'controls' => 'full',
		'show_settings_on_create' => true,
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Icon Name", 'iv_js_composer'),
				"param_name" => "ico",
				'admin_label' => true,
				"description" => __("Type font awesome icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
				"dependency" => array('element' => "type", 'value' => array('with-icon'))
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Style",
				"param_name" => "style",
				"value" => array(
					"Only Icon" => "", // opaque
					"Inside Circle" => "circle", // circle
					"Inside Square" => "square", // square
				),
				"description" => "Define how the icon will be displayed."
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Effect: Social Auto Colors?",
				"param_name" => "social_auto",
				"value" => array(
					"No" => "",
					"Yes" => "yes",
				),
				"description" => "If yes, social icons will receive auto colors respective to the social brand.",
				"dependency" => array('element' => "style", 'not_empty' => true )
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Effect: Icon Glow?",
				"param_name" => "glow",
				"value" => array(
					"No" => "",
					"Yes" => "yes",
				),
				"description" => "If yes, the icon will have a small glow effect."
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Size",
				"param_name" => "size",
				"value" => array(
					"Default" => '',
					"Tiny" => "fa-lg",
					"Small" => "fa-2x",
					"Medium" => "fa-3x",	
					"Large" => "fa-4x",
					"Very Large" => "fa-5x",
				),
				"description" => "Define your icon size.",
			),

			array(
				"type" => "textfield",
				"heading" => __("Link", 'iv_js_composer'),
				"param_name" => "link",
				"description" => __("Defines the link URL or anchor.", 'iv_js_composer'),
				'value' => '',
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Target", 'iv_js_composer'),
				"param_name" => "target",
				"value" => array(
					'Same Page' => '',
					'Blank Page' => 'yes',
				),
				"description" => __("Define link target.", 'iv_js_composer'),
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Align", 'iv_js_composer'),
				"param_name" => "align",
				"value" => array(
					'Default' => '',
					'Center' => 'to-center',
					'Left' => 'to-left',
					'Right' => 'to-right',
				),
				"description" => __("Select main alignment of icon. Default is it being displayed as inline.", 'iv_js_composer'),
			),

			$ivan_add_css_animation,

			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),

			array(
				"type" => "dropdown",
				"heading" => __("Template", 'iv_js_composer'),
				"param_name" => "template",
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_icon', array(
					__( 'Default', 'iv_js_composer' ) => '',
					'Gray' => 'gray-bg',
					'Dark' => 'dark-bg',
					//'Clean' => 'clean-color',
					'Light' => 'light-bg',
					'Primary' => 'primary-bg',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Icon", 'iv_js_composer'),
				"param_name" => "icon_css",
				"customize" => $ivan_vc_icon->selectors['icon_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Circle Color / Square Background", 'iv_js_composer'),
				"param_name" => "holder_css",
				"customize" => $ivan_vc_icon->selectors['holder_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
		)
	) );

/***
 * Icon List
***/

	global $ivan_vc_icon_list;

	vc_map( array(
		'name' => __('Icon List', 'iv_js_composer'),
		'base' => 'ivan_icon_li',
		'icon' => 'vc_info_box',
		'class' => 'ivan_icon_list',
		'category' => 'Elite Addons',
		'description' => 'Display a list styled item with icon support.',
		'controls' => 'full',
		'show_settings_on_create' => true,
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => "Item Content",
				"param_name" => "item",
				"description" => "Item content that will be displayed."
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon Family", 'iv_js_composer'),
				"param_name" => "ico_family",
				"value" => array(
					'Font Awesome' => '',
					'Elegant Icons' => 'el el-',
					'Custom' => 'custom',
				),
				"description" => __("Select the icon family.", 'iv_js_composer'),
				"dependency" => array('element' => "type", 'value' => array('with-icon'))
			),
			array(
				"type" => "textfield",
				"heading" => __("Custom Icon Class", 'iv_js_composer'),
				"param_name" => "ico_custom",
				"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
				'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
			),
			array(
				"type" => "textfield",
				"heading" => __("Icon Name", 'iv_js_composer'),
				"param_name" => "ico",
				"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
				"dependency" => array('element' => "type", 'value' => array('with-icon'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Icon Style",
				"param_name" => "style",
				"value" => array(
					"Only Icon" => "", // opaque
					"Inside Circle" => "circle", // circle
				),
				"description" => "Define how the icon will be displayed in the item."
			),

			$ivan_add_css_animation,

			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),

			array(
				"type" => "dropdown",
				"heading" => __("Template", 'iv_js_composer'),
				"param_name" => "template",
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_icon_li', array(
					__( 'Default', 'iv_js_composer' ) => '',
					'Gray' => 'gray-bg',
					'Dark' => 'dark-bg',
					'Clean' => 'clean-color',
					//'Light' => 'light-bg',
					'Primary' => 'primary-bg',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Main Block", 'iv_js_composer'),
				"param_name" => "block_css",
				"customize" => $ivan_vc_icon_list->selectors['block_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("List Mark", 'iv_js_composer'),
				"param_name" => "mark_css",
				"customize" => $ivan_vc_icon_list->selectors['mark_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
			
		)
	) );

/***
 * Styled List
***/

	global $ivan_vc_list;

	vc_map( array(
		'name' => __('List Styled', 'iv_js_composer'),
		'base' => 'ivan_list',
		'icon' => 'vc_info_box',
		'class' => 'ivan_list',
		'category' => 'Elite Addons',
		'description' => 'Display a styled list.',
		'controls' => 'full',
		'show_settings_on_create' => true,
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Style",
				"param_name" => "style",
				"value" => array(
					"Number" => "", // number
					"Circle" => "circle",
				),
				"description" => "Define the main list style, you can use a circle or a number."
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Number Type",
				"param_name" => "num_type",
				"value" => array(
					"Inside Circle" => "", // circle
					"Only Number" => "opaque", // opaque
				),
				"description" => "Define how the number will be displayed.",
				"dependency" => array('element' => "style", 'value' => array('') )
			),

			$ivan_add_css_animation,

			array(
				"type" => "textarea_html",
				"class" => "",
				"heading" => "List Content",
				"param_name" => "content",
				"value" => "<ul><li>Lorem Ipsum</li><li>Lorem Ipsum</li><li>Lorem Ipsum</li></ul>",
				"description" => "The unordered list to be displayed (ul), only that should be used as content.",
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),
			array(
				"type" => "dropdown",
				"heading" => __("Template", 'iv_js_composer'),
				"param_name" => "template",
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_list', array(
					__( 'Default', 'iv_js_composer' ) => '',
					'Gray' => 'gray-bg',
					'Dark' => 'dark-bg',
					'Clean' => 'clean-color',
					//'Light' => 'light-bg',
					'Primary' => 'primary-bg',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),
			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Main Block", 'iv_js_composer'),
				"param_name" => "block_css",
				"customize" => $ivan_vc_list->selectors['block_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("List Mark", 'iv_js_composer'),
				"param_name" => "mark_css",
				"customize" => $ivan_vc_list->selectors['mark_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
		)	
	) );

/***
 * Message
***/

global $ivan_vc_message;

vc_map( array(
	'name' => __('Message', 'iv_js_composer'),
	'base' => 'ivan_message',
	'icon' => 'vc_info_box',
	'class' => 'ivan_message',
	'category' => 'Elite Addons',
	'description' => 'Display a message box with icon and close button.',
	'controls' => 'full',
	'show_settings_on_create' => true,
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Message Type",
			"param_name" => "msg_type",
			'admin_label' => true,
			"value" => array(
				"Info" => "",
				"Success" => "success",
				"Error" => "error",	
				"Warning" => "warning",	
			),
			"description" => "Define a pre-defined message style to this."
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Type",
			"param_name" => "type",
			"value" => array(
				"Normal" => "",
				"With Icon" => "with-icon"	
			),
			"description" => "Define if the message box will have a icon aside the message or not."
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon Family", 'iv_js_composer'),
			"param_name" => "ico_family",
			"value" => array(
				'Font Awesome' => '',
				'Elegant Icons' => 'el el-',
				'Custom' => 'custom',
			),
			"description" => __("Select the icon family.", 'iv_js_composer'),
			"dependency" => array('element' => "type", 'value' => array('with-icon'))
		),
		array(
			"type" => "textfield",
			"heading" => __("Custom Icon Class", 'iv_js_composer'),
			"param_name" => "ico_custom",
			"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
			'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
			"dependency" => array('element' => "ico_family", 'value' => array('custom'))
		),
		array(
			"type" => "textfield",
			"heading" => __("Icon Name", 'iv_js_composer'),
			"param_name" => "ico",
			"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
			"dependency" => array('element' => "type", 'value' => array('with-icon'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon Size",
			"param_name" => "icon_size",
			"value" => array(
				"Small" => "", // fa-lg
				"Medium" => "fa-2x",
				"Large" => "fa-3x"
			),
			"description" => "Define your icon size.",
			"dependency" => array('element' => "type", 'value' => array('with-icon'))
		),
		array(
			"type" => "textarea_html",
			"class" => "",
			"heading" => "Content",
			"param_name" => "content",
			"value" => "<p>"."Write your message here..."."</p>",
			"description" => "This is where you write your message that will be displayed."
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", 'iv_js_composer'),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
		),

		array(
			"type" => "ivan_customizer_id",
			"heading" => __("Customization ID", 'iv_js_composer'),
			"param_name" => "c_id",
			"value" => "",
		),

		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Main Block", 'iv_js_composer'),
			"param_name" => "block_css",
			"customize" => $ivan_vc_message->selectors['block_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Quote", 'iv_js_composer'),
			"param_name" => "msg_css",
			"customize" => $ivan_vc_message->selectors['msg_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Icon", 'iv_js_composer'),
			"param_name" => "icon_css",
			"customize" => $ivan_vc_message->selectors['icon_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		),
	)
) );

/***
 * Button
***/
	// Call global var to use selectors array
	global $ivan_vc_button;

	vc_map(
		array(
			'name' => __('Button', 'iv_js_composer'),
			'base' => 'ivan_button',
			'icon' => 'vc_info_box',
			'class' => 'ivan_button',
			'category' => 'Elite Addons',
			'description' => 'Display a fully featured button with customizer support.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea",
					"heading" => __("Button Text", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Optional text to be displayed in the button.", 'iv_js_composer'),
					'value' => __('', 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Link", 'iv_js_composer'),
					"param_name" => "link",
					"description" => __("Defines the link URL or anchor.", 'iv_js_composer'),
					'value' => '#',
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Target", 'iv_js_composer'),
					"param_name" => "target",
					"value" => array(
						'Same Page' => '',
						'Blank Page' => 'yes',
					),
					"description" => __("Define link target.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Size", 'iv_js_composer'),
					"param_name" => "size",
					"value" => array(
						'Medium' => '',
						'Large' => 'large',
						'Extra Large' => 'x-large',
						'Compact' => 'compact',
						'Big Circle (only to Circle)' => 'circular-mega',
					),
					"description" => __("Define button size. Big Circle only works with Circle border radius option.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Border Radius", 'iv_js_composer'),
					"param_name" => "border_r",
					"value" => array(
						'Default' => '',
						'Square' => 'square',
						'Round' => 'round',
						'Round Square' => 'round-square',
						'Circle' => 'circular',
					),
					"description" => __("Define the border radius of the button.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Style", 'iv_js_composer'),
					"param_name" => "style",
					"value" => array(
						'Default' => '',
						'Outline' => 'outline',
						'No Border' => 'no-border',
					),
					"description" => __("Define the main button style. Default usually has background and border.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Dark Opacity Background?", 'iv_js_composer'),
					"param_name" => "dark_op",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Only outline with Light template. Select yes to display a dark opacity background.", 'iv_js_composer'),
					'dependency' => array('element' => 'style', 'value' => 'outline'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display", 'iv_js_composer'),
					"param_name" => "display",
					"value" => array(
						'Normal Width' => '',
						'Full Width' => 'btn-block',
					),
					"description" => __("Define button width.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Align", 'iv_js_composer'),
					"param_name" => "align",
					"value" => array(
						'Default' => '',
						'Center' => 'to-center',
						'Left' => 'to-left',
						'Right' => 'to-right',
					),
					"description" => __("Select main alignment of button. Default makes the button be inline.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Icon Area?", 'iv_js_composer'),
					"param_name" => "icon_area",
					"value" => array(
						'No' => '',
						'Icon' => 'icon',
						'Custom Text' => 'text',
					),
					"description" => __("Enable an area to place an icon or custom text inside. A few effects are also avaliable.", 'iv_js_composer'),
				),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Icon Area Position?", 'iv_js_composer'),
						"param_name" => "icon_pos",
						"value" => array(
							'Left' => '',
							'Right' => 'right',
						),
						"description" => __("Define where to place the icon area, before or after button text.", 'iv_js_composer'),
						'dependency' => array('element' => 'icon_area', 'not_empty' => true),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Icon Family", 'iv_js_composer'),
						"param_name" => "ico_family",
						"value" => array(
							'Font Awesome' => '',
							'Elegant Icons' => 'el el-',
							'Custom' => 'custom',
						),
						"description" => __("Select the icon family.", 'iv_js_composer'),
						'dependency' => array('element' => 'icon_area', 'value' => 'icon'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Custom Icon Class", 'iv_js_composer'),
						"param_name" => "ico_custom",
						"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
						'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
					),

					array(
						"type" => "textfield",
						"heading" => __("Icon Name", 'iv_js_composer'),
						"param_name" => "ico",
						"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
						'dependency' => array('element' => 'icon_area', 'value' => 'icon'),
					),

					array(
						"type" => "textfield",
						"heading" => __("Icon Text", 'iv_js_composer'),
						"param_name" => "ico_txt",
						"description" => __("Type the text to be placed in the icon area instead the icon. E.g.: $39", 'iv_js_composer'),
						'dependency' => array('element' => 'icon_area', 'value' => 'text'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Effect: Icon Cover", 'iv_js_composer'),
						"param_name" => "icon_cover",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("If yes, adds a darken background to the icon area creating a dual effect.", 'iv_js_composer'),
						'dependency' => array('element' => 'icon_area', 'not_empty' => true),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Effect: Icon Separator", 'iv_js_composer'),
						"param_name" => "icon_sep",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("If yes, adds a small separator between main text and icon area.", 'iv_js_composer'),
						'dependency' => array('element' => 'icon_area', 'not_empty' => true),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Effect: Icon Glow", 'iv_js_composer'),
						"param_name" => "icon_glow",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("If yes, adds a subtle clean glow in the icon.", 'iv_js_composer'),
						'dependency' => array('element' => 'icon_area', 'not_empty' => true),
					),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Button Zoom", 'iv_js_composer'),
					"param_name" => "icon_zoom",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("If yes, adds a zoom effect to the button when hovered.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Auto Social Icons Background?", 'iv_js_composer'),
					"param_name" => "social_auto",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("If yes, an automatic background will be added to the social brand icon in the button. Supports Font Awesome icons only.", 'iv_js_composer'),
					'dependency' => array('element' => 'icon_area', 'value' => 'icon'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Button Description?", 'iv_js_composer'),
					"param_name" => "e_desc",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("If yes, adds support to a description text below main text.", 'iv_js_composer'),
				),

				array(
					"type" => "textfield",
					"heading" => __("Description Text", 'iv_js_composer'),
					"param_name" => "desc_txt",
					"description" => __("Type the text to be used as description.", 'iv_js_composer'),
					'dependency' => array('element' => 'e_desc', 'value' => 'yes'),
				),
				
				$ivan_add_css_animation,

				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_button', array(
						__( 'Default', 'iv_js_composer' ) => '',
						'Gray' => 'gray-bg',
						'Dark' => 'dark-bg',
						'Light' => 'light-bg',
						'Primary' => 'primary-bg',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),
				//
				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Button", 'iv_js_composer'),
					"param_name" => "btn_css",
					"customize" => $ivan_vc_button->selectors['btn_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "icon_css",
					"customize" => $ivan_vc_button->selectors['icon_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Circular: Separator", 'iv_js_composer'),
					"param_name" => "hr_css",
					"customize" => $ivan_vc_button->selectors['hr_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Description: Main Text", 'iv_js_composer'),
					"param_name" => "desc_css",
					"customize" => $ivan_vc_button->selectors['desc_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Description: Small Text", 'iv_js_composer'),
					"param_name" => "small_css",
					"customize" => $ivan_vc_button->selectors['small_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Button", 'iv_js_composer'),
					"param_name" => "mob_btn_css",
					"customize" => $ivan_vc_button->selectors['mob_btn_css'],
					"value" => "",
					"group" => __('Mobile', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "mob_icon_css",
					"customize" => $ivan_vc_button->selectors['mob_icon_css'],
					"value" => "",
					"group" => __('Mobile', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Circular: Separator", 'iv_js_composer'),
					"param_name" => "mob_hr_css",
					"customize" => $ivan_vc_button->selectors['mob_hr_css'],
					"value" => "",
					"group" => __('Mobile', 'iv_js_composer'),
				),

			),// #params end				
		)// #setting array end
	);// #map end

/***
* Dual Button
***/
	global $ivan_vc_dual_btn;

	vc_map( array(
		"name" => __("Dual Button", 'iv_js_composer'),
		"base" => "ivan_dual_btn",
		'icon' => 'vc_info_box',
		"as_parent" => array('only' => 'ivan_button'),
		"is_container" => true,
		"content_element" => true,
		"show_settings_on_create" => false,
		'category' => 'Elite Addons',
		'description' => 'Use to display two buttons in a better way.',
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Align", 'iv_js_composer'),
				"param_name" => "align",
				"value" => array(
					'Center' => '',
					'Left' => 'to-left',
					'Right' => 'to-right',
				),
				"description" => __("Select main alignment of button group.", 'iv_js_composer'),
			),

			array(
				"type" => "textfield",
				"heading" => __("Middle Text", 'iv_js_composer'),
				"param_name" => "middle_txt",
				"description" => __("Type the text to be displayed between the buttons.", 'iv_js_composer'),
			),

			$ivan_add_css_animation,

			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Template', 'iv_js_composer' ),
				'param_name' => 'template',
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_dual_btn', array(
					__( 'Large Borders', 'iv_js_composer' ) => '',
					'Auto Borders' => 'auto-borders',
					'Thin Borders' => 'thin-borders',
					'No Borders' => 'no-borders',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Middle Text", 'iv_js_composer'),
				"param_name" => "mid_css",
				"customize" => $ivan_vc_dual_btn->selectors['mid_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Middle Text", 'iv_js_composer'),
				"param_name" => "mob_mid_css",
				"customize" => $ivan_vc_dual_btn->selectors['mob_mid_css'],
				"value" => "",
				"group" => __('Mobile', 'iv_js_composer'),
			),
		),
		"js_view" => 'VcColumnView'
	) );
	

/***
* Blockquote
***/
	
	global $ivan_vc_quote;

	// Blockquote 
	vc_map( array(
		"name" => "Blockquote",
		"base" => "iv_quote",
		'category' => 'Elite Addons',
		"icon" => "icon-wpb-blockquote",
		'description' => 'Display a nice quote in your content.',
		'controls' => 'full',
		'show_settings_on_create' => true,
		"params" => array(
			array(
				"type" => "textarea",
				"class" => "",
				"heading" => "Quote",
				"param_name" => "text",
				"value" => "Blockquote Text"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Show Quote Icon?",
				"param_name" => "icon",
				"value" => array(
					"No" => "",
					"Yes" => "yes",
				),
				"description" => ""
			),

			array(
				"type" => "textfield",
				"heading" => __("Author", 'iv_js_composer'),
				"param_name" => "author",
				"description" => __("Optional quote author name or small text placed below the main quote.", 'iv_js_composer')
			),

			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),

			array(
				"type" => "dropdown",
				"heading" => __("Template", 'iv_js_composer'),
				"param_name" => "template",
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_quote', array(
					__( 'Default', 'iv_js_composer' ) => '',
					'Gray' => 'gray-bg',
					'Dark' => 'dark-bg',
					'Clean' => 'clean-color',
					'Light' => 'light-bg',
					'Primary' => 'primary-bg',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Main Block", 'iv_js_composer'),
				"param_name" => "block_css",
				"customize" => $ivan_vc_quote->selectors['block_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Quote", 'iv_js_composer'),
				"param_name" => "quote_css",
				"customize" => $ivan_vc_quote->selectors['quote_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Author", 'iv_js_composer'),
				"param_name" => "author_css",
				"customize" => $ivan_vc_quote->selectors['author_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Icon", 'iv_js_composer'),
				"param_name" => "icon_css",
				"customize" => $ivan_vc_quote->selectors['icon_css'],
				"value" => "",
				"group" => __('Customizer', 'iv_js_composer'),
			),
		) // Params
	) );

/***
* Row Inners
***/
	
	vc_add_param('vc_row_inner', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Anchor ID", 'iv_js_composer'),
			"param_name" => "anchor",
			"admin_label" => false,
			"value" => "",
			"description" => __("Custom Row ID attribute.", 'iv_js_composer'),
		)
	);

	vc_add_param("vc_row_inner", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Use as a box?",
		"value" => array('Yes' => 'yes' ),
		"param_name" => "boxed",
		"description" => '',
	));

	vc_add_param("vc_row_inner", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Row Height",
		"param_name" => 'h',
		"value" => "",
		'description' => 'Defines a custom height to this row section.',
	));

	/// Border Controls

	vc_add_param("vc_row_inner", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Border Top Width",
		"value" => "",
		"param_name" => "bt_width",
		"description" => "Defines a width to the border, default is no border.",
	));	
	
		vc_add_param("vc_row_inner", array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border Top Color", 'iv_js_composer'),
			"param_name" => "bt_color",
			"value" => "",
			"description" => __("Select the border top color.", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bt_width', 'not_empty' => true ),
		));

	vc_add_param("vc_row_inner", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Border Bottom Width",
		"value" => "",
		"param_name" => "bb_width",
		"description" => "Defines a width to the border, default is no border.",
	));	

		vc_add_param("vc_row_inner", array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border Bottom Color", 'iv_js_composer'),
			"param_name" => "bb_color",
			"value" => "",
			"description" => __("Select the border top color.", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bb_width', 'not_empty' => true ),
		));

	vc_add_param('vc_row_inner',array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Background Type", 'iv_js_composer'),
		"param_name" => "bg_type",
		"value" => array(
			'Normal' => "",
			'Image' => "image",
			'Parallax' => "parallax",
			'Video' => "video",
			),
		"description" => __("Select the type of background you'll use in this row.", "ivan_vc_domain"),	
	));

		// Normal Background Type
		vc_add_param("vc_row_inner", array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background Color", 'iv_js_composer'),
			"param_name" => "bg_color_row",
			"value" => "",
			"description" => __("Select the background color.", 'iv_js_composer'),
		));

		// Image BG

		vc_add_param('vc_row_inner',array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Background Image", 'iv_js_composer'),
			"param_name" => "bg_image_url",
			"value" => "",
			"description" => __("Upload or select background image from media gallery.", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bg_type', 'value' => array('image', 'parallax') ),
		));

		vc_add_param('vc_row_inner',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Background Repeat", 'iv_js_composer'),
				"param_name" => "bg_repeat",
				"value" => array(
					'No Repeat' => "",
					'Repeat X' => "repeat-x",
					'Repeat Y' => "repeat-y",
					'Repeat' => "repeat",
					),
				"description" => __("Select the way background image will repeat.", 'iv_js_composer'),
				"dependency" => array( 'element' => 'bg_type', 'value' => array('image') ),
			)
		);

		vc_add_param('vc_row_inner',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Background Position", 'iv_js_composer'),
				"param_name" => "bg_position",
				"value" => array(
					'Center/Center' => "",
					'Left/Top' => "left top",
					'Left/Center' => 'left center',
					'Left/Bottom' => 'left bottom',
					'Right/Top' => "right top",
					'Right/Center' => 'right center',
					'Right/Bottom' => 'right bottom',
					'Center/Top' => "center top",
					'Center/Bottom' => 'center bottom',
					),
				"description" => __("Select the way background image will be positioned. Horizontal/Vertical", 'iv_js_composer'),
				"dependency" => array( 'element' => 'bg_type', 'value' => array('image') ),
			)
		);

		vc_add_param('vc_row_inner',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Background Size", 'iv_js_composer'),
				"param_name" => "bg_size",
				"value" => array(
					'Cover' => "",
					'Contain' => "contain",
					'Default' => "auto",
					),
				"description" => __("Select the way background image will be sized.", 'iv_js_composer'),
				"dependency" => array( 'element' => 'bg_type', 'value' => array('image') ),
			)
		);

		vc_add_param('vc_row_inner',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Background Attachment", 'iv_js_composer'),
				"param_name" => "bg_att",
				"value" => array(
					'Default' => "",
					'Fixed' => "fixed",
					),
				"description" => __("Select the way background image will be attached to the page.", 'iv_js_composer'),
				"dependency" => array( 'element' => 'bg_type', 'value' => array('image') ),
			)
		);

		// Parallax
		vc_add_param("vc_row_inner", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Parallax Speed",
			"param_name" => 'p_speed',
			"value" => "",
			"description" => __("This defines the parallax velocity scaled based in natural scoll. Use values like 0.5, 0.8, 1.5, 2 and others. Default is 0.5", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bg_type', 'value' => array('parallax') ),
		));

		// Video
		vc_add_param("vc_row_inner", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Video (webm) File URL",
			"value" => "",
			"param_name" => "webm",
			"description" => "",
			"dependency" => array( 'element' => 'bg_type', 'value' => array('video') ),
		));

		vc_add_param("vc_row_inner", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Video (mp4) File URL",
			"value" => "",
			"param_name" => "mp4",
			"description" => "",
			"dependency" => array( 'element' => 'bg_type', 'value' => array('video') ),
		));

		vc_add_param("vc_row_inner", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Video (ogv) File URL",
			"value" => "",
			"param_name" => "ogv",
			"description" => "",
			"dependency" => array( 'element' => 'bg_type', 'value' => array('video') ),
		));

		vc_add_param("vc_row_inner", array(
			"type" => "attach_image",
			"class" => "",
			"heading" => "Video Preview Image",
			"value" => "",
			"param_name" => "preview",
			"description" => "",
			"dependency" => array( 'element' => 'bg_type', 'value' => array('video') ),
		));

		vc_add_param("vc_row_inner", array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Overlay Color", 'iv_js_composer'),
			"param_name" => "overlay",
			"value" => "",
			"description" => __("Select overlay color. Usually a color with opacity to be placed above image or video", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bg_type', 'value' => array('image', 'parallax', 'video') ),
		));

	// Dimensions
	vc_add_param('vc_row_inner', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Padding Top", 'iv_js_composer'),
			"param_name" => "p_top",
			"value" => "",
			"description" => __("Define a custom padding top to the section.", 'iv_js_composer'),
			//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
			"group" => __('Margins', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_row_inner', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Padding Bottom", 'iv_js_composer'),
			"param_name" => "p_bottom",
			"value" => "",
			"description" => __("Define a custom padding bottom to the section.", 'iv_js_composer'),
			//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
			"group" => __('Margins', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_row_inner', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Margin Top", 'iv_js_composer'),
			"param_name" => "m_top",
			"value" => "",
			"description" => __("Define a custom margin top to the section.", 'iv_js_composer'),
			//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
			"group" => __('Margins', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_row_inner', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Margin Bottom", 'iv_js_composer'),
			"param_name" => "m_bottom",
			"value" => "",
			"description" => __("Define a custom margin bottom to the section.", 'iv_js_composer'),
			//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
			"group" => __('Margins', 'iv_js_composer'),
		)
	);

	// Effects

		// Vertical Align
		vc_add_param('vc_row_inner',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Enable Vertical Align?", 'iv_js_composer'),
				"param_name" => "v_center",
				"value" => array(
					'No' => "",
					'Yes' => "yes",
					),
				"description" => __("When enabled, the columns content will be vertically aligned.", 'iv_js_composer'),
				"group" => __('Effects', 'iv_js_composer'),
			)
		);

/***
* Row
***/
	
	vc_add_param('vc_row', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Anchor ID", 'iv_js_composer'),
			"param_name" => "anchor",
			"admin_label" => false,
			"value" => "",
			"description" => __("Custom Row ID attribute.", 'iv_js_composer'),
		)
	);

	vc_add_param('vc_row',array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Row Width", 'iv_js_composer'),
		"param_name" => "width",
		"value" => array(
			__("Normal / Grid", "ivan_vc_domain") => "",
			__("Full Width", "ivan_vc_domain") => "full",
			__("Full Width No Side Margins", "ivan_vc_domain") => "no_margin",
			__("Full Width No Side Margin + No Columns Margins", "ivan_vc_domain") => "no_cols_margin",
			__("Normal / Grid + No Columns Margin", "ivan_vc_domain") => "no_cols_grid",
			),
		"description" => __("Select the width behavior of this row.", "ivan_vc_domain"),	
	));

	vc_add_param("vc_row", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Use as a box?",
		"value" => array('Yes' => 'yes' ),
		"param_name" => "boxed",
		"description" => '',
		"dependency" => array( 'element' => 'width', 'value' => '' )
	));

	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Row Height",
		"param_name" => 'h',
		"value" => "",
		'description' => 'Defines a custom height to this row section.',
	));

	/// Border Controls

	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Border Top Width",
		"value" => "",
		"param_name" => "bt_width",
		"description" => "Defines a width to the border, default is no border.",
	));	
	
		vc_add_param("vc_row", array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border Top Color", 'iv_js_composer'),
			"param_name" => "bt_color",
			"value" => "",
			"description" => __("Select the border top color.", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bt_width', 'not_empty' => true ),
		));

	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Border Bottom Width",
		"value" => "",
		"param_name" => "bb_width",
		"description" => "Defines a width to the border, default is no border.",
	));	

		vc_add_param("vc_row", array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border Bottom Color", 'iv_js_composer'),
			"param_name" => "bb_color",
			"value" => "",
			"description" => __("Select the border top color.", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bb_width', 'not_empty' => true ),
		));

	vc_add_param('vc_row',array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Background Type", 'iv_js_composer'),
		"param_name" => "bg_type",
		"value" => array(
			'Normal' => "",
			'Image' => "image",
			'Parallax' => "parallax",
			'Video' => "video",
			),
		"description" => __("Select the type of background you'll use in this row.", "ivan_vc_domain"),	
	));

		// Normal Background Type
		vc_add_param("vc_row", array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background Color", 'iv_js_composer'),
			"param_name" => "bg_color_row",
			"value" => "",
			"description" => __("Select the background color.", 'iv_js_composer'),
		));

		// Image BG

		vc_add_param('vc_row',array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Background Image", 'iv_js_composer'),
			"param_name" => "bg_image_url",
			"value" => "",
			"description" => __("Upload or select background image from media gallery.", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bg_type', 'value' => array('image', 'parallax') ),
		));

		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Background Repeat", 'iv_js_composer'),
				"param_name" => "bg_repeat",
				"value" => array(
					'No Repeat' => "",
					'Repeat X' => "repeat-x",
					'Repeat Y' => "repeat-y",
					'Repeat' => "repeat",
					),
				"description" => __("Select the way background image will repeat.", 'iv_js_composer'),
				"dependency" => array( 'element' => 'bg_type', 'value' => array('image') ),
			)
		);

		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Background Position", 'iv_js_composer'),
				"param_name" => "bg_position",
				"value" => array(
					'Center/Center' => "",
					'Left/Top' => "left top",
					'Left/Center' => 'left center',
					'Left/Bottom' => 'left bottom',
					'Right/Top' => "right top",
					'Right/Center' => 'right center',
					'Right/Bottom' => 'right bottom',
					'Center/Top' => "center top",
					'Center/Bottom' => 'center bottom',
					),
				"description" => __("Select the way background image will be positioned. Horizontal/Vertical", 'iv_js_composer'),
				"dependency" => array( 'element' => 'bg_type', 'value' => array('image') ),
			)
		);

		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Background Size", 'iv_js_composer'),
				"param_name" => "bg_size",
				"value" => array(
					'Cover' => "",
					'Contain' => "contain",
					'Default' => "auto",
					),
				"description" => __("Select the way background image will be sized.", 'iv_js_composer'),
				"dependency" => array( 'element' => 'bg_type', 'value' => array('image') ),
			)
		);

		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Background Attachment", 'iv_js_composer'),
				"param_name" => "bg_att",
				"value" => array(
					'Default' => "",
					'Fixed' => "fixed",
					),
				"description" => __("Select the way background image will be attached to the page.", 'iv_js_composer'),
				"dependency" => array( 'element' => 'bg_type', 'value' => array('image') ),
			)
		);

		// Parallax
		vc_add_param("vc_row", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Parallax Speed",
			"param_name" => 'p_speed',
			"value" => "",
			"description" => __("This defines the parallax velocity scaled based in natural scoll. Use values like 0.5, 0.8, 1.5, 2 and others. Default is 0.5", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bg_type', 'value' => array('parallax') ),
		));

		// Video
		vc_add_param("vc_row", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Video (webm) File URL",
			"value" => "",
			"param_name" => "webm",
			"description" => "",
			"dependency" => array( 'element' => 'bg_type', 'value' => array('video') ),
		));

		vc_add_param("vc_row", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Video (mp4) File URL",
			"value" => "",
			"param_name" => "mp4",
			"description" => "",
			"dependency" => array( 'element' => 'bg_type', 'value' => array('video') ),
		));

		vc_add_param("vc_row", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Video (ogv) File URL",
			"value" => "",
			"param_name" => "ogv",
			"description" => "",
			"dependency" => array( 'element' => 'bg_type', 'value' => array('video') ),
		));

		vc_add_param("vc_row", array(
			"type" => "attach_image",
			"class" => "",
			"heading" => "Video Preview Image",
			"value" => "",
			"param_name" => "preview",
			"description" => "",
			"dependency" => array( 'element' => 'bg_type', 'value' => array('video') ),
		));

		vc_add_param("vc_row", array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Overlay Color", 'iv_js_composer'),
			"param_name" => "overlay",
			"value" => "",
			"description" => __("Select overlay color. Usually a color with opacity to be placed above image or video", 'iv_js_composer'),
			"dependency" => array( 'element' => 'bg_type', 'value' => array('image', 'parallax', 'video') ),
		));

	// Dimensions
	vc_add_param('vc_row', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Padding Top", 'iv_js_composer'),
			"param_name" => "p_top",
			"value" => "",
			"description" => __("Define a custom padding top to the section.", 'iv_js_composer'),
			//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
			"group" => __('Margins', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_row', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Padding Bottom", 'iv_js_composer'),
			"param_name" => "p_bottom",
			"value" => "",
			"description" => __("Define a custom padding bottom to the section.", 'iv_js_composer'),
			//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
			"group" => __('Margins', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_row', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Margin Top", 'iv_js_composer'),
			"param_name" => "m_top",
			"value" => "",
			"description" => __("Define a custom margin top to the section.", 'iv_js_composer'),
			//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
			"group" => __('Margins', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_row', array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Margin Bottom", 'iv_js_composer'),
			"param_name" => "m_bottom",
			"value" => "",
			"description" => __("Define a custom margin bottom to the section.", 'iv_js_composer'),
			//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
			"group" => __('Margins', 'iv_js_composer'),
		)
	);

	// Effects

		// Top Cut Effect
		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top Cut Effect", 'iv_js_composer'),
				"param_name" => "cut_top",
				"value" => array(
					'Disabled' => "",
					'From Right to Left' => "top-left",
					'From Left to Right' => "top-right",
					'Triangle at Center' => "top-triangle",
					'Inverse Triangle at Center' => "inverse-triangle",
					),
				"description" => __("Add a irregular cut effect to this row with same color than background color.", 'iv_js_composer'),
				"group" => __('Effects', 'iv_js_composer'),
			)
		);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Top Cut Height", 'iv_js_composer'),
					"param_name" => "cut_top_h",
					"value" => "",
					"description" => __("Define the height of the cut, when the value is higher, the cut angle will increase. Used as triangle height as well. Default is 30.", 'iv_js_composer'),
					"dependency" => array("element" => "cut_top", "value" => array("top-left", "top-right", "top-triangle", "inverse-triangle")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Top Triangle Width", 'iv_js_composer'),
					"param_name" => "cut_top_w",
					"value" => "",
					"description" => __("Define the triangle width. Default is 60.", 'iv_js_composer'),
					"dependency" => array("element" => "cut_top", "value" => array("top-triangle")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

		// Bottom Cut Effect
		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Bottom Cut Bottom", 'iv_js_composer'),
				"param_name" => "cut_bottom",
				"value" => array(
					'Disabled' => "",
					'From Right to Left' => "bottom-left",
					'From Left to Right' => "bottom-right",
					'Triangle at Center' => "bottom-triangle",
					'Inverse Triangle at Center' => "inverse-triangle",
					),
				"description" => __("Add a irregular cut effect to this row with same color than background color.", 'iv_js_composer'),
				"group" => __('Effects', 'iv_js_composer'),
			)
		);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Bottom Cut Height", 'iv_js_composer'),
					"param_name" => "cut_bottom_h",
					"value" => "",
					"description" => __("Define the height of the cut, when the value is higher, the cut angle will increase. Used as triangle height as well. Default is 30.", 'iv_js_composer'),
					"dependency" => array("element" => "cut_bottom", "value" => array("bottom-left", "bottom-right", "bottom-triangle", "inverse-triangle")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Bottom Triangle Width", 'iv_js_composer'),
					"param_name" => "cut_bottom_w",
					"value" => "",
					"description" => __("Define the triangle width. Default is 60.", 'iv_js_composer'),
					"dependency" => array("element" => "cut_bottom", "value" => array("bottom-triangle")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

		// Vertical Align
		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Enable Vertical Align?", 'iv_js_composer'),
				"param_name" => "v_center",
				"value" => array(
					'No' => "",
					'Yes' => "yes",
					),
				"description" => __("When enabled, the columns content will be vertically aligned.", 'iv_js_composer'),
				"group" => __('Effects', 'iv_js_composer'),
			)
		);

		// Full Height Div
		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Full Viewport Height?", 'iv_js_composer'),
				"param_name" => "full_h",
				"value" => array(
					'No' => "",
					'Yes' => "yes",
					),
				"description" => __("When enabled, row will have same height than viewport/window.", 'iv_js_composer'),
				"group" => __('Effects', 'iv_js_composer'),
			)
		);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Viewport Offsets", 'iv_js_composer'),
					"param_name" => "full_offsets",
					"value" => "",
					"description" => __("Type the selectors to be offset in full viewport height calculation.", 'iv_js_composer'),
					"dependency" => array("element" => "full_h", "value" => array("yes")),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

		// FullPage JS
		vc_add_param('vc_row',array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Enable Full Page Scroll System?", 'iv_js_composer'),
				"param_name" => "row_fullpage",
				"value" => array(
					'No' => "",
					'Yes' => "yes",
					),
				"description" => __("This option is global, if you activate it, all rows in this page will be used as part of the full page scroll system.", 'iv_js_composer'),
				"group" => __('Effects', 'iv_js_composer'),
			)
		);

			vc_add_param('vc_row', array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Full Page Label", 'iv_js_composer'),
					"param_name" => "row_label",
					"value" => "",
					"description" => __("Define the label of this row when using the full page system. E.g.: Features, Requirements...", 'iv_js_composer'),
					//"dependency" => array( "element" => "row_fullpage", "value" => array("yes") ),
					"group" => __('Effects', 'iv_js_composer'),
				)
			);

/***
* Single Image
***/

	// Remove Default
	vc_remove_param('vc_single_image', 'img_size');

	vc_add_param("vc_single_image", array(
		"type" => "dropdown",
		"heading" => __("Image Size", 'iv_js_composer'),
		"param_name" => "img_size",
		"value" => ivan_vc_img_sizes(),
		"description" => __("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Leave empty to use default size.", 'iv_js_composer')
	));


	vc_add_param('vc_single_image',array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Open in lightbox?", 'iv_js_composer'),
			"param_name" => "lightbox",
			"value" => array(
				__("No",'iv_js_composer') => "",
				__("Yes",'iv_js_composer') => "yes",
				),
		)
	);

	vc_add_param('vc_single_image',array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Lightbox Content Type:", 'iv_js_composer'),
			"param_name" => "content_type",
			"value" => array(
				__("Image",'iv_js_composer') => "",
				__("Video",'iv_js_composer') => "mfp-video",
				),
			'dependency' => array('element' => 'lightbox', 'value' => 'yes'),
		)
	);

	vc_add_param('vc_single_image',array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Enable Cover?", 'iv_js_composer'),
			"param_name" => "enable_cover",
			"value" => array(
				__("No",'iv_js_composer') => "",
				__("Yes",'iv_js_composer') => "yes",
				),
			'dependency' => array('element' => 'lightbox', 'value' => 'yes'),
		)
	);

/***
 * Image Gallery from VC
***/

	// Remove Default
	vc_remove_param('vc_gallery', 'img_size');

	vc_add_param("vc_gallery", array(
		"type" => "dropdown",
		"heading" => __("Image Size", 'iv_js_composer'),
		"param_name" => "img_size",
		"value" => ivan_vc_img_sizes(),
		"description" => __("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Leave empty to use default size.", 'iv_js_composer')
	));

	vc_add_param("vc_gallery", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Column Number",
		"param_name" => "column_number",
		"value" => array(2, 3, 4, 5, "Disable" => 0),
		"dependency" => array('element' => "type", 'value' => array('image_grid')),
		'description' => "Define the column number that your image gallery will be displayed.",
	));

	vc_add_param("vc_gallery", array(
	    "type" => "dropdown",
	    "class" => "",
	    "heading" => "Grayscale Effect",
	    "param_name" => "grayscale",
	    "value" => array('No' => 'no', 'Yes' => 'yes'),
	    "dependency" => array('element' => "type", 'value' => array('image_grid')),
	    'description' => 'Select yes to add a grayscale effect to the images.',
	));

	vc_add_param("vc_gallery", array(
	    'type' => 'dropdown',
		'heading' => __( 'Navigation Style', 'iv_js_composer' ),
		'param_name' => 'arr_style',
		'value' => apply_filters( 'ivan_vc_carousel_styles', array(
			__( 'Thin Outline Light', 'iv_js_composer' ) => '',
			__( 'Thin Outline Dark', 'iv_js_composer' ) => 'style-thin-outline dark',
		) ),
		'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' ),
	    "dependency" => array('element' => "type", 'value' => array('flexslider_slide', 'flexslider_fade')),
	));

	if ( shortcode_exists( 'device' ) ) :

		vc_add_param("vc_gallery", array(
		    "type" => "dropdown",
		    "class" => "",
		    "heading" => "Frame",
		    "param_name" => "frame",
			"value" => array(
				'No' => '',
				'Yes' => 'use_frame',
			),
		    "description" => "Select yes to use a frame in your image gallery, it'll be displayed inside a laptop for example.",
		    "dependency" => array('element' => "type", 'value' => array('flexslider_slide', 'flexslider_fade')),
		));

		vc_add_param("vc_gallery", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Device",
			"param_name" => "device",
			"value" => array(
				'MacBook' => 'macbook',
				'iPhone 5' => 'iphone5',
				'iPad' => 'ipad',
				'iMac' => 'imac',
				'Galaxy S3' => 's3',
				'Nexus 7' => 'nexus7',
				'Surface' => 'surface',
				'Lumia 920' => 'lumia920',
				),
			"dependency" => array('element' => "frame", 'value' => array('use_frame')),
			'description' => 'Define the device that will be the frame. Recommended Image Sizes:<br>
				<strong>MacBook Pro</strong> - 1440x900 - 
				<strong>iPad</strong> - 2048×1536 - 
				<strong>iMac</strong> - 1920x1200 - 
				<strong>iPhone 5</strong> - 640×1136<br>
				<strong>Galaxy S3</strong> - 720x1280 - 
				<strong>Nexus 7</strong> - 1920x1200 - 
				<strong>Surface</strong> - 1920 x 1080 - 
				<strong>Lumia 920</strong> - 768 x 1280
			',
		));

		vc_add_param("vc_gallery", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Color",
			"param_name" => "d_color",
			"value" => array(
				'Black' => '',
				'White' => 'white',
				),
			"dependency" => array('element' => "frame", 'value' => array('use_frame')),
			'description' => 'Define a color to the device.',
		));

		vc_add_param("vc_gallery", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Orientation",
			"param_name" => "orientation",
			"value" => array(
				'Portrait' => '',
				'Landscape' => 'landscape',
				),
			"dependency" => array('element' => "frame", 'value' => array('use_frame')),
			'description' => 'Define the device orientation. Not avaliable to all devices. Only mobiles.',
		));

		vc_add_param('vc_gallery', array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Max Width", 'iv_js_composer'),
				"param_name" => "d_width",
				"value" => "",
				"description" => __("Optional. Type the max width of the device wrapper.", 'iv_js_composer'),
				"dependency" => array('element' => "frame", 'value' => array('use_frame')),
			)
		);

		vc_add_param("vc_gallery", array(
		    "type" => "dropdown",
		    "class" => "",
		    "heading" => "Force Height?",
		    "param_name" => "force_height",
			"value" => array(
				'No' => '',
				'Yes' => 'force-height',
			),
		    "description" => "Select yes to force image height fit device height.",
		    "dependency" => array('element' => "frame", 'value' => array('use_frame')),
		));

	endif;

/***
 * Toggle
***/

	// Call global var to use selectors array
	global $ivan_vc_toggle;

	vc_add_param("vc_toggle", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Style",
		"param_name" => "style",
		"value" => array(
			"With Arrow" => "with_arrow",
	        "Boxed Minimal" => "boxed",
	        "Boxed Arrow" => "boxed_arrow",
		),
		"description" => "Select a pre-defined style to your accordion."
	));

	vc_add_param('vc_toggle',
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'iv_js_composer' ),
			'param_name' => 'template',
			'admin_label' => true,
			'value' => apply_filters( 'ivan_vc_toggle', array(
				__( 'Default', 'iv_js_composer' ) => '',
			) ),
			'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
		)
	);

	vc_add_param("vc_toggle", array(
		"type" => "ivan_customizer_id",
		"heading" => __("Customization ID", 'iv_js_composer'),
		"param_name" => "c_id",
		"value" => "",
	));

	vc_add_param('vc_toggle',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Heading", 'iv_js_composer'),
			"param_name" => "toggle_css",
			"customize" => $ivan_vc_toggle->selectors['toggle_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_toggle',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Icon", 'iv_js_composer'),
			"param_name" => "mark_css",
			"customize" => $ivan_vc_toggle->selectors['mark_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_toggle',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "content_css",
			"customize" => $ivan_vc_toggle->selectors['content_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

/***
 * Accordion
***/

	// Call global var to use selectors array
	global $ivan_vc_accordion;

	vc_add_param("vc_accordion", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Style",
		"param_name" => "style",
		"value" => array(
			"Accordion" => "accordion",
	        "Boxed Minimal" => "boxed_accordion",
	        "Boxed Arrow" => "boxed_arrow",
		),
		"description" => "Select a pre-defined style to your accordion."
	));

	vc_add_param('vc_accordion',
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'iv_js_composer' ),
			'param_name' => 'template',
			'admin_label' => true,
			'value' => apply_filters( 'ivan_vc_accordion', array(
				__( 'Default', 'iv_js_composer' ) => '',
			) ),
			'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
		)
	);

	vc_add_param("vc_accordion", array(
		"type" => "ivan_customizer_id",
		"heading" => __("Customization ID", 'iv_js_composer'),
		"param_name" => "c_id",
		"value" => "",
	));

	vc_add_param('vc_accordion',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Heading", 'iv_js_composer'),
			"param_name" => "toggle_css",
			"customize" => $ivan_vc_accordion->selectors['toggle_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_accordion',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Icon", 'iv_js_composer'),
			"param_name" => "mark_css",
			"customize" => $ivan_vc_accordion->selectors['mark_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_accordion',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "content_css",
			"customize" => $ivan_vc_accordion->selectors['content_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

/***
 * Separator
***/

	$separator_settings = array (
		'show_settings_on_create' => true,
		'controls'	=> '',
	);
	vc_map_update('vc_separator', $separator_settings);


	vc_add_param("vc_separator", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Type",
		"param_name" => "type",
		"value" => array(
			"Normal"		=>	"normal",
			"Full Width"	=>	"wide",
			"Small"			=>	"small",
			"Invisible"			=>	"invisible",
		),
		"description" => "Define the size of the separator, normal is a simple line."
	));

	vc_add_param("vc_separator", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Position",
		"param_name" => "position",
		"value" => array(
			"Center" => "center",
			"Left" => "left",
			"Right" => "right"
		),
	    "dependency" => array("element" => "type", "value" => array("small")),
		"description" => ""
	));

	vc_add_param("vc_separator", array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "Color",
		"param_name" => "color",
		"value" => "",
		"description" => ""
	));

	vc_add_param("vc_separator", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Opacity",
		"param_name" => "opacity",
		"value" => "",
		"description" => "Values should be between 0 and 1. For example: 0.5 would be 50% opaque."
	));

	vc_add_param("vc_separator", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Thickness/Height",
		"param_name" => "thickness",
		"value" => "",
		"description" => "Defines the height of the separator."
	));

	vc_add_param("vc_separator", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Width",
		"param_name" => "width",
		"value" => "",
		"dependency" => array("element" => "type", "value" => array("small")),
		"description" => "Custom width to the separator."
	));

	vc_add_param("vc_separator", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Margin Top",
		"param_name" => "up",
		"value" => "",
		"description" => ""
	));

	vc_add_param("vc_separator", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Margin Bottom",
		"param_name" => "down",
		"value" => "",
		"description" => ""
	));

	vc_add_param("vc_separator", array(
		"type" => "dropdown",
		"heading" => __("Template", 'iv_js_composer'),
		"param_name" => "template",
		'admin_label' => true,
		'value' => apply_filters( 'ivan_vc_separator', array(
			__( 'Default', 'iv_js_composer' ) => '',
			'Gray' => 'gray-bg',
			'Dark' => 'dark-bg',
			//'Clean' => 'clean-color',
			'Light' => 'light-bg',
			'Primary' => 'primary-bg',
		) ),
		'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
	));

/***
 * Separator with Text
***/

/***
 * Tabs
***/

	// Call global var to use selectors array
	global $ivan_vc_tabs;

	vc_add_param("vc_tabs", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Style",
		"param_name" => "style",
		"value" => array(
			"Horizontal Left" => "h_left",
			"Horizontal Center" => "h_center",
			"Horizontal Right" => "h_right",
			"Horizontal Boxed" => "boxed",
			"Vertical Left" => "v_left",
			"Vertical Right" => "v_right"
		),
		"description" => "Select default style that the tabs will be displayed.",
	));


	vc_add_param('vc_tabs',
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'iv_js_composer' ),
			'param_name' => 'template',
			'admin_label' => true,
			'value' => apply_filters( 'ivan_vc_tabs', array(
				__( 'Default', 'iv_js_composer' ) => '',
			) ),
			'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
		)		
	);

	vc_add_param("vc_tabs", array(
		"type" => "ivan_customizer_id",
		"heading" => __("Customization ID", 'iv_js_composer'),
		"param_name" => "c_id",
		"value" => "",
	));

	vc_add_param('vc_tabs',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Tabs", 'iv_js_composer'),
			"param_name" => "tabs_css",
			"customize" => $ivan_vc_tabs->selectors['tabs_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

	vc_add_param('vc_tabs',
		array(
			"type" => "ivan_customizer",
			"class" => "",
			"heading" => __("Content", 'iv_js_composer'),
			"param_name" => "content_css",
			"customize" => $ivan_vc_tabs->selectors['content_css'],
			"value" => "",
			"group" => __('Customizer', 'iv_js_composer'),
		)
	);

/***
 * Portfolio
***/

	// Call global var to use selectors array
	global $ivan_vc_projects;

	vc_map(
		array(
			'name' => __('Portfolio', 'iv_js_composer'),
			'base' => 'ivan_projects',
			'icon' => 'vc_info_box',
			'class' => 'ivan_projects',
			'category' => 'Elite Addons',
			'description' => 'Display a grid or carousel of your portfolio.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Posts", 'iv_js_composer'),
					"param_name" => "ivan_posts_per_page",
					"value" => '4',
					"description" => __("Number of entries to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Custom Post Type", 'iv_js_composer'),
					"param_name" => "ivan_cpt",
					"value" => $iv_cpts,
					"description" => __("Select a specific post type to be displayed. Ivan Projects is default.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Specific Category", 'iv_js_composer'),
					"param_name" => "ivan_category",
					"value" => $iv_cats,
					"description" => __("Select a specific category to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Specific Portfolio", 'iv_js_composer'),
					"param_name" => "ivan_portfolio",
					"value" => $iv_ports,
					"description" => __("Select a specific portfolio to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"heading" => __("Image Size", 'iv_js_composer'),
					"param_name" => "ivan_img_size",
					"value" => ivan_vc_img_sizes(),
					"description" => __("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Leave empty to use default size.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Columns", 'iv_js_composer'),
					"param_name" => "ivan_columns",
					"value" => array(
						'Four' => '4',
						'Three' => '3',
						'Two' => '2',
						'One' => '1',
					),
					"description" => __("Select the columns layout to be applied.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Type", 'iv_js_composer'),
					"param_name" => "ivan_type",
					"value" => array(
						'Masonry' => 'mansory',
						'Grid' => 'grid',
						'Carousel' => 'carousel'
					),
					"description" => __("Select the style to display the items.", 'iv_js_composer'),
				),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable special sizes?", 'iv_js_composer'),
						"param_name" => "ivan_enable_sizes",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("Display special sizes defined by tags 'full', 'double-width', 'double-height' and 'half-height' in the projects.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'mansory'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable sortable filters?", 'iv_js_composer'),
						"param_name" => "ivan_sortable_filters",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("Display filters above the items. Not avaliable to Carousel.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => array('mansory', 'grid') ),
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("All Filter Replacement", 'iv_js_composer'),
						"param_name" => "all_txt",
						"value" => '',
						'description' => 'Define a text to replace All in filters.',
						'dependency' => array('element' => 'ivan_sortable_filters', 'value' => 'yes'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Filter Alignment", 'iv_js_composer'),
						"param_name" => "filter_align",
						"value" => array(
							'Center' => '',
							'Left' => 'left',
							'Right' => 'right',
						),
						'description' => 'Define the filters alignment.',
						'dependency' => array('element' => 'ivan_sortable_filters', 'value' => 'yes'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Navigation?", 'iv_js_composer'),
						"param_name" => "ivan_carousel_nav",
						"value" => array(
							'Yes' => '',
							'No' => 'no',
						),
						"description" => __("Display directional arrows in carousel when activated.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Only show arrows/navigation at hover?", 'iv_js_composer'),
						"param_name" => "arrows_hover",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("If enabled, arrows will be displayed only when user hover the carousel.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Bullets?", 'iv_js_composer'),
						"param_name" => "ivan_carousel_bullets",
						"value" => array(
							'Yes' => '',
							'No' => 'no',
						),
						"description" => __("Display bullets bellow carousel when activated.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Nav and Bullets Style', 'iv_js_composer' ),
						'param_name' => 'arr_style',
						'value' => apply_filters( 'ivan_vc_carousel_styles', array(
							__( 'Outline Circle Light', 'iv_js_composer' ) => '',
							__( 'Outline Circle Dark', 'iv_js_composer' ) => 'style-outline-circle dark',
							__( 'Thin Outline Light', 'iv_js_composer' ) => 'style-thin-outline',
							__( 'Thin Outline Dark', 'iv_js_composer' ) => 'style-thin-outline dark',
							__( 'Opaque Box Light', 'iv_js_composer' ) => 'style-opaque-box',
							__( 'Opaque Box Dark', 'iv_js_composer' ) => 'style-opaque-box dark',
						) ),
						'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' ),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Force Bullets be gray?", 'iv_js_composer'),
						"param_name" => "force_g",
						"value" => array(
							'Yes' => '',
							'No' => 'no',
						),
						"description" => __("If yes, bullets will be gray instead be light or dark with the arrows.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_type', 'value' => 'carousel'),
					),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Margin", 'iv_js_composer'),
					"param_name" => "ivan_margin",
					"value" => array(
						'Default Margin' => '',
						'No Margin' => ' no-margin',
						'Small Margin' => ' small-margin',
					),
					"description" => __("Select if items will have margins in items or not.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Cover Type", 'iv_js_composer'),
					"param_name" => "ivan_cover",
					"value" => array(
						'Default' => '',
						'Light Caption' => ' light-caption',
						'Caption Cover' => ' hide-entry',
						'Dark Cover' => ' cover-entry',
						'Soft Cover' => ' soft-cover',
						'Outer Cover' => ' outer-square',
						'Lateral Cover' => ' lateral-cover',
						'Smooth Cover' => ' smooth-cover',
						'Border Cover' => ' border-cover',
					),
					"description" => __("Define how the infos will be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Cover appear only at hover?", 'iv_js_composer'),
					"param_name" => "ivan_cover_hover",
					"value" => array(
						'Yes' => '',
						'No' => ' no-appear-hover',
					),
					"description" => __("Only display cover at hover.", 'iv_js_composer'),
					'dependency' => array('element' => 'ivan_cover', 'value' => ' cover-entry'),
				),	
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Zoom", 'iv_js_composer'),
					"param_name" => "ivan_zoom",
					"value" => array(
						'Yes' => '',
						'No' => ' no-zoom',
					),
					"description" => __("Apply zoom when hover image.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Grayscale", 'iv_js_composer'),
					"param_name" => "ivan_grayscale",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Apply grayscale effect in image and back to normal when hover image.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Item Height", 'iv_js_composer'),
					"param_name" => "ivan_custom_height",
					"description" => __("Enter a custom height to the items like '300' or '250'", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable Entry Infos?", 'iv_js_composer'),
					"param_name" => "ivan_enable_cover",
					"value" => array(
						'Yes' => '',
						'No' => 'no',
					),
					"description" => __("Define if infos like title, read more and excerpt will be displayed or not.", 'iv_js_composer'),
				),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Icon Family", 'iv_js_composer'),
						"param_name" => "ico_family",
						"value" => array(
							'Font Awesome' => 'fa fa-',
							'Elegant Icons' => 'el el-',
							'Custom' => 'custom',
						),
						"description" => __("Select the icon family.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => ''),
					),
					array(
						"type" => "textfield",
						"heading" => __("Custom Icon Class", 'iv_js_composer'),
						"param_name" => "ico_custom",
						"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
						'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Icon Name", 'iv_js_composer'),
						"param_name" => "ico",
						"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => ''),
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable title?", 'iv_js_composer'),
						"param_name" => "ivan_enable_title",
						"value" => array(
							'Yes' => '',
							'No' => 'no',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => ''),
					), ////	
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable filters/categories?", 'iv_js_composer'),
						"param_name" => "ivan_enable_categories",
						"value" => array(
							'Yes' => '',
							'No' => 'no',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => ''),
					), ////
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable excerpt?", 'iv_js_composer'),
						"param_name" => "ivan_enable_excerpt",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => ''),				
					), /////
					array(
						"type" => "textfield",
						"heading" => __("Excerpt Chars", 'iv_js_composer'),
						"param_name" => "chars_excerpt",
						"description" => __("Optional excerpt limit of chars to be displayed in excerpt.", 'iv_js_composer'),
						'dependency' => array('element' => 'ivan_enable_excerpt', 'value' => 'yes'),
					),

						array(
							"type" => "textfield",
							"heading" => __("Double Width Excerpt Chars", 'iv_js_composer'),
							"param_name" => "d_chars_excerpt",
							"description" => __("Optional excerpt limit of chars to be displayed in excerpt when inside double width items.", 'iv_js_composer'),
							'dependency' => array('element' => 'ivan_enable_excerpt', 'value' => 'yes'),
						),
						
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable read more button?", 'iv_js_composer'),
						"param_name" => "ivan_enable_read_more",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						'dependency' => array('element' => 'ivan_enable_cover', 'value' => ''),
					), ////	
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Read More Button Text", 'iv_js_composer'),
						"param_name" => "ivan_enable_read_more_txt",
						"value" => '',
						'dependency' => array('element' => 'ivan_enable_read_more', 'value' => 'yes'),
					), ////
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("When click in project:", 'iv_js_composer'),
					"param_name" => "ivan_open",
					"value" => array(
						'Default' => '',
						'Lightbox' => 'lightbox',
						//'AJAX Box' => 'ajax',
					),
					"description" => __("What do when user clicks in a project? Default is follow the link normally.", 'iv_js_composer'),
				),

				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_projects', array(
						__( 'Default', 'iv_js_composer' ) => '',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Thumbnail", 'iv_js_composer'),
					"param_name" => "thumb_css",
					"customize" => $ivan_vc_projects->selectors['thumb_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Entry Infos", 'iv_js_composer'),
					"param_name" => "entry_css",
					"customize" => $ivan_vc_projects->selectors['entry_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_projects->selectors['title_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Categories/Filters", 'iv_js_composer'),
					"param_name" => "cats_css",
					"customize" => $ivan_vc_projects->selectors['cats_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Excerpt", 'iv_js_composer'),
					"param_name" => "excerpt_css",
					"customize" => $ivan_vc_projects->selectors['excerpt_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Read More Button", 'iv_js_composer'),
					"param_name" => "read_more_css",
					"customize" => $ivan_vc_projects->selectors['read_more_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "icon_css",
					"customize" => $ivan_vc_projects->selectors['icon_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Mark/Separator", 'iv_js_composer'),
					"param_name" => "mark_css",
					"customize" => $ivan_vc_projects->selectors['mark_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Filters", 'iv_js_composer'),
					"param_name" => "filter_css",
					"customize" => $ivan_vc_projects->selectors['filter_css'],
					"value" => "",
					"group" => __('Filters', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Bullets Navigation", 'iv_js_composer'),
					"param_name" => "bullets_css",
					"customize" => $ivan_vc_projects->selectors['bullets_css'],
					"value" => "",
					"group" => __('Carousel', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Arrows Navigation", 'iv_js_composer'),
					"param_name" => "navigation_css",
					"customize" => $ivan_vc_projects->selectors['navigation_css'],
					"value" => "",
					"group" => __('Carousel', 'iv_js_composer'),
				),
			),					
		)
	);

/***
 * Posts
***/
	// Call global var to use selectors array
	global $ivan_vc_posts;

	vc_map(
		array(
			'name' => __('Posts', 'iv_js_composer'),
			'base' => 'ivan_posts',
			'icon' => 'vc_info_box',
			'class' => 'ivan_posts',
			'category' => 'Elite Addons',
			'description' => 'Display a grid, carousel or list of your posts',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
				    "type" => "loop",
				    "heading" => __("Content", 'iv_js_composer'),
				    "param_name" => "loop",
				    'settings' => array(
				        'size' => array('hidden' => false, 'value' => 10),
				        'order_by' => array('value' => 'date'),
				    ),
				    "description" => __("Create WordPress loop, to populate content from your site.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"heading" => __("Image Size", 'iv_js_composer'),
					"param_name" => "ivan_img_size",
					"value" => ivan_vc_img_sizes(),
					"description" => __("Enter image size. Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by current theme. Leave empty to use default size.", 'iv_js_composer')
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Layout", 'iv_js_composer'),
					"param_name" => "layout",
					"value" => array(
						'Grid' => 'grid',
						'Masonry' => 'masonry',
						'Carousel' => 'carousel',
						'List Minimal' => 'list',
						'List with Thumb' => 'list-thumb',
					),
					"description" => __("Select the style to display the items.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Post Infos Style", 'iv_js_composer'),
					"param_name" => "post_style",
					"value" => array(
						'Default' => '',
						'Default Opaque' => ' default-opaque',
						'Border Cover' => ' border-cover',
						'Simple Centered' => ' simple-centered',
						'Bottom Cover' => ' bottom-cover',
					),
					"description" => __("Select the pre-defined styles avaliable to display the post infos.", 'iv_js_composer'),
					'dependency' => array('element' => 'layout', 'value' => array('grid', 'masonry', 'carousel') ),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Disable Gradient Overlay?", 'iv_js_composer'),
					"param_name" => "d_gradient",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Select yes to remove the gradient overlay from the thumbnail.", 'iv_js_composer'),
					'dependency' => array('element' => 'post_style', 'value' => array(' border-cover', ' bottom-cover') ),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Columns", 'iv_js_composer'),
					"param_name" => "ivan_columns",
					"value" => array(
						'Three' => '3',
						'Four' => '4',
						'Two' => '2',
						'One' => '1',
					),
					"description" => __("Select the columns layout to be applied.", 'iv_js_composer'),
					'dependency' => array('element' => 'layout', 'value' => array('grid', 'masonry', 'carousel') ),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Margin", 'iv_js_composer'),
					"param_name" => "ivan_margin",
					"value" => array(
						'Default Margin' => '',
						'No Margin' => ' no-margin',
						'Small Margin' => ' small-margin',
					),
					"description" => __("Select if items will have margins in items or not.", 'iv_js_composer'),
					'dependency' => array('element' => 'layout', 'value' => array('grid', 'masonry', 'carousel') ),
				),				
					
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable special layout?", 'iv_js_composer'),
						"param_name" => "special",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("Display the first posts in a featured position.", 'iv_js_composer'),
						'dependency' => array('element' => 'layout', 'value' => array('grid', 'masonry', 'list-thumb') ),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable special sizes?", 'iv_js_composer'),
						"param_name" => "enable_sizes",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("Display special sizes defined by tags 'full', 'double-width', 'double-height' and 'half-height' in the posts.", 'iv_js_composer'),
						'dependency' => array('element' => 'layout', 'value' => array('grid', 'masonry') ),
					),
					
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Navigation?", 'iv_js_composer'),
						"param_name" => "ivan_carousel_nav",
						"value" => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						"description" => __("Display directional arrows in carousel when activated.", 'iv_js_composer'),
						'dependency' => array('element' => 'layout', 'value' => 'carousel'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Only show arrows/navigation at hover?", 'iv_js_composer'),
						"param_name" => "arrows_hover",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("If enabled, arrows will be displayed only when user hover the carousel.", 'iv_js_composer'),
						'dependency' => array('element' => 'layout', 'value' => 'carousel'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Enable Bullets?", 'iv_js_composer'),
						"param_name" => "ivan_carousel_bullets",
						"value" => array(
							'No' => '',
							'Yes' => 'yes',
						),
						"description" => __("Display bullets bellow carousel when activated.", 'iv_js_composer'),
						'dependency' => array('element' => 'layout', 'value' => 'carousel'),
					),

					array(
						'type' => 'dropdown',
						'heading' => __( 'Nav and Bullets Style', 'iv_js_composer' ),
						'param_name' => 'arr_style',
						'value' => apply_filters( 'ivan_vc_carousel_styles', array(
							__( 'Outline Circle Light', 'iv_js_composer' ) => '',
							__( 'Outline Circle Dark', 'iv_js_composer' ) => 'style-outline-circle dark',
							__( 'Thin Outline Light', 'iv_js_composer' ) => 'style-thin-outline',
							__( 'Thin Outline Dark', 'iv_js_composer' ) => 'style-thin-outline dark',
							__( 'Opaque Box Light', 'iv_js_composer' ) => 'style-opaque-box',
							__( 'Opaque Box Dark', 'iv_js_composer' ) => 'style-opaque-box dark',
						) ),
						'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' ),
						'dependency' => array('element' => 'layout', 'value' => 'carousel'),
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Force Bullets be gray?", 'iv_js_composer'),
						"param_name" => "force_g",
						"value" => array(
							'Yes' => '',
							'No' => 'no',
						),
						"description" => __("If yes, bullets will be gray instead be light or dark with the arrows.", 'iv_js_composer'),
						'dependency' => array('element' => 'layout', 'value' => 'carousel'),
					),
				
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Disable Meta Infos?", 'iv_js_composer'),
					"param_name" => "no_meta",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Remove excerpt, category and date of post.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Disable Date?", 'iv_js_composer'),
					"param_name" => "no_date",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Remove date of post listing.", 'iv_js_composer'),
					'dependency' => array('element' => 'no_meta', 'value' => ''),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Disable Category?", 'iv_js_composer'),
					"param_name" => "no_cats",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Remove categories of post listing.", 'iv_js_composer'),
					'dependency' => array('element' => 'no_meta', 'value' => ''),
				),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Display only one category?", 'iv_js_composer'),
						"param_name" => "one_cat",
						"value" => array(
							'Yes' => '',
							'No' => 'no',
						),
						"description" => __("If enabled, only one category will be displayed.", 'iv_js_composer'),
						'dependency' => array('element' => 'no_meta', 'value' => ''),
					),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Remove excerpt?", 'iv_js_composer'),
					"param_name" => "no_excerpt",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					'description' => 'Remove excerpt from post display.',
					'dependency' => array('element' => 'no_meta', 'value' => ''),
				),

					array(
						"type" => "textfield",
						"heading" => __("Excerpt Chars", 'iv_js_composer'),
						"param_name" => "chars_excerpt",
						"description" => __("Optional excerpt limit of chars to be displayed in excerpt.", 'iv_js_composer'),
						'dependency' => array('element' => 'no_meta', 'value' => ''),
					),

					array(
						"type" => "textfield",
						"heading" => __("Double Width Excerpt Chars", 'iv_js_composer'),
						"param_name" => "d_chars_excerpt",
						"description" => __("Optional excerpt limit of chars to be displayed in excerpt when inside double width items.", 'iv_js_composer'),
						'dependency' => array('element' => 'no_meta', 'value' => ''),
					),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Zoom", 'iv_js_composer'),
					"param_name" => "ivan_zoom",
					"value" => array(
						'Yes' => ' zoom-hover',
						'No' => ' no-zoom',
					),
					"description" => __("Apply zoom when hover image.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect: Grayscale", 'iv_js_composer'),
					"param_name" => "ivan_gray",
					"value" => array(
						'No' => '',
						'Yes' => ' gray-enabled',
					),
					"description" => __("Apply grayscale effect in image and back to normal when hover image.", 'iv_js_composer'),
				),

				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),

				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_posts', array(
						__( 'Default', 'iv_js_composer' ) => '',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),			

				/////// Customizer Starts below...

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Block", 'iv_js_composer'),
					"param_name" => "post_css",
					"customize" => $ivan_vc_posts->selectors['post_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Thumbnail", 'iv_js_composer'),
					"param_name" => "thumb_css",
					"customize" => $ivan_vc_posts->selectors['thumb_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Entry Infos", 'iv_js_composer'),
					"param_name" => "entry_css",
					"customize" => $ivan_vc_posts->selectors['entry_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_posts->selectors['title_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Meta", 'iv_js_composer'),
					"param_name" => "meta_css",
					"customize" => $ivan_vc_posts->selectors['meta_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Excerpt", 'iv_js_composer'),
					"param_name" => "excerpt_css",
					"customize" => $ivan_vc_posts->selectors['excerpt_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Mark/Separator", 'iv_js_composer'),
					"param_name" => "mark_css",
					"customize" => $ivan_vc_posts->selectors['mark_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Bullets Navigation", 'iv_js_composer'),
					"param_name" => "bullets_css",
					"customize" => $ivan_vc_posts->selectors['bullets_css'],
					"value" => "",
					"group" => __('Carousel', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Arrows Navigation", 'iv_js_composer'),
					"param_name" => "navigation_css",
					"customize" => $ivan_vc_posts->selectors['navigation_css'],
					"value" => "",
					"group" => __('Carousel', 'iv_js_composer'),
				),
			),					
		)
	);

/***
 * Title Wrapper
***/
	// Call global var to use selectors array
	global $ivan_vc_title_wrapper;

	vc_map(
		array(
			'name' => __('Title Wrapper', 'iv_js_composer'),
			'base' => 'ivan_title',
			'icon' => 'vc_info_box',
			'class' => 'ivan_title',
			'category' => 'Elite Addons',
			'description' => 'Display a styled title wrapper with style options.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					'admin_label' => true,
					"param_name" => "content",
					"description" => __("Define the text and icons to be displayed. Use strong tag to display the text highlighted. Shortcodes and HTML tags accepted.", 'iv_js_composer'),
					'value' => 'Heading Text',
				),
				array(
					"type" => "dropdown",
					"heading" => "Title Tag",
					"param_name" => "title_tag",
					"value" => array(
						"Default"   => "",
						"h1" => "h1",
						"h2" => "h2",
						"h3" => "h3",
						"h4" => "h4",	
						"h5" => "h5",	
						"h6" => "h6",	
					),
					"description" => "Select the heading tag used in the title.",
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Icon Family", 'iv_js_composer'),
					"param_name" => "ico_family",
					"value" => array(
						'Font Awesome' => 'fa fa-',
						'Elegant Icons' => 'el el-',
						'Custom' => 'custom',
					),
					"description" => __("Select the icon family.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Icon Class", 'iv_js_composer'),
					"param_name" => "ico_custom",
					"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
					'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Icon Name", 'iv_js_composer'),
					"param_name" => "ico",
					"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Above Icon?", 'iv_js_composer'),
					"param_name" => "above_icon",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Display icon above title.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Align", 'iv_js_composer'),
					"param_name" => "align",
					"value" => array(
						'Center' => '',
						'Left' => 'left',
						'Right' => 'right',
					),
					"description" => __("Select main alignment of title.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display", 'iv_js_composer'),
					"param_name" => "display",
					"value" => array(
						'Default' => '',
						'Inline' => 'inline-block',
					),
					"description" => __("Select the display type of title.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Separator?", 'iv_js_composer'),
					"param_name" => "mark",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Select yes to display the separator below the title.", 'iv_js_composer'),
				),
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => __("Sub Title", 'iv_js_composer'),
					"param_name" => "sub",
					"description" => __("Define the text to be displayed below main title. Use strong tag to display the text highlighted. Shortcodes and HTML tags accepted.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),

				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_title_wrapper', array(
						__( 'Default', 'iv_js_composer' ) => '',
						'Gray' => 'gray-bg',
						'Dark' => 'dark-bg',
						'Clean' => 'clean-color',
						//'Light' => 'light-bg',
						'Primary' => 'primary-bg',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),

				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_title_wrapper->selectors['title_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Highlight/Link", 'iv_js_composer'),
					"param_name" => "highlight_css",
					"customize" => $ivan_vc_title_wrapper->selectors['highlight_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Sub Title", 'iv_js_composer'),
					"param_name" => "subtitle_css",
					"customize" => $ivan_vc_title_wrapper->selectors['subtitle_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Mark/Separator", 'iv_js_composer'),
					"param_name" => "mark_css",
					"customize" => $ivan_vc_title_wrapper->selectors['mark_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "icon_css",
					"customize" => $ivan_vc_title_wrapper->selectors['icon_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end				
		)// #setting array end
	);// #map end


/***
 * Counter
***/
	// Call global var to use selectors array
	global $ivan_vc_counter;

	vc_map(
		array(
			'name' => __('Counter', 'iv_js_composer'),
			'base' => 'ivan_counter',
			'icon' => 'vc_info_box',
			'class' => 'ivan_counter',
			'category' => 'Elite Addons',
			'description' => 'Display a styled counter/info that can be animated.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => __("Title/Number", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Define main number. If you are using animated option, do not use ',' - configure it in the animation options.", 'iv_js_composer'),
					'value' => '500',
				),
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => __("Sub Title/Label", 'iv_js_composer'),
					"param_name" => "sub",
					"description" => __("Define the text to be displayed below main title. Use strong tag to display the text highlighted. Shortcodes and HTML tags accepted.", 'iv_js_composer'),
					'value' => __('Satisfied Clients', 'iv_js_composer'),
					'admin_label' => true,
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Icon Family", 'iv_js_composer'),
					"param_name" => "ico_family",
					"value" => array(
						'Font Awesome' => 'fa fa-',
						'Elegant Icons' => 'el el-',
						'Custom' => 'custom',
					),
					"description" => __("Select the icon family.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Custom Icon Class", 'iv_js_composer'),
					"param_name" => "ico_custom",
					"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
					'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Icon Name", 'iv_js_composer'),
					"param_name" => "ico",
					"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
					'value' => '',
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Animated Counter?", 'iv_js_composer'),
					"param_name" => "animated",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("Enable animated counter in title/number.", 'iv_js_composer'),
				),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Separator", 'iv_js_composer'),
						"param_name" => "separator",
						"value" => '',
						"description" => __("Separator to thousand values like 1000 would become 1,000. Default is ','.", 'iv_js_composer'),
						'dependency' => array('element' => 'animated', 'value' => 'yes'),
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Decimals", 'iv_js_composer'),
						"param_name" => "decimals",
						"value" => '',
						"description" => __("Number of decimals places in the number, default is 0.", 'iv_js_composer'),
						'dependency' => array('element' => 'animated', 'value' => 'yes'),
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Decimal Separator", 'iv_js_composer'),
						"param_name" => "decimal",
						"value" => '',
						"description" => __("Separator to decimal part of the number, default is '.'", 'iv_js_composer'),
						'dependency' => array('element' => 'animated', 'value' => 'yes'),
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Prefix", 'iv_js_composer'),
						"param_name" => "prefix",
						"value" => '',
						"description" => __("Prefix to add before number, e.g. '$'", 'iv_js_composer'),
						'dependency' => array('element' => 'animated', 'value' => 'yes'),
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Sufix", 'iv_js_composer'),
						"param_name" => "sufix",
						"value" => '',
						"description" => __("Sufix to add after number, e.g. '%'", 'iv_js_composer'),
						'dependency' => array('element' => 'animated', 'value' => 'yes'),
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Start", 'iv_js_composer'),
						"param_name" => "start",
						"value" => '',
						"description" => __("Number from where start to count, default is start from 0.", 'iv_js_composer'),
						'dependency' => array('element' => 'animated', 'value' => 'yes'),
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Duration", 'iv_js_composer'),
						"param_name" => "duration",
						"value" => '',
						"description" => __("Duration in seconds of the animation, default is 2.5 seconds. Do not use ',' - use '.' instead.", 'iv_js_composer'),
						'dependency' => array('element' => 'animated', 'value' => 'yes'),
					),

				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),

				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_counter', array(
						__( 'Default', 'iv_js_composer' ) => '',
						'Gray' => 'gray-bg',
						//'Dark' => 'dark-bg',
						'Clean' => 'clean-color',
						//'Light' => 'light-bg',
						//'Primary' => 'primary-bg',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),
				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Main Block", 'iv_js_composer'),
					"param_name" => "block_css",
					"customize" => $ivan_vc_counter->selectors['block_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Title", 'iv_js_composer'),
					"param_name" => "title_css",
					"customize" => $ivan_vc_counter->selectors['title_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Sub Title", 'iv_js_composer'),
					"param_name" => "subtitle_css",
					"customize" => $ivan_vc_counter->selectors['subtitle_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Icon", 'iv_js_composer'),
					"param_name" => "icon_css",
					"customize" => $ivan_vc_counter->selectors['icon_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end				
		)// #setting array end
	);// #map end

/***
 * Carousel
***/
	// Call global var to use selectors array
	global $ivan_vc_carousel;

	vc_map( array(
		"name" => __("Anything Carousel", 'iv_js_composer'),
		"base" => "ivan_carousel",
		'icon' => 'vc_info_box',
		//"as_parent" => array('only' => 'vc_column'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		"is_container" => true,
		"content_element" => true,
		"show_settings_on_create" => false,
		'category' => 'Elite Addons',
		'description' => 'Use to display other modules inside a carousel.',
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Number of Columns", 'iv_js_composer'),
				"param_name" => "ivan_columns",
				"value" => '1',
				"description" => __("Number of items the carousel will display.", 'iv_js_composer'),
			),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Columns (Normal Desktop)", 'iv_js_composer'),
					"param_name" => "ivan_columns_desktop",
					"value" => '',
					"description" => __("Number of items the carousel will display. Default: at <1199px - 4 items.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Columns (Small Desktop)", 'iv_js_composer'),
					"param_name" => "ivan_columns_desktop_small",
					"value" => '',
					"description" => __("Number of items the carousel will display. Default: at <980px - 3 items.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Columns (Tablet)", 'iv_js_composer'),
					"param_name" => "ivan_columns_tablet",
					"value" => '',
					"description" => __("Number of items the carousel will display. Default: at <768px - 2 items.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Number of Columns (Mobile)", 'iv_js_composer'),
					"param_name" => "ivan_columns_mobile",
					"value" => '',
					"description" => __("Number of items the carousel will display. Default: at <479px - 1 item.", 'iv_js_composer'),
				),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Margin Type", 'iv_js_composer'),
				"param_name" => "margin",
				"value" => array(
					'No Margin' => '',
					'Normal Margin' => 'normal',
				),
				"description" => __("Define items margin, normal margin uses default margin space.", 'iv_js_composer'),
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Enable Navigation?", 'iv_js_composer'),
				"param_name" => "ivan_carousel_nav",
				"value" => array(
					'No' => 'no',
					'Yes' => 'yes',
				),
				"description" => __("Display directional arrows in carousel when activated.", 'iv_js_composer'),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Enable Bullets?", 'iv_js_composer'),
				"param_name" => "ivan_carousel_bullets",
				"value" => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				"description" => __("Display bullets bellow carousel when activated.", 'iv_js_composer'),
			),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Horizontal Bullets Position", 'iv_js_composer'),
					"param_name" => "ivan_bullets_h",
					"value" => array(
						'Default' => '',
						'Center' => 'h-center',
						'Left' => 'h-left',
						'Right' => 'h-right',
					),
					"description" => __("Align properly the carousel bullets.", 'iv_js_composer'),
					'dependency' => array('element' => 'ivan_carousel_bullets', 'value' => 'yes'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Vertical Bullets Position", 'iv_js_composer'),
					"param_name" => "ivan_bullets_v",
					"value" => array(
						'Default' => '',
						'Inside Bottom' => 'v-bottom',
						'Inside Top' => 'v-top',
					),
					"description" => __("Align properly the carousel bullets.", 'iv_js_composer'),
					'dependency' => array('element' => 'ivan_carousel_bullets', 'value' => 'yes'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Only show arrows at hover?", 'iv_js_composer'),
					"param_name" => "arrows_hover",
					"value" => array(
						'No' => '',
						'Yes' => 'yes',
					),
					"description" => __("If enabled, arrows will be displayed only when user hover the carousel.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Enable mouse drag?", 'iv_js_composer'),
					"param_name" => "mouse_drag",
					"value" => array(
						'Yes' => 'yes',
						'No' => 'no',
					),
					"description" => __("If enabled, user will be able to drag in order to slide the carousel.", 'iv_js_composer'),
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Nav and Bullets Style', 'iv_js_composer' ),
				'param_name' => 'arr_style',
				'value' => apply_filters( 'ivan_vc_carousel_styles', array(
					__( 'Outline Circle Light', 'iv_js_composer' ) => '',
					__( 'Outline Circle Dark', 'iv_js_composer' ) => 'style-outline-circle dark',
					__( 'Thin Outline Light', 'iv_js_composer' ) => 'style-thin-outline',
					__( 'Thin Outline Dark', 'iv_js_composer' ) => 'style-thin-outline dark',
					__( 'Opaque Box Light', 'iv_js_composer' ) => 'style-opaque-box',
					__( 'Opaque Box Dark', 'iv_js_composer' ) => 'style-opaque-box dark',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Force Bullets be gray?", 'iv_js_composer'),
				"param_name" => "force_g",
				"value" => array(
					'Yes' => '',
					'No' => 'no',
				),
				"description" => __("If yes, bullets will be gray instead be light or dark with the arrows.", 'iv_js_composer'),
				'dependency' => array('element' => 'ivan_bullets_v', 'value' => ''),
			),

			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'iv_js_composer'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
			),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Template', 'iv_js_composer' ),
				'param_name' => 'template',
				'admin_label' => true,
				'value' => apply_filters( 'ivan_vc_carousel', array(
					__( 'Default', 'iv_js_composer' ) => '',
				) ),
				'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
			),

			array(
				"type" => "ivan_customizer_id",
				"heading" => __("Customization ID", 'iv_js_composer'),
				"param_name" => "c_id",
				"value" => "",
			),

			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Carousel", 'iv_js_composer'),
				"param_name" => "block_css",
				"customize" => $ivan_vc_carousel->selectors['block_css'],
				"value" => "",
				"group" => __('Carousel', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Bullets Navigation", 'iv_js_composer'),
				"param_name" => "bullets_css",
				"customize" => $ivan_vc_carousel->selectors['bullets_css'],
				"value" => "",
				"group" => __('Carousel', 'iv_js_composer'),
			),
			array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Arrows Navigation", 'iv_js_composer'),
				"param_name" => "navigation_css",
				"customize" => $ivan_vc_carousel->selectors['navigation_css'],
				"value" => "",
				"group" => __('Carousel', 'iv_js_composer'),
			),
		),
		"js_view" => 'VcColumnView'
	) );

/***
 * Contact Form
***/
	// Call global var to use selectors array
	global $ivan_vc_contact_form;

	vc_map(
		array(
			'name' => __('Forms', 'iv_js_composer'),
			'base' => 'ivan_contact',
			'icon' => 'vc_info_box',
			'class' => 'ivan_contact_form',
			'category' => 'Elite Addons',
			'description' => 'Style and display any form avaliable.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Contact Form Shortcode", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Insert here your contact form shortcode to be displayed.", 'iv_js_composer'),
					'value' => '',
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_contact_form', array(
						__( 'Default', 'iv_js_composer' ) => '',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),
				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),		
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Label", 'iv_js_composer'),
					"param_name" => "label_css",
					"customize" => $ivan_vc_contact_form->selectors['label_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Inputs", 'iv_js_composer'),
					"param_name" => "input_css",
					"customize" => $ivan_vc_contact_form->selectors['input_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Submit", 'iv_js_composer'),
					"param_name" => "submit_css",
					"customize" => $ivan_vc_contact_form->selectors['submit_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Error Message", 'iv_js_composer'),
					"param_name" => "error_css",
					"customize" => $ivan_vc_contact_form->selectors['error_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end				
		)// #setting array end
	);// #map end

/***
 * Testimonial
***/

	// Call global var to use selectors array
	global $ivan_vc_testimonial;

	vc_map(
		array(
			'name' => __('Testimonial', 'iv_js_composer'),
			'base' => 'ivan_testimonial',
			'icon' => 'vc_info_box',
			'class' => 'ivan_testimonial',
			'category' => 'Elite Addons',
			'description' => 'Display testimonials in a lot of styles.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => __("Testimonial", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("What did the customer said, here you define what will be displayed.", 'iv_js_composer'),
					'value' => '',
				),

				array(
					"type" => "textfield",
					"heading" => __("Author", 'iv_js_composer'),
					"param_name" => "author",
					"description" => __("The author name, e.g. Carl James via Twitter.", 'iv_js_composer')
				),

				array(
					"type" => "textfield",
					"heading" => __("Author Description", 'iv_js_composer'),
					"param_name" => "desc",
					"description" => __("Small text displayed below Author name, e.g. Creative Director.", 'iv_js_composer')
				),

				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Author Image", 'iv_js_composer'),
					"param_name" => "image_id",
					"value" => "",
					"description" => __("Upload or select background image from media gallery. Use a size like 100x100 for example.", 'iv_js_composer'),
				),

				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Quote Style", 'iv_js_composer'),
					"param_name" => "q_style",
					"value" => array(
						'Centered Text' => '',
						'Boxed with Arrow' => 'boxed-left',
						'Image Left' => 'image-left',
						'Image Right' => 'image-right',
					),
					"description" => __("Select main alignment of quote.", 'iv_js_composer'),
				),

				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_testimonial', array(
						__( 'Default', 'iv_js_composer' ) => '',
						//'Gray' => 'gray-bg',
						'Dark' => 'dark-bg',
						'Clean' => 'clean-color',
						//'Light' => 'light-bg',
						'Primary' => 'primary-bg',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),	

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),
		
				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Testimonial Block", 'iv_js_composer'),
					"param_name" => "block_css",
					"customize" => $ivan_vc_testimonial->selectors['block_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Author Name", 'iv_js_composer'),
					"param_name" => "author_css",
					"customize" => $ivan_vc_testimonial->selectors['author_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Author Description", 'iv_js_composer'),
					"param_name" => "desc_css",
					"customize" => $ivan_vc_testimonial->selectors['desc_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Author Image", 'iv_js_composer'),
					"param_name" => "img_css",
					"customize" => $ivan_vc_testimonial->selectors['img_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				
			),// #params end				
		)// #setting array end
	);// #map end

/***
 * Table
***/
	// Call global var to use selectors array
	global $ivan_vc_table;

	vc_map(
		array(
			'name' => __('Table Styled', 'iv_js_composer'),
			'base' => 'ivan_table',
			'icon' => 'vc_info_box',
			'class' => 'ivan_table',
			'category' => 'Elite Addons',
			'description' => 'Display an interface to customize tables.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => __("Table", 'iv_js_composer'),
					"param_name" => "content",
					"description" => __("Insert here the table to be displayed as content.", 'iv_js_composer'),
					'value' => '',
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_table', array(
						__( 'Default', 'iv_js_composer' ) => '',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Table", 'iv_js_composer'),
					"param_name" => "table_css",
					"customize" => $ivan_vc_table->selectors['table_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Table Heading (th)", 'iv_js_composer'),
					"param_name" => "th_css",
					"customize" => $ivan_vc_table->selectors['th_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Table Heading Odd (th)", 'iv_js_composer'),
					"param_name" => "th_odd_css",
					"customize" => $ivan_vc_table->selectors['th_odd_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Table Item (td)", 'iv_js_composer'),
					"param_name" => "td_css",
					"customize" => $ivan_vc_table->selectors['td_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Table Odd Item (td)", 'iv_js_composer'),
					"param_name" => "td_odd_css",
					"customize" => $ivan_vc_table->selectors['td_odd_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Table Odd Col (td)", 'iv_js_composer'),
					"param_name" => "col_odd_css",
					"customize" => $ivan_vc_table->selectors['col_odd_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Table Footer (tfoot)", 'iv_js_composer'),
					"param_name" => "tfoot_css",
					"customize" => $ivan_vc_table->selectors['tfoot_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),

			),// #params end				
		)// #setting array end
	);// #map end


/***
 * Text Block
***/

global $ivan_vc_text;

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer_id",
		"heading" => __("Customization ID", 'iv_js_composer'),
		"param_name" => "c_id",
		"value" => "",
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("H1 Customization", 'iv_js_composer'),
		"param_name" => "h1_css",
		"customize" => $ivan_vc_text->selectors['h1_css'],
		"value" => "",
		"group" => __('H1', 'iv_js_composer'),
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("H2 Customization", 'iv_js_composer'),
		"param_name" => "h2_css",
		"customize" => $ivan_vc_text->selectors['h2_css'],
		"value" => "",
		"group" => __('H2', 'iv_js_composer'),
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("H3 Customization", 'iv_js_composer'),
		"param_name" => "h3_css",
		"customize" => $ivan_vc_text->selectors['h3_css'],
		"value" => "",
		"group" => __('H3', 'iv_js_composer'),
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("H4 Customization", 'iv_js_composer'),
		"param_name" => "h4_css",
		"customize" => $ivan_vc_text->selectors['h4_css'],
		"value" => "",
		"group" => __('H4', 'iv_js_composer'),
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("H5 Customization", 'iv_js_composer'),
		"param_name" => "h5_css",
		"customize" => $ivan_vc_text->selectors['h5_css'],
		"value" => "",
		"group" => __('H5', 'iv_js_composer'),
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("H6 Customization", 'iv_js_composer'),
		"param_name" => "h6_css",
		"customize" => $ivan_vc_text->selectors['h6_css'],
		"value" => "",
		"group" => __('H6', 'iv_js_composer'),
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Paragraph Customization", 'iv_js_composer'),
		"param_name" => "p_css",
		"customize" => $ivan_vc_text->selectors['p_css'],
		"value" => "",
		"group" => __('Paragraph', 'iv_js_composer'),
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Link Customization", 'iv_js_composer'),
		"param_name" => "link_css",
		"customize" => $ivan_vc_text->selectors['link_css'],
		"value" => "",
		"group" => __('Link', 'iv_js_composer'),
	));

	vc_add_param("vc_column_text", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("List Customization", 'iv_js_composer'),
		"param_name" => "list_css",
		"customize" => $ivan_vc_text->selectors['list_css'],
		"value" => "",
		"group" => __('List', 'iv_js_composer'),
	));

/***
 * WooCommerce
***/
	// Call global var to use selectors array
	global $ivan_vc_woo;

	vc_map(
		array(
			'name' => __('WooCommerce', 'iv_js_composer'),
			'base' => 'ivan_woo',
			'icon' => 'vc_info_box',
			'class' => 'ivan_woo',
			'category' => 'Elite Addons',
			'description' => 'Display WooCommerce products easily.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display", 'iv_js_composer'),
					"param_name" => "code",
					"value" => array(
						'Recent' => 'recent_products',
						'Featured' => 'featured_products',
						'On Sale' => 'sale_products',
						'Best Selling' => 'best_selling_products',
						'Top Rated' => 'top_rated_products',
						'Products by ID' => 'products',
					),
					"description" => __("Define button size.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Per Page", 'iv_js_composer'),
					"param_name" => "per_page",
					"value" => "4",
					"description" => __("Defines the number of products to be displayed.", 'iv_js_composer')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Columns", 'iv_js_composer'),
					"param_name" => "columns",
					"value" => array(
						"Four" => "4",
						"Three" => "3",
						"Two" => "2",
						"One" => "1",
					),
					"description" => __("Define columns numbers to be displayed.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("IDs", 'iv_js_composer'),
					"param_name" => "ids",
					"description" => __("Comma separated products IDs to be displayed.", 'iv_js_composer'),
					'dependency' => array('element' => 'code', 'value' => 'products'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
			),// #params end				
		)// #setting array end
	);// #map end

/***
 * Tweet
***/
	// Call global var to use selectors array
	global $ivan_vc_tweet;

	vc_map(
		array(
			'name' => __('Latest Tweet', 'iv_js_composer'),
			'base' => 'ivan_tweet',
			'icon' => 'vc_info_box',
			'class' => 'ivan_tweet',
			'category' => 'Elite Addons',
			'description' => 'Display your latest tweet.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Template', 'iv_js_composer' ),
					'param_name' => 'template',
					'admin_label' => true,
					'value' => apply_filters( 'ivan_vc_tweet', array(
						__( 'Default', 'iv_js_composer' ) => '',
						'Clean' => 'clean-color',
					) ),
					'description' => __( 'Select a default template to start and maybe customize it. Usually the templates are added by themes.', 'iv_js_composer' )
				),

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),

				//
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Tweet", 'iv_js_composer'),
					"param_name" => "tweet_css",
					"customize" => $ivan_vc_tweet->selectors['tweet_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Tweet Date", 'iv_js_composer'),
					"param_name" => "meta_css",
					"customize" => $ivan_vc_tweet->selectors['meta_css'],
					"value" => "",
					"group" => __('Customizer', 'iv_js_composer'),
				),
			),// #params end				
		)// #setting array end
	);// #map end

/***
 * Posts
***/
	// Call global var to use selectors array
	global $ivan_vc_gmap;

	vc_map(
		array(
			'name' => __('Google Maps', 'iv_js_composer'),
			'base' => 'ivan_gmap',
			'icon' => 'vc_info_box',
			'class' => 'ivan_gmap',
			'category' => 'Elite Addons',
			'description' => 'Display a powerful Google Maps module with more options.',
			'controls' => 'full',
			'show_settings_on_create' => true,
			'params' => array(
				array(
					"type" => "textfield",
					"heading" => __("Address", 'iv_js_composer'),
					"param_name" => "address",
					"description" => __("Add the location address like street name, city, state, country. Leave blank to use latitude and longitude instead address.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Latitude", 'iv_js_composer'),
					"param_name" => "lat",
					"description" => __("Add the latitude coordinate of the address.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Longitude", 'iv_js_composer'),
					"param_name" => "long",
					"description" => __("Add the longitude coordinate of the address.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Height", 'iv_js_composer'),
					"param_name" => "height",
					"description" => __("Custom height without px, only numbers. Default is 350.", 'iv_js_composer'),
				),
				array(
					"type" => "textfield",
					"heading" => __("Zoom", 'iv_js_composer'),
					"param_name" => "zoom",
					"description" => __("Define a zoom number from 1 (lowest) to 19 (max zoom). Default is 16.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Scroll Zoom?", 'iv_js_composer'),
					"param_name" => "scroll",
					"value" => array(
						"Yes" => "true",
						"No" => "false",
					),
					"description" => __("Allow users zoom the map with scrollwheel of mouse.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Draggable?", 'iv_js_composer'),
					"param_name" => "drag",
					"value" => array(
						"Yes" => "true",
						"No" => "false",
					),
					"description" => __("Allow users move the map with mouse.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Remove UI?", 'iv_js_composer'),
					"param_name" => "noui",
					"value" => array(
						"No" => "false",
						"Yes" => "true",	
					),
					"description" => __("If yes, the default GMap UI (zoom, move tools) will be removed.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Grayscale Map Effect?", 'iv_js_composer'),
					"param_name" => "grayscale",
					"value" => array(
						"No" => "",
						"Yes" => "yes",	
					),
					"description" => __("If yes, the map will be displayed in grayscale.", 'iv_js_composer'),
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Add Marker at Location?", 'iv_js_composer'),
					"param_name" => "marker",
					"value" => array(
						"No" => "",
						"Yes" => "yes",	
					),
					"description" => __("If yes, a custom marker will be displayed at location.", 'iv_js_composer'),
				),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Icon Family", 'iv_js_composer'),
						"param_name" => "ico_family",
						"value" => array(
							'Font Awesome' => '',
							'Elegant Icons' => 'el el-',
							'Custom' => 'custom',
						),
						"description" => __("Select the icon family.", 'iv_js_composer'),
						'dependency' => array('element' => 'marker', 'value' => 'yes'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Custom Icon Class", 'iv_js_composer'),
						"param_name" => "ico_custom",
						"description" => __("Type a custom icon class to be used in the icon.", 'iv_js_composer'),
						'dependency' => array('element' => 'ico_family', 'value' => 'custom'),
					),
					array(
						"type" => "textfield",
						"heading" => __("Icon Name", 'iv_js_composer'),
						"param_name" => "ico",
						"description" => __("Type icon name without prefixes, e.g. cogs or eye.", 'iv_js_composer'),
						'dependency' => array('element' => 'marker', 'value' => 'yes'),
					),

					array(
						"type" => "attach_image",
						"heading" => "Image Icon",
						"param_name" => "ico_image",
						'description' => 'Replace font icon with an image file.',
						'dependency' => array('element' => 'marker', 'value' => 'yes'),
					),

				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'iv_js_composer'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'iv_js_composer')
				),

				array(
					"type" => "ivan_customizer_id",
					"heading" => __("Customization ID", 'iv_js_composer'),
					"param_name" => "c_id",
					"value" => "",
				),

				/////// Customizer Starts below...
				array(
					"type" => "ivan_customizer",
					"class" => "",
					"heading" => __("Marker", 'iv_js_composer'),
					"param_name" => "marker_css",
					"customize" => $ivan_vc_gmap->selectors['marker_css'],
					"value" => "",
					"group" => __('Customization', 'iv_js_composer'),
				),
			),					
		)
	);

/***
 * Widget Area
***/
	// Call global var to use selectors array
	global $ivan_vc_widgets;

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer_id",
		"heading" => __("Customization ID", 'iv_js_composer'),
		"param_name" => "c_id",
		"value" => "",
	));

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Widget Block", 'iv_js_composer'),
		"param_name" => "widget_css",
		"customize" => $ivan_vc_widgets->selectors['widget_css'],
		"value" => "",
		"group" => __('Widget Block', 'iv_js_composer'),
	));

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Widget Title", 'iv_js_composer'),
		"param_name" => "title_css",
		"customize" => $ivan_vc_widgets->selectors['title_css'],
		"value" => "",
		"group" => __('Widget Block', 'iv_js_composer'),
	));

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Paragraph Customization", 'iv_js_composer'),
		"param_name" => "p_css",
		"customize" => $ivan_vc_widgets->selectors['p_css'],
		"value" => "",
		"group" => __('Widget Content', 'iv_js_composer'),
	));

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Link Customization", 'iv_js_composer'),
		"param_name" => "link_css",
		"customize" => $ivan_vc_widgets->selectors['link_css'],
		"value" => "",
		"group" => __('Widget Content', 'iv_js_composer'),
	));

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("List Customization", 'iv_js_composer'),
		"param_name" => "list_css",
		"customize" => $ivan_vc_widgets->selectors['list_css'],
		"value" => "",
		"group" => __('Widget Content', 'iv_js_composer'),
	));

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Label Customization", 'iv_js_composer'),
		"param_name" => "label_css",
		"customize" => $ivan_vc_widgets->selectors['label_css'],
		"value" => "",
		"group" => __('Widget Form', 'iv_js_composer'),
	));

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Input Customization", 'iv_js_composer'),
		"param_name" => "input_css",
		"customize" => $ivan_vc_widgets->selectors['input_css'],
		"value" => "",
		"group" => __('Widget Form', 'iv_js_composer'),
	));

	vc_add_param("vc_widget_sidebar", array(
		"type" => "ivan_customizer",
		"class" => "",
		"heading" => __("Submit Customization", 'iv_js_composer'),
		"param_name" => "submit_css",
		"customize" => $ivan_vc_widgets->selectors['submit_css'],
		"value" => "",
		"group" => __('Widget Form', 'iv_js_composer'),
	));