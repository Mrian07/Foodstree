<?php
/***
 * Extension > Single Image
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_SingleImage') && class_exists('WPBakeryShortCode') ) {
	class Ivan_VC_SingleImage extends WPBakeryShortCode {

		// Contructor
		public function __construct( $settings ) {

			parent::__construct( $settings );

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_single_image_shortcode_before', array($this, 'shortcode_before'), 10, 3 );
			add_filter( 'ivan_vc_single_image_shortcode', array($this, 'shortcode_output'), 10, 3 );
			add_filter( 'ivan_vc_single_image_shortcode_after', array($this, 'shortcode_after'), 15, 3 );

		}

		// Shortcode
		public function shortcode_before($output, $atts, $content) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'lightbox' => '',
				'content_type' => 'mfp-image', // default is image, but support video
				'enable_cover' => '',
			), $atts) );
			
			$output = '';

			if($lightbox == 'yes') :

				if( $enable_cover == 'yes' )
					$content_type .= ' with-cover';

				$output .= '<div class="ivan-single-image-wrap '. $content_type .'">';
				
			endif;
			
			return $output;
		}

		// Shortcode
		public function shortcode_output($output, $atts, $content) {
			$output = $el_class = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $alignment = $css_animation = $css = '';

			extract( shortcode_atts( array(
				'title' => '',
				'image' => $image,
				'img_size' => 'thumbnail',
				'img_link_large' => false,
				'img_link' => '',
				'link' => '',
				'img_link_target' => '_self',
				'alignment' => 'left',
				'el_class' => '',
				'css_animation' => '',
				'style' => '',
				'border_color' => '',
				'css' => '',
				'lightbox' => '',
				'enable_cover' => '',
			), $atts ) );

			$style = ( $style != '' ) ? $style : '';
			$border_color = ( $border_color != '' ) ? ' vc_box_border_' . $border_color : '';

			$img_id = preg_replace( '/[^\d]/', '', $image );
			$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => $style . $border_color ) );
			if ( $img == NULL ) $img['thumbnail'] = '<img class="' . $style . $border_color . '" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; //' <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';

			$el_class = $this->getExtraClass( $el_class );

			$a_class = '';
			if ( $el_class != '' ) {
				$tmp_class = explode( " ", strtolower( $el_class ) );
				$tmp_class = str_replace( ".", "", $tmp_class );
				if ( in_array( "prettyphoto", $tmp_class ) ) {
					wp_enqueue_script( 'prettyphoto' );
					wp_enqueue_style( 'prettyphoto' );
					$a_class = ' class="prettyphoto"';
					$el_class = str_ireplace( " prettyphoto", "", $el_class );
				}
			}

			$link_to = '';
			if ( $img_link_large == true ) {
				$link_to = wp_get_attachment_image_src( $img_id, 'large' );
				$link_to = $link_to[0];
			} else if ( strlen($link) > 0 ) {
				$link_to = $link;
			} else if ( ! empty( $img_link ) ) {
				$link_to = $img_link;
				if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link_to ) ) $link_to = 'http://' . $link_to;
			}
			//to disable relative links uncomment this..


			$img_output = ( $style == 'vc_box_shadow_3d' ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : $img['thumbnail'];

			if($lightbox == 'yes') :

				if( $enable_cover == 'yes' )
					$img_output = '<span class="iv-gallery-hover"><i class="fa fa-search"></i></span>' . $img_output;

			endif;

			$image_string = ! empty( $link_to ) ? '<a' . $a_class . ' href="' . $link_to . '"' . ' target="' . $img_link_target . '"'. '>' . $img_output . '</a>' : $img_output;
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
			$css_class .= $this->getCSSAnimation( $css_animation );

			$css_class .= ' vc_align_' . $alignment;

			$output .= "\n\t" . '<div class="' . $css_class . '">';
			$output .= "\n\t\t" . '<div class="wpb_wrapper">';
			$output .= "\n\t\t\t" . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) );
			$output .= "\n\t\t\t" . $image_string;
			$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
			$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_single_image' );

			return $output;
		}

		// Shortcode
		public function shortcode_after($output, $atts, $content) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'lightbox' => '',
			), $atts) );
			
			$output = '';

			if($lightbox == 'yes') :
				$output = '</div>';
			endif;

			return $output;
		}

	} // #end class

	// Ignition!
	global $ivan_vc_single_image;
	$ivan_vc_single_image = new Ivan_VC_SingleImage( array( 'base' => 'vc_single_image' ) );

	if ( !function_exists( 'vc_theme_before_vc_single_image' ) ) {
		function vc_theme_before_vc_single_image($atts, $content = null) {
			return apply_filters( 'ivan_vc_single_image_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_vc_single_image' ) ) {
		function vc_theme_vc_single_image($atts, $content = null) {
			return apply_filters( 'ivan_vc_single_image_shortcode', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_single_image' ) ) {
		function vc_theme_after_vc_single_image($atts, $content = null) {
			return apply_filters( 'ivan_vc_single_image_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check