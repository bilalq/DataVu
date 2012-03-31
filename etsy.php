<?php

include("config.php");

$keyword = $_GET["keyword"];

if(!isset($keyword)) {
	return;
}

echo json_encode(getEtsyRecommendations($keyword));

function getEtsyRecommendations($keyWords) {

	$options="";
	$keywords='"' . $keyWords . '"';

	$type_response="listings/active";
	$keyword_pre="?keywords=";
	$api_call=$type_response . $keyword_pre . $keywords . $options;


	$response = etsyRequest(htmlentities($api_call));

	//Not Found
	if(strlen($response) == 0) {

	}

	$respJson = json_decode($response);

	$items_arr=array();

/*
results=>listing_id
		=>title
		=>description
		=>price
		=>url
 */
	foreach($respJson->results as $result) {
		$item = array(
			"listing_id" => $result->listing_id,
			"title" => $result->title,
			"description => "$result->description,
			"price" => $result->price,
			"url" => $result->url,
			"img" => etsyGetImage($result->listing_id),
		);
		array_push($items_arr, $item);
	}

	return $items_arr;
}

function etsyGetImage($listingID) {
	$type_response="listings/" . $listingID;
	$api_call=$type_response;

	$response = etsyRequest(htmlentities($api_call));

	//Not Found
	if(strlen($response) == 0) {
		return NULL;
	}

	$respJson = json_decode($response);

	$img_arr=array();

	/*
		results[*]=>url_75x75
		=>url_170x135
		=>url_570xN
	 */
	foreach($respJson->results as $result) {
		$img = array(
			"small" => $result->url_75x75,
			"medium" => $result->url_170x135,
			"large" => $result->url_570xN,
		);
		array_push($img_arr, $img);
	}

	return $img_arr;
}

function etsyRequest($request) {
	$apikey = "&api_key=" . $etsy_appid;
	$base = "http://openapi.etsy.com/v2/";
	$url = $base . $requests . $apikey;

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_body = curl_exec($ch);
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	$ret_status = intval($status);

	if($ret_status != 200) { 
		return "";
	}
	return $response_body
}
?>
