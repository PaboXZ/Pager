<?php
	session_start();

	require_once('php-script/rules.php');
	isLoggedIn();
	
	require_once("php-script/db_connect.php");
	$db_connection = db_connect();
	
	
	require_once('php-script/message_print.php');
	require_once('php-script/settings_error_print.php');
	
	require_once('php-script/print_data.php');
	
	$thread_names = printThreadNamesId($db_connection, $_SESSION['user_id']);
	
	$threads_menu_html="";
	if($thread_names)
	{
		foreach($thread_names as $thread_name)
		{
			$temp_message = "Czy chcesz usunąć listę: $thread_name[1]?";
			$temp_target = "thread_delete.php";
			$temp_data = "?thread_name=$thread_name[1]";
			$threads_menu_html = $threads_menu_html.'
					<div class="offset-1 col-6">
						<a href="change_active_thread.php?id='.$thread_name[0].'">'.$thread_name[1].'</a>
					</div>
					<div class="col-1" onclick="corfirmActionDisplay(\''.$temp_message.'\', \''.$temp_target.'\', \''.$temp_data.'\')">
						x
					</div>
			';
		}
	}
	
	db_close($db_connection);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/> 
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="css/main.css"/>
	<link rel="stylesheet" href="css/settings.css"/>
	<link rel="stylesheet" href="css/fontello.css"/>
	
	<title>Skippit - ustawienia</title>
	<link rel="icon" type="image/x-icon" href="favicon/favicon-32x32.png"/>
	
	<script src="js/dialog.box.js"></script>
	
	<style><?=isset($error_style) ? $error_style : ""?><?=isset($message_style) ? $message_style : ""?></style>
</head>
<body>

	<!--Confirm action box-->
	<aside class="blur-background" id="confirm-action-box">
		<div class="container">
			<div class="row">
				<div class="dialog-box offset-1 col-10">
					<div class="row">
						<div class="offset-10 col-1 offset-lg-11">
							<div class="dialog-box-title dialog-box-close" onclick="closeDialogBox('confirm-action-box'); clearConfirmActionBox();">
								<i class="icon-cancel"></i>
							</div>
						</div>
						<div class="col-12 offset-md-1 col-md-10">
							<div class="message-container" id="confirm-action-text">Tekst</div>
						</div>
						<div class="offset-2 col-4 offset-lg-4 col-lg-2">
							<div class="confirm-action-button" id="action-confirm">
								Akceptuj
							</div>
						</div>						
						<div class="col-4 col-lg-2">
							<div class="confirm-action-button" id="action-decline" onclick="closeDialogBox('confirm-action-box'); clearConfirmActionBox();">
								Powrót
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</aside>
	<!--Message/error box-->
	<aside class="blur-background" id="dialog-box-message">
		<div class="container">
			<div class="row">
				<div class="dialog-box offset-1 col-10">
					<div class="row">
						<div class="offset-10 col-1 offset-lg-11">
							<div class="dialog-box-title dialog-box-close" onclick="closeDialogBox('dialog-box-message')">
								<i class="icon-cancel"></i>
							</div>
						</div>
						<div class="col-12 offset-md-1 col-md-10">
							<div class="message-container" id="error-text"><?=isset($error_message) ? $error_message : ""?></div>
							<div class="message-container" id="message-text"><?=isset($message) ? $message : ""?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</aside>
	
	
	<div id="topbar">
		<div class="logo col-1 d-lg-none topnav-button-mobile">
			<a href="panel.php">Skippit</a>
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
				<div class="logo d-none d-lg-block col-8"><a href="panel.php">Skippit</a></div>
				<div class="d-none d-lg-block col-2"><a href="settings.php" class="topnav-button"><?=$_SESSION['user_name']?> <i class="icon-cog"></i></a></div>
				<div class="d-none d-lg-block col-2"><a href="logout.php" class="topnav-button" id="logout-button">Log out <i class="icon-off"></i></a></div>
			</div>
		</div>
	</div>
	

	
	<main>
		<div class="container">
			<div class="row">
				<div class="settings-title">Ustawienia</div>
				<div class="settings-tab col-4 offset-lg-1 col-lg-2">
					Listy
				</div>
			</div>
			<div class="row">
				<div class="settings-content col-12">
					<div class="row">
							<?=isset($threads_menu_html) ? $threads_menu_html : ""?>
					</div>
				</div>
			</div>
		</div>
	</main>
	
	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
