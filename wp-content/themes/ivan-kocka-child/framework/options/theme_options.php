<?php
/**
 * Theme Configuration built with Redux Framework
 * NOTICE: You should not remove this file, keep updating only /ReduxFramework folder
 * */

if (!class_exists("Redux_Framework_Ivan_Config")) {

	class Redux_Framework_Ivan_Config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct() {

			if ( !class_exists("ReduxFramework" ) ) {
				return;
			}	

			// This is needed. Bah WordPress bugs.  ;)
			if ( defined('TEMPLATEPATH') && strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( TEMPLATEPATH ) ) !== false) {
				$this->initSettings();
			} else {
				add_action('plugins_loaded', array($this, 'initSettings'), 10);	
			}
		}

		public function initSettings() {
			
			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			//$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if (!isset($this->args['opt_name'])) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			//add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
			
			// Function to test the compiler hook and demo CSS output.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			// Change the default value of a field after it's been set, but before it's been useds
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
			
			// Dynamically add a section. Can be also used to modify sections/fields
			//add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

			add_filter( "redux/".$this->args['opt_name']."/field/class/social_select", array( $this, "overload_social_select_field_path" ) );
			add_filter( "redux/".$this->args['opt_name']."/field/class/spacing_mod", array( $this, "overload_spacing_mod_field_path" ) );
			add_filter( "redux/".$this->args['opt_name']."/field/class/button_set_mod", array( $this, "overload_button_set_mod_field_path" ) );
			add_filter( "redux/".$this->args['opt_name']."/field/class/border_mod", array( $this, "overload_border_mod_field_path" ) );
			add_filter( "redux/".$this->args['opt_name']."/field/class/typography_mod", array( $this, "overload_typography_mod_field_path" ) );

			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
		}

		/**
		*
		*  This is a test function that will let you see when the compiler hook occurs.
		*  It only runs if a field	set with compiler=>true is changed.
		*
		 * */
		function compiler_action($options, $css) {
			//echo "<h1>The compiler hook has run!";
			//print_r($options); //Option values
			//print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

			/*
			  // Demo of how to use the dynamic CSS and write your own static CSS file
			  $filename = dirname(__FILE__) . '/style' . '.css';
			  global $wp_filesystem;
			  if( empty( $wp_filesystem ) ) {
			  require_once( ABSPATH .'/wp-admin/includes/file.php' );
			  WP_Filesystem();
			  }

			  if( $wp_filesystem ) {
			  $wp_filesystem->put_contents(
			  $filename,
			  $css,
			  FS_CHMOD_FILE // predefined mode settings for WP files
			  );
			  }
			 */
		}

		/**
		*
		*  Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		*  Simply include this function in the child themes functions.php file.
		*
		*  NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		*  so you must use get_template_directory_uri() if you want to use any of the built in icons
		*
		 * */
		/*
		function dynamic_section($sections) {
			//$sections = array();
			$sections[] = array(
				'title' => __('Section via hook', 'ivan_domain_redux'),
				'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'ivan_domain_redux'),
				'icon' => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array()
			);

			return $sections;
		}
		*/

		/**
		*
		*  Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		*
		 * */
		function change_arguments($args) {
			//$args['dev_mode'] = true;

			return $args;
		}

		/**
		*
		*  Filter hook for filtering the default value of any given field. Very useful in development mode.
		*
		 * */
		function change_defaults($defaults) {
			$defaults['str_replace'] = "Testing filter hook!";

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if (class_exists('ReduxFrameworkPlugin')) {
				remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
				
				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
				
			}
		}

		public function setSections() {

			ob_start();

			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get('Name');
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'ivan_domain_redux'), $this->theme->display('Name'));
			?>
			<div id="current-theme" class="<?php echo esc_attr($class); ?>">
			<?php if ($screenshot) : ?>
				<?php if (current_user_can('edit_theme_options')) : ?>
						<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
							<img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
						</a>
				<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
			<?php endif; ?>

				<h4>
			<?php echo $this->theme->display('Name'); ?>
				</h4>

				<div>
					<ul class="theme-info">
						<li><?php printf(__('By %s', 'ivan_domain_redux'), $this->theme->display('Author')); ?></li>
						<li><?php printf(__('Version %s', 'ivan_domain_redux'), $this->theme->display('Version')); ?></li>
						<li><?php echo '<strong>' . __('Tags', 'ivan_domain_redux') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
					</ul>
					<p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
				<?php
				if ($this->theme->parent()) {
					printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'ivan_domain_redux'), $this->theme->parent()->display('Name'));
				}
				?>

				</div>

			</div>

			<?php
			$item_info = ob_get_contents();

			ob_end_clean();

			// GET PATTENRS AVALIABLE TO THIS THEME
			
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

			do_action('ivan_before_theme_opts');

			// ACTUAL DECLARATION OF SECTIONS

			include_once('sections/general.php');

			include_once('sections/layout.php');

			include_once('sections/header.php');

			include_once('sections/title_wrapper.php');

			include_once('sections/content.php');

			include_once('sections/top_header.php');

			include_once('sections/footer.php');

			include_once('sections/bottom_footer.php');

			$this->sections[] = array(
				'type' => 'divide',
			);

			include_once('sections/blog.php');
			include_once('sections/single.php');

			include_once('sections/woo_templates.php');

			$this->sections[] = array(
				'type' => 'divide',
			);
		
			include_once('sections/basic_customizer.php');

			include_once('sections/favicon.php');

			include_once('sections/custom_code.php');

			if( IVAN_DEBUG == true ) :

				$theme_info = '<div class="redux-framework-section-desc">';
				$theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'ivan_domain_redux') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
				$theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'ivan_domain_redux') . $this->theme->get('Author') . '</p>';
				$theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'ivan_domain_redux') . $this->theme->get('Version') . '</p>';
				$theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
				$tabs = $this->theme->get('Tags');
				if (!empty($tabs)) {
					$theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'ivan_domain_redux') . implode(', ', $tabs) . '</p>';
				}
				$theme_info .= '</div>';

				
				$this->sections[] = array(
					'type' => 'divide',
				);

				$this->sections[] = array(
					'icon' => 'el-icon-info-sign',
					'title' => __('Theme Information', 'ivan_domain_redux'),
					'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'ivan_domain_redux'),
					'fields' => array(
						array(
							'id' => 'raw_new_info',
							'type' => 'raw',
							'content' => $item_info,
						)
					),
				);

			endif; // endif IVAN_DEBUG
		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id' => 'redux-opts-1',
				'title' => __('Theme Information 1', 'ivan_domain_redux'),
				'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'ivan_domain_redux')
			);

			$this->args['help_tabs'][] = array(
				'id' => 'redux-opts-2',
				'title' => __('Theme Information 2', 'ivan_domain_redux'),
				'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'ivan_domain_redux')
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'ivan_domain_redux');
		}

		/**
		*
		*  All the possible arguments for Redux.
		*  For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		*
		 * */
		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name' => IVAN_FW_THEME_OPTS, // This is where your data is stored in the database and also becomes your global variable name.
				'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
				'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type' => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu' => true, // Show the sections below the admin menu item or not
				'menu_title' => __('Theme Options', 'ivan_domain_redux'),
				'page_title' => __('Theme Options', 'ivan_domain_redux'),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key' => IVAN_GFONTS_API_KEY, // Must be defined to add google fonts to the typography module
				//'admin_bar' => false, // Show the panel pages on the admin bar
				//'global_variable' => '', // Set a different name for your global variable other than the opt_name
				'dev_mode' => IVAN_DEBUG, // Show the time the page took to load, etc
				'customizer' => false, // Enable basic customizer support
				// OPTIONAL -> Give you extra features
				'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon' => '', // Specify a custom URL to an icon
				'last_tab' => '', // Force your panel to always open to a specific tab (by id)
				'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug' => '_options', // Page slug used to denote the panel
				'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
				'default_show' => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
				// CAREFUL -> These options are for advanced use only
				'transient_time' => 60 * MINUTE_IN_SECONDS,
				'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				//'domain'			 	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
				//'footer_credit'	  	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'show_import_export' => true, // REMOVE
				'system_info' => IVAN_DEBUG, // REMOVE
				'help_tabs' => array(),
				'help_sidebar' => '', // __( '', $this->args['domain'] );			
			);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
			/*
			$this->args['share_icons'][] = array(
				'url' => 'https://github.com/ReduxFramework/ReduxFramework',
				'title' => 'Visit us on GitHub',
				'icon' => 'el-icon-github'
					// 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
			);
			$this->args['share_icons'][] = array(
				'url' => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
				'title' => 'Like us on Facebook',
				'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
				'url' => 'http://twitter.com/reduxframework',
				'title' => 'Follow us on Twitter',
				'icon' => 'el-icon-twitter'
			);
			$this->args['share_icons'][] = array(
				'url' => 'http://www.linkedin.com/company/redux-framework',
				'title' => 'Find us on LinkedIn',
				'icon' => 'el-icon-linkedin'
			);
			*/

			// Panel Intro text -> before the form
			/*
			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
				//$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'ivan_domain_redux'), $v);
			} else {
				$this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'ivan_domain_redux');
			}
			*/

			// Add content after the form.
			//$this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'ivan_domain_redux');
		}

		public function overload_social_select_field_path( $field ) {
			return dirname(__FILE__).'/fields/social_select/field_social_select.php';
		}

		public function overload_spacing_mod_field_path( $field ) {
			return dirname(__FILE__).'/fields/spacing_mod/field_spacing_mod.php';
		}

		public function overload_button_set_mod_field_path( $field ) {
			return dirname(__FILE__).'/fields/button_set_mod/field_button_set_mod.php';
		}

		public function overload_border_mod_field_path( $field ) {
			return dirname(__FILE__).'/fields/border_mod/field_border.php';
		}

		public function overload_typography_mod_field_path( $field ) {

			require_once(ReduxFramework::$_dir . 'inc/fields/typography/field_typography.php' );

			return dirname(__FILE__).'/fields/typography_mod/field_typography.php';
		}

	}

	new Redux_Framework_Ivan_Config();
}