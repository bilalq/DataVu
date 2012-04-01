<?php

require_once 'debug.php';

require_once 'mongo.php';

require_once 'points.php';

$collection = $db->selectCollection('yelp');

/*
$tl_lat = 41.39;
$tl_long = -74;
$br_lat = 39;
$br_long = -75.3;
 */

$limit = 20;

foreach ($pointsList as $point) {
	$lat = $point['lat'];
	$lng =$point['lng'];

	yelpGetRest($lat, $lng, 15, $limit, $collection);
}

function yelpGetRest($lat, $lng, $radius, $limit, $collection) {

/*
	tl_lat	 double	 required	 Top left latitude of bounding box
	tl_long	double	required	Top left longitude of bounding box
	br_lat	double	required	Bottom right latitude of bounding box
	br_long	double	required	Bottom right longitude of bounding box
	
	?term=yelp&tl_lat=37.9&tl_long=-122.5&br_lat=37.788022&br_long=-122.399797&limit=3
 */

//	$request = '?tl_lat=' . $tl_lat . '&tl_long=' . $tl_long . 
//		'&br_lat=' . $br_lat . '&br_long=' . $br_long;

	
	$request = '?lat=' . $lat . '&long=' . $lng . '&radius=' . $radius . '&limit=' . $limit;
	
	$jsonData = yelpRequest($request);

	if(empty($jsonData)) {
		echo "Failed JSON Request Son!";
		return '';
	}

	$rests = json_decode($jsonData);

	yelpProcessJson($rests,$collection);
}

function isValid($state) {
	if(strcmp($state, "NJ") == 0) {
		return true;
	}
	return false;
}

function yelpProcessJson($jsonData, $collection) {
	foreach($jsonData->businesses as $business) {
		if(isValid($business->state)) {

			$business_arr = array(
				"id" => $business->id,
        "name" => $business->name,
				"city" => $business->city,
				"zip" => $business->zip,
				"state" => $business->state,
				"lat" => $business->latitude,
				"lng" => $business->longitude,
				"url" => $business->url,
        "img" => $business->snippet_image_url,
        "description" => $business->snippet_text,
				"avg_rating" => $business->avg_rating,
				"reviews" => array(
					"text" => $business->reviews[0]->text_excerpt,
					"rating" => $business->reviews[0]->rating,
				),
			);
			
			$collection->insert($business_arr);
		}
	}
}

function yelpRequest($request) {
	include 'config.php';

	$apikey = '&ywsid=' . $yelp_appid;
	$base = 'http://api.yelp.com/business_review_search';
	$url = $base . $request . $apikey;

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
