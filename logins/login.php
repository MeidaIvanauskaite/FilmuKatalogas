<!DOCTYPE html>
<html>
	<head>
		<title>Filmų Katalogas</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="icon" href="../images/icon.png" type="image/x-icon">
	</head>
	<body class="body_main">
		<div class="index_main2">
			<form action="login2.php" method="post">
				<a href="../index.php" class="a_back">Atgal</a>
				<p class="index_title" id="login_title" >PRISIJUNGIMAS</p>

				<?php if (isset($_GET['error'])) { ?>
					<p class="error"><?php echo $_GET['error']; ?> </p>
				<?php } ?>

				<?php if (isset($_GET['success'])) { ?>
					<p class="success"><?php echo $_GET['success']; ?> </p>
				<?php } ?>

				<label>Naudotojo vardas</label>
				<input class="input1" type="text" name="username" placeholder="Naudotojo vardas"><br>

				<label>Slaptažodis</label>
				<input class="input1" type="password" name="password" placeholder="Slaptažodis"><br>

				<button class="button1" type="submit">Prisijungti</button>
			</form>
		</div>
	</body>
</html>