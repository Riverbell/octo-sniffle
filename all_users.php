<?php
        session_start();
        if(!isset($_SESSION['user_type'] == 'admin'))
        {
            header("location: login.php");
        }
?>

<html>
	<?php
		//Connecting to sql db.
		$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

	    // Check connection
	    if (mysqli_connect_errno()) {
	        printf("Connect failed: %s\n", mysqli_connect_error());
	        exit();
	    }

	    $query = "SELECT user_email, user_name, user_password, user_type
	    		  FROM users
	    ";

	    // Execute the query
	    if (($result = mysqli_query($link, $query)) === false) {
	       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
	       exit();
	    }

	    $users = "";
	    while ($line = $result->fetch_object()) {
	        // Store results from each row in variables
	        $user_email = $line->user_email;
	        $user_name = $line->user_name;
	        $user_password = $line->user_password;
	        $user_type = $line->user_type;

	        $users .= "<div class='container'>
		        	<h3>$user_name</h3>
		        	<p>Email: $user_email</p>
		        	<p>Medlemstyp: $user_type</p>
		        	

		        	<form action='update_user.php' method='post'>
						<input type='hidden' value='{$user_email}' name='user_id'/>
						<input type='submit' value='Ändra'/>
					</form>
				</div>
	        ";
	    }
	?>
	<head>
		<title>Alla användare</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

	</head>
	<body>
		<?php
		include 'menu.php';
		print utf8_encode($users);
    ?>

	
	</body>
</html>