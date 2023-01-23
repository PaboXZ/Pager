<?php
/*
Access: logged in users with active thread
Required data: task_title, task_content, task_power

Rules:
If not logged in go to index
If no active thread go to panel

If no data was sent (after login check) go to panel
Then check values with database requirements

Rights!!  power level
*/
	
?>

<?php

	function errorAdd($message)
	{
		if(isset($_SESSION['error_create_task']))
		{
			$_SESSION['error_create_task'] = $_SESSION['error_create_task']."<br>".$message;
		}
		else
		{
			$_SESSION['error_create_task'] = $message;
		}
	}



	session_start();
	
	require_once('rules.php');
	isLoggedIn();
	
	if(!isset($_SESSION['user_active_thread']))
	{
		header('Location: panel.php');
		exit();
	}
	
	if(!isset($_POST['task_title']) || !isset($_POST['task_content']) || !isset($_POST['task_power']))
	{
		header('Location: panel.php');
		exit();
	}
	$task_title = htmlentities($_POST['task_title'], ENT_QUOTES);
	$task_content = htmlentities($_POST['task_content'], ENT_QUOTES);
	$task_power = intval($_POST['task_power']);
	
	if(strlen($task_title) < 3 || strlen($task_title) > 64)
	{
		errorAdd("Dozwolona długość nazwy wpisu: 3-60");
	}
	
	if(strlen($task_content) > 2024)
	{
		errorAdd("Maksymalna długość wpisu: 1900");
	}
	
	if($task_power > 5 OR $task_power < 1)
	{
		errorAdd("Nieznany błąd");
	}
	
	error_reporting(E_ERROR);
	mysqli_report(MYSQLI_REPORT_OFF);
	
	try
	{
		require_once("db_credentials.php");
		
		if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
		{
			throw new Exception("Błąd serwera", 1);
		}
		$user_id = $_SESSION['user_id'];
		$task_thread_id = $_SESSION['user_active_thread'];
		
		if(!$db_query_result = $db_connection->query("SELECT task_id FROM task_data WHERE task_user_id = '$user_id' AND task_thread_id = '$task_thread_id' AND task_title = '$task_title'"))
		{
			throw new Exception("Bład serwera", 4);
		}
		if($db_query_result->num_rows > 0)
		{
			throw new Exception("Podana nazwa wpisu już istnieje");
		}
		
		if(!$db_query_result = $db_connection->query("SELECT connection_create_power FROM connection_user_thread WHERE connection_user_id = '$user_id' AND connection_thread_id = '$task_thread_id'"))
		{
			throw new Exception("Bład serwera", 2);
		}
		
		$db_result_row = $db_query_result->fetch_assoc();
		if($task_power < $connection_create_power)
		{
			errorAdd("Przekroczono dozwoloną siłę wpisu");
			throw new Exception($_SESSION['error_create_task']);
		}
		if(isset($_SESSION['error_create_task']))
		{
			throw new Exception($_SESSION['error_create_task']);
		}
		
		if(!$db_connection->query("INSERT INTO task_data (task_thread_id, task_user_id, task_title, task_content, task_power) VALUES ('$task_thread_id', '$user_id', '$task_title', '$task_content', '$task_power')"))
		{
			throw new Exception("Błąd serwera", 3);
		}
	}
	catch(Exception $error)
	{
		$_SESSION['error_create_task'] = $error->getMessage();
	}
	
	if(isset($db_connection))
	{
		$db_connection->close();
	}
	header('Location: panel.php');

?>