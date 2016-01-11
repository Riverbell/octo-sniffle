<?php
        session_start();
        if(!isset($_SESSION['name'])) {
			header("location: login.php");
		}
		$action = $_GET[act];
		$event_id = $_GET[event_id];
		
		//Connecting to sql db.
		$link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

		//Check connection
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		if ($action == 'add') {
			$query = "SELECT * FROM favorites 
				WHERE user_email = '$_SESSION[name]' AND event_id = $event_id";
			if (($result = mysqli_query($link, $query)) === false) {
				print utf8_decode($error_message);
				exit();
			}

			/* determine number of rows result set */
	    	$row_count = $result->num_rows;
			if ( $row_count > 0 ) {
				echo "Redan tillagd i favoriter!";
			} else {

				//Insert into favorites table 
				$query = "INSERT INTO favorites(user_email, event_id) VALUES
						('$_SESSION[name]', '$_GET[event_id]')
					";

				//Execute the query
				//$error_message = "Du har redan lagt denna bland dina favoriter. <a href='index.php'> Gå tillbaka </a>";

				if (($result = mysqli_query($link, $query)) === false) {
					print utf8_decode($error_message);
					exit();

				}

				$favorite_result = "<input type='button' value='Ta bort från favoriter' onclick = \"ajaxFunction($event_id, fav_sub_$event_id, 'del')\"/>";
				echo $favorite_result;
			}
		} elseif ( $action == 'del' ) {
			$query = "SELECT * FROM favorites 
				WHERE user_email = '$_SESSION[name]' AND event_id = $event_id";
			if (($result = mysqli_query($link, $query)) === false) {
				print utf8_decode($error_message);
				exit();
			}

			/* determine number of rows result set */
	    	$row_count = $result->num_rows;
			if ( $row_count == 0 ) {
				echo "Finns ingen favorit!";
			} else {

				$query = "DELETE FROM favorites
						WHERE user_email = '$_SESSION[name]' AND
						event_id = $event_id
				";

				//Execute the query
				//$error_message = "Du har redan lagt denna bland dina favoriter. <a href='index.php'> Gå tillbaka </a>";

				if (($result = mysqli_query($link, $query)) === false) {
					print utf8_decode($error_message);
					exit();

				}

				$favorite_result = "<input type='button' value='Lägg i favoriter' onclick = \"ajaxFunction($event_id, fav_sub_$event_id, 'add')\"/>";
				echo $favorite_result;

			}
		}
?>
