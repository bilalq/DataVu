<?php

require_once 'mongo.php';

if(!empty($_POST['lens'])) {

	$lens = $_POST['lens'];

	switch($lens) {
	case "twitter":
		$collection = $db->selectCollection('twitter');
		$cursor = $collection->find();

		$congregate = array();

		foreach($cursor as $obj) {
			array_push($congregate, $obj);
		}
		$jsons = json_encode($congregate);
		echo $jsons;
		break;
	case "groupon":
		$collection = $db->selectCollection('groupon');
		$cursor = $collection->find();

		$congregate = array();

		foreach($cursor as $obj) {
			array_push($congregate, $obj);
		}
		$jsons = json_encode($congregate);
		echo $jsons;
		break;
	case "craigslist":
		$collection = $db->selectCollection('craigslist');
		$cursor = $collection->find();

		$congregate = array();

		foreach($cursor as $obj) {
			array_push($congregate, $obj);
		}
		$jsons = json_encode($congregate);
		echo $jsons;
		break;
	default:
		echo "Wrong Lens type";
	}
}

