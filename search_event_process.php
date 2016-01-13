<?php
	session_start();
	//create connection to db to check if event_name exists
	$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');
	
	// Check connection
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
	
	// FAVORITES ==============================================
    //check fav events
    if(isset($_SESSION['name']) and $_SESSION['user_type'] == 'user') {
        $user_email = $_SESSION['name'];
        
        $query = "SELECT event_id 
        		  FROM favorites 
        		  WHERE user_email = '$user_email';
        		  ";

        // Execute the query
        if (($result = mysqli_query($link, $query)) === false) {
           printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
           exit();
        }

        $fav_events = array();
        $i = 0;
        while($row = $result->fetch_object()) {
            $fav_event = $row->event_id;
            $fav_events[$i] = $fav_event;
            $i = $i + 1;
        }
	    mysqli_free_result($result);
    }


    // EVENTS =================================================
	$search_input=$_GET['search_input'];
	//print($event_name);
	$query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, startdate, starttime, creator_email, category_name, user_name
            FROM events JOIN users ON events.creator_email = users.user_email
	    	WHERE event_name LIKE '%$search_input%' 
	    	OR venue LIKE '%$search_input%'
	    	OR user_name LIKE '%$search_input%'
	    	OR category_name LIKE '%$search_input%'";
	//execute query
	$error_message = "Eventet du sökte efter finns inte.";
	if (($result = mysqli_query($link, $query)) === false) {
		print($error_message);
	}
	

	$event_info = '';
	while ($line = $result->fetch_object()) {
		//Store results from each row in variables
		$event_id = $line->event_id;
        $event_name = $line->event_name;
        $total_tickets = $line->total_tickets;
        $available_tickets = $line->available_tickets;
        $venue = $line->venue;
        $startdate = $line->startdate;
        $starttime = $line->starttime;
        $category = $line->category_name;
        $creator = $line->user_name;

        $event_name = utf8_encode($event_name);
        $venue = utf8_encode($venue);
        $category = utf8_encode($category);
        $creator = utf8_encode($creator);

        $event_info .= "
        		<div class='container'>
	    		<h2>$event_name</h2>
	    		<ul>
				<li>Datum: $startdate kl $starttime</li>
				<li>Arena: $venue</li>
				<li>Arrangör: $creator</li>
				<li>Kategori: $category</li>
				<li>Lediga platser: $available_tickets av $total_tickets</li>
				<ul>
				
				";

		//if there is no user logged in
        if(!isset($_SESSION['name'])) {
            $event_info .= "</div>";
        } else {
            //if the logged in user is the creator of this event or admin
            if ($creator_id==$_SESSION['name'] || $_SESSION['user_type'] == 'admin') {
                $event_info .= "
                	<form action='update_event.php' method='post'>
						<input type='hidden' value='$event_id' name='event_id'/>
						<input class='submit_button' type='submit' value='Ändra'/>
					</form>
					</div>
                	";
            } elseif ( $_SESSION['user_type'] == 'user' ) {
                //if the logged in user already has favorited this event
                if (in_array("$event_id", $fav_events)) {
                    $event_info .= "
                    	<form action='book_event.php' method='post'>
							<input type='hidden' value='$event_id' name='event_id'/>
							<input class='submit_button' type='submit' value='Boka'/>
						</form>

						<form id='fav_$event_id'>
							<input type='hidden' value='$event_id' name='event_id' id='fav_event_$event_id'/>
							<div id='fav_sub_$event_id'>
								<input class='submit_button_delete' type='button' value='Ta bort från favoriter' onclick = \"ajaxFunc_favEvent($event_id, fav_sub_$event_id, 'del')\"/>
							</div>
						</form>

						</div>
                    ";
                //if the logged in user has NOT favorited this event
                } else {
                    $event_info .= "
                    	<form action='book_event.php' method='post'>
							<input type='hidden' value='$event_id' name='event_id'/>
							<input class='submit_button' type='submit' value='Boka'/>
						</form>

                    	<form id='fav_$event_id'>
							<input type='hidden' value='$event_id' name='event_id' id='fav_event_$event_id'/>
							<div id='fav_sub_$event_id'>
								<input class='submit_button' type='button' value='Lägg i favoriter' onclick = \"ajaxFunc_favEvent($event_id, fav_sub_$event_id, 'add')\"/>
							</div>
						</form>

						</div>
                    "; 
                }
            } elseif ( $_SESSION['user_type'] == 'creator' ) {
                $event_info .= "
                	</div> 
                ";
            }
        } 

	} // end while

	echo $event_info;
?>
