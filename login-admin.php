<?php
/*
Required data: admin_name, admin_password
Access: all

Rules: redirect if logged in
*/
?>

<?php
	/*Data check*/
	if(!isset($_POST['admin_name']) || !isset($_POST['admin_password']))
	{
		Header("Location: index-admin.php");
		exit();
	}
	/*END*/
	
	session_start();
	
	/*Rules check*/
	if(isset($_SESSION['admin_id'])){
		Header("Location: panel-admin.php");
		exit();
	}
	/*END*/
	try
	{
		require_once('db_credentials.php');
		$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
		
		$admin_name = htmlentities($_POST['admin_name']);
		
		if($db_temporary_query = $db_connection->query("SELECT admin_id, admin_password FROM admin_login WHERE admin_name='$admin_name'"))
		{
			if($db_temporary_query->num_rows == 1)
			{
				$db_temporary_row = $db_temporary_query->fetch_assoc();
				$db_temporary_query->close();
				
				if(password_verify($_POST['admin_password'], $db_temporary_row['admin_password']))
				{
					$_SESSION['admin_id'] = $db_temporary_row['admin_id'];
					Header("Location: panel-admin.php");
				}
				else
				{
					echo "incorrect password";
				}
			}
			else
			{
				echo "incorrect login";
			}
		}
		else
		{
			echo "incorrect sql query";
		}
	}
	catch(Exception $error)
	{
		
	}
	
	
	if(isset($db_connection)) $db_connection->close();
	
?>