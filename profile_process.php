<?php
	$action=$_GET['action'];
	$user_email=$_GET['user_email'];



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
    		  WHERE user_email = '$user_email'
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
        $numberOfTickets = $line->tickets;

        $event_id = utf8_encode($event_id);
        $event_name = utf8_encode($event_name);
        $venue = utf8_encode($venue);
        $category = utf8_encode($category);
        $creator = utf8_encode($creator);

    
   		$booking_info .= "
   			<div class='container'>
	   			<h4>Bokningsnummer: $booking_id</h4>
	   			<p>Antal biljetter: $numberOfTickets</p>
	    		<p>Eventnamn: $event_name</p>
				<p>Startdatum: $startdate</p>
				<p>Starttid: $starttime</p>
				<p>Arena: $venue</p>
				<p>Arrangör: $creator</p>
				<p>Kategori: $category</p>
				<p>Lediga platser: $available_tickets av $total_tickets</p>
				<form action='update_booking.php' method='post'>
					<input type='hidden' value='{$event_id}' name='change_booking'/>
					<input type='hidden' value='{$booking_id}' name='booking_id'/>
					<input type='submit' value='Ändra bokning'/>
				</form>
				<form action='delete_booking.php' method='post'>
					<input type='hidden' value='{$event_id}' name='delete_booking'/>
					<input type='hidden' value='{$booking_id}' name='booking_id'/>
					<input type='submit' value='Ta bort bokning'/>
				</form>
			</div>
			";

    } // end while
    echo $booking_info;
?>


	    