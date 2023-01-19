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
	
	function isLoggedAdmin()
	{
		session_start();
		
		if(isset($_SESSION['user_power']))
		{
			if($_SESSION['user_power'] == 0)
			{
				return TRUE;
			}
			else
			{
				header("Location: panel.php");
				exit();
			}
		}
		else
		{
			header("Location: index.php");
			exit();
		}
	}
?>