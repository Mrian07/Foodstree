<?php
/***
 * General Shortcodes that aren't used as modules
 *
 * This file will store all the shortcodes that aren't converted to modules...
 *
 **/

//
// Lead Text
//
if (!function_exists('ivan_lead')) {
	function ivan_lead($atts, $content = null) {
		$args = array(
			"style" => '', // default or light
			"align" => '',
			"margin" => '',
		);
		extract(shortcode_atts($args, $atts));

		$style = '';

		if($align != '')
			$style .= 'text-align:'.$align.';';

		if($margin != '')
			$style .= 'margin-bottom:'.ivan_style_val($margin).';';

		$output = '<p class="ivan-lead '.$style.'" style="'.$style.'">'.do_shortcode($content).'</p>';

		return $output;
	}
	add_shortcode('iv_lead', 'ivan_lead');
}

//
// Animated Arrow
//
if (!function_exists('ivan_arrow')) {
	function ivan_arrow($atts, $content = null) {
		$args = array(
			'anim' => '',
			'ico' => 'angle-down',
			'size' => 'tiny',
			'link' => '',
			'target' => '',
			'outline' => 'circle',
			'border' => '', // double
			'style' => '', // light
		);
		extract(shortcode_atts($args, $atts));

		$before = '';
		$after = '';

		//$anim = 'shake';
		//$anim = 'pulse';

		//$outline = 'square';
		//$outline = '';

		//$style = 'light';

		//$link = '#';

		//$border = 'double';

		// Sizes
		switch ($size) {
			case 'tiny':
				$size = 'fa-lg';
				break;
			case 'small':
				$size = 'fa-2x';
			case 'medium':
				$size = 'fa-3x';
				break;
			case 'large':
				$size = 'fa-5x';
				break;
			case 'xlarge':
				$size = 'fa-5x';
				break;
			default:
				$size = 'fa-3x';
				break;
		}

		if($link != '') {
			if($target != '')
				$target = ' target="_blank"';
			else
				$target = '';

			$before = '<a href="'.$link.'"'.$target.'>';
			$after = '</a>';

		}

		$ico_size = $size;
		if($outline == 'square' OR $outline == 'circle') {
			$ico_size = 'fa-1x';
		} else {
			$size = '';
		}

		$output = '<div class="ivan-arrow-wrapper"><div class="ivan-arrow '.$anim.' '.$outline.' '.$style.' '.$border.'">'.$before.'<span class="fa-stack '.$size.'"><i class="fa fa-'.$ico.' '.$ico_size.'"></i></span>'.$after.'</div></div>';

		return $output;
	}
	add_shortcode('iv_arrow', 'ivan_arrow');
}

//
// Dropcaps
//
if (!function_exists('ivan_dropcap')) {
	function ivan_dropcap($atts, $content = null) {
		$args = array(
			"color" => "",
			"bg" => "",
			"border" => "",
			"type" => "normal", // square, circle and normal
		);
		extract(shortcode_atts($args, $atts));

		$output = '';

		$output = "<span class='ivan-dropcap ".$type."' style='";
		if($bg != ""){
			$output .= "background-color: $bg;";
		}
		if($color != ""){
			$output .= " color: $color;";
		}
		if($border != ""){
			$output .= " border-color: $border;";
		}
		$output .= "'>" . $content  . "</span>";

		return $output;
	}
	add_shortcode('iv_dropcap', 'ivan_dropcap');
}

//
// Highlight
//
if (!function_exists('iv_highlight')) {
	function iv_highlight($atts, $content = null) {
		$args = array(
			"color" => "",
			"bg" => "",
		);
		extract(shortcode_atts($args, $atts));

		$output = '';

		$output =  "<span class='ivan-highlight' style='";
		
			if( $color != '')
				$output .= 'color:'.$color.';';

			if( $bg != '')
				$output .= 'background-color:'.$bg.';';

		$output .= "''>" . $content . "</span>";

		return $output;
	}
	add_shortcode('iv_highlight', 'iv_highlight');
}

//
// Unstyled List
//
if( !function_exists('iv_code_list_func') ) {
	function iv_code_list_func( $atts, $content = null ) {
		return '<div class="iv-unstyled-list">'.do_shortcode($content).'</div>';
	}
	add_shortcode('iv_list', 'iv_code_list_func');
}

//
// Br / New Line
//
if( !defined('USING_IVAN_THEME') && !function_exists('iv_code_br_func') ) {
	function iv_code_br_func( $atts, $content = null ) {
		return '<br>';
	}
	add_shortcode('iv_br', 'iv_code_br_func');
}

// Inline List
//if( !function_exists('iv_code_inline_ul_func') ) {
	add_shortcode('iv_inline_ul', 'iv_code_inline_ul_func');
	function iv_code_inline_ul_func( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'align' => 'center',
	    ), $atts));
	    
		return '<ul class="iv-inline-list to-'.$align.'">'.do_shortcode($content).'</ul>';
	}
//} // ends shortcode

// List Item
if( !function_exists('iv_code_li_func') ) {
	function iv_code_li_func( $atts, $content = null ) {
		return '<li>'.do_shortcode($content).'</li>';
	}
	add_shortcode('iv_li', 'iv_code_li_func');
}