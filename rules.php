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
		
	function isTemporary()	
	{
		if($_SESSION['user_temporary_flag'])
		{
			header("Location: panel.php");
			exit();
		}
	}	
	
?>