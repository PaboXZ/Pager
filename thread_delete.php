<?php

	session_start();
	
	require_once('php-script/rules.php');
	isLoggedIn();
	redirectTemporary();
	
	if(!isset($_GET['thread_name']))
	{
		header('Location: panel.php.php');
		exit();
	}
	
	$thread_name = htmlentities($_GET['thread_name'], ENT_QUOTES);
	$user_id = $_SESSION['user_id'];
	require_once('php-script/db_connect.php');
	try
	{
		if(!$db_connection = db_connect())
		{
			throw new Exception();
		}
		if(!$db_query_result = $db_connection->query("SELECT thread_id FROM thread_data INNER JOIN connection_user_thread ON connection_thread_id = thread_id WHERE connection_user_id = '$user_id' AND thread_name = '$thread_name'"))
		{
			throw new Exception();
		}
		if($db_query_result->num_rows != 1)
		{
			throw new Exception();
		}
		
		$db_result = $db_query_result->fetch_assoc();
		$thread_id = $db_result['thread_id'];
		
		if(isset($_SESSION['user_active_thread']) && $_SESSION['user_active_thread'] == $thread_id)
		{
			$_SESSION['user_active_thread'] = 0;
		}
		
		if(!$db_connection->query("DELETE FROM connection_user_thread WHERE connection_thread_id = '$thread_id'"))
		{
			throw new Exception();
		}
		if(!$db_connection->query("DELETE FROM thread_data WHERE thread_id = '$thread_id'"))
		{
			throw new Exception();
		}
		if(!$db_connection->query("DELETE FROM task_data WHERE task_thread_id = '$thread_id'"))
		{
			throw new Exception();
		}
	}
	catch(Exception $error)
	{
		$_SESSION['error_thread_delete'] = "Wystąpił błąd podczas usuwania listy";
		db_close($db_connection);
		header('Location: settings.php');
		exit();
	}
	
	$_SESSION['message'] = "Usunięto listę: ".$thread_name;
	db_close($db_connection);
	header('Location: settings.php');
?>