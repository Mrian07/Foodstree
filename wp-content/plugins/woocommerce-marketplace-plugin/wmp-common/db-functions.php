<?php

global $wmp_db_version;
$wmp_db_version = '1.1.0';

function wmp_activate() {
   global $wpdb;
  global $wmp_db_version;

  $table_name = $wpdb->prefix . 'pincodes';
  
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `pincode` varchar(6) NOT NULL,
  `seller_id` longtext DEFAULT NULL,
  `city` varchar(25) NOT NULL,
  `state` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'wmp_db_version', $wmp_db_version );
}








function wmp_deactivate() {
    global $wpdb;

    $wpdb->query( "DROP TABLE {$wpdb->prefix}pincodes" );
}



?>