<?php
/**
 * @package Mega Main Menu
 * @version 1.1.0
 * Primary functions file. Creates and initializes the primary class that calls all the other classes. 
 * Author: MegaMain.com
 * Author URI: http://megamain.com
 */

$mmpm_primary_class = new mmpm_primary_class; // call class below
class mmpm_primary_class {
	public function __construct () {
		// Order of calling functions is very important first-constants, second-mmpm_theme_options, last-extensions_loader!
		@ini_set('max_input_vars', 20000);
		add_action( 'init', array( $this, 'constants' ), 1 );
		add_action( 'init', array( $this, 'mmpm_theme_options' ), 1 );
		add_action( 'init', array( $this, 'extensions_loader' ), 1 );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'widgets' );

		if( is_admin() ) {
			// Filter to adds notices in Dashboard
			add_action( 'admin_notices',  array( $this, 'PostRequestLimits' ) );
		}
	}

	/*
	 * Function sets theme constants.
	 */
	public static function constants() {
		// Set theme primary information.
		define( 'MMPM_PLUGIN_NAME', 'Mega Main Menu' );
		define( 'MMPM_PLUGIN_VERSION', '1.1.0' );
		define( 'MMPM_PLUGIN_SLUG', 'mega_main_menu' );
		// Set theme identificators and prefixes.
		define( 'MMPM_PREFIX', 'mmpm' );
		define( 'MMPM_OPTIONS_NAME', 'options_' . MMPM_PLUGIN_SLUG );
		define( 'MMPM_OPTIONS_DB_NAME', MMPM_PREFIX . '_' . MMPM_OPTIONS_NAME );
		define( 'MMPM_SKIN_NAME', 'skin_' . MMPM_PLUGIN_SLUG );
		define( 'MMPM_SKIN_DB_NAME', MMPM_PREFIX . '_' . MMPM_SKIN_NAME );
		define( 'MMPM_TEXTDOMAIN', MMPM_PLUGIN_SLUG );
		define( 'MMPM_TEXTDOMAIN_ADMIN', MMPM_PLUGIN_SLUG . '_admin' );
		define( 'MMPM_THEME_PAGE_SLUG', MMPM_PREFIX . '_options_' . MMPM_PLUGIN_SLUG );
		// Set theme static locations: directories and files.
		// DIRECTORIES
		define( 'MMPM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'MMPM_EXTENSIONS_DIR', MMPM_PLUGIN_DIR . '/extensions' );
		define( 'MMPM_SRC_DIR', MMPM_PLUGIN_DIR . '../src' );
		define( 'MMPM_CSS_DIR', MMPM_SRC_DIR . '/css' );
		// URI
		define( 'MMPM_PLUGIN_URI', str_replace( '/plugin_framework/', '', plugin_dir_url( __FILE__ ) ) );
		define( 'MMPM_SRC_URI', MMPM_PLUGIN_URI . '/src' );
		define( 'MMPM_CSS_URI', MMPM_SRC_URI . '/css' );
		define( 'MMPM_JS_URI', MMPM_SRC_URI . '/js' );
		define( 'MMPM_FONTS_URI', MMPM_SRC_URI . '/fonts' );
		define( 'MMPM_IMG_URI', MMPM_SRC_URI . '/img' );
		define( 'MMPM_IMAGE_NOT_FOUND', MMPM_PLUGIN_URI . '/src/img/image_not_found.png' );
		define( 'MMPM_NO_IMAGE_AVAILABLE', MMPM_PLUGIN_URI . '/src/img/no_image_available.png' );
	}

	/*
	 * Function sets global theme variable $mmpm_theme_options wherein the stored all theme options for visual appearance.
	 */
	public function mmpm_theme_options () {
		$GLOBALS['mmpm_theme_options'] = get_option( MMPM_OPTIONS_DB_NAME, 'Not saved options' );
//		$GLOBALS['mmpm_theme_skin'] = get_option( MMPM_SKIN_DB_NAME, 'Not saved skin' );
	}

	/*
	 * Function open extensions directory (MMPM_EXTENSIONS_DIR) and load all initialization files (init.php) in subfolders.
	 */
	public function extensions_loader () {
		include_once( MMPM_EXTENSIONS_DIR . '/common_tools/init.php' ); 
		if ( $dir_contents = opendir( MMPM_EXTENSIONS_DIR ) ) {
			while( ( $inner_dir = readdir( $dir_contents ) ) !== false ) {
				if ($inner_dir != "." && $inner_dir != ".." && file_exists( MMPM_EXTENSIONS_DIR . '/' . $inner_dir . '/init.php' ) ) { 
					include_once( MMPM_EXTENSIONS_DIR . '/' . $inner_dir . '/init.php' ); 
				} 
			}
			closedir($dir_contents);
		}
	}

	/* Post Var Count
	=============================*/

	function PostRequestLimits(){
		$screen = get_current_screen();
		if( $screen->id != 'nav-menus' ) return;

		$currentPostVars_count = $this->megaMenuCountPostVars();
		$r = array(); //restrictors

		$r['suhosin_post_maxvars'] = ini_get( 'suhosin.post.max_vars' );
		$r['suhosin_request_maxvars'] = ini_get( 'suhosin.request.max_vars' );
		$r['max_input_vars'] = ini_get( 'max_input_vars' );


		//$r['max_input_vars'] = 1355;

		if( $r['suhosin_post_maxvars'] != '' ||
			$r['suhosin_request_maxvars'] != '' ||
			$r['max_input_vars'] != '' ){


			$message = array();

			if( ( $r['suhosin_post_maxvars'] != '' && $r['suhosin_post_maxvars'] < 1000 ) || 
				( $r['suhosin_request_maxvars']!= '' && $r['suhosin_request_maxvars'] < 1000 ) ){
				$message[] = __( "Your server is running Suhosin, and your current maxvars settings may limit the number of menu items you can save." );
			}


			//150 ~ 10 left
			foreach( $r as $key => $val ){
				if( $val > 0 ){
					if( $val - $currentPostVars_count < 150 ){
						$message[] = __( "You are approaching the post variable limit imposed by your server configuration.  Exceeding this limit may automatically delete menu items when you save.  Please increase your <strong>$key</strong> directive in php.ini. Read theme documentation to more details.");
					}
				}
			}

			if( !empty( $message ) ): ?>
			<div class="spark-infobox spark-infobox-warning error">
				<h4><?php _e( 'Menu Item Limit Warning'); ?></h4>
				<ul>
				<?php foreach( $message as $m ): ?>
					<li><?php echo $m; ?></li>
				<?php endforeach; ?>
				</ul>

				<?php
				if( $r['max_input_vars'] != '' ) echo "<strong>max_input_vars</strong> :: ". 
					$r['max_input_vars']. " <br/>";
				if( $r['suhosin_post_maxvars'] != '' ) echo "<strong>suhosin.post.max_vars</strong> :: ".$r['suhosin_post_maxvars']. " <br/>";
				if( $r['suhosin_request_maxvars'] != '' ) echo "<strong>suhosin.request.max_vars</strong> :: ". $r['suhosin_request_maxvars'] ." <br/>";
				
				echo "<br/><strong>".__( 'Menu Item Post variable count on last save' )."</strong> :: ". $currentPostVars_count."<br/>";
				if( $r['max_input_vars'] != '' ){
					$estimate = ( $r['max_input_vars'] - $currentPostVars_count ) / 15;
					if( $estimate < 0 ) $estimate = 0;
					echo "<strong>".__( 'Approximate remaining menu items')."</strong> :: " . floor( $estimate );
				}

				?>


			</div>
			<?php endif; 

		}
	}

	function megaMenuCountPostVars() {

		if( isset( $_POST['save_menu'] ) ){

			$megaMenuCount = 0;
	    	foreach( $_POST as $key => $arr ){
				$megaMenuCount+= count( $arr );
			}

			update_option( 'megamainmenu-post-var-count' , $megaMenuCount );
		}
		else{
			$megaMenuCount = get_option( 'megamainmenu-post-var-count' , 0 );
		}

		return $megaMenuCount;
	}

}

?>