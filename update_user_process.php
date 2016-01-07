<?php
        session_start();
        if(!isset($_SESSION['name']))
        {
            header("location: login.php");
        }
?>
<html>
	<head>
		<title>Uppdatera användare</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<?php
			//Connecting to sql db.
			$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

		    // Check connection
		    if (mysqli_connect_errno()) {
		        printf("Connect failed: %s\n", mysqli_connect_error());
		        exit();
		    }

		    $old_user_email = utf8_decode($_POST[old_user_email]);
		    $new_user_name = utf8_decode($_POST[new_user_name]);
		    $new_user_email = utf8_decode($_POST[new_user_email]);
		    $new_user_type = utf8_decode($_POST[new_user_type]);

		    $query = "UPDATE users
			    SET user_name = '$new_user_name', user_email = '$new_user_email', user_type = '$new_user_type'
			    WHERE user_email = '$old_user_email'
			    ";

		    // Execute the query
		    if (($result = mysqli_query($link, $query)) === false) {
		       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
		       exit();
		    }
		    else {
		        print "<p>Success!</p>
		            <a href='/~emmabac/DM2517/project/all_users.php'>Gå tillbaka</a>";
		    }
		?>
	</body>
</html>