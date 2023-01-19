<?php
	/*
	Required data: thread_version, thread_name
	
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
	
	require_once("rules.php");
	
	isLoggedIn();

	if($_SESSION['user_temporary_flag'])
	{
		echo "0";
		Header("Location: panel.php");
		exit();
	}
	
	$thread_owner_id = $_SESSION['user_id'];
	$thread_name = htmlentities($_POST['thread_name'], ENT_QUOTES);
	$thread_version = htmlentities($_POST['thread_version'], ENT_QUOTES);
	
	if(strlen($thread_name) > 24)
	{
		Header("Location: panel.php");
		$_SESSION['error_thread_name'] = "Przekroczona długość nazwy (24)";
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
		require_once("db_credentials.php");
		$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
		
		$db_connection->query("INSERT INTO thread_data (thread_owner_id, thread_name, thread_version) VALUES ('$thread_owner_id', '$thread_name', '$db_thread_version')");

	}
	catch(Exception $e)
	{
		$_SESSION['error_create_thread'] = "Wystąpił błąd";
		echo $e;
	}
	
	if(isset($db_connection))
	{
		$db_connection->close();
	}
	
	Header("Location: panel.php");
?>