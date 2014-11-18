<?php
/***
 * Module > Staff
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_staff extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'infos_inside' => 'no',
				'social_inside' => 'no',
				'content_inside' => 'no',
				'overlay' => 'no',
				'opacity' => 'no',
				'grayscale' => 'no',
				'align' => ' to-center',
				'image_id' => '',
				'name' => '',
				'job_title' => '',
				'sep' => '',
				'social_auto' => 'yes',
				'el_class' => '',
				'template' => '',
			), $atts) );

			$output = '';
			$classes = '';

			//$overlay = 'yes';
			//$opacity = 'yes';
			//$grayscale = 'yes';

			//$sep = 'no';

			//$social_auto = 'yes';

			//$infos_inside = 'yes';
			//$social_inside = 'yes';
			//$content_inside = 'yes';

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

			$infos_inside = $infos_inside;
			$social_inside = $social_inside;

			// Effects
			if('yes' == $overlay)
				$classes .= ' overlay-enabled';
			if('yes' == $opacity)
				$classes .= ' opacity-enabled';
			if('yes' == $grayscale)
				$classes .= ' gray-enabled';

			if( $social_auto == 'yes' ) {
				$classes .= ' social-auto';
			}

			$classes .= $align;

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Add custom template class
			if('' != $template)
				$classes .= ' ' . $template;

			// Social Markup
			$social_markup = '';

			// Social Icon List
			$ivan_icon_array = ivan_vc_staff_icons();

			foreach ($ivan_icon_array as $key => $value) {

				if(isset($atts[$key])) {
					$social_markup .= '<a href="'.$atts[$key].'" class="social-icon-inner sa sa-'.str_replace('_', '-', $key).'" target="_blank"><i class="fa fa-'.str_replace('_', '-', $key).'"></i></a>';
				}
			}

			//
			if( ('yes' == $social_inside && '' != $social_markup) OR ('yes' == $content_inside) )
				$classes .= ' has-flip';

			// Output Form
			ob_start();
			?>
			<div class="ivan-staff-main <?php echo $prefixClass; ?>">
				<div class="ivan-staff-wrapper taphover <?php echo $classes; ?>">
					<?php if('' != $image_id) : ?>
						<div class="thumbnail">
							<?php
							$url = wp_get_attachment_image_src($image_id, 'full');
							echo '<img src="'. $url['0'].'" alt="">';
							?>

							<span class="overlay"></span>

							<?php if('yes' == $infos_inside) : ?>
								<div class="in-infos-holder">
									<div class="name"><?php echo $name; ?></div>
									<?php if('' != $job_title) : ?>
										<div class="job-title"><?php echo $job_title; ?></div>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if( ('yes' == $social_inside && '' != $social_markup) OR ('yes' == $content_inside) ) : ?>
								<div class="in-flip-holder">

									<?php if($content != '' && $content != null && 'yes' == $content_inside ) : ?>
										<div class="description"><?php echo do_shortcode($content); ?></div>
									<?php endif; ?>

									<?php if( 'yes' == $social_inside && '' != $social_markup ) : ?>
										<div class="social-icons"><?php echo $social_markup; ?></div>
									<?php endif; ?>		

								</div>
							<?php endif; ?>

						</div>
					<?php endif; ?>

					<?php if('yes' != $infos_inside OR ('' != $content && $content_inside != 'yes') OR 'yes' != $social_inside) : ?>
						<div class="infos">
							<?php if('yes' != $infos_inside) : ?>
								<div class="name"><?php echo $name; ?></div>
								<?php if('' != $job_title) : ?>
									<div class="job-title"><?php echo $job_title; ?></div>
								<?php endif; ?>
							<?php endif; ?>
							<?php if($content != '' && $content != null && 'yes' != $content_inside ): ?>
								<div class="description"><?php echo do_shortcode($content); ?></div>
							<?php endif; ?>

							<?php
							// Separator Logic
							if( $sep != 'no' ) {
								if( ( $sep == 'yes' && $sep != 'no' ) OR ( ($content != '' && $content != null && $content_inside != 'yes' && 'yes' != $social_inside) OR ('yes' != $social_inside && '' != $social_markup && 'yes' != $infos_inside) ) ) : ?>
									<hr>
								<?php 
								endif; 
							} ?>

							<?php if('yes' != $social_inside && '' != $social_markup) : ?>
								<div class="social-icons">
										<?php echo $social_markup; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

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
			'block_css' => array(
				// Spacing
				'margin-top' => '&',
				'margin-right' => '&',
				'margin-bottom' => '&',
				'margin-left' => '&',
				'padding-top' => '.ivan-staff-wrapper',
				'padding-right' => '.ivan-staff-wrapper',
				'padding-bottom' => '.ivan-staff-wrapper',
				'padding-left' => '.ivan-staff-wrapper',
				// Bg
				'background-color' => '.ivan-staff-wrapper',
				// Border Radius
				'border-top-left-radius' => '.ivan-staff-wrapper',
				'border-top-right-radius' => '.ivan-staff-wrapper',
				'border-bottom-left-radius' => '.ivan-staff-wrapper',
				'border-bottom-right-radius' => '.ivan-staff-wrapper',
				// Border
				'border-top-width' => '.ivan-staff-wrapper',
				'border-right-width' => '.ivan-staff-wrapper',
				'border-bottom-width' => '.ivan-staff-wrapper',
				'border-left-width' => '.ivan-staff-wrapper',
				'border-style' => '.ivan-staff-wrapper',
				'border-color' => '.ivan-staff-wrapper',
			),
			'overlay_css' => array(
				// Bg
				'background-color' => '.thumbnail',
			),
			'infos_css' => array(
				// Spacing
				'padding-top' => '.infos',
				'padding-right' => '.infos',
				'padding-bottom' => '.infos',
				'padding-left' => '.infos',
				// Bg
				'background-color' => '.infos',
				// Border Radius
				'border-top-left-radius' => '.infos',
				'border-top-right-radius' => '.infos',
				'border-bottom-left-radius' => '.infos',
				'border-bottom-right-radius' => '.infos',
				// Border
				'border-top-width' => '.infos',
				'border-right-width' => '.infos',
				'border-bottom-width' => '.infos',
				'border-left-width' => '.infos',
				'border-style' => '.infos',
				'border-color' => '.infos',
			),
			'title_css' => array(
				// Font
				'font-family' => '.name',
				'font-weight' => '.name',
				'font-size' => '.name',
				'line-height' => '.name',
				'text-transform' => '.name',
				'color' => '.name',
				// Dimensions
				//'width' => '.name',
				//'height' => '.name',
				// Spacing
				'margin-top' => '.name',
				'margin-right' => '.name',
				'margin-bottom' => '.name',
				'margin-left' => '.name',
			),
			'job_css' => array(
				// Font
				'font-family' => '.job-title',
				'font-weight' => '.job-title',
				'font-size' => '.job-title',
				'line-height' => '.job-title',
				'text-transform' => '.job-title',
				'color' => '.job-title',
				// Dimensions
				//'width' => '.job-title',
				//'height' => '.job-title',
				// Spacing
				'margin-top' => '.job-title',
				'margin-right' => '.job-title',
				'margin-bottom' => '.job-title',
				'margin-left' => '.job-title',
			),
			'desc_css' => array(
				// Font
				'font-family' => '.description',
				'font-weight' => '.description',
				'font-size' => '.description',
				'line-height' => '.description',
				'text-transform' => '.description',
				'color' => '.description',
				// Dimensions
				//'width' => '.description',
				//'height' => '.description',
				// Spacing
				'margin-top' => '.description',
				'margin-right' => '.description',
				'margin-bottom' => '.description',
				'margin-left' => '.description',
			),
			'sep_css' => array(
				// Dimensions
				'width' => 'hr',
				'height' => 'hr',
				// Spacing
				'margin-top' => 'hr',
				'margin-right' => 'hr',
				'margin-bottom' => 'hr',
				'margin-left' => 'hr',
				// Bg
				'background-color' => 'hr',
			),
			'social_css' => array(
				// Font
				//'font-family' => '.social-icons',
				//'font-weight' => '.social-icons',
				'font-size' => '.social-icons a',
				'line-height' => '.social-icons a',
				//'text-transform' => '.social-icons',
				'color' => '.social-icons a',
				// Dimensions
				'width' => '.social-icons a',
				'height' => '.social-icons a',
				// Spacing
				'margin-top' => '.social-icons',
				'margin-right' => '.social-icons a',
				'margin-bottom' => '.social-icons',
				'margin-left' => '.social-icons a',
				'padding-top' => '.social-icons a',
				'padding-right' => '.social-icons a',
				'padding-bottom' => '.social-icons a',
				'padding-left' => '.social-icons a',
				// Bg
				'background-color' => '.social-icons a',
				// Border Radius
				'border-top-left-radius' => '.social-icons a',
				'border-top-right-radius' => '.social-icons a',
				'border-bottom-left-radius' => '.social-icons a',
				'border-bottom-right-radius' => '.social-icons a',
				// Border
				'border-top-width' => '.social-icons a',
				'border-right-width' => '.social-icons a',
				'border-bottom-width' => '.social-icons a',
				'border-left-width' => '.social-icons a',
				'border-style' => '.social-icons a',
				'border-color' => '.social-icons a',
				// Hovers
				'color-hover' => '.social-icons a',
				'border-color-hover' => '.social-icons a',
				'background-color-hover' => '.social-icons a',
			),
		);

		public $prefix = '';

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_staff;
	$ivan_vc_staff = new WPBakeryShortCode_ivan_staff( array('name' => 'Staff', 'base' => 'ivan_staff') );

} // #end class check