<?php

	if(isset($_SESSION['error_create_thread']))
	{
		$error_message = $_SESSION['error_create_thread'];
		$error_style = "#dialog-box-message{display: block;} #error-text{display: block;}";
		unset($_SESSION['error_create_thread']);
	}
	else if(isset($_SESSION['error_change_active_thread']))
	{
		$error_message = $_SESSION['error_change_active_thread'];
		$error_style = "#dialog-box-message{display: block;} #error-text{display: block;}";
		unset($_SESSION['error_change_active_thread']);
	}
	else if(isset($_SESSION['error_task_delete']))
	{
		$error_message = $_SESSION['error_task_delete'];
		$error_style = "#dialog-box-message{display: block;} #error-text{display: block;}";
		unset($_SESSION['error_task_delete']);
	}
	else if(isset($_SESSION['error_create_task']))
	{
		$error_message = $_SESSION['error_create_task'];
		$error_style = "#dialog-box-message{display: block;} #error-text{display: block;}";
		unset($_SESSION['error_create_task']);
	}

?>