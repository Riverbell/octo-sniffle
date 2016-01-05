<?php
        session_start();
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


    $query = "UPDATE events
    SET event_name = '$_POST[input_name]', total_tickets = '$_POST[input_totalTickets]', 
    available_tickets = '$_POST[input_availableTickets]',
    venue = '$_POST[input_venue]', startdate = '$_POST[input_startdate]', 
    starttime = '$_POST[input_starttime]', user_email = '$_POST[input_creatorEmail]', 
    category_id = '$_POST[input_categoryID]'
    WHERE event_id = $_POST[event_id]
    ";

	// Execute the query
    if (($result = mysqli_query($link, $query)) === false) {
       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
       exit();
    }
    else {
        print utf8_decode("<p>Success!</p>
            <a href='/~emmabac/DM2517/project/index.php'>Gå tillbaka</a>");
    }
?>
</body>

</html>