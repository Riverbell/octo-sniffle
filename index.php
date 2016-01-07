<?php include 'prefix.php';?>
<?php
        session_start();
?>
<?xml version="1.0" ?>
<!DOCTYPE bookingSystem [
    <!ENTITY Aring "&#197;">
    <!ENTITY aring "&#229;">
    <!ENTITY Auml "&#196;">
    <!ENTITY auml "&#228;">
    <!ENTITY Ouml "&#214;">
    <!ENTITY ouml "&#246;">
]>

<?php
    //http://xml.csc.kth.se/~mawestl/DM2517/project/start.php
    // Connect using host, username, password and databasename
    $link = mysqli_connect('localhost', 'mawestl', 'mawestl-xmlpub13', 'mawestl');

    // Check connection
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }


// EVENTS ========================================================
    $query = "SELECT event_id, event_name, total_tickets, available_tickets, venue, startdate, starttime, user_email, category_id, user_name, category_name
            FROM events NATURAL JOIN users
            NATURAL JOIN categories
            ORDER BY startdate, starttime";

    // Execute the query
    if (($result = mysqli_query($link, $query)) === false) {
       printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
       exit();
    }

    $event_tag = '';
    while ($line = $result->fetch_object()) {
        // Store results from each row in variables
        $event_id = $line->event_id;
        $event_name = $line->event_name;
        $total_tickets = $line->total_tickets;
        $available_tickets = $line->available_tickets;
        $venue = $line->venue;
        $startdate = $line->startdate;
        $starttime = $line->starttime;
        $creator = $line->user_name;
        $category = $line->category_name;
        $creator_id = $line->user_email;
    
        //if there is no user logged in
        if(!isset($_SESSION['name'])) {
            $event_tag .= "<event id='$event_id' edit='no' book='no' favorites='no'>
                <name>$event_name</name>
                <startdate>$startdate</startdate>
                <starttime>$starttime</starttime>
                <venue>$venue</venue>
                <creator>$creator</creator>
                <category>$category</category>
                <total_tickets>$total_tickets</total_tickets>
                <available_tickets>$available_tickets</available_tickets>
            </event>";
        } else {
            //if the logged in user is the creator of this event or admin
            if ($creator_id==$_SESSION['name'] || $_SESSION['user_type'] == 'admin') {
                $event_tag .= "<event id='$event_id' edit='ok' book='no' favorites='no'>
                    <name>$event_name</name>
                    <startdate>$startdate</startdate>
                    <starttime>$starttime</starttime>
                    <venue>$venue</venue>
                    <creator>$creator</creator>
                    <category>$category</category>
                    <total_tickets>$total_tickets</total_tickets>
                    <available_tickets>$available_tickets</available_tickets>
                </event>";
            } elseif ( $_SESSION['user_type'] == 'user' ) {
                $event_tag .= "<event id='$event_id' edit='no' book='ok' favorites='ok'>
                <name>$event_name</name>
                <startdate>$startdate</startdate>
                <starttime>$starttime</starttime>
                <venue>$venue</venue>
                <creator>$creator</creator>
                <category>$category</category>
                <total_tickets>$total_tickets</total_tickets>
                <available_tickets>$available_tickets</available_tickets>
            </event>";
            } elseif ( $_SESSION['user_type'] == 'creator' ) {
                $event_tag .= "<event id='$event_id' edit='no' book='no' favorites='no'>
                <name>$event_name</name>
                <startdate>$startdate</startdate>
                <starttime>$starttime</starttime>
                <venue>$venue</venue>
                <creator>$creator</creator>
                <category>$category</category>
                <total_tickets>$total_tickets</total_tickets>
                <available_tickets>$available_tickets</available_tickets>
            </event>";
            }
    } 
    } //end while

    // Free result and just in case encode result to utf8 before returning
    mysqli_free_result($result);

    if(!isset($_SESSION['name'])) {
        $menuItem = "<menuItem link='login.php'>Logga in</menuItem>";
    } else {
        $menuItem = "<menuItem link='logout.php'>Logga ut</menuItem>";

    }
        
?>

<bookingSystem>
<menu>
    <menuItem link="index.php">Startsida</menuItem>
    <?php
        if(isset($_SESSION['name'])) {
            if($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'creator') {
                print utf8_encode("<menuItem link='create_event.php'>Skapa event</menuItem>");
            }
        }
    ?>
    <menuItem link="search_event.php">Sök Event</menuItem>
    <menuItem link="profile.php">Profil</menuItem>
    <?php 
        print utf8_encode($menuItem);
    ?>
</menu>
<title>Coola bokningar!</title>
<events>
    <?php
        print utf8_encode($event_tag);
    ?>
</events>


</bookingSystem>

<?php include 'postfix.php';?>



