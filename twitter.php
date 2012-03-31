<?php
  require_once('config.php');

  function getTweetSet($lat, $lng, $rad) {
  $tweetSet = json_decode(file_get_contents("http://search.twitter.com/search.json?q="."a"."&geocode=".$lat.",".$lng.",".$rad."mi&result_type=mixed&count=50&lang=en"));	

  $tweetSet->
  }

?>
