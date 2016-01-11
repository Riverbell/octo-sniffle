<?php
        session_start();
        if(!isset($_SESSION['name']))
        {
            header("location: login.php");
        } elseif($_SESSION['user_type'] == 'user') {
            header("location: index.php");
        }
?>
<html>
<head>
	<title>Skapa event</title>
	<link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<?php include 'menu.php'; ?>
	<?php 
		$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

		if ( $_SESSION['user_type'] == 'admin' ) {
			$query = "SELECT user_email, user_name, user_type  
					  FROM users 
					  WHERE user_type = 'creator'
					  ";
			// Execute the query
			if (($result = mysqli_query($link, $query)) === false) {
				printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
				exit();
			}

			$creators = "<select name='input_creatorEmail'>";
		    while ($line = $result->fetch_object()) {
		        // Store results from each row in variables
		        $user_email = $line->user_email;
		        $user_name = $line->user_name;
		        $user_type = $line->user_type;

		        $creators .= "
		        	<option value='$user_email'>$user_name</option>
		        ";
		    }
		    $creators .= "</select>";

		} else {
			$query = "SELECT user_email, user_name, user_type
					  FROM users
					  WHERE user_email = '$_SESSION[name]'
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
		        $user_type = $line->user_type;

		        $creators = "
		        	<input type='text' name='input_creatorEmail' value='$user_name' disabled/>
		        ";
		    }
		}
	?>
	<div class="container">
		<form action="" method="post">
			<h2>Skapa ett nytt event</h2>
			<p>Event Namn:
			<input type="text" name="input_name"/>
			</p>
			<p>Totalt Antal Biljetter:
			<input type="text" name="input_totalTickets"/>
			</p>
			<p>Antal Tillgängliga Biljetter:
			<input type="text" name="input_availableTickets"/>
			</p>
			<p>Arena:
			<input type="text" name="input_venue"/>
			</p>
			<p>Startdatum:
			<input type="text" name="input_startdate"/>
			</p>
			<p>Starttid:
			<input type="text" name="input_starttime"/>
			</p>
			<p>Arrangör:
				<?php 
					print utf8_encode($creators); 
				?>
			</p>
			<p>Kategori:
			<select name='input_categoryID'>
				<option value='1'>Sport</option>
				<option value='2'>Musik</option>
				<option value='3'>Teater</option>
				<option value='4'>Underhållning</option>
				<option value='5'>Barn</option>
			</select>
			</p>
			<input class="submit_button" type="submit" value="Skapa"/>
			<span><?php echo $error; ?></span>
		</form>
		<?php
			if(isset($_POST['input_name'], $_POST['input_totalTickets'], $_POST['input_availableTickets'], $_POST['input_venue'], $_POST['input_startdate'], $_POST['input_starttime'], $_POST['input_creatorEmail'], $_POST['input_categoryID'])) {
				//Connecting to sql db.
				$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

			    // Check connection
			    if (mysqli_connect_errno()) {
			        printf("Connect failed: %s\n", mysqli_connect_error());
			        exit();
			    }

			    $query = "INSERT INTO events (event_name, total_tickets, available_tickets, venue, startdate, starttime, user_email, category_id) 
			    	 	  VALUES ('$_POST[input_name]', '$_POST[input_totalTickets]','$_POST[input_availableTickets]','$_POST[input_venue]','$_POST[input_startdate]','$_POST[input_starttime]','$_POST[input_creatorEmail]','$_POST[input_categoryID]')
			    ";

				// Execute the query
			    if (($result = mysqli_query($link, $query)) === false) {
			       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
			    }
			    else {
			        print utf8_decode("<p>Event skapat!</p>
			            <a href='/~emmabac/DM2517/project/index.php'>Gå tillbaka</a>");
			    }
			}
		?>
	</div>

</body>

</html>