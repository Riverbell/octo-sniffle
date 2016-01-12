<?php
    session_start();
    header('Content-type: text/html; charset=utf-8');
?>
<html>
<head>
    <title>Success!</title>
    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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


    $event_name = utf8_decode($_POST[input_name]);
    $venue = utf8_decode($_POST[input_venue]);
    $category = utf8_decode($_POST[input_categoryID]);

    //$event_name = $_POST[input_name];
    //$venue = $_POST[input_venue];
    //$category = $_POST[input_categoryID];


    $query = "UPDATE events
    SET event_name = '$event_name', total_tickets = '$_POST[input_totalTickets]', 
    available_tickets = '$_POST[input_availableTickets]',
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
        print "<p>Success!</p>
            <a href='/~emmabac/DM2517/project/index.php'>Gå tillbaka</a>";
    }
?>
</body>

</html>