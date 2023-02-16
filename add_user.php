<?php
	session_start();
	
	require_once('php-script/rules.php');
	isLoggedIn();
	
	require_once('php-script/check_thread.php');
	
	if(checkThreadOwner($_SESSION['user_active_thread'] != $_SESSION['user_id']))
	{
		exit("Access denied");
	}
	
	if(!isset($_POST['user_name']))
	{
		exit("Access denied");
	}
	try
	{
		$user_name = $_POST['new_user_name'];
		if(!ctype_alnum($new_user_name))
		{
			throw new Exception("1");
		}
		
		require_once('php-script/db_connect.php');
		$db_connection = db_connect();
		
		if(isset($_POST['user_password']))
		{
			if($_POST['user'])
			$user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
			if(!$db_result = $db_connection->query("SELECT user_id FROM user_data WHERE user_name = '$user_name'"))
			{
				throw new Exception("1");
			}
			if($db_result->num_rows > 0)
			{
				throw new Exception("2");
			}
			
			if(!$db_connection->query("INSERT INTO user_data (user_email, user_password, user_name) VALUES ('0', '$user_password', '$user_name')"))
			{
				throw new Exception("3");
			}
			if(!$db_result = $db_connection->query("SELECT user_id FROM user_data WHERE user_name = '$user_name'"))
			{
				throw new Exception("4");
			}
			$db_result = $db_result->fetch_assoc();
			
			$new_user_id = $db_result['user_id'];
			$thread_id = $_SESSION['user_active_thread'];
			
			if(!$db_connection->query("INSERT INTO connection_user_thread (connection_user_id, connection_thread_id) VALUES ('$new_user_id', '$thread_id')"))
			{
				throw new Exception("5");
			}
		}
		else
		{
		}
	}
	catch(Exception $error)
	{
		echo $error->getMessage();
	}
	db_close($db_connection);

?>