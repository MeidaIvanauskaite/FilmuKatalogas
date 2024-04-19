<!DOCTYPE html>
<html>
	<head>
		<title>Filmų Katalogas</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="icon" href="../images/icon.png" type="image/x-icon">
	</head>
	<body class="body_main">
		<div class="index_main2">
			<form action="register2.php" method="post">
				<a href="../index.php" class="a_back">Atgal</a>
				<p class="index_title" id="register_title">REGISTRACIJA</p>

				<?php if (isset($_GET['error'])) { ?>
					<p class="error"><?php echo $_GET['error']; ?></p>
				<?php } ?>

				<label>Naudotojo vardas</label>
				<?php if (isset($_GET['uname'])) { ?>
					<input class="input1" type="text" name="username" placeholder="Naudotojo vardas" value="<?php echo $_GET['uname']; ?>"><br>
				<?php } else { ?>
					<input class="input1" type="text" name="username" placeholder="Naudotojo vardas"><br>
				<?php }?>

				<label>Slaptažodis</label>
				<input class="input1" type="password" name="password1" placeholder="Slaptažodis"><br>

				<label>Pakartokite slaptažodį</label>
				<input class="input1" type="password" name="password2" placeholder="Slaptažodis"><br>

				<button class="button1" type="submit">Registruotis</button>
			</form>
		</div>
	</body>
</html>