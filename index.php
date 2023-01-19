<?php
/*Required data: none OK
Access: all	OK

Rules: redirect if logged in (beware admin/user panel)
*/
?>

<?php
	/*Rules check*/
	session_start();
	if(isset($_SESSION['user_id']))
	{
		Header("Location: panel.php");
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
	<form action="login.php" method="POST">
		<input type="text" placeholder="login" name="user_name"/>
		<input type="password" placeholder="password" name="user_password"/>
		<input type="submit" value="Log in"/>
	</form>
</body>
</html>