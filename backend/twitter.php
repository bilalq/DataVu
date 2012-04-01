<?php
  require_once('config.php');
  require_once('mongo.php');
  require_once('points.php');

  $collection = $db->selectCollection('twitter');  
  $collection->drop;
  $collection = $db->selectCollection('twitter');  

  foreach ($pointsList as $point) {
    $currLat = $point['lat'];
    $currLong = $point['lng'];

    insertTweets($currLat, $currLong, 15, $collection);
  }

  function insertTweets($lat, $lng, $rad, $set) {
    $tweetSet = json_decode(file_get_contents("http://search.twitter.com/search.json?q="."a"."&geocode=".$lat.",".$lng.",".$rad."mi&result_type=mixed&count=20&lang=en"));	

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

