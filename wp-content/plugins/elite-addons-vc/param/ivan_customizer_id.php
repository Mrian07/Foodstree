<?php
// Ivan Customizer Field
if( !class_exists('Ivan_VC_Customizer_ID') ) {
	class Ivan_VC_Customizer_ID {

		protected $settings = array();
		protected $value = '';

		function __construct() {

		}

		/**
		 * Setters/Getters {{
		 */
		function settings($settings = null) {
			if (is_array($settings)) $this->settings = $settings;
			return $this->settings;
		}

		function setting($key) {
			return isset($this->settings[$key]) ? $this->settings[$key] : '';
		}

		function value($value = null) {
			if (is_string($value)) {
				$this->value = $value;
			}
			return $this->value;
		}

		function render() {
			$output = '<div class="vc-ivan-customizer-id" data-ivan-customizer-id="true">';

			// Hidden field to store Custom CSS
			$output .= '<input name="' . $this->setting('param_name') . '" class="wpb_vc_param_value  ' . $this->setting('param_name') . ' ' . $this->setting('type') . '_field" type="text" value="' . esc_attr($this->value()) . '"/>';

			$output .= '</div>';// Wrapper

			return apply_filters('vc_ivan_customizer_id', $output);
		}

	} // #end class
} // #end if class

// Call form field
function ivan_vc_customizer_id_field($settings, $value) {
	$customizer_id_editor = new Ivan_VC_Customizer_ID();
	$customizer_id_editor->settings($settings);
	$customizer_id_editor->value($value);
	return $customizer_id_editor->render();
}