<?php
	session_start();
	
	require_once('php-script/rules.php');
	isLoggedIn();
	redirectTemporary();
	
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
		require_once('php-script/db_connect.php');
		$db_connection = db_connect();
		
		$user_name = $_POST['user_name'];
		if(!ctype_alnum($user_name))
		{
			throw new Exception("1");
		}

		
		if(isset($_POST['user_password']))
		{
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
		db_close($db_connection);
	}
	catch(Exception $error)
	{
		db_close($db_connection);
		echo $error->getMessage();
	}

?>