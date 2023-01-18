<?php
/*
Required data: none OK
Access: logged user OK

Rules: redirect if not logged in OK
*/
?>

<?php
	/*Rules check*/
	session_start();
	if(!isset($_SESSION['user_id']))
	{
		Header("Location: index.php");
		exit();
	}
	/*END*/
	
	
	
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<a href="logout.php">Wyloguj</a>
</body>
</html>