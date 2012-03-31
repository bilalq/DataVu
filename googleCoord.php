<?php
function googleLocation($address) {
  $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlEncode($address).'&sensor=false');
  $output= json_decode($geocode);
  $lat = $output->results[0]->geometry->location->lat;
  $long = $output->results[0]->geometry->location->lng;
  $latlong = array('lat' => $lat, 'long' => $long);
  return $latlong;
}

$place = googleLocation("51 McGuire St., Metuchen, NJ");
print_r($place);
