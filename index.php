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
		header("Location: panel.php");
		exit();
	}
	//to be repositioned
	if(isset($_SESSION['error_login']))
	{
		echo $_SESSION['error_login'];
		unset($_SESSION['error_login']);
	}
	/*END*/
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<h1>Login</h1>
	<form action="login.php" method="POST">
		<input type="text" placeholder="login" name="user_name"/>
		<input type="password" placeholder="password" name="user_password"/>
		<input type="submit" value="Log in"/>
	</form>
	<h1>Register</h1>
	<form action="register.php" method="POST">
		<input type="text" name="user_name" placeholder="login"/>
		<input type="text" name="user_email" placeholder="email"/>
		<input type="password" name="user_password" placeholder="hasło"/>
		<input type="password" name="user_password_confirm" placeholder="potwierdź hasło"/>
		<input type="checkbox" name="tos" id="tos"/>
		<label for="tos">Akceptuję regulamin</label>
		<input type="submit" value="Zarejestruj"/>
	</form>
	<?php
		if(isset($_SESSION['error_register']))
		{
			echo $_SESSION['error_register'];
			unset($_SESSION['error_register']);
		}
	?>
</body>
</html>