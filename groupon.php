<?php

include('./debug.php');

function grouponGetDealsByDivision($division_id) {
	$base = 'deals.json';
	$request = $base . '?division_id=' . $division_id;

	$jsons = grouponRequest($request);

	//Something failed
	if(empty($jsons))  {
		return '';
	}

	$deals = json_decode($jsons);
	
	$first = true;

	foreach($deals->deals as $deal)  {
		if($first == true) {
			debug($deal);
			$first=false;

			$sale = array(
				"id" => $deal->id, 
				"dealUrl" => $deal->dealUrl,
				"title" => $deal->title,
				"img" => $deal->sidebarImageUrl,
				"pitchHtml" => $deal->pitchHtml,
			);

			foreach($deal->options as $option) {

			}
		}

		
	}


}

function grouponRequest($request) {
	include 'config.php';

	$apikey = '&client_id=' . $groupon_appid;
	$base = 'https://api.groupon.com/v2/';
	$url = urlencode($base . $request . $apikey);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_body = curl_exec($ch);
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$ret_status = intval($status);

	if($ret_status != 200) {
		return '';
	}

	return $response_body;
}


?>
