<?php
/*
Panel in dummy version
Required data: none OK
Access: logged user OK

Rules: redirect if not logged in OK
*/
?>

<?php

	session_start();
	require_once("rules.php");
	isLoggedIn();
		
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<h1>DUMMY PANEL - TESTING</h1>
	<h2>Add thread</h2>
	<form action="create_thread.php" method="POST">
	<input type="text" name="thread_name"/>
	<select name="thread_version" placeholder="Version">
		<optgroup label="Version">
			<option value="simple">Simple</option>
			<option value="pro">Pro</option>
		</optgroup>
	</select>
	<input type="submit" value="Utwórz"/>
	
	</form>
	<a href="logout.php">Wyloguj</a>
</body>
</html>