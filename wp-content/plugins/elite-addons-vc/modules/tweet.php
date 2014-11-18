<?php
/***
 * Module > Tweet
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_tweet extends WPBakeryShortCode {

		public $tweet_counter = 0;

		function ivan_only_one_tweet($tweet) {

			if( $this->tweet_counter == 0 ) {

			 	/** Set the date and time format */
                $datetime_format = apply_filters( 'displaytweets_datetime_format', "l M j \- g:ia" );

                /** Get the date and time posted as a nice string */
                $posted_since = apply_filters( 'displaytweets_posted_since', date_i18n( $datetime_format , strtotime( $tweet->created_at ) ) );

                /** Filter for linking dates to the tweet itself */
                $link_date = apply_filters( 'displaytweets_link_date_to_tweet', __return_false() );
                if ( $link_date )
                    $posted_since = "<a href=\"https://twitter.com/{$tweet->user->screen_name}/status/{$tweet->id_str}\">{$posted_since}</a>";

                /** Print tweet */
                echo "<p>{$this->format_tweet( $tweet->text )}<br /><small class=\"muted\">- {$posted_since}</small></p>";

                $this->tweet_counter = 1;

           	}
		}

		/**
	     * Formats tweet text to add URLs and hashtags
	     *
	     * @since 1.0
	     */
	    public function format_tweet( $text ) {
	        $text = preg_replace( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $text );
	        $text = preg_replace( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $text );
	        $text = preg_replace( "/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $text );
	        $text = preg_replace( "/#(\w+)/", "<a href=\"http://twitter.com/search?q=%23\\1&src=hash\" target=\"_blank\">#\\1</a>", $text );
	        return $text;
	    }

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'template' => '',
				'el_class' => '',
			), $atts) );

			$output = '';
			$classes = '';

			//
			// Start Customizer Prefix
			//
				$prefixClass = '';
				if( isset($atts['c_id']) ) {
					$this->prefix = $atts['c_id'] . ' ';
					$prefixClass = str_replace('.', '', $atts['c_id']);
				} else {
					$this->prefix = '.vc_custom_' . rand(25, 3000) . ' ';
					$prefixClass = str_replace('.', '', $this->prefix);
				}
			// End Customizer Prefix

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Output Form
			ob_start();
			?>
			<div class="ivan-tweet-wrap <?php echo $prefixClass; ?>">
				<div class="ivan-tweet <?php echo $classes; ?>">
					<?php if ( function_exists( "display_tweets" ) ) {
						add_action('displaytweets_tweet_template', array($this, 'ivan_only_one_tweet'));
						display_tweets(); 
						remove_action('displaytweets_tweet_template', array($this, 'ivan_only_one_tweet'));
						$this->tweet_counter = 0;
					} ?>
				</div>
			</div>
			<?php
			$output .= ob_get_clean();

			//
			// Customizer CSS Output
			//
				$style = '';
				foreach ($this->selectors as $key => $value) {
					if( isset($atts[$key]) && '' != $atts[$key]) {
						$style .= ivan_vc_customizer_get_style( $atts[$key], $this->selectors[$key], $this->prefix );
					}
				}

				// Print style
				if(is_admin()) {
					$output .= '<style type="text/css">'
					. $style
					. '</style>';
				}
				else {
					$ivan_custom_css .= $style;
				}
			// End Customizer Output

			return $output;
		}

		// H1 Selectors
		public $selectors = array(
			'tweet_css' => array(
				// Font
				'font-family' => 'p',
				'font-weight' => 'p',
				'font-size' => 'p',
				'line-height' => 'p',
				'text-transform' => 'p',
				'color' => 'p, a',
				// Spacing
				'margin-top' => 'p',
				'margin-right' => 'p',
				'margin-bottom' => 'p',
				'margin-left' => 'p',
				//'padding-top' => 'p',
				//'padding-right' => 'p',
				//'padding-bottom' => 'p',
				//'padding-left' => 'p',
				// Bg
				//'background-color' => 'p',
				// Border Radius
				//'border-top-left-radius' => 'p',
				//'border-top-right-radius' => 'p',
				//'border-bottom-left-radius' => 'p',
				//'border-bottom-right-radius' => 'p',
				// Border
				//'border-top-width' => 'p',
				//'border-right-width' => 'p',
				//'border-bottom-width' => 'p',
				//'border-left-width' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				'color-hover' => 'a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'meta_css' => array(
				// Font
				'font-family' => 'small',
				'font-weight' => 'small',
				'font-size' => 'small',
				'line-height' => 'small',
				'text-transform' => 'small',
				'color' => 'small',
				// Spacing
				'margin-top' => 'small',
				'margin-right' => 'small',
				'margin-bottom' => 'small',
				'margin-left' => 'small',
				//'padding-top' => 'p',
				//'padding-right' => 'p',
				//'padding-bottom' => 'p',
				//'padding-left' => 'p',
				// Bg
				//'background-color' => 'p',
				// Border Radius
				//'border-top-left-radius' => 'p',
				//'border-top-right-radius' => 'p',
				//'border-bottom-left-radius' => 'p',
				//'border-bottom-right-radius' => 'p',
				// Border
				//'border-top-width' => 'p',
				//'border-right-width' => 'p',
				//'border-bottom-width' => 'p',
				//'border-left-width' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),		
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_tweet;
	$ivan_vc_tweet = new WPBakeryShortCode_ivan_tweet( array('name' => 'Tweet', 'base' => 'ivan_tweet') );

} // #end class check