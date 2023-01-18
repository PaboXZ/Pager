<?php
	/*
		Required data: none OK
		Access: admin OK
		
		Rules: Redirect if not admin(for clarity if changed later) OK
	*/
?>

<?php
	session_start();
	
	/*Rules check*/
	if(!isset($_SESSION['admin_id']))
	{
		Header("Location: index-admin.php");
		exit();
	}
	/*END*/
	
	
	
	if(isset($_SESSION['user_id']))
	{
		unset($_SESSION['admin_id']);
	}
	else
	{
		session_destroy();
	}
	Header("Location: index-admin.php");
?>