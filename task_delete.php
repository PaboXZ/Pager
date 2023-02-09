<?php
	/*check if is logged in
	check if task name exists for active thread*/
	
	session_start();
	
	require_once('php-script/rules.php');
	isLoggedIn();

	if(!isset($_GET['task_name']))
	{
		header('Location: panel.php');
		exit();
	}
	
	try
	{
		require_once('php-script/db_credentials.php');
		$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
		
		$user_id = $_SESSION['user_id'];
		$thread_id = $_SESSION['user_active_thread'];
		$task_title = htmlentities($_GET['task_name'], ENT_QUOTES);
		
		if(!$db_connection->query("DELETE FROM task_data WHERE task_user_id = '$user_id' AND task_thread_id = '$thread_id' AND task_title = '$task_title'"))
		{
			throw new Exception();
		}
		
		if($db_connection->affected_rows != 1)
		{
			throw new Exception();
		}
	}
	catch(Exception $error)
	{
		echo $_SESSION['error_task_delete'] = "Wystąpił błąd, spróbuj ponownie później.";
	}
	if(isset($db_connection->host_info))
	{
		$db_connection->close();
	}
	header('Location: panel.php');
?>