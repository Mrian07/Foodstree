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

$out = '';

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