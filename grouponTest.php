<?php

require_once 'groupon.php';
require_once 'debug.php';

$jsonz = grouponGetDealsByDivision('central-jersey');

debug($jsonz);

?>
