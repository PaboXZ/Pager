<?php
	session_start();

	require_once('php-script/rules.php');
	isLoggedIn();
	
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="css/main.css"/>
	<link rel="stylesheet" href="css/settings.css"/>
	<link rel="stylesheet" href="css/fontello.css"/>
</head>
<body>
	<div id="topbar">
		<div class="col-1 d-lg-none topnav-button-mobile" id="mobile-thread-menu-open" onclick="showSideMenu()">
			<i class="icon-menu"></i>
		</div>
		<div class="d-none col-1 d-lg-none topnav-button-mobile" id="mobile-thread-menu-close" onclick="hideSideMenu()">
			<i class="icon-left-open"></i>
		</div>
		<div class="offset-7 col-1 d-lg-none topnav-button-mobile topnav-button-mobile-right">
			<a href="settings.php"><i class="icon-cog"></i></a><br>
		</div>
		<div class="offset-1 col-1 d-lg-none topnav-button-mobile topnav-button-mobile-right" onclick="window.location.href='logout.php'">
			<i class="icon-off"></i><br>
		</div>
	
	
		<div class="container">
			<div class="row">
				<div class="d-none d-lg-block col-8" id="logo"><a href="panel.php">Skippit</a></div>
				<div class="d-none d-lg-block col-2"><a href="settings.php" class="topnav-button"><?=$_SESSION['user_name']?> <i class="icon-cog"></i></a></div>
				<div class="d-none d-lg-block col-2"><a href="logout.php" class="topnav-button" id="logout-button">Log out <i class="icon-off"></i></a></div>
			</div>
		</div>
	</div>
	

	
	<main>
		<div class="container">
			<div class="row">
				<div class="settings-title">Ustawienia</div>
				<div class="settings-tab offset-1 col-2">
					Listy
				</div>
			</div>
			<div class="row">
				<div class="settings-content col-12">
					Content
				</div>
			</div>
		</div>
	</main>
	
	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
