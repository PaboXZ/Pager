<?php
/*
Required data: none OK
Access: logged user OK

Rules: redirect if not logged in OK
*/
?>

<?php

	require_once("rules.php");
	isLoggedIn();
		
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<?php
	echo $_SESSION['user_id'];
	?>
	<a href="logout.php">Wyloguj</a>
</body>
</html>