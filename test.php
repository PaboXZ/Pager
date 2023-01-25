<?php
	
	echo microtime()."<br>";
	$time = new DateTime();
	echo $time->format('u')."<br>";
	echo print_r($time);
?>