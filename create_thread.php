<?php
	/*
	Required data:
	thread_version : 0-3
	thread_name : 3-24
	
	Access: logged in, not TEMPORARY
	
	Rules: Redirect if not logged in
	Redirect if temporary user
	
	Check for thread_name length, max is 24
	Sanitize thread_name
	*/
?>

<?php
	if(!isset($_POST['thread_version']) || !isset($_POST['thread_name']))
	{
		header("Location: panel.php");
		exit();
	}
	
	session_start();
	
	require_once("php-script/rules.php");
	
	isLoggedIn();
	redirectTemporary();
	
	$thread_owner_id = $_SESSION['user_id'];
	$thread_name = htmlentities($_POST['thread_name'], ENT_QUOTES);
	$thread_version = htmlentities($_POST['thread_version'], ENT_QUOTES);
	
	if(strlen($thread_name) > 24 OR strlen($thread_name) < 3)
	{
		$_SESSION['error_create_thread'] = "Niewłaściwa długość nazwy (3 - 24)";
		header("Location: panel.php");
		exit();
	}
	
	$db_thread_version = 0;
	switch ($thread_version)
	{
		case "pro":
			$db_thread_version = 1;
	}
	
	try
	{
		
		require_once("php-script/db_credentials.php");
		if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
		{
			throw new Exception("Błąd serwera", 0);
		}
		if(!$db_query_result = $db_connection->query("SELECT thread_id FROM thread_data WHERE thread_owner_id = '$thread_owner_id'"))
		{
			throw new Exception("Błąd serwera", 0);
		}
		if($db_query_result->num_rows > 10)
		{
			throw new Exception("Osiągnięto maksymanlną ilość list: 10");
		}
		if(!$db_query_result = $db_connection->query("SELECT thread_id FROM thread_data WHERE thread_owner_id = '$thread_owner_id' AND thread_name = '$thread_name'"))
		{
			throw new Exception("Bład serwera", 10);
		}
		if($db_query_result->num_rows > 0)
		{
			throw new Exception("Wybrana nazwa już istnieje.");
		}
		if(!$db_connection->query("INSERT INTO thread_data (thread_owner_id, thread_name, thread_version) VALUES ('$thread_owner_id', '$thread_name', '$db_thread_version')"))
		{
			throw new Exception("Błąd serwera", 1);
		}			
		if(!$db_query_result = $db_connection->query("SELECT thread_id FROM thread_data WHERE thread_owner_id = '$thread_owner_id' AND thread_name = '$thread_name'"))
		{
			throw new Exception("Błąd serwera", 2);
		}
		
		$thread_id = $db_query_result->fetch_assoc()['thread_id'];
		
		if(!$db_connection->query("INSERT INTO connection_user_thread (connection_user_id, connection_thread_id, connection_view_power, connection_is_owner, connection_edit_permission, connection_delete_permission, connection_create_power, connection_complete_permission) VALUES ('$thread_owner_id', '$thread_id', '15', '1', '1', '1', '15', '1')"))
		{
			throw new Exception("Błąd serwera", 3);
		}
		$_SESSION['user_active_thread'] = $thread_id;
	}
	catch(Exception $error)
	{
		if($error->getCode() == 2 OR $error->getCode() == 3)
		{
			$db_connection->query("DELETE FROM thread_data WHERE thread_owner_id = '$thread_owner_id' AND thread_name = '$thread_name'");
		}
		$_SESSION['error_create_thread'] = $error->getMessage();
	}
	
	if(isset($db_connection->host_info))
	{
		$db_connection->close();
	}
	header("Location: panel.php");
?>