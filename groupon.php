<?php

include 'debug.php';

#Hard Coded Bad Stuff
function isVerifiedState($location) {
	$hardcodeSadness = "New Jersey";
	if(strcmp($location->state, $hardcodeSadness) == 0) {
		return true;
	}
	return false;
}
#End of the Bad Hard Coding

function encodeJsonDeal($deal) {

	if(!$deal->isSoldOut) {
		foreach($deal->options as $option) {


			//Make sure it isn't sold out
			if(!$option->isSoldOut) {


				foreach($option->redemptionLocations as $location) {

					//Make sure its in New Jersey, hardcoded sadness
					if(isVerifiedState($location)) {

						//Jsonify
						$sale = array(
							"id" => $option->id, 
							"title" => $option->title,
							"price" => $option->price->formattedAmount,
							"expires" => $option->expiresAt,
							"dealUrl" => $deal->dealUrl,
							"img" => $deal->sidebarImageUrl,
							"pitchHtml" => $deal->pitchHtml,
							"lng" => $location->lng,
							"lat" => $location->lat,
						);

						return $sale;

					}
				}
			}
		}
	}
}

function encodeJson($deals) {
	$arrDeals = array();

	foreach($deals->deals as $deal) {
		$jsonDeal = encodeJsonDeal($deal);
		if(!empty($jsonDeal)) {
			array_push($arrDeals, $jsonDeal);
		}
	}

	return json_encode($arrDeals);
}

function grouponGetDealsByDivision($division_id) {
	$base = 'deals.json';
	$request = $base . '?division_id=' . $division_id;

	$jsons = grouponRequest($request);

	//Something failed
	if(empty($jsons))  {
		return '';
	}

	$deals = json_decode($jsons);

	return encodeJson($deals);
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
