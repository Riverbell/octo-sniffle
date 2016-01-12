<?php
        session_start();
        if($_SESSION['user_type'] != 'admin')
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

	    }

	    // Update ===============================
	    if(isset($_POST['new_user_name'], $_POST['new_user_email'], $_POST['new_user_type'], $_POST['new_password'], $_POST['new_password_again'])) {
	    	$old_user_email = utf8_decode($_POST[old_user_email]);
	    	$old_password = utf8_decode($_POST[old_password]);
			$new_user_name = utf8_decode($_POST[new_user_name]);
			$new_user_email = utf8_decode($_POST[new_user_email]);
			$new_user_type = utf8_decode($_POST[new_user_type]);
			$new_password = utf8_decode($_POST[new_password]);
			$new_password_again = utf8_decode($_POST[new_password_again]);

		    if ( $new_password == $new_password_again ) {
		    	if (empty($new_password) and empty($new_password_again)){
		    		$new_password = $old_password; 
		    	}
			    $query = "UPDATE users
				    SET user_name = '$new_user_name', user_email = '$new_user_email', 
				    user_type = '$new_user_type', user_password = '$new_password'
				    WHERE user_email = '$old_user_email'
				    ";

			    // Execute the query
			    if (($result = mysqli_query($link, $query)) === false) {
			       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
			       exit();
			    }
			    else {
			        $update_result = "<p>Användare uppdaterad!</p>";
			    }
		    } else if ( $new_password != $new_password_again ) {
		    	$update_result = "Lösenorden matchar inte!";
		    } 
	    }
	?>
	<head>
		<title>Uppdatera användare</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<?php include 'menu.php'; ?>

		<div class="container">
			<form action='' method='post'>
	        		<input type='hidden' name='old_user_email' value='<?php echo "$user_email" ?>'/>
		        	<p>Namn: 
		        		<input type='text' name='new_user_name' value='<?php echo "$user_name" ?>'/>
		        	</p>
		        	<p>Email: 
		        		<input type='text' name='new_user_email' value='<?php echo "$user_email" ?>'/>
		        	</p>
		        	<p>Ny medlemstyp:
		        		<select name='new_user_type'>
		        			<option value='admin'
			        		<?php if ($user_type == 'admin') {
			        			echo 'selected';
			        		} ?>
		        			>Admin</option>
		        			<option value='creator' 
			        		<?php if ($user_type == 'creator') {
			        			echo 'selected';
			        		} ?>
		        			>Creator</option>
		        			<option value='user' 
			        		<?php if ($user_type == 'user') {
			        			echo 'selected';
			        		} ?>
		        			>User</option>
		        		</select>
		        	</p>
		        	<p>Nytt lösenord: 
		        		<input type='password' name='new_password' placeholder='***'/>
		        	</p>
		        	<p>Nytt lösenord igen: 
		        		<input type='password' name='new_password_again' placeholder='***'/>
		        	</p>
		        	<input class='submit_button' type='submit' value='Spara'/>
	        	</form>
		<?php
			echo $update_result;
	    ?>
    	</div>

	
	</body>
</html>