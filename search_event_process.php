<?php
	$event_name=$_GET['event_name'];
	//print($event_name);
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
				</div>
				";
	}

	echo $event_info;
?>
<!--
<html>
<head>
	<title>Hittat event!</title>
	<link rel="stylesheet" type="text/css" href="/~mawestl/DM2517/project/style.css"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	
</head>
<body>
	<?php
	//include 'menu.php';
	//print($event_info);
?>
</body>
</html>
-->