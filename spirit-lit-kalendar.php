<?php
/*
Plugin Name: Spirit Liturgický kalendár
Plugin URI: https://thespirit.studio/the-spirit-lit-kalendar/
Description: Liturgický kalendár podľa stránky lc.kbs.sk
Version: 1.2
Author: The Spirit Studio
Author URI: https://thespirit.studio
Text Domain: spirit-lit-kalendar
Domain Path: /languages
License: GPL2

!!! INFO IN ENGLISH !!!
This plugin displays daily readings from Holy Bible. 
It fetches data from Slovak web site of Catholic church in Slovakia (lc.kbs.sk)
Therefore it is localized only in Slovak language.

Spirit Liturgický kalendár is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version

Spirit Liturgický kalendár is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define ('TSSLK_PLUGIN_PATH', plugin_dir_path( __FILE__));
define('SPIRIT_LIT_KAL_VERSION', '1.2' );

include (TSSLK_PLUGIN_PATH . 'admin/admin.php');
include (TSSLK_PLUGIN_PATH . 'includes/functions.php');
include (TSSLK_PLUGIN_PATH . 'includes/lc_kbs_api.php');
include (TSSLK_PLUGIN_PATH . 'includes/widget.php');
include (TSSLK_PLUGIN_PATH . 'lk-block/lk-block.php');

//Globals
global $tsslk_db_version, $tsslk_table_name;
$tsslk_db_version = "1.0";
$tsslk_table_name = 'spirit_lit_kalendar';


/*
* Plugin activation
*/
function tsslk_activate() {
    tsslk_db_install();

	$tsslk_options = array(
		'ShowButton' => 1,
		'ShowIconInButton' => 1,
		'CustomCSS' => 0,
		'ButtonColor' => '#3e6083',
        'ButtonHoverColor' => '#214a75',
        'VerseFontFamily' => '',
        'VerseFontWeight' => 0,
        'VerseFontItalic' => 1,
        'VerseFontSize' => 'inherit'
	);

	update_option( 'tsslk_options', $tsslk_options );    

	//Register CRON event
	if (! wp_next_scheduled ( 'tsslk_fetchLitKalendarData' )) {
		wp_schedule_event(time(), 'daily', 'tsslk_fetchLitKalendarData');
	}    
}
register_activation_hook( __FILE__, 'tsslk_activate' );

/*
* Plugin deactivation
*/
function tsslk_deactivate() {

    // Cancel cron task upon deactivation
    wp_clear_scheduled_hook('tsslk_fetchLitKalendarData');
}
register_deactivation_hook( __FILE__, 'tsslk_deactivate' );


/*
* Include styles on frontend
*/
function tsslk_enqueue_styles() {
	wp_enqueue_style('spirit-lit-kalendar-css', plugins_url( 'css/spirit-lit-kalendar.css',__FILE__ ), SPIRIT_LIT_KAL_VERSION);
}
add_action( 'wp_enqueue_scripts', 'tsslk_enqueue_styles' );

//Add dynamic styles
add_action( 'wp_enqueue_scripts', 'tsslk_load_dynamic_style' );

?>