<?php
class ivan_wp_import extends WP_Import
{

	function saveOptions($option_file, $_content) {

		if($option_file)
			@include_once($option_file);

		// Theme Options
		if( $ivan_theme_options != '' && ( $_content == 'all' OR $_content == 'opts' ) ) {

			$ivan_theme_options = base64_decode( $ivan_theme_options );
			$ivan_theme_options = unserialize( $ivan_theme_options );

			update_option( IVAN_FW_THEME_OPTS, $ivan_theme_options );
		}

		// Widgets
		if( $ivan_sidebar_widgets != '' && ( $_content == 'all' OR $_content == 'widgets' ) ) {

			$ivan_sidebar_widgets = base64_decode( $ivan_sidebar_widgets );
			$ivan_sidebar_widgets = unserialize( $ivan_sidebar_widgets );

			update_option( 'sidebars_widgets', $ivan_sidebar_widgets );

			// Widgets
			$ivan_widget_data = base64_decode( $ivan_widget_data );
			$ivan_widget_data = unserialize( $ivan_widget_data );

			//var_dump($ivan_widget_data);
			foreach ($ivan_widget_data as $key => $value) {
				update_option( $key, unserialize( $value ) );
			}

		}
		
	}

	function set_menus() {
		global $ivan_menu_locations;

		// Get all registered menu locations
		$locations = get_theme_mod('nav_menu_locations');
		
		// Get all created menus
		$all_menus  = wp_get_nav_menus();
		
		if( !empty($all_menus) && !empty( $ivan_menu_locations ) ) {
			foreach( $all_menus as $single_menu ) {

				if(is_object($single_menu) && in_array($single_menu->name, $ivan_menu_locations)) {
					$key = array_search($single_menu->name, $ivan_menu_locations);
					if($key) {
						$locations[$key] = $single_menu->term_id;
					}
				}
			}
		}

		// Update theme options
		set_theme_mod( 'nav_menu_locations', $locations);
	}
}




