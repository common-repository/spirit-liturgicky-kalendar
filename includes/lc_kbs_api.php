<?php
// Cron event function 
add_action('tsslk_fetchLitKalendarData', 'tsslk_fetchLitKalendarData');

function tsslk_fetchLitKalendarData() {
	global $wpdb;
	$cal_day = date("Ymd");
	$lit_address = "https://lc.kbs.sk/?den=" . $cal_day;
   
	//Update calendar for next 7 days
	for ($i = 0; $i < 7; $i++) {

		//Fetch data from https://lc.kbs.sk - Page that presents daily reading from Holy Bible
		$response = wp_remote_get($lit_address, array('timeout' => 30));
		
		$dom = new DOMDocument();
		@ $dom->loadHTML($response['body']);
		$xpath = new DOMXpath($dom);
	
		//Aleluja vers
		$lcVERS = $xpath->query("//span[contains(@class,'lcVERS')]");
		$aleluja_vers = $lcVERS[1]->textContent;
	
		//Liturgicky den
		$litur_den_raw = trim($dom->getElementsByTagName('h2')[0]->childNodes[1]->textContent);
		$litur_den_raw_array = explode("\n", $litur_den_raw);
		$litur_den = $litur_den_raw_array[0];
	
		//Insert into DB
		$table_name = $wpdb->prefix . "spirit_lit_kalendar";
		$wpdb->query("INSERT INTO " . $table_name ."(datum,sviatok,vers)
			VALUES('" . $cal_day . "','" . $litur_den . "','" . $aleluja_vers . "') ON DUPLICATE KEY UPDATE datum = datum");
	
		//Build URL for next day	
		$cal_day = date("Ymd", strtotime("+" . (1+$i) . " day"));
		$lit_address = "https://lc.kbs.sk/?den=" . $cal_day;
	}
}