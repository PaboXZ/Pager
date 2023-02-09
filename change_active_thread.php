<?php
/*
Required data: $_GET['id'];

Acces: logged in and not temporary, has access to thread
Rules: redirect to index if not logged in
redirect to panel if temporary or id is not sent or has no access
*/
?>

<?php
	
	session_start();
	
	if(!isset($_GET['id']))
	{
		$_SESSION['error_change_active_thread'] = "Access denied";
		header("Location: panel.php");
		exit();
	}
	
	require_once("php-script/rules.php");
	isLoggedIn();
	
	try
	{
		
		require_once("php-script/db_credentials.php");
		if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
		{
			throw new Exception("Błąd serwera", 1);
		}
		
		$user_id = $_SESSION['user_id'];
		$thread_id = $_GET['id'];
		
		if(!$db_query_result = $db_connection->query("SELECT connection_thread_id FROM connection_user_thread WHERE connection_user_id = '$user_id' AND connection_thread_id = '$thread_id'"))
		{
			throw new Exception("Błąd serwera", 2);
		}
		if($db_query_result->num_rows != 1)
		{
			throw new Exception("Błąd serwera", 3);
		}
		else
		{
			$db_query_result->close();
			$_SESSION['user_active_thread'] = $thread_id;
			header("Location: panel.php");
		}
		
	}
	catch(Exception $error)
	{
		$_SESSION['error_change_active_thread'] = $error->getMessage();
		header("Location: panel.php");
	}
	if(isset($db_connection->host_info))
	{
		$db_connection->close();
	}
	
?>