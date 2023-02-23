<?php

	session_start();
	
	require_once('php-script/rules.php');
	isLoggedIn();
	redirectTemporary();
	
	if(!isset($_GET['thread_id']))
	{
		header('Location: panel.php.php');
		exit();
	}
	
	$thread_id = intval($_GET['thread_id']);
	$user_id = $_SESSION['user_id'];
	
	require_once('php-script/db_connect.php');
	
	try
	{
		if(!$db_connection = db_connect())
		{
			throw new Exception("Błąd serwera.", 0);
		}
		if(!$db_query_result = $db_connection->query("SELECT thread_name, thread_id, connection_is_owner FROM thread_data INNER JOIN connection_user_thread ON connection_thread_id = thread_id WHERE connection_user_id = '$user_id' AND thread_id = '$thread_id'"))
		{
			throw new Exception("Błąd serwera.", 1);
		}
		if($db_query_result->num_rows != 1)
		{
			throw new Exception("Nie znaleziono listy", 10);
		}
		
		$db_result = $db_query_result->fetch_assoc();
		$thread_name = $db_result['thread_name'];
		
		if($_SESSION['user_active_thread'] == $thread_id)
		{
			$_SESSION['user_active_thread'] = 0;
		}
		
		if(!$db_connection->query("DELETE FROM connection_user_thread WHERE connection_thread_id = '$thread_id'"))
		{
			throw new Exception("Błąd serwera", 2);
		}
		
		if($db_result['connection_is_owner'] == 1)
		{
			if(!$db_connection->query("DELETE FROM thread_data WHERE thread_id = '$thread_id'"))
			{
				throw new Exception("Błąd serwera", 3);
			}
			if(!$db_connection->query("DELETE FROM task_data WHERE task_thread_id = '$thread_id'"))
			{
				throw new Exception("Błąd serwera", 4);
			}
			if(!$db_connection->query("DELETE FROM user_data WHERE user_email = '$thread_id'"))
			{
				throw new Exception("Błąd serwera", 5);
			}
			if(!$db_connection->query("DELETE FROM connection_user_thread WHERE connection_thread_id = '$thread_id'"))
			{
				throw new Exception("Błąd serwera", 6);
			}
			$_SESSION['message'] = "Usunięto listę: ".$thread_name;
		}
	}
	catch(Exception $error)
	{
		$_SESSION['error_thread_delete'] = $error->getMessage();
	}
	
	db_close($db_connection);
	header('Location: settings.php');
?>