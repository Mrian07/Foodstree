<?php
/*
 * Row Module Customization
 */

if( !class_exists('Ivan_VC_Row') ) {
	class Ivan_VC_Row {

		// Contructor
		function __construct() {

			// Apply filter to output custom markup
			add_filter( 'ivan_custom_row_shortcode_before', array($this, 'shortcode_before'), 10, 3 );
			add_filter( 'ivan_custom_row_shortcode_after', array($this, 'shortcode_after'), 15, 3 );

			add_filter( 'ivan_custom_row_inner_shortcode_before', array($this, 'shortcode_before_inner'), 10, 3 );
			add_filter( 'ivan_custom_row_inner_shortcode_after', array($this, 'shortcode_after_inner'), 10, 3 );

		}

		// Before
		public static function shortcode_before($output, $atts, $content) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'anchor' => '',
				'width' => '',
				'boxed' => '',
				'h' => '', // row custom height
				'bg_type' => '',
				'bg_color_row' => '',
				'bg_image_url' => '',
				'bg_repeat' => '',
				'bg_position' => '',
				'bg_size' => '',
				'bg_att' => '',
				'p_speed' => '0.5', // parallax speed
				'webm' => '',
				'mp4' => '',
				'ogv' => '',
				'preview' => '',
				'overlay' => '',
				'bt_color' => '',
				'bt_width' => '',
				'bb_color' => '',
				'bb_width' => '',
				'cut_top' => '',
				'cut_top_h' => '30',
				'cut_top_w' => '60',
				'cut_bottom' => '',
				'cut_bottom_h' => '30',
				'cut_bottom_w' => '60',
				'v_center' => '',
				'full_h' => '',
				'full_offsets' => '',
				'row_fullpage' => '',
				'row_label' => '',
				'p_top' => '',
				'p_bottom' => '',
				'm_top' => '',
				'm_bottom' => '',
			), $atts) );

			$output = '';
			$styles = '';
			$classes = '';
			$attributes = '';
			$after = '';

			// Section Width
			switch ( $width ) {
				case 'full':
					$classes .= 'full_width ';
					break;
				case 'no_margin':
					$classes .= 'full_width no_margin ';
					break;
				case 'no_cols_margin':
					$classes .= 'full_width no_margin no_columns_margin ';
					break;
				case 'no_cols_grid':
					$classes .= 'no-cols-grid ';
					break;
				default:
					$classes .= 'theme_default ';
					break;
			}

			// Paddings / Margins
			if( $p_top != '' )
				$styles .= 'padding-top: '. ivan_style_val( $p_top ) .';';

			if( $p_bottom != '' )
				$styles .= 'padding-bottom: '. ivan_style_val( $p_bottom ) .';';

			if( $m_top != '' )
				$styles .= 'margin-top: '. ivan_style_val( $m_top ) .';';

			if( $m_bottom != '' )
				$styles .= 'margin-bottom: '. ivan_style_val( $m_bottom ) .';';

			// Boxed Style
			if( $boxed == 'yes' && $width == '' )
				$classes .= 'boxed-row ';

			// Custom Height
			if( $h != '' ) {
				$styles .= 'height: '.ivan_style_val( $h ).';';
				$classes .= 'custom-height ';
			}
			// Custom Border
			if( $bt_width != '' ) {
				$styles .= 'border-top-width: '.ivan_style_val( $bt_width ).';';

				if( $bt_color != '' )
					$styles .= 'border-top-color: '. $bt_color.';';							
			}

			if( $bb_width != '' ) {
				$styles .= 'border-bottom-width: '.ivan_style_val( $bb_width ).';';

				if( $bb_color != '' )
					$styles .= 'border-bottom-color: '. $bb_color.';';							
			}

			// Bg Color
			if( $bg_color_row != '' )
				$styles .= 'background-color: '. $bg_color_row.';';

			// Bg Image
			$url = '';
			if( $bg_type == 'image' || $bg_type == 'parallax' ) {
				
				if( $bg_image_url != '' ) {
					$url = wp_get_attachment_image_src( $bg_image_url, 'full');

					$styles .= 'background-image: url('.$url[0].');';
				}
			}

			// Bg Image Specific
			if( $bg_type == 'image' ) {

				if( $bg_repeat != '' )
					$styles .= 'background-repeat: ' . $bg_repeat . ';';

				if( $bg_position != '' )
					$styles .= 'background-position: ' . $bg_position . ';';

				if( $bg_size != '' )
					$styles .= 'background-size: ' . $bg_size . ';';
				
				if( $bg_att != '' )
					$styles .= 'background-attachment: ' . $bg_att . ';';
			}

			// Bg Parallax Specific
			if( $bg_type == 'parallax' ) {

				$classes .= 'parallax-vertical ';

				if( $p_speed != '' ) {
					$attributes .= 'data-speed="'. $p_speed .'" ';
				}

				if( $bg_image_url != '' ) {
					$attributes .= 'data-height="'. $url[2] . '" ';
				}
			}

			// Bg Video
			if( $bg_type == 'video' ) {

				$classes .= 'row-video ';

				$v_image = '';

				if( $preview != '' ) {
					$preview = wp_get_attachment_image_src( $preview, 'full');

					$v_image = $preview[0];

					// Mobile Replacement
					$after .= '<div class="mobile-video-image" style="background-image: url('.$v_image.')"></div>';
				}

				$after .= '<div class="video-wrap">';

					$after .= '<video class="video" poster="'. $v_image .'" controls="controls" preload="auto" loop autoplay muted>';

						if( $webm != '' )
							$after .= '<source type="video/webm" src="'. $webm .'">';

						if( $mp4 != '' )
							$after .= '<source type="video/mp4" src="'. $mp4 .'">';

						if( $ogv != '' )
							$after .= '<source type="video/ogg" src="'. $ogv .'">';

						// Fallback?!

					$after .= '</video>';

				$after .= '</div><!-- .video-wrap -->';
				
			}

			// Overlay
			if('' != $overlay) {
				$after .= '<div class="row-overlay" style="background-color:' . $overlay .';"></div>';
			}

			// V-Align
			if( $v_center == 'yes' && !is_admin() )
				$classes .= 'v-center ';

			// FullPage Effects
			if('yes' == $row_fullpage)
				$classes .= 'row-fullpage ';

			if( '' != $row_label )
				$attributes .= ' data-fulllabel="'.$row_label.'" ';

			// Full Viewport Height
			if('yes' == $full_h) :
				$classes .= 'iv-full-viewport ';

				if('' != $full_offsets)
					$attributes .= ' data-offset="'.$full_offsets.'"';
			endif;

			if( $anchor != '' )
				$anchor = 'id="'.$anchor.'"';

			$output = '<div '.$attributes.' class="ivan-custom-wrapper '.$classes.'" '.$anchor.' style="'.$styles.'">' . $after;

				// Add page cut effects
				if('top-left' == $cut_top) :

					$output .= '
					<div class="ivan-page-cut top-left" style="height: '.$cut_top_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M100 100 L0 100 L0 0" stroke-width="0"></path>
						</svg>
					</div>';

				endif;

				if('top-right' == $cut_top) :

					$output .= '
					<div class="ivan-page-cut top-right" style="height: '.$cut_top_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M100 0 L0 100 L100 100" stroke-width="0"></path>
						</svg>
					</div>';

				endif;

				if('top-triangle' == $cut_top) :

					$output .= '
					<div class="ivan-page-cut top-right top-triangle" style="height: '.$cut_top_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="'.$cut_top_w.'px" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M50 0 L0 100 L100 100" stroke-width="0"></path>
						</svg>
					</div>';

				endif;

				if('inverse-triangle' == $cut_top) :

					$output .= '
					<div class="ivan-page-cut top-right inverse-tri-mobile" style="height: '.$cut_top_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M0 0 L0 100 L100 100 L100 0 L62 0 L50 100 L38 0" stroke-width="0"></path>
						</svg>
					</div>';

					$output .= '
					<div class="ivan-page-cut top-right inverse-tri" style="height: '.$cut_top_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M0 0 L0 100 L100 100 L100 0 L54 0 L50 100 L46 0" stroke-width="0"></path>
						</svg>
					</div>';

				endif;

				if('bottom-left' == $cut_bottom) :

					$output .= '
					<div class="ivan-page-cut bottom-left" style="height: '.$cut_bottom_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M0 100 L100 0 L0 0" stroke-width="0"></path>
						</svg>
					</div>';

				endif;

				if('bottom-right' == $cut_bottom) :

					$output .= '
					<div class="ivan-page-cut bottom-right" style="height: '.$cut_bottom_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M100 100 L100 0 L0 0" stroke-width="0"></path>
						</svg>
					</div>';

				endif;

				if('bottom-triangle' == $cut_bottom) :

					$output .= '
					<div class="ivan-page-cut bottom-right bottom-triangle" style="height: '.$cut_bottom_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="'.$cut_bottom_w.'px" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M50 100 L100 0 L0 0" stroke-width="0"></path>
						</svg>
					</div>';

				endif;

				if('inverse-triangle' == $cut_bottom) :

					$output .= '
					<div class="ivan-page-cut bottom-right inverse-tri-mobile" style="height: '.$cut_bottom_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M0 100 L0 100 L38 100 L50 0 L62 100 L100 100 L100 0 L0 0" stroke-width="0"></path>
						</svg>
					</div>';

					$output .= '
					<div class="ivan-page-cut bottom-right inverse-tri" style="height: '.$cut_bottom_h.'px;">
						<svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg" style="'.vc_get_css_color('fill', $bg_color_row).'">
							<path d="M0 100 L0 100 L46 100 L50 0 L54 100 L100 100 L100 0 L0 0" stroke-width="0"></path>
						</svg>
					</div>';

				endif;

			return $output;

		}

		// After
		public static function shortcode_after($output, $atts, $content) {
			// Additional update script

			$js = '';
			if( is_admin() )
				$js = '<textarea class="ivan-script">
					jQuery(document).ready(function() {
						ivan_update_bg();
						jQuery(".ivan-projects-mansory").trigger("ivan_updated_width");
					});
					</textarea>';

			$output = '</div>'.$js;

			return $output;
		}

		//
		//	ROW INNER
		//

		// Before
		public static function shortcode_before_inner($output, $atts, $content) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'anchor' => '',
				'boxed' => '',
				'h' => '', // row custom height
				'bg_type' => '',
				'bg_color_row' => '',
				'bg_image_url' => '',
				'bg_repeat' => '',
				'bg_position' => '',
				'bg_size' => '',
				'bg_att' => '',
				'p_speed' => '0.5', // parallax speed
				'webm' => '',
				'mp4' => '',
				'ogv' => '',
				'preview' => '',
				'overlay' => '',
				'bt_color' => '',
				'bt_width' => '',
				'bb_color' => '',
				'bb_width' => '',
				'v_center' => '',
				'p_top' => '',
				'p_bottom' => '',
				'm_top' => '',
				'm_bottom' => '',
			), $atts) );

			$output = '';
			$styles = '';
			$classes = '';
			$attributes = '';
			$after = '';

			// Paddings / Margins
			if( $p_top != '' )
				$styles .= 'padding-top: '. ivan_style_val( $p_top ) .';';

			if( $p_bottom != '' )
				$styles .= 'padding-bottom: '. ivan_style_val( $p_bottom ) .';';

			if( $m_top != '' )
				$styles .= 'margin-top: '. ivan_style_val( $m_top ) .';';

			if( $m_bottom != '' )
				$styles .= 'margin-bottom: '. ivan_style_val( $m_bottom ) .' !important;';

			// Boxed Style
			if( $boxed == 'yes' )
				$classes .= 'boxed-row ';

			// Custom Height
			if( $h != '' ) {
				$styles .= 'height: '.ivan_style_val( $h ).';';
				$classes .= 'custom-height ';
			}
			// Custom Border
			if( $bt_width != '' ) {
				$styles .= 'border-top-width: '.ivan_style_val( $bt_width ).';';

				if( $bt_color != '' )
					$styles .= 'border-top-color: '. $bt_color.';';							
			}

			if( $bb_width != '' ) {
				$styles .= 'border-bottom-width: '.ivan_style_val( $bb_width ).';';

				if( $bb_color != '' )
					$styles .= 'border-bottom-color: '. $bb_color.';';							
			}

			// Bg Color
			if( $bg_color_row != '' )
				$styles .= 'background-color: '. $bg_color_row.';';

			// Bg Image
			$url = '';
			if( $bg_type == 'image' || $bg_type == 'parallax' ) {
				
				if( $bg_image_url != '' ) {
					$url = wp_get_attachment_image_src( $bg_image_url, 'full');

					$styles .= 'background-image: url('.$url[0].');';
				}
			}

			// Bg Image Specific
			if( $bg_type == 'image' ) {

				if( $bg_repeat != '' )
					$styles .= 'background-repeat: ' . $bg_repeat . ';';

				if( $bg_position != '' )
					$styles .= 'background-position: ' . $bg_position . ';';

				if( $bg_size != '' )
					$styles .= 'background-size: ' . $bg_size . ';';
				
				if( $bg_att != '' )
					$styles .= 'background-attachment: ' . $bg_att . ';';
			}

			// Bg Parallax Specific
			if( $bg_type == 'parallax' ) {

				$classes .= 'parallax-vertical ';

				if( $p_speed != '' ) {
					$attributes .= 'data-speed="'. $p_speed .'" ';
				}

				if( $bg_image_url != '' ) {
					$attributes .= 'data-height="'. $url[2] . '" ';
				}
			}

			// Bg Video
			if( $bg_type == 'video' ) {

				$classes .= 'row-video ';

				$v_image = '';

				if( $preview != '' ) {
					$preview = wp_get_attachment_image_src( $preview, 'full');

					$v_image = $preview[0];

					// Mobile Replacement
					$after .= '<div class="mobile-video-image" style="background-image: url('.$v_image.')"></div>';

					$after .= '<div class="video-wrap">';

						$after .= '<video class="video" poster="'. $v_image .'" controls="controls" preload="auto" loop autoplay muted>';

							if( $webm != '' )
								$after .= '<source type="video/webm" src="'. $webm .'">';

							if( $mp4 != '' )
								$after .= '<source type="video/mp4" src="'. $mp4 .'">';

							if( $ogv != '' )
								$after .= '<source type="video/ogg" src="'. $ogv .'">';

							// Fallback?!

						$after .= '</video>';

					$after .= '</div><!-- .video-wrap -->';
				}
			}

			// Overlay
			if('' != $overlay) {
				$after .= '<div class="row-overlay" style="background-color:' . $overlay .';"></div>';
			}

			// V-Align
			if( $v_center == 'yes' && !is_admin() )
				$classes .= 'v-center ';

			if( $anchor != '' )
				$anchor = 'id="'.$anchor.'"';

			$output = '<div '.$anchor.' '.$attributes.' class="ivan-custom-wrapper '.$classes.'" style="'.$styles.'">' . $after;

			return $output;

		}

		// After
		public static function shortcode_after_inner($output, $atts, $content) {
			// Additional update script

			$js = '';
			if( is_admin() )
				$js = '<textarea class="ivan-script">
					jQuery(document).ready(function() {
						ivan_update_bg();
					});
					</textarea>';

			$output = '</div><!-- .ivan-custom-wrapper -->'.$js;

			return $output;
		}



	} // #end class

	// Ignition!
	$ivan_vc_row = new Ivan_VC_Row();

	if ( !function_exists( 'vc_theme_before_vc_row' ) ) {
		function vc_theme_before_vc_row($atts, $content = null) {
			return apply_filters( 'ivan_custom_row_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_row' ) ) {
		function vc_theme_after_vc_row($atts, $content = null) {
			return apply_filters( 'ivan_custom_row_shortcode_after', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_before_vc_row_inner' ) ) {
		function vc_theme_before_vc_row_inner($atts, $content = null) {
			return apply_filters( 'ivan_custom_row_inner_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_row_inner' ) ) {
		function vc_theme_after_vc_row_inner($atts, $content = null) {
			return apply_filters( 'ivan_custom_row_inner_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check