<?php

require_once 'mongo.php';

$lens = $_POST['lens'];

	switch($lens) {
		case "twitter":
			$collection = $db->selectCollection('twitter');
			$cursor = $collection->find();
			foreach($cursor as $obj) {


    break;
  case "groupon":
    $collection = $db->selectCollection('groupon');
    echo $collection->find();

    break;
  case "craigslist":
    $collection = $db->selectCollection('craigslist');

    break;
  default:
    echo "Wrong Lens type";
}
