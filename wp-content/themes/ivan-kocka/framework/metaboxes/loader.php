<?php

// Load the filters properly to ensure values being overwrited by metaboxes

if(!function_exists('ivan_redux_register_custom_extension_loader')) :
	function ivan_redux_register_custom_extension_loader($ReduxFramework) {

		//var_dump(IVAN_FW_THEME_OPTS);

		$path = dirname( __FILE__ ) . '/extensions/';
		$folders = scandir( $path, 1 );		   
		foreach($folders as $folder) {
			if ($folder === '.' or $folder === '..' or !is_dir($path . $folder) ) {
				continue;	
			}
			$extension_class = 'ReduxFramework_extension_' . $folder;
			if( !class_exists( $extension_class ) ) {
				// In case you wanted override your override, hah.
				$class_file = $path . $folder . '/extension_' . $folder . '.php';
				$class_file = apply_filters( 'redux/extension/'.IVAN_FW_THEME_OPTS.'/'.$folder, $class_file );
				if( $class_file ) {
					require_once( $class_file );
					$extension = new $extension_class( $ReduxFramework );
				}
			}
		}
	}
	// Modify redux_demo to match your opt_name
	add_action("redux/extensions/". IVAN_FW_THEME_OPTS . "/before", 'ivan_redux_register_custom_extension_loader', 0);
endif;

