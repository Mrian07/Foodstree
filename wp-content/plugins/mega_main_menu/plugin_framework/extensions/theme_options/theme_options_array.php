<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	function mmpm_theme_options_array(){
		
		foreach ( get_nav_menu_locations() as $key => $value ){
			$key = str_replace( ' ', '-', $key );
			$theme_menu_locations[ $key ] = $key;
		}
		

		$locations_options = array(
			array(
				'name' => __( 'Change structure settings of theme locations below.', MMPM_TEXTDOMAIN_ADMIN ),
				'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
				'key' => 'primary_settings',
				'type' => 'caption',
			),
		);

		/*
		if ( isset( $theme_menu_locations ) && is_array( $theme_menu_locations ) ) {
			$locations_options[] = array(
				'name' => __( 'You can activate Mega Main Menu in such locations:', MMPM_TEXTDOMAIN_ADMIN ),
				'descr' => __( 'Mega Main Menu and its settings will be displayed in selected locations only after the activation of this location.', MMPM_TEXTDOMAIN_ADMIN ),
				'key' => 'mega_menu_locations',
				'type' => 'checkbox',
				'values' => apply_filters('ivan_megamenu_locations', $theme_menu_locations),
			);
		} else {
			$locations_options[] = array(
				'name' => __( 'Firstly, You need to create at least one menu', MMPM_TEXTDOMAIN_ADMIN ) . ' (<a href="' . home_url() . '/wp-admin/nav-menus.php">' . __( 'Theme Menu Settings', MMPM_TEXTDOMAIN_ADMIN ) . '</a>) ' . __( 'and set theme-location for him', MMPM_TEXTDOMAIN_ADMIN ) . ' (<a href="' . home_url() . '/wp-admin/nav-menus.php?action=locations">' . __( 'Theme Menu Locations', MMPM_TEXTDOMAIN_ADMIN ) . '</a>).',
				'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
				'key' => 'no_locations',
				'type' => 'caption',
			);
		}
		*/
		

		foreach ( get_nav_menu_locations() as $key => $value ){
			$key = str_replace( ' ', '-', $key );
			$locations_options = array_merge( 
				$locations_options, array(
					array(
						'name' =>  __( 'Layout Options For: ', MMPM_TEXTDOMAIN_ADMIN ) . '&nbsp; <strong>' . $key . '</strong>',
						'key' => $key . '_menu_options',
						'type' => 'collapse_start',
					),
					
					array(
						'name' => __( 'Location of icon in first level elements', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Choose where to locate icon for first level items.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_first_level_icons_position',
						'type' => 'select',
						'values' => array(
							__( 'Left', MMPM_TEXTDOMAIN_ADMIN ) => 'left',
							__( 'Above', MMPM_TEXTDOMAIN_ADMIN ) => 'top',
							__( 'Right', MMPM_TEXTDOMAIN_ADMIN ) => 'right',
							__( 'Disable Icons', MMPM_TEXTDOMAIN_ADMIN ) => 'disable_first_lvl',
							__( 'Disable Icons Globally', MMPM_TEXTDOMAIN_ADMIN ) => 'disable_globally',
						),
						'default' => array( 'left', ),
					),
					array(
						'name' => __( 'Dropdowns Animation:', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Select the type of animation to displaying dropdowns. <span style="color: #f11;">Warning:</span> Animation correctly works only in the latest versions of progressive browsers.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_dropdowns_animation',
						'type' => 'select',
						'values' => array(
							__( 'Fading', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_2',
							__( 'None', MMPM_TEXTDOMAIN_ADMIN ) => 'none',
							__( 'Unfold', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_1',
							__( 'Scale', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_3',
							__( 'Down to Up', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_4',
							__( 'Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_5',
						),
						'default' => array( 'anim_2', ),
					),
					/*
					array(
						'name' => __( 'Direction', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Here you can determine the direction of the menu. Horizontal for classic top menu bar. Vertical for sidebar menu.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_direction',
						'type' => 'select',
						'values' => array(
							__( 'Horizontal', MMPM_TEXTDOMAIN_ADMIN ) => 'horizontal',
							__( 'Vertical', MMPM_TEXTDOMAIN_ADMIN ) => 'vertical',
						),
						'default' => array( 'horizontal' ),
	                    'dependency' => array(
	                        'element' => array( 
	                            $key . '_sticky_status', 
	                            $key . '_sticky_offset', 
	                        ),
	                        'value' => 'horizontal',
	                    ),
					),
					*/
					array(
						'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'type' => 'collapse_end',
					),
				) // 'options' => array
			);
		};

		$locations_options = array_merge( 
			$locations_options, array(
				array(
					'name' => __( 'Logo Settings', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'mega_menu_logo',
					'type' => 'caption',
				),
				array(
					'name' => __( 'The logo file', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( "Select image to be used as logo in Main Mega Menu. It's recommended to use image with transparent background (.PNG) and sizes like 50x50 pixels.", MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'logo_src',
					'type' => 'file',
					'default' => MMPM_IMG_URI . '/megamain-logo-120x120.png',
				),
				array(
					'name' => __( 'Maximum Logo Width', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( 'Maximum logo width to avoid issues with menu size.', MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'logo_width',
					'min' => 10,
					'max' => 200,
					'units' => 'px',
					'type' => 'number',
					'default' => 50,
				),
				array(
					'name' => __( 'Maximum Logo Height', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( 'Maximum logo height to avoid issues with menu size.', MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'logo_height',
					'min' => 10,
					'max' => 200,
					'units' => 'px',
					'type' => 'number',
					'default' => 50,
				),
				array(
					'name' => __( 'Backup of the settings', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( 'You can make a backup of the plugin settings and restore this settings later. Notice: Options of each menu item from the section "Menu Structure" is not imported.', MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'backup',
					'type' => 'just_html',
					'default' => '<a href="http://menu.megamain.dev/wp-admin/?mmpm_page=backup_file">' . __( 'Download backup file with current settings') . '</a><br /><br />' . __( 'Upload backup file and restore settings. Chose file and click "Save All Settings".') . '<br /><input class="col-xs-12 form-control input-sm" type="file" name="' . MMPM_OPTIONS_DB_NAME . '_backup" />',
				),
			) // 'options' => array
		);

		$skins_options = array(
			array(
				'name' => __( 'You can change any properties for any menu location', MMPM_TEXTDOMAIN_ADMIN ),
				'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
				'key' => 'mega_menu_skins',
				'type' => 'caption',
			)
		);
		$skins_options = array_merge( 
			$skins_options, array(
				array(
					'name' => __( 'Custom Icons', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( 'You can add custom raster icons. After saving these settings, icons will become available in a modal window of icons selection. Recommended size 64x64 pixels.', MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'set_of_custom_icons',
					'type' => 'multiplier',
					'default' => '1',
					'values' => array(
						array(
							'name' => __( 'Custom Icon 1', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'icon_item',
							'type' => 'collapse_start',
						),
						array(
							'name' => __( 'Icon File', MMPM_TEXTDOMAIN_ADMIN ),
							'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'custom_icon',
							'type' => 'file',
							'default' => MMPM_IMG_URI . '/megamain-logo-120x120.png',
						),
						array(
							'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'icon_item',
							'type' => 'collapse_end',
						),
					),
				),
			)
		);

		return array(
			array(
				'title' => 'General',
				'key' => 'general',
				'icon' => 'im-icon-wrench-3',
				'options' => $locations_options,
			),
			array(
				'title' => 'Skins',
				'key' => 'skins',
				'icon' => 'im-icon-brush',
				'options' => $skins_options, // 'options' => array
			),
/*
			array(
				'title' => 'Google Fonts',
				'key' => 'custom_fonts',
				'icon' => 'im-icon-font',
				'options' => array(
					array(
						'name' => __( 'Set of Installed Fonts', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Select the fonts to be included on the site. Remember that a lot of fonts affect on the speed of load page. Always remove unnecessary fonts. Font faces can see on this page - ', MMPM_TEXTDOMAIN_ADMIN ) . '<a href="http://www.google.com/fonts" target="_blank">Google fonts</a>',
						'key' => 'set_of_google_fonts',
						'type' => 'multiplier',
						'default' => '1',
						'values' => array(
							array(
								'name' => __( 'Font 1', MMPM_TEXTDOMAIN_ADMIN ),
								'key' => 'contact_item',
								'type' => 'collapse_start',
							),
							array(
								'name' => __( 'Fonts Faily', MMPM_TEXTDOMAIN_ADMIN ),
								'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
								'key' => 'family',
								'type' => 'select',
								'values' => mmpm_get_googlefonts_list(),
								'default' => 'Open Sans'
							),
							array(
								'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
								'key' => 'contact_item',
								'type' => 'collapse_end',
							),
						),
					),
				), // 'options' => array
			),
*/
			array(
				'title' => 'Specific Options',
				'key' => 'specific_options',
				'icon' => 'im-icon-hammer',
				'options' => array(
					array(
						'name' => __( 'Custom CSS', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'You can place here any necessary custom CSS properties.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'custom_css',
						'type' => 'textarea',
					),
					array(
						'name' => __( 'Number of widget areas', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Set here how many independent widget areas you need.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'number_of_widgets',
						'type' => 'number',
						'min' => 1,
						'max' => 100,
						'units' => 'areas',
						'values' => '1',
						'default' => '1',
					),
				), // 'options' => array
			),
			/*
			array(
				'title' => 'Support & Suggestions',
				'key' => 'support',
				'icon' => 'im-icon-support',
				'options' => array(
					array(
						'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'support',
						'type' => 'just_html',
						'default' => '<br /><br /> <a href="http://manual.menu.megamain.com/" target="_blank">Online documentation</a>. <br /><br /> If you need support, <br /> If you have a question or suggestion - <br /> Leave a message on our support page <br /> <a href="http://support.megamain.com/?ref=' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '" target="_blank">Support.MegaMain.com</a> (in new window).',
					),
				), // 'options' => array
			),
			*/
		); // END FRIMARY ARRAY
	}
?>
