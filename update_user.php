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
	    		  WHERE user_email = '$_POST[user_id]'
	    ";

	    // Execute the query
	    if (($result = mysqli_query($link, $query)) === false) {
	       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
	       exit();
	    }

	    $user = "";
	    while ($line = $result->fetch_object()) {
	        // Store results from each row in variables
	        $user_email = $line->user_email;
	        $user_name = $line->user_name;
	        $user_password = $line->user_password;
	        $user_type = $line->user_type;

	        $user_email = utf8_encode($user_email);
	        $user_name = utf8_encode($user_name);
	        $user_password = utf8_encode($user_password);
	        $user_type = utf8_encode($user_type);

	        $user .= "<div class='container'>
	        	<form action='update_user_process.php' method='post'>
	        		<input type='hidden' name='old_user_email' value='$user_email'/>
		        	<p>Namn: 
		        		<input type='text' name='new_user_name' value='$user_name'/>
		        	</p>
		        	<p>Email: 
		        		<input type='text' name='new_user_email' value='$user_email'/>
		        	</p>
		        	<p>Nuvarande medlemstyp: $user_type </p>
		        	<p>Ny medlemstyp:
		        		<select name='new_user_type'>
		        			<option value='admin' ";
			        		if ($user_type == 'admin') {
			        			$user .= "selected";
			        		}
		        			$user .= ">Admin</option>
		        			<option value='creator' ";
			        		if ($user_type == 'creator') {
			        			$user .= "selected";
			        		}
		        			$user .= ">Creator</option>
		        			<option value='user' ";
			        		if ($user_type == 'user') {
			        			$user .= "selected";
			        		}
		        			$user .= ">User</option>
		        		</select>
		        	</p>
		        	<input type='submit' value='Spara'/>
	        	</form>
	        	</div>
	        ";
	    }
	?>
	<head>
		<title>Uppdatera användare</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<?php
		include 'menu.php';
		print $user;
    ?>

	
	</body>
</html>