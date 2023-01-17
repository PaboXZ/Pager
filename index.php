<?php
/*Required data: none
Access: all

Rules: redirect if logged in (beware admin/user panel)*/
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<form action="login.php" method="POST">
		<input type="text" placeholder="login" name="user_name"/>
		<input type="password" placeholder="password" name="user_password"/>
		<input type="submit" value="Log in"/>
	</form>
	
	<a href="admin-index.php">Panel Administracyjny</a>
</body>
</html>