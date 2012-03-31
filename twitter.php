<?php
  require_once('config.php');
  require_once('mongo.php');

  $collection = $db->selectCollection('twitter');  

  function getTweetSet($lat, $lng, $rad) {
    $tweetSet = json_decode(file_get_contents("http://search.twitter.com/search.json?q="."a"."&geocode=".$lat.",".$lng.",".$rad."mi&result_type=mixed&count=10&lang=en"));	

    $results = $tweetSet->results;

    foreach ($results as $tweet) {
      $handle = $tweet->from_user;
      $full_name = $tweet->from_user_name;
      $text = $tweet->text;

      $entry = array(
        "handle" => $handle,
        "name" => $full_name,
        "tweet" => $text,
        "lat" => $lat,
        "lng" => $lng
      );

      $collection->insert($entry);
    }
  }

