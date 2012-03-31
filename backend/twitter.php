<?php
  require_once('config.php');
  require_once('mongo.php');

  $collection = $db->selectCollection('twitter');  

  $pointsList = array (
    "13.213, 13.12312",
    "34.21321, 32.1423"
  );

  foreach ($pointsList as $point) {
    $currLat = $point['lat'];
    $currLong = $point['lng'];

    insertTweets($currLat, $currLong, 15, $collection);
  }

  function insertTweets($lat, $lng, $rad, $set) {
    $tweetSet = json_decode(file_get_contents("http://search.twitter.com/search.json?q="."a"."&geocode=".$lat.",".$lng.",".$rad."mi&result_type=mixed&count=10&lang=en"));	

    $results = $tweetSet->results;

    foreach ($results as $tweet) {
      $handle = $tweet->from_user;
      $full_name = $tweet->from_user_name;
      $text = $tweet->text;
      $photo = $tweet->profile_image_url_https;

      $entry = array(
        "handle" => $handle,
        "name" => $full_name,
        "tweet" => $text,
        "img" => $photo,
        "lat" => $lat,
        "lng" => $lng
      );

      $set->insert($entry);
    }
  }

