<?php
	/*
	Required data: none OK
	Access: user
	
	Rules: Redirect if not logged in
	*/
?>

<?php
	session_start();
	/*Rules check*/
	if(!isset($_SESSION['user_id']))
	{
		Header("Location: index.php");
		exit();
	}
	/*END*/
	
	if(isset($_SESSION['admin_id']))
	{
		unset($_SESSION['user_id']);
	}
	else
	{
		session_destroy();
	}
	
	Header("Location: index.php");
	
?>