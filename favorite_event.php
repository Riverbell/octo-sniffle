<?php
        session_start();
        if(!isset($_SESSION['name'])) {
			header("location: login.php");
		}
?>

<html>
	<?php
		//Connecting to sql db.
		$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

		//Check connection
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		//Insert into favorites table 

		$query = "INSERT INTO favorites(user_id, event_id) VALUES
				('$_SESSION[name]', '$_POST[event_id]')
			";



		//Execute the query
		$error_message = "Du har redan lagt denna bland dina favoriter. <a href='index.php'> Gå tillbaka </a>";

		if (($result = mysqli_query($link, $query)) === false) {
			print utf8_decode($error_message);
			exit();

		}

		$favorite_result = "Lagd i favoriter! <a href='index.php'>Gå tillbaka </a>";

		?>
		<head>
			<title>Lagd i favoriter</title>
			<link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
		</head>
		<body>
			<?php
			print utf8_decode($favorite_result);
			?>
		</body>
</html>