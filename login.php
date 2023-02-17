<?php

	session_start();
	
	if(isset($_SESSION['user_id']))
	{
		header("Location: panel.php");
		exit();
	}
	

	try
	{
		if(!isset($_POST["user_name"]) OR !isset($_POST["user_password"]))
		{
			throw new Exception("Wprowadź dane logowania");
		}
		
		$user_name = $_POST['user_name'];
		
		if(filter_var($user_name, FILTER_VALIDATE_EMAIL))
		{
			$user_name_credential = "user_email";
		}
		else if(ctype_alnum($user_name))
		{
			$user_name_credential = "user_name";
		}
		else
		{
			throw new Exception("Nieprawidłowe dane logowania");
		}
		
		require_once('php-script/db_connect.php');
		
		if(!$db_connection = db_connect())
		{
			throw new Exception("Usługa niedostępna, za utrudnienia przepraszamy");
		}
		
		if($db_temporary_query = $db_connection->query("SELECT user_id, user_name, user_password, user_email FROM user_data WHERE $user_name_credential='$user_name'"))
		{
			if($db_temporary_query->num_rows == 1)
			{
				$db_temporary_row = $db_temporary_query->fetch_assoc();
				$db_temporary_query->close();
				
				if(password_verify($_POST['user_password'], $db_temporary_row['user_password']))
				{
					$user_id = $db_temporary_row['user_id'];
					if(!$db_query_result = $db_connection->query("SELECT connection_thread_id FROM connection_user_thread WHERE connection_user_id = '$user_id' LIMIT 1"))
					{
						throw new Exception("Usługa niedostępna, za utrudnienia przepraszamy");
					}
					if($db_query_result->num_rows == 1)
					{
						$db_thread = $db_query_result->fetch_assoc();
						$_SESSION['user_active_thread'] = $db_thread['connection_thread_id'];
					}
					else
					{
						$_SESSION['user_active_thread'] = 0;
					}
					
					$_SESSION['user_id'] = $db_temporary_row['user_id'];
					$_SESSION['user_name'] = $db_temporary_row['user_name'];
					if(!filter_var($db_temporary_row['user_email'], FILTER_VALIDATE_EMAIL)) $_SESSION['user_temporary_flag'] = TRUE;
					else $_SESSION['user_temporary_flag'] = FALSE;
					header("Location: panel.php");
					
					
				}
				else
				{
					throw new Exception("Nieprawidłowe dane logowania.");
				}
			}
			else
			{
				throw new Exception("Nieprawidłowe dane logowania.");
			}
		}
		else
		{
			throw new Exception("Wystąpił błąd, spróbuj ponownie później.");
		}
		
		db_close($db_connection);
		$db_temporary_query->close();
	}
	catch(Exception $error)
	{
		$_SESSION['error_login'] = $error->getMessage();
		$_SESSION['error-login-return']['login'] = $_POST['user_name'];
		$_SESSION['error-login-return']['password'] = $_POST['user_password'];
		db_close($db_connection);
		header("Location: index.php");
		
	}
	
	

?>