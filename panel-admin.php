<?php
/*
Required data: none
Access: admin

Rules: redirect if not logged in admin
*/
?>

<?php
	/*Rules check*/
	session_start();
	if(!isset($_SESSION['admin_id']))
	{
		Header("Location: login-admin.php");
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
	<a href="logout-admin.php">Log out</a>
</body>
</html>