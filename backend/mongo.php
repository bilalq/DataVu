<?php
try {
  $m = new Mongo(); // connect
  $db = $m->selectDB("datavu");
}
catch ( MongoConnectionException $e ) {
  echo '<p>Couldn\'t connect to mongodb.</p>';
  exit();
}
?>
