<?php
/***
 * Extension > Separator
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Gallery') && class_exists('WPBakeryShortCode') ) {

	class Ivan_VC_Gallery extends WPBakeryShortCode {

		public function __construct( $settings ) {
			parent::__construct( $settings );

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_gallery_shortcode', array($this, 'custom_output'), 12, 3 );
		}

		public function custom_output($output, $atts, $content) {
			$output = $title = $type = $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $interval = '';
			extract( shortcode_atts( array(
				'title' => '',
				'type' => 'flexslider',
				'onclick' => 'link_image',
				'custom_links' => '',
				'custom_links_target' => '',
				'img_size' => 'thumbnail',
				'images' => '',
				'el_class' => '',
				'interval' => '5',
				'column_number' => '3',
				'grayscale' => 'no',

				'frame' => 'no',
				'device' => 'macbook',
				'd_color' => 'black',
				'orientation' => 'portrait',
				'd_width' => '',
				'force_height' => '',

				'arr_style' => 'style-thin-outline',

			), $atts ) );
			$gal_images = '';
			$link_start = '';
			$link_end = '';
			$el_start = '';
			$el_end = '';
			$slides_wrap_start = '';
			$slides_wrap_end = '';

			// Adds custom nav styles
			//$arrow_styles = '';
			//$arrow_styles = 'style-thin-outline';
			//$arrow_styles = 'style-thin-outline dark';

			// enqueue owlcarousel styles if arrow is different
			if( $arr_style != '' ) {
				wp_enqueue_style( 'ivan_owl_carousel' );
			}

			$el_class .= ' ' . $arr_style;

			$frame_class = '';

			$el_class = $this->getExtraClass( $el_class );
			if ( $type == 'nivo' ) {
				$type = ' wpb_slider_nivo theme-default';
				wp_enqueue_script( 'nivo-slider' );
				wp_enqueue_style( 'nivo-slider-css' );
				wp_enqueue_style( 'nivo-slider-theme' );

				$slides_wrap_start = '<div class="nivoSlider">';
				$slides_wrap_end = '</div>';
			} else if ( $type == 'flexslider' || $type == 'flexslider_fade' || $type == 'flexslider_slide' || $type == 'fading' ) {
				$el_start = '<li>';
				$el_end = '</li>';
				$slides_wrap_start = '<ul class="slides">';
				$slides_wrap_end = '</ul>';
				wp_enqueue_style( 'flexslider' );
				wp_enqueue_script( 'flexslider' );
			} else if ( $type == 'image_grid' ) {
				wp_enqueue_script( 'isotope' );

				$item_classes = '';

				if($grayscale == 'yes')
					$item_classes .= 'grayscale-effect';
				else
					$item_classes .= 'no-grayscale-effect';

				$el_start = '<li class="isotope-item '. $item_classes .'">';
				$el_end = '</li>';
				$slides_wrap_start = '<div class="iv-gallery-wrapper"><ul class="wpb_image_grid_ul iv-gallery-inner cols-'.$column_number.'">';
				$slides_wrap_end = '</ul></div>';
			}

			if ( $onclick == 'link_image' ) {
				//wp_enqueue_script( 'prettyphoto' );
				//wp_enqueue_style( 'prettyphoto' );
			}

			$flex_fx = '';
			if ( $type == 'flexslider' || $type == 'flexslider_fade' || $type == 'fading' ) {
				$type = ' wpb_flexslider flexslider_fade flexslider';
				$flex_fx = ' data-flex_fx="fade"';
			} else if ( $type == 'flexslider_slide' ) {
				$type = ' wpb_flexslider flexslider_slide flexslider';
				$flex_fx = ' data-flex_fx="slide"';

				if ( $frame == 'use_frame' )
					$frame_class = ' have-frame';

			} else if ( $type == 'image_grid' ) {
				$type = ' wpb_image_grid';
			}


			/*
			 else if ( $type == 'fading' ) {
			    $type = ' wpb_slider_fading';
			    $el_start = '<li>';
			    $el_end = '</li>';
			    $slides_wrap_start = '<ul class="slides">';
			    $slides_wrap_end = '</ul>';
			    wp_enqueue_script( 'cycle' );
			}*/

			//if ( $images == '' ) return null;
			if ( $images == '' ) $images = '-1,-2,-3';

			//$pretty_rel_random = ' rel="prettyPhoto[rel-' . rand() . ']"'; //rel-'.rand();
			$pretty_rel_random = ''; //rel-'.rand();

			if ( $onclick == 'custom_link' ) {
				$custom_links = explode( ',', $custom_links );
			}
			$images = explode( ',', $images );
			$i = - 1;

			foreach ( $images as $attach_id ) {
				$i ++;
				if ( $attach_id > 0 ) {
					$post_thumbnail = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ) );
				} else {
					$post_thumbnail = array();
					$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
					$post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
				}

				$thumbnail = $post_thumbnail['thumbnail'];
				$p_img_large = $post_thumbnail['p_img_large'];
				$link_start = $link_end = '';
				$hover_img = '';

				if( $type == ' wpb_image_grid' && $grayscale == 'no' ) {
					$hover_img = '<span class="iv-gallery-hover"><i class="fa fa-search"></i></span>';
				}

				if ( $onclick == 'link_image' ) {
					$link_start = '<a class="open-in-lightbox" href="' . $p_img_large[0] . '"' . $pretty_rel_random . '>' . $hover_img;
					$link_end = '</a>';
				} else if ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
					$link_start = '<a href="' . $custom_links[$i] . '"' . ( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) . '>';
					$link_end = '</a>';
				}
				$gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
			}
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element' . $el_class . ' vc_clearfix', $this->settings['base'], $atts );

			if( $frame == 'use_frame' ) {

				// Using Frame....

			}

			if ( $onclick == 'link_image' )
				$css_class .= ' iv-open-gallery';

			$output .= "\n\t" . '<div class="' . $css_class . '">';
			$output .= "\n\t\t" . '<div class="wpb_wrapper">';
			$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_gallery_heading' ) );

			if( $frame != 'use_frame' ) {
				$output .= '<div class="wpb_gallery_slides' . $type . $frame_class .'" data-interval="' . $interval . '"' . $flex_fx . '>' . $slides_wrap_start . $gal_images . $slides_wrap_end . '</div>';
			} 
			else if( $frame == 'use_frame' ) {

				$device = do_shortcode('[device type="'.$device.'" color="'.$d_color.'" orientation="'.$orientation.'" width="'. ivan_style_val( $d_width ) .'"]...[/device]');

				$device = str_replace('...', '<div class="wpb_gallery_slides' . $type . $frame_class .'" data-interval="' . $interval . '"' . $flex_fx . '>' . $slides_wrap_start . $gal_images . $slides_wrap_end . '</div>', $device);

				$output .= '<div class="device-wrapper '.$force_height.'">'.$device.'</div>';
			}

			$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
			$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_gallery' );

			return $output;
		}

	} // #end class

	// Ignition!
	global $ivan_vc_gallery;
	$ivan_vc_gallery = new Ivan_VC_Gallery( array( 'base' => 'vc_gallery' ) );

	if ( !function_exists( 'vc_theme_vc_gallery' ) ) {
		function vc_theme_vc_gallery($atts, $content = null) {
			return apply_filters( 'ivan_vc_gallery_shortcode', '', $atts, $content );
		}
	}

} // #end class check