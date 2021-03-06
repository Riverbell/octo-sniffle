<?php
        session_start();
        header('Content-type: text/html; charset=utf-8');
        if(!isset($_SESSION['name']) || $_SESSION['user_type'] == 'user') {
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

	    $query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, startdate, starttime, category_name
	    		  FROM events
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

	        $event_id = utf8_encode($event_id);
	        $event_name = utf8_encode($event_name);
	        $venue = utf8_encode($venue);
	        $category = utf8_encode($category);
	    
	   
	        // Store the result we want by appending strings

	    	$update_form = "<form action='' method='post' accept-charset='utf-8'>
					<input type='hidden' value='$event_id' name='event_id'/>
					<p>Eventnamn:
					<input type='text' name='input_name' value='$event_name'/>
					</p>
					<p>Totalt Antal Biljetter:
					<input type='text' name='input_totalTickets' value='$total_tickets'/>
					</p>
					<p>Arena:
					<input type='text' name='input_venue' value='$venue'/>
					</p>
					<p>Startdatum:
					<input type='text' name='input_startdate' value='$startdate'/>
					</p>
					<p>Starttid:
					<input type='text' name='input_starttime' value='$starttime'/>
					</p>
					<p>Kategori:
					<select name='input_categoryID'>
						<option value='sport'";
						if ($category == 'sport') {
			        			$update_form .= "selected";
			        		}
					$update_form .= ">Sport</option>
						<option value='musik'";
						if ($category == 'musik') {
			        			$update_form .= "selected";
			        		}
					$update_form .= ">Musik</option>
						<option value='teater'";
						if ($category == 'teater') {
			        			$update_form .= "selected";
			        		}
					$update_form .= ">Teater</option>
						<option value='underhållning'";
						if ($category == 'underhållning') {
			        			$update_form .= "selected";
			        		}
					$update_form .= ">Underhållning</option>
						<option value='barn'";
						if ($category == 'barn') {
			        			$update_form .= "selected";
			        		}
					$update_form .= ">Barn</option>
					</select>
					</p>
					<input class='submit_button' type='submit' value='Spara'/>
			</form>
	    	";

	    } // end while

	    
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
		print "<div class='container'>";
        print $update_form;

        if(isset($_POST['input_name'], $_POST['input_totalTickets'], $_POST['input_availableTickets'], $_POST['input_venue'], $_POST['input_startdate'], $_POST['input_starttime'], $_POST['input_categoryID'])) {
	    	$event_name = utf8_decode($_POST[input_name]);
		    $venue = utf8_decode($_POST[input_venue]);
		    $category = utf8_decode($_POST[input_categoryID]);

		    //$event_name = $_POST[input_name];
		    //$venue = $_POST[input_venue];
		    //$category = $_POST[input_categoryID];


		    $query = "UPDATE events
		    SET event_name = '$event_name', total_tickets = '$_POST[input_totalTickets]', 
		    venue = '$venue', startdate = '$_POST[input_startdate]', 
		    starttime = '$_POST[input_starttime]', 
		    category_name = '$category'
		    WHERE event_id = $_POST[event_id]
		    ";

			// Execute the query
		    if (($result = mysqli_query($link, $query)) === false) {
		       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
		       exit();
		    }
		    else {
		        print "<p>Event uppdaterat!</p>";
		    }
	    } //end if

        print "</div>";
    ?>

	
	</body>
</html>