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

	    //$bookings = "<input id='bookings' type='button' value='Se mina bokningar' onclick='ajaxFunction()'/>";

	    //$fav_events = "<p><input id='fav_events' type='button' value='Se mina favoriter' onclick='ajaxFunction()'/></p>";
	?>
	<head>
		<title>Profil</title>
	    <link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<?php
		include 'menu.php';
		print("<div class='container'>");
		print $profile;
		?>
		<form>
			<input type='button' onclick='ajaxFunction("bookings", "<?php print $user_email; ?>")' value='Se mina bokningar'/>
		</form>
	
		<form>
			<input type='button' onclick='ajaxFunction("fav_events")' value='Se mina favoriter'/>
		</form>
		<?php
		print("</div>");
    	?>
		<div id='nav_result'></div>
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
		           ajaxRequest.open("GET", "profile_process.php" + queryString, true);
		           ajaxRequest.send(null); 
		        }
		  </script>
	</body>
</html>