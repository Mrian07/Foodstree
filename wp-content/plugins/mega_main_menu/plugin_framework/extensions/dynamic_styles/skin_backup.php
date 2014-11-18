<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	global $mmpm_theme_options;
	$mega_menu_locations = is_array( mmpm_get_option( 'mega_menu_locations' ) ) 
		? mmpm_get_option( 'mega_menu_locations' ) 
		: array();
$out = '.empty{}';
	if ( count( $mega_menu_locations ) > 1 ) {
$out .= '
.mega_main_menu .nav_logo > .logo_link > img 
{
	max-height: ' . mmpm_get_option( 'logo_height', '90' ) . '%;
}
';
		array_shift( $mega_menu_locations );
		foreach ( $mega_menu_locations as $key => $location_name ) { 
if ( is_array( mmpm_get_option( 'indefinite_location_mode' ) ) && in_array( 'true', mmpm_get_option( 'indefinite_location_mode' ) ) ) {
		$location_class = '';
} else {
		$location_class = '.' . $location_name;
}

$out .= '/* ' . $location_name . ' */

/*
*
* # FIRST LEVEL ITEMS
*
*/
/*
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > .nav_logo > .mobile_toggle > .mobile_button,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link .link_text,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.nav_search_box *,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details > .post_title,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details > .post_title > .item_link
{
	font-size: 14px;
	line-height: 21px;
	color: red;
}
*/
/*
*
* # FIRST LEVEL ITEMS > ICONS
*
*/
/*
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link > i
{
	color: blue;
	font-size: 20px;
}
*/

/*
.mega_main_menu' . $location_class . '.icons-right > .menu_holder > .menu_inner > ul > li > .item_link > i:before,
.mega_main_menu' . $location_class . '.icons-left > .menu_holder > .menu_inner > ul > li > .item_link > i:before
{	
	width: auto;
}
*/



/*
*
* # FIRST LEVEL ITEMS > HOVER
*
*/
/*
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li:hover > .item_link,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link:hover,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-ancestor > .item_link,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-item > .item_link
{
	background: transparent;
}

.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li:hover > .item_link,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link:hover,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li:hover > .item_link *,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-ancestor > .item_link *,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-item > .item_link *
{
	color: #000;
}
*/

/*
*
* # DROPDOWN BOX
*
*/
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.default_dropdown .mega_dropdown,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .mega_dropdown,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .mega_dropdown > li .post_details
{
	background: #fff;
}

.mega_main_menu' . $location_class . ' ul > li.default_dropdown .mega_dropdown ul.mega_dropdown > li:first-child > .item_link:after
{
	background: #fff;
}

/*
*
* # DROPDOWN LINKS TEXT
*
*/
/*
.mega_main_menu' . $location_class . ' ul li .mega_dropdown > li > .item_link,
.mega_main_menu' . $location_class . ' ul li .mega_dropdown > li > .item_link .link_text,
.mega_main_menu' . $location_class . ' ul li .mega_dropdown,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details > .post_description
{
	font-size: 14px;
	line-height: 21px;
	color: #000;
}
*/

/*
*
* # DROPDOWN LINKS BG
*
*/
/*
.mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li > .item_link,
.mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li > .item_link,
.mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li > .item_link
{
	background: transparent;
}
*/

/*
*
* # DROPDOWN ICONS AND NORMAL DROP
*
*/
/*
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details > .post_icon > i,
.mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li > .item_link *,
.mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li > .item_link *
.mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li > .item_link *,
.mega_main_menu' . $location_class . ' ul li li .post_details a
{
	color: #000;
}
*/

/*
*
* # DROPDOWN LINKS BORDER
*
*/
/*
.mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li > .item_link
{
	border-color: #333;
}

.mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li:hover > .item_link,
.mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li > .item_link:hover,
.mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li.current-menu-item > .item_link,
.mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li > .item_link:hover,
.mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li.current-menu-item > .item_link,
.mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li:hover > .item_link,
.mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li > .item_link:hover,
.mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li.current-menu-item > .item_link,
.mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li:hover > .item_link,
.mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li > .item_link:hover,
.mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li.current-menu-item > .item_link,
.mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li:hover > .processed_image
{
	background: #777;
	color: #fff;
}

.mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li:hover > .item_link *,
.mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li.current-menu-item > .item_link *,
.mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li > .item_link:hover *,
.mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li.current-menu-item > .item_link *,
.mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li:hover > .item_link *,
.mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li.current-menu-item > .item_link *,
.mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li:hover > .item_link *,
.mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li a:hover *,
.mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li.current-menu-item > .item_link *,
.mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li:hover > .processed_image > .cover > .item_link > i
{
	color: #fff;
}
*/
';
			$additional_styles = $mmpm_theme_options[ 'additional_styles_presets' ];
			$out .= '/* additional_styles */ ';
			if ( $additional_styles['0'] > 0 ) {
		        unset( $additional_styles['0'] );
	            foreach ( $additional_styles as $key => $value ) {
	                $out .= '
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ' > .item_link
{
	' . mmpm_css_gradient( $value['bg_gradient'] ) . '
	color: ' . $value['text_color'] . ';
}
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ' > .item_link > i,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ' > .item_link .link_text
{
	color: ' . $value['text_color'] . ';
}
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-ancestor.additional_style_' . $key . ' > .item_link,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.current-menu-item.additional_style_' . $key . ' > .item_link,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ':hover > .item_link,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ' > .item_link:hover
{
	' . mmpm_css_gradient( $value['bg_gradient_hover'] ) . '
	color: ' . $value['text_color_hover'] . ';
}
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ':hover > .item_link > i,
.mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ':hover > .item_link .link_text
{
	color: ' . $value['text_color_hover'] . ';
}
';
	            }
			}
		}
	}


$out .= '/* set_of_custom_icons */ ';
$set_of_custom_icons = isset( $mmpm_theme_options[ 'set_of_custom_icons' ] ) ? $mmpm_theme_options[ 'set_of_custom_icons' ] : array();
if ( is_array( $set_of_custom_icons ) && $set_of_custom_icons['0'] > 0 ) {
    unset( $set_of_custom_icons['0'] );
    foreach ( $set_of_custom_icons as $value ) {
		$icon_name = str_replace( array( '/', strrchr( $value[ 'custom_icon' ], '.' ) ), '', strrchr( $value[ 'custom_icon' ], '/' ) );
        $out .= '
i.ci-icon-' . $icon_name . ':before
{
	background-image: url(' . $value[ 'custom_icon' ] . ');
}
';
    }
}
$out .= ( isset( $mmpm_theme_options[ 'custom_css' ] ) && !empty( $mmpm_theme_options[ 'custom_css' ] ) ) 
	? '/* custom css */ ' . $mmpm_theme_options[ 'custom_css' ] 
	: '';

?>