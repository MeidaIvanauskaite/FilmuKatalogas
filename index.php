<!DOCTYPE html>
<html>
	<head>
		<title>Filmų Katalogas</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="icon" href="./images/icon.png" type="image/x-icon">
	</head>
	<body class="body_main">
		<form action="help.php" method="post">
			<button class="button_help" type="submit">?</button>
		</form>

		<div class="index_main">
			<p class="index_title">FILMŲ KATALOGAS</p>
			<p style="margin-bottom: 40px; font-size: 20px; font-weight: bold">Pasižymėkite savo žiūrėtus filmus, ir filmus, kuriuos planuojate žiūrėti</p>
			<form action="./registers/register.php" method="post" class="button_register">
				<button class="button1" type="submit">Registracija</button>
			</form>
			<form action="./logins/login.php" method="post" class="button_login">
				<button class="button1" type="submit">Prisijungimas</button>
			</form>
		</div>
	</body>
</html>