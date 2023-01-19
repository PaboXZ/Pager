<?php
/*
Required data: none OK
Access: admin OK

Rules: redirect if not logged in admin OK
*/
?>

<?php
	/*Rules check*/
	require_once("rules.php");
	isLoggedAdmin();
	/*END*/
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<a href="logout.php">Log out</a>
	<h1>Nowy użytownik</h1>
	<form action="admin-new-user.php" method="POST">
		<input type="text" name="register_name" placeholeder="Nazwa"/>
		<input type="password" name="register_password" placeholder="hasło"/>
		<input type="submit" value="Zarejestruj"/>
	</form>
</body>
</html>