<?php 
/*
Required data: Login(POST), Password(POST) 
Access: all

Rules: redirect if logged in
*/
?>

<?php

	/*Required data check*/
	if(!isset($_POST["user_name"]) OR !isset($_POST["user_password"]))
	{
		Header("Location: index.php");
		exit();
	}
	/*END*/

	
	try
	{
		/*DB connection*/
		require_once('db_credentials.php');
		
		$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
		
		if($db_connection->connect_errno!=0)
		{
			throw new Exception($db_connection->mysqli_connect_errno());
		}
		/*END*/
		
		/*User name sanitization*/
		$user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
		/*END*/
		
		/*Check for user name in db and verify password with hash*/
		if($db_temporary_query = $db_connection->query("SELECT user_id, user_password FROM login_data WHERE user_name='$user_name'"))
		{
			if($db_temporary_query->num_rows == 1)
			{
				$db_temporary_row = $db_temporary_query->fetch_assoc();
				if(password_verify($_POST['user_password'], $db_temporary_row['user_password']))
				{
					echo "Login success";
				}
				else
				{
					echo "password error";
				}
			}
			else
			{
				echo "login error";
			}
		}
		else
		{
			echo "query fail";
		}
		/*END*/
		
		
		$db_temporary_query->close();
	}
	catch(Exception $error)
	{
		echo $error;
	}
	
	
	if(isset($db_connection)) $db_connection->close();

?>