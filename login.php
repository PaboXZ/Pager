<?php 
/*
Required data: Login(POST), Password(POST)  OK
Access: all OK

Rules: redirect if logged in OK

Exceptions: all to index.php
*/
?>

<?php

	session_start();
	/*Required data check*/
	if(!isset($_POST["user_name"]) OR !isset($_POST["user_password"]))
	{
		$_SESSION['error_login'] = "Wprowadź dane logowania.";
		header("Location: index.php");
		exit();
	}
	/*END*/
	
	
	/*Rules check*/
	if(isset($_SESSION['user_id']))
	{
		header("Location: panel.php");
		exit();
	}
	/*END*/
	
	try
	{
		require_once('php-script/db_credentials.php');
		
		if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
		{
			throw new Exception("Usługa niedostępna, za utrudnienia przepraszamy");
		}

		$user_name = htmlentities($_POST['user_name'], ENT_QUOTES);

		if(filter_var($user_name, FILTER_VALIDATE_EMAIL))
		{
			$user_name_credential = "user_email";
		}
		else
		{
			$user_name_credential = "user_name";
		}
		
		if($db_temporary_query = $db_connection->query("SELECT user_id, user_name, user_password, user_email FROM user_data WHERE $user_name_credential='$user_name'"))
		{
			if($db_temporary_query->num_rows == 1)
			{
				$db_temporary_row = $db_temporary_query->fetch_assoc();
				$db_temporary_query->close();
				
				if(password_verify($_POST['user_password'], $db_temporary_row['user_password']))
				{
					if(!$db_query_result = $db_connection->query("SELECT thread_id FROM thread_data LIMIT 1"))
					{
						throw new Exception("Usługa niedostępna, za utrudnienia przepraszamy");
					}
					
					if($db_query_result->num_rows == 1)
					{
						$db_thread = $db_query_result->fetch_assoc();
						$_SESSION['user_active_thread'] = $db_thread['thread_id'];
					}
					else
					{
						$_SESSION['usere_active_thread'] = 0;
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
		
		
		$db_temporary_query->close();
	}
	catch(Exception $error)
	{
		$_SESSION['error_login'] = $error->getMessage();
		$_SESSION['error-login-return']['login'] = $_POST['user_name'];
		$_SESSION['error-login-return']['password'] = $_POST['user_password'];
		
		header("Location: index.php");
		
	}
	
	if(isset($db_connection)) $db_connection->close();

?>