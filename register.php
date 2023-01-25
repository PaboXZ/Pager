<?php
/*
Access: not logged in

Required data:
Name: alnum, length : 3-20, not existing
email: email verify, not existing
password: At least one of each [A-Z], [a-z], [0-9], hash to db, length : 8-48
ToS check
recaptcha -- later

optional temporary flag
*/
?>

<?php
	function error_add($message)
	{
		if(isset($_SESSION['error_register']))
		{
			$_SESSION['error_register'] = $_SESSION['error_register']."<br>".$message;
		}
		else
		{
			$_SESSION['error_register'] = $message;
		}
	}
	
	
	session_start();
	
	if(isset($_SESSION['user_id']))
	{
		header("Location: panel.php");
		exit();
	}
	
	if(!isset($_POST['user_email']))
	{
		header("Location: index.php");
		exit();
	}
	
	if(!isset($_POST['user_name']) || !isset($_POST['user_password']) || !isset($_POST['user_password_confirm']))
	{
		header("Location: index.php");
	}
	
	if(!ctype_alnum($_POST['user_name']))
	{
		error_add("Dozwolone znaki dla nazwy użytkownika: a-Z, 0-9");
	}
	
	error_reporting(E_ERROR);
	mysqli_report(MYSQLI_REPORT_OFF);
	
	try
	{
		require_once("db_credentials.php");
		if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
		{
			throw new Exception("Bład serwera:", 1);
		}
		
		$user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
		if(strlen($user_name) < 3 || strlen($user_name) > 20)
		{
			error_add("Dozwolona ilość znaków dla nazwy użytkownika: 3-20");
		}
		
		if(!$db_query_result = $db_connection->query("SELECT user_name FROM user_data WHERE user_name = '$user_name'"))
		{
			throw new Exception("Błąd serwera", 2);
		}
		
		if($db_query_result->num_rows > 0)
		{
			error_add("Wybrana nazwa użytkownika już istnieje");
		}
		
		$user_email = $_POST['user_email'];
		
		if(!filter_var($user_email, FILTER_VALIDATE_EMAIL))
		{
			error_add("Wprowadzono nieprawidłowy email");
		}
		
		if(!$db_query_result = $db_connection->query("SELECT user_email FROM user_data WHERE user_email = '$user_email'"))
		{
			throw new Exception("Bład serwera", 3);
		}
		
		if($db_query_result->num_rows > 0)
		{
			error_add("Podany adres email istnieje już w systemie");
		}
		if(strlen($_POST['user_password']) < 8 OR strlen($_POST['user_password']) > 48)
		{
			error_add("Niepoprawna długość hasła (8-48)");
		}
		if($_POST['user_password'] != $_POST['user_password_confirm'])
		{
			error_add("Podane hasła nie są jednakowe");
		}
		
		if(!preg_match("/[0-9]/", $_POST['user_password']) || !preg_match("/[a-z]/", $_POST['user_password']) || !preg_match("/[A-Z]/", $_POST['user_password']))
		{
			error_add("Hasło musi zawierać jedną wielką, mała literę oraz cyfrę");
		}
		
		if(!isset($_POST['tos']))
		{
			error_add("Wymagana akceptacja regulaminu");
		}
		
		if(isset($_SESSION['error_register']))
		{
			throw new Exception($_SESSION['error_register']);
		}
		
		$user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
		
		if(!$db_connection->query("INSERT INTO user_data (user_name, user_email, user_password) VALUES ('$user_name', '$user_email', '$user_password')"))
		{
			throw new Exception("Błąd serwera", 4);
		}
	}
	catch(Exception $error)
	{
		$_SESSION['error_register'] = $error->getMessage();
		header("Location: index.php", );
	}
	
	if(isset($db_connection))
	{
		$db_connection->close();
	}
	header('Location: index.php');
	
?>