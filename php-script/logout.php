<?php
	/*
	Required data: none OK
	Access: all
	
	Rules: none
	*/
?>

<?php
	session_start();
	session_destroy();
	Header("Location: ../index.php");
?>