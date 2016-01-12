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

    if($action == 'bookings'){

	    $query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, 
	    		  startdate, starttime, user_email, category_id, category_name,
	    		  booking_id, tickets
	    		  FROM bookings NATURAL JOIN events NATURAL JOIN users NATURAL JOIN categories
	    		  WHERE user_email = '$user_email' AND user_type = 'user'
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
						<input type='hidden' value='$event_id' name='change_booking'/>
						<input type='hidden' value='$booking_id' name='booking_id'/>
						<input class='submit_button' type='submit' value='Ändra bokning'/>
					</form>
					<form action='delete_booking.php' method='post'>
						<input type='hidden' value='$event_id' name='delete_booking'/>
						<input type='hidden' value='$booking_id' name='booking_id'/>
						<input class='submit_button_delete' type='submit' value='Ta bort bokning'/>
					</form>
				</div>
				";

	    } // end while
	    echo $booking_info;
	}

	elseif($action == 'fav_event'){

		$query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, 
	    		  startdate, starttime, user_email, category_id, category_name,
	    		  favorite_id
	    		  FROM favorites NATURAL JOIN events NATURAL JOIN users NATURAL JOIN categories
	    		  WHERE user_email = '$user_email' AND user_type = 'user'
	    		  ";

	    // Execute the query
	    if (($result = mysqli_query($link, $query)) === false) {
	       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
	       exit();
	    }

	    $fav_event_info = '';
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
	        $favorite_id = $line->favorite_id;
	        

	        $event_id = utf8_encode($event_id);
	        $event_name = utf8_encode($event_name);
	        $venue = utf8_encode($venue);
	        $category = utf8_encode($category);
	        $creator = utf8_encode($creator);

	        $fav_event_info .= "
	        	<div class='container'>
		   			<h2>$event_name</h2>
		    		<ul>
						<li>Startdatum: $startdate</li>
						<li>Starttid: $starttime</li>
						<li>Arena: $venue</li>
						<li>Arrangör: $creator</li>
						<li>Kategori: $category</li>
						<li>Totalt Antal Biljetter: $total_tickets</li>
						<li>Antal Tillgängliga Biljetter: $available_tickets</li>
					</ul>
				</div>
				";
			echo $fav_event_info;
		}
	}	

	elseif($action == 'created_events'){

		$query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, 
	    		  startdate, starttime, user_email, user_name, category_id, category_name
	    		  FROM events NATURAL JOIN users NATURAL JOIN categories
	    		  WHERE user_email = '$user_email' AND user_type = 'creator'
	    		  ";

	   	// Execute the query
	    if (($result = mysqli_query($link, $query)) === false) {
	       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
	       exit();
	    }

	    $created_events_info = '';
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
	        $favorite_id = $line->favorite_id;
	        

	        $event_id = utf8_encode($event_id);
	        $event_name = utf8_encode($event_name);
	        $venue = utf8_encode($venue);
	        $category = utf8_encode($category);
	        $creator = utf8_encode($creator);

	        $created_events_info .= "
	        	<div class='container'>
		   			<h2>$event_name</h2>
		    		<ul>
						<li>Startdatum: $startdate</li>
						<li>Starttid: $starttime</li>
						<li>Arena: $venue</li>
						<li>Arrangör: $creator</li>
						<li>Kategori: $category</li>
						<li>Totalt Antal Biljetter: $total_tickets</li>
						<li>Antal Tillgängliga Biljetter: $available_tickets</li>
					</ul>
					<form action='update_event.php' method='post'>
						<input type='hidden' value='$event_id' name='event_id'/>
						<input class='submit_button' type='submit' value='Ändra'/>
					</form>
				</div>
				";	
		}
		echo $created_events_info;
	}
?>	    