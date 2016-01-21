<?php
        session_start();
        if(!isset($_SESSION['name']))
        {
            header("location: login.php");
        }
        $user_email = $_SESSION[name];
        $user_name = $_SESSION[user_name];
        $user_type = $_SESSION[user_type];
?>
<html>
	<?php
		

	    $user_name = utf8_encode($user_name);

	    $profile = "<h2>Hej $user_name!</h2>
	    			<h3>Här är din profil</h3>
	    			<p>Medlemstyp: $user_type</p>
	    			";

	    if($usertype='user'){

	    }

	    $bookings = "<input class='submit_button' type='button' value='Se mina bokningar' onclick='ajaxFunction(\"bookings\", \"$user_email\")'/>";

	    $fav_events = "<p><input class='submit_button' type='button' value='Se mina favoriter' onclick='ajaxFunction(\"fav_events\", \"$user_email\")'/></p>";

	    $created_events = "<input class='submit_button' type='button' value='Se skapade event' onclick='ajaxFunction(\"created_events\", \"$user_email\")'/>";

	?>
	<head>
		<title>Profil</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width" />
		<script language = "javascript" type = "text/javascript">
		        //Browser Support Code

		        function ajaxFunction(action, user_email){
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
		              if(ajaxRequest.readyState== 4){
		                 var ajaxDisplay = document.getElementById('nav_result');
		                 ajaxDisplay.innerHTML = ajaxRequest.responseText;
		              }
		           }
		           
		           // Now get the value from user and pass it to
		           // server script.

		           
		           var queryString = "?user_email=" + user_email + "&action=" + action;
		           console.log(queryString);
		           ajaxRequest.open("GET", "profile_process.php" + queryString, true);
		           ajaxRequest.send(null); 
		        }
		  </script>
	</head>
	<body>
		<?php
		include 'menu.php';
		print("<div class='container'>");
		print $profile;
		if($user_type == 'user'){
			print $bookings;
			print $fav_events;
		}

		else if($user_type == 'creator'){
			print $created_events;
		}
		print("</div>");
    	?>
		<div id='nav_result'></div>
	</body>
</html>