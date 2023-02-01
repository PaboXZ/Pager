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
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="main.css"/>
	<link rel="stylesheet" href="index.style.css"/>
	
	
	<script src="dialog.box.js"></script>
</head>
<body>
	
	<main class="blur-background" id="dialog-box-login">
		<div class="container">
			<div class="row">
				<div class="offset-xl-4 col-xl-4 offset-xl-3 col-lg-6 offset-md-2 col-md-8 offset-1 col-10">
					<div class="dialog-box">
						<div class="row">
							<div class="offset-1 col-8 offset-xl-1 col-xl-4">
								<div class="dialog-box-title">Zaloguj</div>
							</div>
							<div class="offset-2 col-1 offset-xl-6 col-xl-1 dialog-box-close" onclick="closeDialogBox('dialog-box-login')">
								<div class="dialog-box-title">X</div>
							</div>
							<div class="offset-1 col-10">
								<div class="dialog-box-content">
									<form action="login.php" method="POST">
										<input type="text" placeholder="login" name="user_name" onfocus="this.placeholder=''" onblur="this.placeholder='login'"/><br>
										<input type="password" placeholder="hasło" name="user_password" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'"/><br>
										<input type="submit" value="Log in"/>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>	
	
	<aside class="blur-background" id="dialog-box-register">
		<div class="container">
			<div class="row">
				<div class="offset-xl-4 col-xl-4 offset-xl-3 col-lg-6 offset-md-2 col-md-8 offset-1 col-10">
					<div class="dialog-box">
						<div class="row">
							<div class="offset-1 col-8 offset-xl-1 col-xl-4">
								<div class="dialog-box-title">Zarejestruj</div>
							</div>
							<div class="offset-2 col-1 offset-xl-6 col-xl-1 dialog-box-close" onclick="closeDialogBox('dialog-box-register')">
								<div class="dialog-box-title">X</div>
							</div>
							<div class="offset-1 col-10">
								<div class="dialog-box-content">
									<form action="register.php" method="POST">
										<input type="text" name="user_name" placeholder="login"/>
										<input type="text" name="user_email" placeholder="email"/>
										<input type="password" name="user_password" placeholder="hasło"/>
										<input type="password" name="user_password_confirm" placeholder="potwierdź hasło"/>
										<input type="checkbox" name="tos" id="tos"/>
										<label for="tos">Akceptuję regulamin</label>
										<input type="submit" value="Zarejestruj"/>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</aside>
	
	<nav id="topbar">
		<div class="container">
			<div class="row">
				<div id="logo" class="col-1 d-md-block d-none">
					Skippit
				</div>
				<div class="offset-xl-7 col-xl-2 offset-lg-7 col-lg-2 offset-md-5 col-md-3 col-6">
					<div class="topnav-button" onclick="showDialogBox('dialog-box-login')">Zaloguj</div>
				</div>
				<div class="col-xl-2 col-lg-2 col-md-3 col-6">
					<div class="topnav-button" onclick="showDialogBox('dialog-box-register')">Zarejestruj</div>
				</div>
			</div>
		</div>
	</nav>
	
	<div id="index-welcome-text">
		<h1>Skippit</h1>
		<p>Skip it, or complete it.</p>
	</div>
	<?php
		if(isset($_SESSION['error_register']))
		{
			echo $_SESSION['error_register'];
			unset($_SESSION['error_register']);
		}
	?>
		
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-12" id="footer-top-text">
					&copy;Mose creations 
				</div>
			</div>
		</div>
	</footer>
	
	
	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>


</body>
</html>