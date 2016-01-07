<?php
//if username and password are submitted
if(isset($_POST['user_email'], $_POST['password'])) {
	// Define $username and $password
	$user_email=$_POST['user_email'];
	$password=$_POST['password'];
	//create a connection to database to check is username and password exists
	$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');
	$query = "SELECT user_email, user_name, user_type  
			  FROM users 
			  WHERE user_password='$password' 
			  AND user_email='$user_email'";
	// Execute the query
	if (($result = mysqli_query($link, $query)) === false) {
		printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
		exit();
	}
	//Check if username and password are correct (in database)
	$rows = mysqli_num_rows($result);
	if ($rows == 1) {
		//creates a variable for user type
		$line = $result->fetch_object();
		$user_type = $line->user_type;
		$user_name = $line->user_name;
		//starts session
		session_start();
		//give the session a name and saves the variable user_type
		$_SESSION['name']=$_POST['user_email'];
		$_SESSION['user_type']=$user_type;
		$_SESSION['user_name']=$user_name;
		//Storing the name of user in SESSION variable.
		header("location: index.php");
	} else {
				$error = "Username or Password is invalid";
			}
			mysqli_close($link); // Closing Connection
}
?>
<html>
<head>
	<title>Logga in</title>
	<link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<?php include 'menu.php'; ?>
	<div class="container">
		<h2>Logga in</h2>
		<form action="" method="post">
			<label>Användarnamn:</label>
			<input id="name" name="user_email" placeholder="user_email" type="text">
			<label>Lösenord:</label>
			<input id="password" name="password" placeholder="**********" type="password">
			<input name="submit" type="submit" value="Logga in">
			<span><?php echo $error; ?></span>
		</form>
	</div>

</body>
</html>