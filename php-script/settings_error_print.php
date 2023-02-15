<?php
	if(count(get_included_files()) == 1)
	{
		exit("Access denied.");
	}
	
	if(isset($_SESSION['error_thread_delete']))
	{
		$error_message = $_SESSION['error_thread_delete'];
		$error_style = "#dialog-box-message{display: block;} #error-text{display: block;}";
		unset($_SESSION['error_thread_delete']);
	}
?>