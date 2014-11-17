<?php
/**
 * Adds the AJAX action to fire the importer
 * Insert a new page at Dashboard where user can import the dummy content easily
 * Adds the exporter action
 */

	// Custom Import AJAX Action
	add_action('wp_ajax_ivan_importer_dummy_content_ajax', 'ivan_custom_import');
	function ivan_custom_import() {

		//require_once get_template_directory() . '/ivan_framework/core/init/inc_importer.php';

		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

		$_path = $_POST['path']; // folder name without trails
		$_content = $_POST['content']; // all, widgets, opts

		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';
		$ivan_importerError = false;
		$import_filepath = IVAN_THEME_CONFIGS ."/dummy_importer/demos/" . $_path . '/dummy';

		// Check if wp_importer, the base importer class is available, otherwise include it
		if ( !class_exists( 'WP_Importer' ) ) {
			$ivan_class_wp_importer = IVAN_THEME_CONFIGS . "/dummy_importer/wordpress-importer/class-wp-importer.php";
			if ( file_exists( $ivan_class_wp_importer ) ) {
				require_once($ivan_class_wp_importer);
			}
			else {
				$ivan_importerError = true;
			}
		}

		// Check if the wp import class is available, this class handles the wordpress XML files.
		if ( !class_exists( 'WP_Import' ) ) {
			$ivan_class_wp_import = IVAN_THEME_CONFIGS ."/dummy_importer/wordpress-importer/wordpress-importer.php";
			if ( file_exists( $ivan_class_wp_import ) )
				require_once( $ivan_class_wp_import );
			else
				$ivan_importerError = true;
		}

		if($ivan_importerError !== false) {
			echo "The Auto importing script could not be loaded. Try manual.";
		} else {

			if ( class_exists( 'WP_Import' ) )
				include_once('wordpress-importer/xt-import-class.php');

			if( !is_file($import_filepath.'.xml') ) {
				echo "The XML file containing the dummy content is not available or could not be read. Try change permission or upload manually.";
			} else {

				do_action('ivan_import_hook');

				$wp_import = new ivan_wp_import();
				
				if( $_content == 'all' ) {
					
					$wp_import->fetch_attachments = true;
					$wp_import->import($import_filepath.'.xml');
					$wp_import->saveOptions($import_filepath.'.php', 'all');
					$wp_import->set_menus();

					echo 'All Content Type Done';
				}
				else if( $_content == 'widgets') {
					$wp_import->saveOptions($import_filepath.'.php', 'widgets');

					echo 'Widgets Content Type Done';
				} else if( $_content == 'opts') {
					$wp_import->saveOptions($import_filepath.'.php', 'opts');

					echo 'Opts Content Type Done';
				}
					
				do_action('ivan_after_import_hook');
			}
		}

		die();
	}

	// Custom Export Function
	function ivan_custom_export_sql() {
		if( isset($_GET['exportsql']) == false ) return;

		// 
		// Theme Options
		// 
		$ivan_theme_options = get_option( IVAN_FW_THEME_OPTS );
		$ivan_theme_options = base64_encode( serialize( $ivan_theme_options ) );
		?>
		<pre>
		$ivan_theme_options = "<?php echo $ivan_theme_options; ?>";
		</pre>
		<?php

		// 
		// Widgets
		//
		global $wp_registered_widgets;

		$ivan_sidebar_widgets = get_option('sidebars_widgets');
		$ivan_widget_data = array();
		
		foreach ($ivan_sidebar_widgets as $key => $value) {

			if( empty($value) == true OR is_array( $value) == false ) continue;

			$sidebar_name = $key;
			$widgets = $value;

			foreach ($widgets as $widget_name) {

				// The name of the option in the database is the name of the widget class.
				$option_name = $widget_name;
				if( isset( $wp_registered_widgets[ $widget_name ]['callback'][0]->option_name ) == true )
					$option_name = $wp_registered_widgets[ $widget_name ]['callback'][0]->option_name;
				
				$widget_data = serialize( get_option($option_name) );

				$ivan_widget_data[ $option_name ] = $widget_data;
			}

		}

		$ivan_sidebar_widgets = base64_encode( serialize( $ivan_sidebar_widgets ) );
		$ivan_widget_data = base64_encode( serialize( $ivan_widget_data ) );

		?>
		<pre>
		$ivan_sidebar_widgets = "<?php echo $ivan_sidebar_widgets; ?>";
		$ivan_widget_data = "<?php echo $ivan_widget_data; ?>";
		</pre>
		<?php
	}
	add_action('admin_init', 'ivan_custom_export_sql', 99);

	// Custom Dashboard "Appearance - Import Dummy"

	function ivan_importer_register_settings() {
		register_setting( 'ivan_importer_settings_group', 'ivan_importer_settings' );
	}
	add_action( 'admin_init', 'ivan_importer_register_settings' );

	/**
	 * Register the settings page
	 */
	function ivan_importer_settings_menu() {
		add_theme_page(__( 'Import Dummy Content', 'ivan_domain_redux' ), __( 'Import Dummy Content', 'ivan_domain_redux' ), 'manage_options', 'ivan_importer_settings', 'ivan_importer_settings_page');
	}
	add_action( 'admin_menu', 'ivan_importer_settings_menu' );

	/**
	 * Render the settings page
	 */
	function ivan_importer_settings_page() {
	 ?>
		<div class="wrap">
			<h2><?php _e('Import Dummy Content',' ivan_domain_redux'); ?></h2>

			<div class="metabox-holder">
	 
				<div class="postbox">
					<h3><span><?php _e( 'Import Dummy Demo',' ivan_domain_redux' ); ?></span></h3>
					<div class="inside">
						<p>Import the theme dummy content and settings. <strong>The process can be really long, don't close or refresh the page!!!</strong></p>
						<div>
							<p><label>Select Demo</label></p>
							<p><select class="iv-demo-path">
								<option value="demo_default">Default Style</option>
							</select>
							</p>
							<p><label>What will be imported?</label></p>
							<p><select class="iv-demo-content">
								<option value="all">All (with Content)</option>
								<option value="widgets">Widgets</option>
								<option value="opts">Theme Options</option>
							</select>
							</p>
							<p><strong>1. IMPORTANT:</strong> The option All (with Content) will download all media, pages, menus and other datas, import with this option ONCE, else the pages will be duplicated and errors may occurs. It's recommended to websites without content yet, or with minimal content.</p>
							<p><strong>2. IMPORTANT:</strong> The Widgets and Theme Options will define the theme options automatically but will overwrite any change you did at Theme Options. CAn be used how many times you want.</p>
							<p><strong>3. IMPORTANT:</strong> If you're importing all content, it's recommended that your <i>upload_max_filesize</i> be greather than 5MB. </p>
						</div>
						<p><a id="xt-importer-button" href="#" class="button button-primary button-hero">Import Dummy Content</a></p>
						<div id="xt-import-results" style="display: none;">
							<span class="spinner" style="float: left; display: block;"></span> <strong>The process can be really long, don't close or refresh the page!!!</strong>
						</div>
					</div><!-- .inside -->
				</div><!-- .postbox -->
			</div><!-- .metabox-holder -->

			<script type="text/javascript">
			jQuery(document).ready( function() {

				<?php
				$ivan_importer_protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
				?>

				jQuery('#xt-importer-button').click( function() {

					var ivan_importer_data = {
						action: 'ivan_importer_dummy_content_ajax',
						path: jQuery('.iv-demo-path').val(),
						content: jQuery('.iv-demo-content').val()
					};

					if( confirm('This will add content and rewrite your options, do you have sure you want import dummy data?') ) {
						jQuery('#xt-import-results').fadeIn();
						console.log(ivan_importer_data);
						jQuery.ajax({
							type: "POST",
							url: "<?php echo admin_url( 'admin-ajax.php', $ivan_importer_protocol ); ?>",
							data: ivan_importer_data,
							success: function( data ) {
								console.log( data );
								jQuery('#xt-import-results').html('Success! Everything was imported! Have fun!');
							},
							dataType: 'text'
						});
					}

					return false;
				});

			});
			</script>
	 
		</div><!--end .wrap-->
		<?php
	}