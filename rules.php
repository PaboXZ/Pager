<?php

	function isLoggedIn()
	{
		session_start();
		if(isset($_SESSION['user_id']))
		{
			return TRUE;
		}
		else
		{
			header("Location: index.php");
			exit();
		}
	}	
	
?>