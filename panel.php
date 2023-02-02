<?php
/*
Access: logged in
Redirect if not logged in
*/
?>

<?php
	
	session_start();
	require_once("rules.php");
	isLoggedIn();
		$user_id = $_SESSION['user_id'];
		
		
		//Thread HTML
		try
		{
			mysqli_report(MYSQLI_REPORT_OFF);
			error_reporting(E_ERROR);
			
			require_once("db_credentials.php");
	
			if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
			{
				throw new Exception("Błąd serwera", 1);
			}
			
			if(!$db_query_result = $db_connection->query("SELECT thread_id, thread_name FROM connection_user_thread INNER JOIN thread_data ON connection_user_thread.connection_thread_id = thread_data.thread_id WHERE connection_user_thread.connection_user_id = '$user_id'"))
			{
				throw new Exception("Błąd serwera", 2);
			}
			else
			{
				if(!isset($_SESSION['user_active_thread']))
				{
					$_SESSION['user_active_thread'] = 0;
				}
				$thread_html = "";
				$thread_active_name = "";
				
				for($i = $db_query_result->num_rows; $i > 0; $i--)
				{
					$db_result_row = $db_query_result->fetch_assoc();
					
					if($_SESSION['user_active_thread'] == $db_result_row['thread_id'])
					{
						$thread_active_name = $db_result_row['thread_name'];
						$temp_html = '<li class="active-thread"><a href="change_active_thread.php?id='.$db_result_row['thread_id'].'">'.$db_result_row['thread_name']."</a><br></li>";
					}
					else
					{
						$temp_html = '<li class="inactive-thread"><a href="change_active_thread.php?id='.$db_result_row['thread_id'].'">'.$db_result_row['thread_name']."</a><br></li>";
					}
					$thread_html =  $thread_html.$temp_html;
				}
				$db_query_result->close();
				
			}
			
		}
		catch(Exception $error)
		{
			echo $error->getMessage();
		}
		
		
		//Task HTML
		try
		{
			if(!isset($_SESSION['user_active_thread']))
			{
				throw new Exception();
			}
			
			
			if(!$db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name))
			{
				throw new Exception("Błąd serwera", 11);
			}
			
			$user_id = $_SESSION['user_id'];
			$user_active_thread = $_SESSION['user_active_thread'];
			
			if(!$db_query_result = $db_connection->query("SELECT task_id, task_title, task_content, task_power FROM task_data WHERE task_user_id = '$user_id' AND task_thread_id = '$user_active_thread' ORDER BY task_power DESC, task_id ASC"))
			{
				throw new Exception("Błąd serwera", 12);
			}
			if(isset($db_connection))
			{
				$db_connection->close();
				
			}
			$task_html = "";
			for($i = $db_query_result->num_rows; $i > 0; $i--)
			{
				$db_result_row = $db_query_result->fetch_assoc();
				
				$temporary_html = '<div class="col-12 col-lg-6">
					<div class="task-show task-power-'.$db_result_row['task_power'].'">
						<div class="task-title">'.$db_result_row['task_title'].'</div>
						<div class="task-content">'.$db_result_row['task_content'].'</div>
					</div>
				</div>';
				
				$task_html = $task_html.$temporary_html;
			}
			$db_query_result->close();
		}
		catch(Exception $error)
		{
			echo $error->getMessage();
		}
		
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
	<script src="js/dialog.box.js"></script>
</head>
<body>
	<aside>
		<div class="blur-background" id="add-task">
			<div class="container">
				<div class ="row">
					<div class="col-lg-6 offset-lg-3">
						<div class="dialog-box">
							<div class="row">
								<div class="col-lg-5">
									<h3>Tworzenie Wpisu<h3>
								</div>
								<div class="offset-lg-6 col-lg-1 dialog-box-close" onclick="closeDialogBox('add-task')">
									<h3>X</h3>
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
	
	<aside>
		<div class="blur-background" id="add-thread">
			<div class="container">
				<div class ="row">
					<div class="col-lg-6 offset-lg-3">
						<div class="dialog-box">
							<div class="row">
								<div class="col-lg-5">
									<h3>Tworzenie listy<h3>
								</div>
								<div class="offset-lg-6 col-lg-1 dialog-box-close" onclick="closeDialogBox('add-thread')">
									<h3>X</h3>
								</div>
								<div class="offset-lg-1 col-lg-10">
									<form action="create_thread.php" method="POST">
										<label for="thread_name">Nazwa listy:</label>
										<input type="text" name="thread_name"/>
										<label for="thread_version">Wersja:</label>
										<select name="thread_version" placeholder="Version">
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
		<div class="d-lg-none topnav-button-mobile">
			Threads
		</div><div class="d-lg-none topnav-button-mobile topnav-button-mobile-right">
			<?=$_SESSION['user_name']?>
		</div>
	
	
		<div class="container">
			<div class="row">
				<div class="d-none d-lg-block col-8" id="logo">Skippit</div>
				<div class="d-none d-lg-block col-2"><div class="topnav-button"><?=$_SESSION['user_name']?></div></div>
				<div class="d-none d-lg-block col-2"><a href="logout.php" class="topnav-button" id="logout-button">Log out</a></div>
			</div>
		</div>
	</div>
	
	
	<nav class="sidemenu d-none d-lg-block"><ul><?=$thread_html ?><li onclick="showDialogBox('add-thread')"><a href="#" id="create-thread">+ Utwórz</a></li></ul></nav>
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