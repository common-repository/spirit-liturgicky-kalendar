<?php
/*
 * Fired when the plugin is uninstalled.
*/

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit; }

	global $wpdb;

	$table_name = $wpdb->prefix . "spirit_lit_kalendar";
	$wpdb->query( "DROP TABLE IF EXISTS " .  $table_name); //Drop plugin table

	delete_option("tsslk_db_version");
