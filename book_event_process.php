<?php
        session_start();
        if(!isset($_SESSION['name'])) {
            header("location: login.php");
        }
?>
<html>
<head>
    <title>Success!</title>
    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
</head>
<body>
<?php
	//Connecting to sql db.
	$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

    // Check connection
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    //creating variables
    $booker_email = $_SESSION[name];
    $event_id = $_POST[event_id];
    $numberOfTickets = $_POST[numberOfTickets];

    //checking the number of available tickets in chosen event
    $query = "SELECT available_tickets
              FROM events
              WHERE event_id = $event_id";
    // Execute the query
    if (($result = mysqli_query($link, $query)) === false) {
       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
       exit();
    }
    $line = $result->fetch_object();
    $available_tickets = $line->available_tickets;

    //check if there's room
    if ( $numberOfTickets > $available_tickets) {
        print utf8_decode("Det finns inte så många platser!");
    } else {
        //create the booking ==============================
        $query ="INSERT INTO bookings (user_id, event_id, tickets) VALUES 
        ('$booker_email', '$event_id', '$numberOfTickets')
        ";

    	// Execute the query
        if (($result = mysqli_query($link, $query)) === false) {
           printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
           exit();
        }
        else {
            print utf8_decode("<p>Bokning klar!</p>
                <a href='/~emmabac/DM2517/project/index.php'>Gå tillbaka</a>");
        }

        //update number of available tickets ================
        $available_tickets = $available_tickets - $numberOfTickets;
        $query = "UPDATE events
                  SET available_tickets = $available_tickets
                  WHERE event_id = $event_id";
        // Execute the query
        if (($result = mysqli_query($link, $query)) === false) {
           printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
           exit();
        }
        else {
            print utf8_decode("<p>Success!</p>
                <a href='/~emmabac/DM2517/project/index.php'>Gå tillbaka</a>");
        }
    }
?>
</body>

</html>