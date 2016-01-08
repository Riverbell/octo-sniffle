<html>

	<?php
		//Connecting to db
		$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');
		//Check connection
		if (mysqli_connect_errno()) {
	        printf("Connect failed: %s\n", mysqli_connect_error());
	        exit();
	    }

	    $search_form = "<form action='search_event_process.php' method='post'>
	    				<label>Eventnamn</label>
	    				<input id='name' name='event_name' placeholder='Eventnamn' type='text'/>
	    				<input type='submit' value='Sök'/>";
?>
<head>	  		
	<title>Sök Event</title>
	<link rel="stylesheet" type="text/css" href="/~mawestl/DM2517/project/style.css"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<?php include 'menu.php';
	print("<div class='container'>");
	print("<h2>Sök event</h2>");
	print ($search_form);
	print("</div>")
	?>
</body>
</html>