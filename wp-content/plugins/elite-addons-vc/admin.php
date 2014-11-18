<?php

add_action( 'admin_menu', 'ivan_vc_add_admin_menu' );
add_action( 'admin_init', 'ivan_vc_settings_init' );

function ivan_vc_get_option( $id ) {
	$options = get_option( 'ivan_vc_settings' );

	if( isset( $options[$id] ) ) {
		return $options[$id];
	} else {
		return null;
	}
}

//var_dump(get_option( 'ivan_vc_settings' ));

function ivan_vc_add_admin_menu(  ) {

	global $elite_addons_vc_support;

	if( $elite_addons_vc_support == false ) :
		add_options_page( 'Elite Addons', 'Elite Addons', 'manage_options', 'elite_addons', 'elite_addons_options_page' );
	endif;

}


function ivan_vc_settings_exist(  ) { 

	if( false == get_option( 'elite_addons_settings' ) ) { 

		add_option( 'elite_addons_settings' );

	}

}


function ivan_vc_settings_init(  ) {

	global $elite_addons_vc_support;

	if( $elite_addons_vc_support == false ) :

	register_setting( 'pluginPage', 'ivan_vc_settings' );

	add_settings_section(
		'ivan_vc_pluginPage_section', 
		__( 'Customizer', 'iv_js_composer' ), 
		'ivan_vc_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'ivan_vc_primary_bg', 
		__( 'Accent Background', 'iv_js_composer' ), 
		'ivan_vc_primary_bg_render', 
		'pluginPage', 
		'ivan_vc_pluginPage_section' 
	);

	add_settings_field( 
		'ivan_vc_primary_color', 
		__( 'Accent Contrast Color', 'iv_js_composer' ), 
		'ivan_vc_primary_color_render', 
		'pluginPage', 
		'ivan_vc_pluginPage_section' 
	);

	add_settings_field( 
		'ivan_vc_dark_bg', 
		__( 'Dark Background', 'iv_js_composer' ), 
		'ivan_vc_dark_bg_render', 
		'pluginPage', 
		'ivan_vc_pluginPage_section' 
	);

	add_settings_field( 
		'ivan_vc_dark_color', 
		__( 'Dark Contrast Color', 'iv_js_composer' ), 
		'ivan_vc_dark_color_render', 
		'pluginPage', 
		'ivan_vc_pluginPage_section' 
	);

	add_settings_field( 
		'ivan_vc_disable_cpt', 
		__( 'Disable Projects Post Type?', 'iv_js_composer' ), 
		'ivan_vc_disable_cpt_render', 
		'pluginPage', 
		'ivan_vc_pluginPage_section' 
	);

	endif;

}


function ivan_vc_primary_bg_render(  ) { 

	$options = get_option( 'ivan_vc_settings' );
	?>
	<input type='text' name='ivan_vc_settings[ivan_vc_primary_bg]' value='<?php echo $options['ivan_vc_primary_bg']; ?>' class='color-control css-control wp-color-picker'>
	<?php

}


function ivan_vc_primary_color_render(  ) { 

	$options = get_option( 'ivan_vc_settings' );
	?>
	<input type='text' name='ivan_vc_settings[ivan_vc_primary_color]' value='<?php echo $options['ivan_vc_primary_color']; ?>' class='color-control css-control wp-color-picker'>
	<?php

}


function ivan_vc_dark_bg_render(  ) { 

	$options = get_option( 'ivan_vc_settings' );
	?>
	<input type='text' name='ivan_vc_settings[ivan_vc_dark_bg]' value='<?php echo $options['ivan_vc_dark_bg']; ?>' class='color-control css-control wp-color-picker'>
	<?php

}


function ivan_vc_dark_color_render(  ) { 

	$options = get_option( 'ivan_vc_settings' );
	?>
	<input type='text' name='ivan_vc_settings[ivan_vc_dark_color]' value='<?php echo $options['ivan_vc_dark_color']; ?>' class='color-control css-control wp-color-picker'>
	<?php

}


function ivan_vc_disable_cpt_render(  ) { 

	$options = get_option( 'ivan_vc_settings' );
	?>
	<input type='checkbox' name='ivan_vc_settings[ivan_vc_disable_cpt]' <?php checked( $options['ivan_vc_disable_cpt'], 1 ); ?> value='1'> <?php _e('Check to disable.', 'iv_js_composer'); ?>
	<?php

}


function ivan_vc_settings_section_callback(  ) { 

	echo __( 'Customize a few aspects of Elite Addons Plugin.', 'iv_js_composer' );

}


function elite_addons_options_page(  ) { 

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );

	?>
	<form action='options.php' method='post'>
		
		<h2>Elite Addons for Visual Composer</h2>
		
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
		
	</form>

	<script type="text/javascript">
		jQuery(document).ready(function($) {   
			$('.color-control').wpColorPicker();
		});             
	</script>
	<?php

}

/**
 * Basic Customizer
 *
 * This is used to allow users customize primary font, heading font and accent color.
 *
 * Use: http://rvision.ws/cssextractor/
 *
 *
 */

// Customizer Output
function ivan_vc_customizer_output() {

	global $elite_addons_vc_support;

	if( $elite_addons_vc_support == true )
		return;

	$output = '';

	ob_start();

	//
	// Primary Color
	//
	$accentBG = ivan_vc_get_option('ivan_vc_primary_bg');
	$accentColor = '#fff'; // Default
	if( '' != ivan_vc_get_option('ivan_vc_primary_color') && null != ivan_vc_get_option('ivan_vc_primary_color') )
		$accentColor = ivan_vc_get_option('ivan_vc_primary_color');

	if($accentBG != '' && $accentBG != null) :

		// Adjusted Accent Bg
		$darkenAccentBG = iv_vc_adjustColor($accentBG, -13);
	?>
		.ivan-staff-wrapper .social-icons a:hover,
		.ivan-call-action.primary-bg.with-icon .call-action-icon i,
		.ivan-button.outline:hover,
		.ivan-pricing-table.default.dark-bg .signup:hover,
		.ivan-pricing-table.default.black-bg .signup:hover,
		.ivan-pricing-table.big-price .top-section .adquire-plan .signup:hover,
		.ivan-pricing-table.description-support .bottom-section .signup:hover,
		.ivan-pricing-table.subtitle.dark-bg .signup:hover,
		.ivan-pricing-table.subtitle.black-bg .signup:hover,
		.ivan-pricing-table.small-desc.dark-bg .signup:hover,
		.ivan-pricing-table.small-desc.black-bg .signup:hover,
		.marker-icon.ivan-gmap-marker,
		.ivan-title-wrapper.primary-bg .icon-above i,
		.ivan-title-wrapper.primary-bg strong,
		.ivan-title-wrapper.primary-bg a,
		.ivan-title-wrapper.primary-bg a:hover,
		.ivan-service .main-icon,
		.ivan-service.primary-bg .fa-stack .main-icon,
		.ivan-icon-box.primary-bg .icon-box-holder .main-icon,
		.ivan-icon-wrapper .primary-bg .ivan-icon,
		.ivan-icon-wrapper .primary-bg a:hover,
		.ivan-icon-wrapper .primary-bg .ivan-font-stack .stack-holder,
		.ivan-icon-wrapper .primary-bg .ivan-font-stack.with-link:hover .stack-holder,
		.ivan-icon-list.primary-bg i,
		.ivan-list.primary-bg.number ul > li:before {
			color: <?php echo $accentBG; ?>;
		}

		.ivan-button:hover,
		.ivan-button.outline:hover hr,
		.ivan-button.no-border:hover,
		.ivan-button.primary-bg,
		.ivan-projects .ivan-project.hide-entry .entry,
		.ivan-projects .ivan-project.outer-square .entry,
		.ivan-projects .ivan-project.lateral-cover .entry,
		.ivan-projects .ivan-project.smooth-cover .entry,
		.ivan-testimonial.primary-bg.boxed-left .testimonial-content,
		.ivan-service .fa-stack,
		.ivan-service.primary-bg,
		.ivan-progress.primary-bg .ivan-progress-inner,
		.ivan-icon-box.primary-bg .icon-box-holder .fa-stack,
		.ivan-icon-boxed-holder.primary-bg .ivan-icon-boxed-icon-inner .fa-stack,
		.ivan-icon-wrapper .primary-bg .ivan-font-stack-square,
		.ivan-icon-list.primary-bg.circle i,
		.ivan-list.primary-bg.number.circle-in ul > li:before,
		.ivan-list.primary-bg.circle ul > li:before,
		.ivan-quote.primary-bg blockquote,
		.ivan-tabs-wrap .wpb_tour_tabs_wrapper.iv-tabs.iv-boxed .wpb_tabs_nav li.ui-tabs-active a,
		.ivan-vc-separator.primary-bg,
		.ivan-pricing-table.default.primary-bg,
		.ivan-pricing-table.subtitle .featured-table-text,
		.ivan-pricing-table.subtitle.primary-bg,
		.ivan-pricing-table.small-desc .featured-table-text,
		.ivan-pricing-table.small-desc.primary-bg,
		.ivan-projects .ivan-project.cover-entry .entry .read-more a:hover,
		.ivan-projects .ivan-project.soft-cover .entry .read-more a:hover,
		.ivan-icon-wrapper .primary-bg .ivan-font-stack-square.with-link:hover,
		.wpb_toggle.iv-toggle.boxed-arrow.wpb_toggle_title_active,
		.ivan_acc_holder.iv-accordion.with-arrow .ui-state-active {
			background-color: <?php echo $accentBG; ?>;
		}

		.ivan-button:hover,
		.ivan-button.outline:hover,
		.ivan-button.no-border:hover,
		.ivan-button.primary-bg,
		.ivan-button.primary-bg.outline.text-separator.with-icon .text-btn,
		.ivan-pricing-table.default.dark-bg .signup:hover,
		.ivan-pricing-table.default.black-bg .signup:hover,
		.ivan-pricing-table.big-price .top-section .adquire-plan .signup:hover,
		.ivan-pricing-table.description-support .bottom-section .signup:hover,
		.ivan-pricing-table.subtitle.dark-bg .signup:hover,
		.ivan-pricing-table.subtitle.black-bg .signup:hover,
		.ivan-pricing-table.small-desc.dark-bg .signup:hover,
		.ivan-pricing-table.small-desc.black-bg .signup:hover,
		.ivan-projects .ivan-project.cover-entry .entry .read-more a:hover,
		.ivan-projects .ivan-project.soft-cover .entry .read-more a:hover,
		.ivan-service .fa-stack,
		.ivan-icon-box.primary-bg .icon-box-holder .fa-stack,
		.ivan-icon-boxed-holder.primary-bg .ivan-icon-boxed-icon-inner .fa-stack,
		.ivan-tabs-wrap .wpb_tour_tabs_wrapper.iv-tabs.iv-boxed .wpb_tabs_nav li.ui-tabs-active a,
		.ivan-tabs-wrap .wpb_tour_tabs_wrapper.iv-tabs.iv-boxed .wpb_tab {
			border-color: <?php echo $accentBG; ?>;
		}

		.ivan-button:hover,
		.ivan-button.primary-bg,
		.ivan-button.primary-bg:hover,
		.ivan-button.primary-bg.with-icon.icon-cover .icon-simple,
		.ivan-pricing-table.default.primary-bg h3,
		.ivan-pricing-table.default.primary-bg li,
		.ivan-pricing-table.default.primary-bg .plan-infos,
		.ivan-pricing-table.default.primary-bg li a,
		.ivan-pricing-table.default.primary-bg li a:hover,
		.ivan-pricing-table.default.primary-bg .signup,
		.ivan-pricing-table.default.primary-bg .signup:hover,
		.ivan-pricing-table.default.primary-bg .featured-table-text,
		.ivan-pricing-table.subtitle .featured-table-text,
		.ivan-pricing-table.subtitle.primary-bg h3,
		.ivan-pricing-table.subtitle.primary-bg li,
		.ivan-pricing-table.subtitle.primary-bg .plan-infos,
		.ivan-pricing-table.subtitle.primary-bg .plan-subtitle,
		.ivan-pricing-table.subtitle.primary-bg li a,
		.ivan-pricing-table.subtitle.primary-bg li a:hover,
		.ivan-pricing-table.subtitle.primary-bg .signup,
		.ivan-pricing-table.subtitle.primary-bg .signup:hover,
		.ivan-pricing-table.subtitle.primary-bg .featured-table-text,
		.ivan-pricing-table.small-desc .featured-table-text,
		.ivan-pricing-table.small-desc.primary-bg h3,
		.ivan-pricing-table.small-desc.primary-bg li,
		.ivan-pricing-table.small-desc.primary-bg .plan-infos,
		.ivan-pricing-table.small-desc.primary-bg .plan-subtitle,
		.ivan-pricing-table.small-desc.primary-bg li a,
		.ivan-pricing-table.small-desc.primary-bg li a:hover,
		.ivan-pricing-table.small-desc.primary-bg .signup,
		.ivan-pricing-table.small-desc.primary-bg .signup:hover,
		.ivan-pricing-table.small-desc.primary-bg .featured-table-text,
		.ivan-projects .ivan-project.cover-entry .entry .read-more a:hover,
		.ivan-projects .ivan-project.soft-cover .entry .read-more a:hover,
		.ivan-testimonial.primary-bg.boxed-left .testimonial-content,
		.ivan-testimonial.primary-bg.boxed-left .testimonial-content a,
		.ivan-testimonial.primary-bg.boxed-left .testimonial-content a:hover,
		.ivan-service .fa-stack .main-icon,
		.ivan-service.primary-bg .service-title,
		.ivan-service.primary-bg .main-icon,
		.ivan-icon-box.primary-bg .icon-box-holder .fa-stack .main-icon,
		.ivan-icon-boxed-holder.primary-bg .ivan-icon-boxed-icon-inner .fa-stack .main-icon,
		.ivan-icon-wrapper .primary-bg a,
		.ivan-icon-wrapper .primary-bg .ivan-font-stack .main-icon,
		.ivan-icon-wrapper .primary-bg .ivan-font-stack-square i,
		.ivan-icon-list.primary-bg.circle i,
		.ivan-list.primary-bg.number.circle-in ul > li:before,
		.ivan-quote.primary-bg blockquote h5,
		.ivan-quote.primary-bg blockquote .author,
		.ivan-quote.primary-bg blockquote .pull-left,
		.ivan-tabs-wrap .wpb_tour_tabs_wrapper.iv-tabs.iv-boxed .wpb_tabs_nav li.ui-tabs-active a,
		.wpb_toggle.iv-toggle.boxed-arrow.wpb_toggle_title_active,
		.wpb_toggle.iv-toggle.boxed-arrow.wpb_toggle_title_active .toggle-mark .toggle-mark-icon,
		.ivan_acc_holder.iv-accordion.with-arrow .ui-state-active a,
		.ivan_acc_holder.iv-accordion.with-arrow .ui-state-active .accordion-mark .accordion-mark-icon {
			color: <?php echo $accentColor; ?>;
		}

		.ivan-button:hover hr,
		.ivan-button.primary-bg hr,
		.ivan-button.primary-bg:hover hr,
		.ivan-service.primary-bg .fa-stack {
			background-color: <?php echo $accentColor; ?>;
		}

		.ivan-pricing-table.default.primary-bg .signup,
		.ivan-pricing-table.default.primary-bg .signup:hover,
		.ivan-pricing-table.subtitle.primary-bg .signup,
		.ivan-pricing-table.subtitle.primary-bg .signup:hover,
		.ivan-pricing-table.small-desc.primary-bg .signup,
		.ivan-pricing-table.small-desc.primary-bg .signup:hover,
		.ivan-service.primary-bg .fa-stack {
			border-color: <?php echo $accentColor; ?>;
		}

		// Darken Accent Bg
		.ivan-button.primary-bg:hover,
		.ivan-button.primary-bg.outline hr,
		.ivan-button.primary-bg.outline:hover hr,
		.ivan-button.primary-bg.outline.icon-cover.with-icon .icon-simple,
		.ivan-pricing-table.default.primary-bg .featured-table-text,
		.ivan-pricing-table.subtitle.primary-bg .featured-table-text,
		.ivan-pricing-table.small-desc.primary-bg .featured-table-text {
			background-color: <?php echo $darkenAccentBG; ?>;
		}

		.ivan-button.primary-bg:hover {
			border-color: <?php echo $darkenAccentBG; ?>;
		}

		.ivan-button.primary-bg.outline,
		.ivan-button.primary-bg.outline:hover {
			color: <?php echo $darkenAccentBG; ?>;
		}

		.ivan-service.primary-bg .content-section-holder li,
		.ivan-service.primary-bg .content-section-holder p {
		  border-color: <?php echo iv_vc_adjustColor($accentBG, -7); ?>;
		}

	<?php
	endif;

	//
	// Dark Color
	//
	$darkBG = ivan_vc_get_option('ivan_vc_dark_bg');
	$darkColor = '#fff'; // Default
	if( '' != ivan_vc_get_option('ivan_vc_dark_color') && null != ivan_vc_get_option('ivan_vc_dark_color') )
		$darkColor = ivan_vc_get_option('ivan_vc_dark_color');

	if($darkBG != '' && $darkBG != null) :
		// Adjusted Dark Bg
		$darkenDarkBG = iv_vc_adjustColor($darkBG, -13);
	?>

		.ivan-call-action.dark-bg.boxed,
		.ivan-button.dark-bg,
		.ivan-testimonial.dark-bg.boxed-left .testimonial-content,
		.ivan-title-wrapper.dark-bg .ivan-vc-separator.small,
		.ivan-pie-chart-holder.dark-bg .ivan-pie-chart-content .ivan-vc-separator,
		.ivan-service.dark-bg,
		.ivan-progress.dark-bg .ivan-progress-outer,
		.ivan-icon-box.dark-bg .icon-box-holder .fa-stack,
		.ivan-icon-boxed-holder.dark-bg,
		.ivan-icon-wrapper .dark-bg .ivan-font-stack-square,
		.ivan-icon-list.dark-bg.circle i,
		.ivan-list.dark-bg.number.circle-in ul > li:before,
		.ivan-list.dark-bg.circle ul > li:before,
		.ivan-quote.dark-bg blockquote,
		.ivan-vc-separator.dark-bg,
		.ivan-pricing-table.default.dark-bg,
		.ivan-pricing-table.subtitle.dark-bg,
		.ivan-pricing-table.small-desc.dark-bg,
		.ivan-icon-wrapper .dark-bg .ivan-font-stack-square.with-link:hover {
			background-color: <?php echo $darkBG; ?>;
		}

		.ivan-call-action.dark-bg.opaque.with-icon .call-action-icon i,
		.ivan-call-action.dark-bg.opaque .call-action-text-inner .call-action-heading-text,
		.ivan-call-action.dark-bg.opaque .call-action-text-inner .call-action-text,
		.ivan-testimonial.dark-bg .testimonial-content,
		.ivan-testimonial.dark-bg .testimonial-content a,
		.ivan-testimonial.dark-bg .testimonial-content a:hover,
		.ivan-testimonial.dark-bg .author-name,
		.ivan-testimonial.dark-bg .author-desc,
		.ivan-title-wrapper.dark-bg .title-heading,
		.ivan-title-wrapper.dark-bg .sub,
		.ivan-title-wrapper.dark-bg i,
		.ivan-title-wrapper.dark-bg strong,
		.ivan-title-wrapper.dark-bg a,
		.ivan-title-wrapper.dark-bg a:hover,
		.ivan-pie-chart-holder.dark-bg .ivan-pie-chart,
		.ivan-pie-chart-holder.dark-bg .ivan-pie-chart-content .pie-chart-heading,
		.ivan-pie-chart-holder.dark-bg .pie-chart-content-inner,
		.ivan-service.dark-bg .fa-stack .main-icon,
		.ivan-progress.dark-bg .progress-title-holder,
		.ivan-icon-box.dark-bg .icon-box-text-holder .icon-box-title,
		.ivan-icon-box.dark-bg .icon-box-content,
		.ivan-icon-box.dark-bg .icon-box-holder .main-icon,
		.ivan-icon-box.dark-bg a,
		.ivan-icon-box.dark-bg a:hover,
		.ivan-icon-boxed-holder.dark-bg .ivan-icon-boxed-icon-inner .fa-stack .main-icon,
		.ivan-icon-wrapper .dark-bg .ivan-icon,
		.ivan-icon-wrapper .dark-bg a,
		.ivan-icon-wrapper .dark-bg a:hover,
		.ivan-icon-wrapper .dark-bg .ivan-font-stack .stack-holder,
		.ivan-icon-wrapper .dark-bg .ivan-font-stack.with-link:hover .stack-holder,
		.ivan-icon-list.dark-bg p,
		.ivan-icon-list.dark-bg i,
		.ivan-list.dark-bg li,
		.ivan-list.dark-bg.number ul > li:before {
			color: <?php echo $darkBG; ?>;
		}

		.ivan-progress.dark-bg .ivan-progress-outer,
		.ivan-icon-box.dark-bg .icon-box-holder .fa-stack,
		.ivan-icon-box.dark-bg hr,
		.ivan-icon-boxed-holder.dark-bg {
			border-color: <?php echo $darkBG; ?>;
		}

		.ivan-call-action.dark-bg.boxed.with-icon .call-action-icon i,
		.ivan-call-action.dark-bg.boxed .call-action-text-inner .call-action-heading-text,
		.ivan-call-action.dark-bg.boxed .call-action-text-inner .call-action-text,
		.ivan-dual-button .dark-bg .middle-text,
		.ivan-button.dark-bg,
		.ivan-button.dark-bg:hover,
		.ivan-button.dark-bg.with-icon.icon-cover .icon-simple,
		.ivan-pricing-table.default.dark-bg h3,
		.ivan-pricing-table.default.dark-bg li,
		.ivan-pricing-table.default.dark-bg .plan-infos,
		.ivan-pricing-table.default.dark-bg li a,
		.ivan-pricing-table.default.dark-bg li a:hover,
		.ivan-pricing-table.default.dark-bg .signup,
		.ivan-pricing-table.default.dark-bg .featured-table-text,
		.ivan-pricing-table.subtitle.dark-bg h3,
		.ivan-pricing-table.subtitle.dark-bg li,
		.ivan-pricing-table.subtitle.dark-bg .plan-infos,
		.ivan-pricing-table.subtitle.dark-bg .plan-subtitle,
		.ivan-pricing-table.subtitle.dark-bg li a,
		.ivan-pricing-table.subtitle.dark-bg li a:hover,
		.ivan-pricing-table.subtitle.dark-bg .signup,
		.ivan-pricing-table.subtitle.dark-bg .featured-table-text,
		.ivan-pricing-table.small-desc.dark-bg h3,
		.ivan-pricing-table.small-desc.dark-bg li,
		.ivan-pricing-table.small-desc.dark-bg .plan-infos,
		.ivan-pricing-table.small-desc.dark-bg .plan-subtitle,
		.ivan-pricing-table.small-desc.dark-bg li a,
		.ivan-pricing-table.small-desc.dark-bg li a:hover,
		.ivan-pricing-table.small-desc.dark-bg .signup,
		.ivan-pricing-table.small-desc.dark-bg .featured-table-text,
		.ivan-testimonial.dark-bg.boxed-left .testimonial-content,
		.ivan-testimonial.dark-bg.boxed-left .testimonial-content a,
		.ivan-testimonial.dark-bg.boxed-left .testimonial-content a:hover,
		.ivan-service.dark-bg .content-section-holder li,
		.ivan-service.dark-bg .content-section-holder p,
		.ivan-service.dark-bg .content-section-holder a,
		.ivan-service.dark-bg .content-section-holder a:hover,
		.ivan-service.dark-bg .service-title,
		.ivan-service.dark-bg .main-icon,
		.ivan-service.primary-bg .content-section-holder li,
		.ivan-service.primary-bg .content-section-holder p,
		.ivan-service.primary-bg .content-section-holder a,
		.ivan-service.primary-bg .content-section-holder a:hover,
		.ivan-icon-box.dark-bg .icon-box-holder .fa-stack .main-icon,
		.ivan-icon-boxed-holder.dark-bg .icon-box-title,
		.ivan-icon-boxed-holder.dark-bg .icon-box-content,
		.ivan-icon-boxed-holder.dark-bg a,
		.ivan-icon-boxed-holder.dark-bg a:hover,
		.ivan-icon-wrapper .dark-bg .ivan-font-stack .main-icon,
		.ivan-icon-wrapper .dark-bg .ivan-font-stack-square i,
		.ivan-icon-list.dark-bg.circle i,
		.ivan-list.dark-bg.number.circle-in ul > li:before,
		.ivan-quote.dark-bg blockquote h5,
		.ivan-quote.dark-bg blockquote .author,
		.ivan-quote.dark-bg blockquote .pull-left {
			color: <?php echo $darkColor; ?>;
		}

		.ivan-button.dark-bg hr,
		.ivan-button.dark-bg:hover hr,
		.ivan-service.dark-bg .fa-stack,
		.ivan-progress.dark-bg .ivan-progress-inner,
		.ivan-icon-boxed-holder.dark-bg .ivan-icon-boxed-icon-inner .fa-stack {
			background-color: <?php echo $darkColor; ?>;
		}

		.ivan-pricing-table.default.dark-bg .signup,
		.ivan-pricing-table.subtitle.dark-bg .signup,
		.ivan-pricing-table.small-desc.dark-bg .signup,
		.ivan-service.dark-bg .fa-stack,
		.ivan-icon-boxed-holder.dark-bg .ivan-icon-boxed-icon-inner .fa-stack {
			border-color: <?php echo $darkColor; ?>;
		}

		// Darken Dark Bg
		.ivan-dual-button .dark-bg .middle-text,
		.ivan-button.dark-bg,
		.ivan-button.dark-bg:hover {
			border-color: <?php echo $darkenDarkBG; ?>;
		}

		.ivan-dual-button .dark-bg .middle-text,
		.ivan-pricing-table.default.dark-bg .featured-table-text,
		.ivan-pricing-table.subtitle.dark-bg .featured-table-text,
		.ivan-pricing-table.small-desc.dark-bg .featured-table-text,
		.ivan-button.dark-bg:hover,
		.ivan-button.dark-bg.outline hr,
		.ivan-button.dark-bg.outline:hover hr,
		.ivan-button.dark-bg.outline.icon-cover.with-icon .icon-simple {
			background: <?php echo $darkenDarkBG; ?>;
		}

		.ivan-button.dark-bg.outline,
		.ivan-button.dark-bg.outline:hover {
			color: <?php echo $darkenDarkBG; ?>;
		}

		.ivan-service.dark-bg .content-section-holder li,
		.ivan-service.dark-bg .content-section-holder p {
		  border-color: <?php echo iv_vc_adjustColor($darkBG, -7); ?>;
		}
			
	<?php
	endif;

	$output = ob_get_contents();
	ob_end_clean();
	// Check if can print something...
	if('' != $output) :
		echo '<style type="text/css">' . $output . '</style>';
	endif;// end main check

}
add_action('wp_head', 'ivan_vc_customizer_output', 200);

function iv_vc_adjustColor($hex, $steps) { // 2.55 = 1 %
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}

add_filter('ivan_pie_chart_active_primary', 'custom_ivan_vc_pie_chart_active_primary', 105);
function custom_ivan_vc_pie_chart_active_primary( $color ) {
	$accentBG = ivan_vc_get_option('ivan_vc_primary_bg');

	if($accentBG != '' && $accentBG != null)
		$color = $accentBG;

	return $color;
}