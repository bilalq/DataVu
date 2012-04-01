<?php
function googleLocation($address) {
  $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlEncode($address).'&sensor=false');
  $output= json_decode($geocode);
  $lat = $output->results[0]->geometry->location->lat;
  $lng = $output->results[0]->geometry->location->lng;
  $latlng = array('lat' => $lat, 'lng' => $lng);
  return $latlng;
}

print_r(googleLocation("paterson, nj"));
print_r(googleLocation("morristown, nj"));
print_r(googleLocation("freehold, nj"));
print_r(googleLocation("hammonton, nj"));
print_r(googleLocation("millville, nj"));
print_r(googleLocation("capemay, nj"));
print_r(googleLocation("flemington, nj"));
print_r(googleLocation("newark, nj"));
print_r(googleLocation("sparta, nj"));
print_r(googleLocation("bridgewater, nj"));
print_r(googleLocation("winslow, nj"));
print_r(googleLocation("vineland, nj"));
print_r(googleLocation("pemberton , nj"));
print_r(googleLocation("manalapan, nj"));
print_r(googleLocation("hamilton , nj"));
print_r(googleLocation("new brunswick, nj"));
