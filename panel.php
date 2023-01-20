<?php
/*
Panel in dummy version
Required data: none OK
Access: logged user OK

Rules: redirect if not logged in OK
*/
?>

<?php

	session_start();
	require_once("rules.php");
	isLoggedIn();
		
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<h1>DUMMY PANEL - TESTING</h1>
	<h2>Add thread</h2>
	<form action="create_thread.php" method="POST">
		<input type="text" name="thread_name"/>
		<select name="thread_version" placeholder="Version">
			<optgroup label="Version">
				<option value="simple">Simple</option>
				<option value="pro">Pro</option>
			</optgroup>
		</select>
		<input type="submit" value="Utwórz"/>
	</form>
	<?php
		if(isset($_SESSION['error_create_thread']))
		{
			echo $_SESSION['error_create_thread'];
			unset($_SESSION['error_create_thread']);
		}
	?>
	<h2>Threads</h2>
	<?php
		
		try
		{
			mysqli_report(MYSQLI_REPORT_OFF);
			error_reporting(E_ERROR);
			
			require_once("db_credentials.php");
			if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
			{
				throw new Exception("Błąd serwera", 1);
			}
			$user_id = $_SESSION['user_id'];
			if(!$db_query_result = $db_connection->query("SELECT thread_id, thread_name FROM connection_user_thread INNER JOIN thread_data ON connection_user_thread.connection_thread_id = thread_data.thread_id WHERE connection_user_thread.connection_user_id = '$user_id'"))
			{
				throw new Exception("Błąd serwera", 2);
			}
			else
			{	
				for($i = $db_query_result->num_rows; $i > 0; $i--)
				{
					$db_result_row = $db_query_result->fetch_assoc();
					echo '<a href="change_active_thread.php?id='.$db_result_row['thread_id'].'">'.$db_result_row['thread_name']."</a><br>";
				}
				$db_query_result->close();
			}
			
		}
		catch(Exception $error)
		{
			echo $error->getMessage();
		}
		if(isset($db_connection)) $db_connection->close();
		if(isset($_SESSION['error_change_active_thread']))
		{
			echo $_SESSION['error_change_active_thread'];
			unset($_SESSION['error_change_active_thread']);
		}
	?>
	<a href="logout.php">Wyloguj</a>
</body>
</html>