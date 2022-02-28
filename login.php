<?php
	session_start();
	// if(isset($_SESSION['user-name'])) {
	// 	header('Location: index.php');
	// } else if(isset($_POST['user-name']) && isset($_POST['user-pass']) && $_POST['user-name'] !== '' && $_POST['user-pass'] !== '') {

		// Checkk if user login and password are correct
		// require_once('backend/DB/DBConnection.php');
		// require_once('backend/DB/DBQueryHandler.php');

		// $encryptedPassword = password_hash($_POST['user-pass'], PASSWORD_BCRYPT, ['cost' => 20]);

		// $queryHandler = new DBQueryHandler();

		// $usersInDB = $queryHandler->read("SELECT * FROM `users` WHERE `login` LIKE 'admin' AND `passwd` LIKE '".$encryptedPassword."' ");

		// $queryHandler->revoke();

	// }
	print(password_hash("C'estpasbien!", PASSWORD_BCRYPT, ['cost' => 12]));
?>
<html>
	<head>
		<title>BIEN - Login</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<form name="authentification-form" action="login.php" method="post">
			Nom d'utilisateur : <input type="text" name="user-name" /><br />
			Mot de passe : <input type="password" name="user-pass"><br />
			<input type="submit" value="s'identifier" />
		</form>
	</body>
</html>