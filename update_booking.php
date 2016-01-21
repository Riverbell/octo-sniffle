<?php
        session_start();
        if(!isset($_SESSION['name'])) {
			header("location: login.php");
		}
?>
<html>
	<?php
		$booking_id =$_POST['booking_id'];

		//Connecting to sql db.
		$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

	    // Check connection
	    if (mysqli_connect_errno()) {
	        printf("Connect failed: %s\n", mysqli_connect_error());
	        exit();
	    }

	    $query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, 
	    		  startdate, starttime, user_email, category_id, user_name, category_name,
	    		  booking_id, tickets
	    		  FROM bookings NATURAL JOIN events NATURAL JOIN users NATURAL JOIN categories
	    		  WHERE booking_id = '$booking_id'
	    ";

		// Execute the query
	    if (($result = mysqli_query($link, $query)) === false) {
	       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
	       exit();
	    }

	    $booking_info = '';
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
	        $creator = $line->user_name;
	        $booking_id = $line->booking_id;
	        $tickets = $line->tickets;

	    
	   		$booking_info .= "
		   			<h4>Bokningsnummer: $booking_id</h4>
		   			<p>Antal biljetter: $tickets</p>
		    		<p>Eventnamn: $event_name</p>
					<p>Startdatum: $startdate</p>
					<p>Starttid: $starttime</p>
					<p>Arena: $venue</p>
					<p>Arrangör: $creator</p>
					<p>Kategori: $category</p>
					<p>Lediga platser: $available_tickets av $total_tickets</p>
					
					<p>Ändra antal biljetter</p>
					<form action='' method='post'>
						<input type='hidden' value='$booking_id' name='booking_id'/>
						<input type='hidden' value='$tickets' name='oldTickets'/>
						<input type='hidden' value='$event_id' name='event_id'/>
						<input type='hidden' value='$available_tickets' name='available_tickets'/>
						<select name='newTickets'>
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
							<option value='6'>6</option>
							<option value='7'>7</option>
							<option value='8'>8</option>
						</select>
						<input type='submit' value='Ok'/>
					</form>
		
				";

	   
	   
	    }

	    if(isset($_POST['booking_id'], $_POST['oldTickets'], $_POST['event_id'], $_POST['newTickets'], $_POST['available_tickets'])) {
	    	$booking_id = $_POST['booking_id'];
	    	$oldTickets = $_POST['oldTickets'];
	    	$event_id = $_POST['event_id'];
	    	$newTickets = $_POST['newTickets'];
	    	$available_tickets = $_POST['available_tickets'];
	    	if($newTickets < $oldTickets) {
	    		$query = "UPDATE bookings
	    				  SET tickets = $newTickets
	    				  WHERE booking_id = $booking_id";
	    		// Execute the query
			    if (($result = mysqli_query($link, $query)) === false) {
			       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
			       exit();
			    }
			    $ticketDiff = $oldTickets - $newTickets;
			    $query = "UPDATE events
			    		  SET available_tickets = available_tickets + $ticketDiff
			    		  WHERE event_id = $event_id";
	    		// Execute the query
			    if (($result = mysqli_query($link, $query)) === false) {
			       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
			       exit();
			    }
			    $booking_result = "Bokning uppdaterad! <a href='profile.php'>Gå tillbaka</a>";
	    	} else if ( $newTickets > $available_tickets ) {
	    		$booking_result = "Det finns inte så många platser!";
	    	} else if ( $newTickets > $oldTickets and $newTickets < $available_tickets ) {
	    		$query = "UPDATE bookings
	    				  SET tickets = $newTickets
	    				  WHERE booking_id = $booking_id";
	    		// Execute the query
			    if (($result = mysqli_query($link, $query)) === false) {
			       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
			       exit();
			    }
			    $ticketDiff = $newTickets - $oldTickets;
			    $query = "UPDATE events
			    		  SET available_tickets = available_tickets - $ticketDiff
			    		  WHERE event_id = $event_id";
	    		// Execute the query
			    if (($result = mysqli_query($link, $query)) === false) {
			       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
			       exit();
			    }
			    $booking_result = "Bokning uppdaterad! <a href='profile.php'>Gå tillbaka</a>";
	    	}
	    }
	?>
	<head>
		<title>Uppdatera event</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width" />
	</head>
	<body>
		<?php
		include 'menu.php';
        print ("<div class='container'");
        print utf8_decode($booking_info);
        print utf8_decode($booking_result);
        print ("</div>");
    ?>

	
	</body>
</html>