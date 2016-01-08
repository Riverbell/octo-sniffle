<?php
	$event_name=$_POST[event_name];
	//create connection to db to check if event_name exists
	$link = mysqli_connect('localhost', 'mawestl', 'mawestl-xmlpub13', 'mawestl');
	$query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, startdate, starttime, user_email, category_id, user_name, category_name
            FROM events NATURAL JOIN users
            NATURAL JOIN categories
	    	WHERE event_name LIKE '%$event_name%'";
	//execute query
	$error_message = "Eventet du sökte efter finns inte.";
	if (($result = mysqli_query($link, $query)) === false) {
		print($error_message);
	}
	$event_tag = '';
	while ($line = $result->fetch_object()) {
		//Store results from each row in variables
		$event_id = $line->event_id;
        $event_name = $line->event_name;
        $total_tickets = $line->total_tickets;
        $available_tickets = $line->available_tickets;
        $venue = $line->venue;
        $startdate = $line->startdate;
        $starttime = $line->starttime;
        $category = $line->category_id;
        $creator = $line->user_name;

        $event_info .= "
        		<div class='container'>
	    		<p>Eventnamn: $event_name</p>
				<p>Startdatum: $startdate</p>
				<p>Starttid: $starttime</p>
				<p>Arena: $venue</p>
				<p>Arrangör: $creator</p>
				<p>Kategori: $category</p>
				<p>Totalt Antal Biljetter: $total_tickets</p>
				<p>Antal Tillgängliga Biljetter: $available_tickets</p>
				</div>
				";
	}
?>
<html>
<head>
	<title>Hittat event!</title>
	<link rel="stylesheet" type="text/css" href="/~mawestl/DM2517/project/style.css"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<?php
	include 'menu.php';
	print($event_info);
?>
</body>
</html>