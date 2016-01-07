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

	    // Check connection
	    if (mysqli_connect_errno()) {
	        printf("Connect failed: %s\n", mysqli_connect_error());
	        exit();
	    }

	    $query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, startdate, starttime, user_email, category_id, user_name, category_name
            FROM events NATURAL JOIN users
            NATURAL JOIN categories
	    	WHERE event_id = '$_POST[event_id]'
	    ";

		// Execute the query
	    if (($result = mysqli_query($link, $query)) === false) {
	       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
	       exit();
	    }

	    $event_tag = '';
	    while ($line = $result->fetch_object()) {
	        // Store results from each row in variables
	        $event_id = $line->event_id;
	        $event_name = $line->event_name;
	        $total_tickets = $line->total_tickets;
	        $available_tickets = $line->available_tickets;
	        $venue = $line->venue;
	        $startdate = $line->startdate;
	        $starttime = $line->starttime;
	        $category = $line->category_name;
	        $creator = $line->user_email;

	    	$event_name = utf8_encode($event_name);
	        $venue = utf8_encode($venue);
	        $category = utf8_encode($category);
	        $creator = utf8_encode($creator);

	   
	        // Store the result we want by appending strings
	        $event_info = "
	    		<p>Eventnamn: $event_name</p>
				<p>Startdatum: $startdate</p>
				<p>Starttid: $starttime</p>
				<p>Arena: $venue</p>
				<p>Arrangör: $creator</p>
				<p>Kategori: $category</p>
				<p>Totalt Antal Biljetter: $total_tickets</p>
				<p>Antal Tillgängliga Biljetter: $available_tickets</p>
				";

	    	$booking_form = "<form action='book_event_process.php' method='post'>
					<input type='hidden' value='$event_id' name='event_id'/>
					<select name='numberOfTickets'>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
					</select>
					<input type='submit' value='Boka'/>
			</form>
	    	";

	    	
	    }
	?>
	<head>
		<title>Uppdatera event</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<?php
		include 'menu.php';
		print ("<div class='container'");
        print $event_info;
        print $booking_form;
        print ("</div>");
    ?>

	
	</body>
</html>