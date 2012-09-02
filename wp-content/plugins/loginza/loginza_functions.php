<?php
function loginza_json_support () {
	if ( function_exists('json_decode') ) {
		return true;
	}
	// загружаем библиотеку работы с JSON если она необходима
	if (!class_exists('Services_JSON')) {
		include_once( dirname( __FILE__ ) . '/JSON.php' );
	}
	return false;
}

// если нету поддержки json
if ( !loginza_json_support() ) {
	// декодирует json в объект/массив
	function json_decode($data) {
        $json = new Services_JSON();
        return $json->decode($data);
    }
}

function loginza_api_request ($url) {
	if ( function_exists('curl_init') ) {
		$curl = curl_init($url);
		$user_agent = 'Loginza-API/Wordpress';
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$raw_data = curl_exec($curl);
		curl_close($curl);
		return $raw_data;
	} else {
		return file_get_contents($url);
	}
}
?>