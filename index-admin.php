<?php
/*
Required data: none
Access: all

Rules: redirect if logged in
*/
?>

<?php
	/*Rules check*/
	session_start();
	if(isset($_SESSION['admin_id'])){
		Header("Location: panel-admin.php");
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
	<form action="login-admin.php" method="POST">
		<input type="text" name="admin_name" placeholder="login"/>
		<input type="password" name="admin_password" placeholder="password"/>
		<input type="submit" value="Log in"/>
	</form>
	
	
	<a href="index.php">Panel użytkownika</a>
</body>
</html>