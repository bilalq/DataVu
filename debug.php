<?php
	function debug($stuff) {
		if(!empty($DEBUG)) {
			echo "<pre>";
			print_r($stuff);
			echo "</pre>";
		}
	}
?>
