<?php

	function isLoggedIn()
	{
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