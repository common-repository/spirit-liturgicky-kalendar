<?php

/*
* Create table in DB 
*/

function tsslk_db_install() {
	global $wpdb;
	global $tsslk_db_version;
	global $tsslk_table_name;
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$wpdb->prefix}{$tsslk_table_name} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			datum VARCHAR(100) NOT NULL,
			sviatok VARCHAR(200) NOT NULL,
			vers VARCHAR(1000) NOT NULL,
			PRIMARY KEY id (id),
			UNIQUE KEY datum (datum)
	  ) $charset_collate;";
	  
	  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  dbDelta( $sql );    

	  update_option( "tsslk_db_version", $tsslk_db_version );
}

/*
* Check if DB update is needed
*/

function tsslk_update_db_check() {
	global $tsslk_db_version;
	if ( get_site_option( 'tsslk_db_version' ) != $tsslk_db_version ) {
		tsslk_db_install();
	}
}

/*
* Set plugin colors dynamically based on user selection in the settings
*/
function tsslk_load_dynamic_style() {

	global $tsslk_options;
    
	$tsslk_options = get_option( 'tsslk_options');    

	$dynamic_style = "";
	
	if ($tsslk_options['CustomCSS']) {
		$dynamic_style .= "
		.tsslk_widget .widget-button {
			background-color: " . $tsslk_options['ButtonColor'] .";
		}
		.tsslk_widget .widget-button:hover  {
			background-color: " . $tsslk_options['ButtonHoverColor'] .";
		}
		.tsslk_lit_kalendar_widget_vers {
			font-size: " . $tsslk_options['VerseFontSize'] . (is_numeric($tsslk_options['VerseFontSize']) ? 'px' : '') . ";
		}
	";
	}



	if ($tsslk_options['VerseFontFamily'] != '' && $tsslk_options['VerseFontFamily'] != '_Default') {
		$dynamic_style .= "		
			.tsslk_lit_kalendar_widget_vers {
				font-family: " . $tsslk_options['VerseFontFamily'] .";
			}
		";		
	} 

	if ($tsslk_options['VerseFontWeight'] != 0) {
		$dynamic_style .= "		
			.tsslk_lit_kalendar_widget_vers {
				font-weight: bold;
			}
		";		
	} 	

	if ($tsslk_options['VerseFontItalic'] != 0) {
		$dynamic_style .= "		
			.tsslk_lit_kalendar_widget_vers {
				font-style: italic;
			}
		";		
	} 	

	wp_add_inline_style( 'spirit-lit-kalendar-css', $dynamic_style);
}

/*
* Content to be shown on Widget and Block part
*/
function tsslk_get_block_code(){

	global $wpdb;

	global $tsslk_options;
	$tsslk_options = get_option( 'tsslk_options');    

	$cal_day = date("Ymd");
	$table_name = $wpdb->prefix . "spirit_lit_kalendar";
	$results = $wpdb->get_results("SELECT * FROM " . $table_name ." WHERE datum='" . $cal_day . "'");

	?>
			<section class="widget tsslk_widget">
				<header class="widge-header">
					<h2 class="widget-title">Písmo na dnes</h2>
				</header>

				<div>
					<div class="tsslk_lit_kalendar_widget_sviatok"><?PHP echo $results[0]->sviatok; ?></div>
					<br>
					<div class="tsslk_lit_kalendar_widget_vers"><?PHP echo $results[0]->vers; ?></div>
					
					<?php if ($tsslk_options['ShowButton']) { ?>
						<br>
						<div><button class="widget-button <?php echo ($tsslk_options['ShowIconInButton'] ? 'lk-icon' : ''); ?>" onclick="window.open('https://lc.kbs.sk/?den=<?PHP echo str_replace("-", "", $results[0]->datum); ?>','_blank')">Liturgický kalendár</button></div>
					<?php } ?>
					
				</div>
			</section>
	<?PHP
}

//Get custom fonts
function tsslk_get_standard_fonts() {
	return array(
			'_Default',
			'Arial, Helvetica, sans-serif',
			'Arial Black, Gadget, sans-serif',
			'Bookman Old Style, serif',
			'Comic Sans MS, cursive',
			'Courier, monospace',
			'Georgia, serif',
			'Garamond, serif',
			'Impact, Charcoal, sans-serif',
			'Lucida Console, Monaco, monospace',
			'Lucida Sans Unicode, Lucida Grande, sans-serif',
			'MS Sans Serif, Geneva, sans-serif',
			'MS Serif, New York, sans-serif',
			'Palatino Linotype, Book Antiqua, Palatino, serif',
			'Tahoma, Geneva, sans-serif',
			'Times New Roman, Times, serif',
			'Trebuchet MS, Helvetica, sans-serif',
			'Verdana, Geneva, sans-serif',
			'Paratina Linotype',
			'Trebuchet MS',
		);
}