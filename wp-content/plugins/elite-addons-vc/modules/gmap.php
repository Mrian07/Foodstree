<?php
/***
 * Module > GMap
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_ivan_gmap extends WPBakeryShortCode {

		// Shortcode
		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'height' => '350',
				'lat' => '',
				'long' => '',
				'address' => '',
				'scroll' => 'true',
				'drag' => 'true',
				'noui' => 'false',
				'zoom' => '16',
				'marker' => '',

				'ico_family' => 'fa fa-',
				'ico' => 'map-marker',
				'ico_custom' => '',
				'ico_image' => '',

				'grayscale' => '',
				'el_class' => '',
			), $atts) );

			$output = '';

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

			$prefixAttr = str_replace(' ', '', $prefixClass);

			wp_enqueue_script( 'ivan_vc_gmap_api');
			wp_enqueue_script( 'ivan_vc_gmaps');
			
			// Display Main Wrapper
			$output .= '<div class="ivan-gmap-main-wrapper ' . $el_class . ' ' . $prefixAttr . '">';
				$output .= '<div class="ivan-gmap-inner">';

					$output .= '<div id="map-' . $prefixAttr . '" style="height: '.$height.'px;"></div>';

				$output .= '</div>';// .ivan-posts-inner
			$output .= '</div>';// .ivan-posts-main-wrapper

			// Generate Script to be printed
			$mapAttributes = '';

				$mapAttributes .= 'scrollwheel: '.$scroll.',';
				$mapAttributes .= 'draggable: '.$drag.',';
				$mapAttributes .= 'disableDefaultUI: '.$noui.',';
				$mapAttributes .= 'zoom: '.$zoom.',';

			// Generate Map JavaScript Code
			$mapCode = '';

			$prefixVar = str_replace(' ', '', $prefixClass);

			if( ($lat != '' AND $long != '') OR $address != '' ) {

				if($address == '') :
					$mapCode .= "

						var map_".$prefixVar.";

						map_".$prefixVar." = new GMaps({
							el: '#map-". $prefixAttr ."',
							lat: ". $lat .",
							lng: ". $long .",
							". apply_filters('ivan_gmap_attrs', $mapAttributes) ."
						});
					";
				else :

					$mapCode .= "
					GMaps.geocode({
						address: '".$address."',
						callback: function(results, status) {
							if(status == 'OK') {
								var latlng = results[0].geometry.location;
								";

								$mapCode .= "

									var map_".$prefixVar.";

									map_".$prefixVar." = new GMaps({
										el: '#map-". $prefixAttr ."',
										lat: latlng.lat(),
										lng: latlng.lng(),
										". apply_filters('ivan_gmap_attrs', $mapAttributes) ."
									});
								";

				endif;

				if('yes' == $marker) :

					$markerIcon = '<i class="fa fa-map-marker marker-icon ivan-gmap-marker"></i>';

					// Generate Icon Markup
					if( '' == $ico_image ) {

						if('' != $ico) :
							$markerIcon = '<i class="'.$ico_family.$ico.' marker-icon ivan-gmap-marker"></i>';
						endif;

						if('' != $ico_custom) :
							$markerIcon = '<i class="'.$ico_custom.' marker-icon ivan-gmap-marker"></i>';
						endif;

					} else {
						// if it's using an image

						if( is_numeric($ico_image) ) {
							$image_src = wp_get_attachment_url( $ico_image );
						} else {
							$image_src = $ico_image;
						}

						$markerIcon = '<img class="ivan-gmap-img" src="'.$image_src.'" alt="">';
					}

					$mapCode .= "
						map_".$prefixVar.".drawOverlay({
							lat: map_".$prefixVar.".getCenter().lat(),
							lng: map_".$prefixVar.".getCenter().lng(),
							content: '" . apply_filters('ivan_gmap_marker', $markerIcon) ."',
							verticalAlign: 'top',
							horizontalAlign: 'center'
						});
					";

				endif;

				if('yes' == $grayscale) :
					$mapCode .= "
						// The styles below present your map in muted colours. If you would like to use the standard map colours, then please remove the code below.
						var styles = [{
								stylers: [{
								saturation: -100
								}]
							}, {
									featureType: \"road\",
									elementType: \"geometry\",
									stylers: [{
								lightness: 100
							}, {
								visibility: \"simplified\"
								}]
							}, {
									featureType: \"road\",
									elementType: \"labels\",
									stylers: [{
								visibility: \"off\"
							}]
						}];
						 
						map_".$prefixVar.".setOptions({
								styles: styles
						});
					";
				endif;

				if($address != '') :

					$mapCode .= "}
						}
					}); // Ends GeoCode Function
					";

				endif;

			}// ends main check of GMAP

			if(!is_admin()) {

				$output .= '<script type="text/javascript">
					jQuery(document).ready( function() {
						';
					
					$output .= $mapCode;
				
					
				$output .= '});</script>';
			
			} else {
				$output .= '<textarea class="ivan-script">

					jQuery(document).ready( function() {
						';

					$output .= $mapCode;

				$output .= '});</textarea>';
			}							

			// Apply Custom Styles
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
			
			return $output;
		}

		// H1 Selectors
		public $selectors = array(
			'marker_css' => array(
				// Font
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				'font-size' => '.marker-icon.ivan-gmap-marker',
				//'line-height' => 'h1',
				'color' => '.marker-icon.ivan-gmap-marker',
				// Dimensions
				'width' => '.ivan-gmap-img',
				'height' => '.ivan-gmap-img',
			),
		);

		public $prefix = '';

	} // #end class

	// Init global var to store this module data
	global $ivan_vc_gmap;
	$ivan_vc_gmap = new WPBakeryShortCode_ivan_gmap( array('name' => 'GMap', 'base' => 'ivan_gmap') );

 } // #end class check