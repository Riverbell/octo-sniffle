<html>

	<?php
		//Connecting to db
		$link = mysqli_connect('localhost', 'mawestl', 'mawestl-xmlpub13', 'mawestl');
		//Check connection
		if (mysqli_connect_errno()) {
	        printf("Connect failed: %s\n", mysqli_connect_error());
	        exit();
	    }
?>
<head>	  		
	<title>Sök Event</title>
	<link rel="stylesheet" type="text/css" href="/~mawestl/DM2517/project/style.css"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	
</head>
<body>
	<?php include 'menu.php';
	print("<div class='container'>");
	print("<h2>Sök event</h2>");
	?>
	<form>
		<label>Eventnamn</label>
		<input id='name' name='event_name' placeholder='Eventnamn' type='text' onkeyup = "if (event.keyCode == 13)
                        {ajaxFunction()}"/>
		<input id='butt' type='button' onclick = 'ajaxFunction()' value='Sök' />
	</form>
	<?php
	print("</div>");
	?>
	<div id='search_result'></div>
	<script language = "javascript" type = "text/javascript">
            //Browser Support Code
            function ajaxFunction(){
            	console.log("Hej");
               var ajaxRequest;  // The variable that makes Ajax possible!
               
               try {
                  // Opera 8.0+, Firefox, Safari
                  ajaxRequest = new XMLHttpRequest();
               }
               catch (e) {
                  // Internet Explorer Browsers
                  try {
                     ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
                  }
                  catch (e) {
                     try{
                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                     }
                     catch (e){
                        // Something went wrong
                           alert("Your browser broke!");
                           return false;
                     }
                  }
               }
               
               // Create a function that will receive data 
               // sent from the server and will update
               // div section in the same page.
               
               ajaxRequest.onreadystatechange = function(){
                  if(ajaxRequest.readyState == 4){
                     var ajaxDisplay = document.getElementById('search_result');
                     ajaxDisplay.innerHTML = ajaxRequest.responseText;
                  }
               }
               
               // Now get the value from user and pass it to
               // server script.
               
               var event_name = document.getElementById('name').value;
               var queryString = "?event_name=" + event_name;
               console.log(queryString);
               ajaxRequest.open("GET", "search_event_process.php" + queryString, true);
               ajaxRequest.send(null); 
            }
      </script>
</body>
</html>