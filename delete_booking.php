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
	    		  startdate, starttime, user_email, user_name, category_name,
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
	   			<div class='container'>
		   			<h4>Bokningsnummer: $booking_id</h4>
		   			<p>Antal biljetter: $tickets</p>
		    		<p>Eventnamn: $event_name</p>
					<p>Startdatum: $startdate</p>
					<p>Starttid: $starttime</p>
					<p>Arena: $venue</p>
					<p>Arrangör: $creator</p>
					<p>Kategori: $category</p>
					<p>Lediga platser: $available_tickets av $total_tickets</p>
					
					<p>Vill du radera denna bokning?</p>
					<form action='' method='post'>
						<input type='hidden' value='$booking_id' name='booking_id'/>
						<input type='hidden' value='$tickets' name='tickets'/>
						<input type='hidden' value='$event_id' name='event_id'/>
						<input type='radio' name='choice' value='yes' /> Ja
						<input type='radio' name='choice' value='no' /> Nej
						<input type='submit' value='Ok'/>
					</form>
				</div>
				";

	   
	   
	    }

	    if(isset($_POST['booking_id'], $_POST['tickets'], $_POST['choice'])) {
	    	$booking_id = $_POST['booking_id'];
	    	$choice = $_POST['choice'];
	    	$tickets = $_POST['tickets'];
	    	$event_id = $_POST['event_id'];
	    	if($choice == 'yes') {
	    		$query = "DELETE FROM bookings
	    				  WHERE booking_id = $booking_id";
	    		// Execute the query
			    if (($result = mysqli_query($link, $query)) === false) {
			       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
			       exit();
			    }
			    $query = "UPDATE events
			    		  SET available_tickets = available_tickets + $tickets
			    		  WHERE event_id = $event_id";
	    		// Execute the query
			    if (($result = mysqli_query($link, $query)) === false) {
			       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
			       exit();
			    }
			    print utf8_decode("Bokning borttagen! <a href='profile.php'>Gå tillbaka</a>");
	    	} else {
	    		header("location: profile.php");
	    	}
	    }
	?>
	<head>
		<title>Uppdatera event</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
	</head>
	<body>
		<?php
		include 'menu.php';
        print utf8_decode($booking_info);
    ?>

	
	</body>
</html>