<?php
/*
Access: logged in
Redirect if not logged in
*/
?>

<?php
	
	session_start();
	require_once("php-script/rules.php");
	isLoggedIn();
	
	require_once('php-script/message_print.php');
	require_once('php-script/panel_error_print.php');
	require_once('php-script/message_print.php');
			
	require_once('php-script/panel_thread_print.php');
	require_once('php-script/panel_task_print.php');
	
		//Add task button
		$task_button_html = "";
		if($_SESSION['user_active_thread'] != 0)
		{
			$task_button_html = '	<div id="add-task-button" onclick="showDialogBox(\'add-task\')">
									+ Dodaj wpis
									</div>';
		}
?>



<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/main.css"/>
	<link rel="stylesheet" href="css/task.css"/>
	<link rel="stylesheet" href="css/thread.css"/>
	<link rel="stylesheet" href="css/fontello.css"/>
	<script src="js/dialog.box.js"></script>
	<script src="js/thread.js"></script>
	<script src="js/task.js"></script>
	<style><?=isset($error_style) ? $error_style : ""?><?=isset($message_style) ? $message_style : ""?></style>
</head>
<body>
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
	
	<!--Add task box-->
	<aside>
		<div class="blur-background" id="add-task">
			<div class="container">
				<div class ="row">
					<div class="col-lg-6 offset-lg-3">
						<div class="dialog-box">
							<div class="row">
								<div class="col-9">
									<h3>Tworzenie Wpisu<h3>
								</div>
								<div class="offset-1 col-1 dialog-box-close" onclick="closeDialogBox('add-task')">
									<h3><i class="icon-cancel"></i></h3>
								</div>
								<div class="offset-lg-1 col-lg-10">
									<form action="create_task.php" method="POST">
										Nazwa wpisu:<br>
										<input type="text" name="task_title" placeholder="Nazwa wpisu"/><br>
										Treść wpisu:<br>
										<textarea name="task_content" rows="6" value="Treść wpisu"></textarea><br>
										Priorytet:<br>
										<input type="radio" name="task_power" value="1" id="power-low" checked/>
										<label for="power-low">Niski</label><br>
										<input type="radio" name="task_power" value="2" id="power-mid-low"/>
										<label for="power-mid-low">Średnio-niski</label><br>
										<input type="radio" name="task_power" value="3" id="power-mid"/>
										<label for="power-mid">Średni</label><br>
										<input type="radio" name="task_power" value="4" id="power-mid-high"/>
										<label for="power-mid-high">Średnio-wysoki</label><br>
										<input type="radio" name="task_power" value="5" id="power-high"/>
										<label for="power-high">Wysoki</label><br>
										<br>
										<input type="submit" value="Dodaj wpis"/>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</aside>
	
	<!--Add thread box-->
	<aside>
		<div class="blur-background" id="add-thread">
			<div class="container">
				<div class ="row">
					<div class="col-lg-6 offset-lg-3">
						<div class="dialog-box">
							<div class="row">
								<div class="col-9">
									<h3>Tworzenie listy<h3>
								</div>
								<div class="offset-1 col-1 dialog-box-close" onclick="closeDialogBox('add-thread')">
									<h3><i class="icon-cancel"></i></h3>
								</div>
								<div class="offset-lg-1 col-lg-10">
									<form action="create_thread.php" method="POST">
										<label for="thread_name">Nazwa listy:</label>
										<input type="text" name="thread_name"/>
										<label for="thread_version">Wersja:</label>
										<select name="thread_version">
											<optgroup label="Version">
												<option value="simple">Simple</option>
												<option value="pro">Pro</option>
											</optgroup>
										</select>
										<input type="submit" value="Utwórz"/>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</aside>
	
	<?=$task_button_html?>
	
	
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
	
	
	<nav class="sidemenu d-none d-lg-block" id="sidemenu"><ul><?=$thread_html ?><li onclick="showDialogBox('add-thread')"><a id="create-thread">+ Utwórz</a></li></ul></nav>
	<main>	
		<div class="container">
			<div class="row">
				
				<main class="col-12 offset-lg-2 col-lg-10">
					<div class="row">
						<div id="thread-active-name"><?=$thread_active_name?></div>
						<?=$task_html ?>
					</div>
				</main>

			</div>
		</div>
	</main>




	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>