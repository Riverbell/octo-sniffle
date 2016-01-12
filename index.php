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
    <!ENTITY amp "&#38;">

    <!ELEMENT bookingSystem (menu, title, events)>
    <!ELEMENT menu (menuItem*)>
    <!ELEMENT menuItem (#PCDATA)>
    <!ATTLIST menuItem link CDATA #REQUIRED>

    <!ELEMENT title (#PCDATA)>

    <!ELEMENT events (event*)>
    <!ELEMENT event (name, startdate, starttime, venue, creator, category, total_tickets, available_tickets)>

    <!ATTLIST event id CDATA #REQUIRED
    edit CDATA #REQUIRED
    book CDATA #REQUIRED
    favorites CDATA #REQUIRED>

    <!ELEMENT name (#PCDATA)>
    <!ELEMENT startdate (#PCDATA)>
    <!ELEMENT starttime (#PCDATA)>
    <!ELEMENT venue (#PCDATA)>
    <!ELEMENT creator (#PCDATA)>
    <!ELEMENT category (#PCDATA)>
    <!ELEMENT total-tickets (#PCDATA)>
    <!ELEMENT available-tickets (#PCDATA)>
]>

<?php
    //http://xml.csc.kth.se/~emmabac/DM2517/project/start.php
    // Connect using host, username, password and databasename
    $link = mysqli_connect('localhost', 'emmabac', 'emmabac-xmlpub13', 'emmabac');

    // Check connection
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    // FAVORITES ==============================================
    //check fav events
    if(isset($_SESSION['name']) and $_SESSION['user_type'] == 'user') {
        $user_email = $_SESSION['name'];
        
        $query = "SELECT event_id FROM favorites WHERE user_email = '$user_email'";

        // Execute the query
        if (($result = mysqli_query($link, $query)) === false) {
           printf("Query failed: %s<br />\n%s", $query, mysqli_error($link));
           exit();
        }

        $fav_events = array();
        $i = 0;
        while($row = $result->fetch_object()) {
            $fav_event = $row->event_id;
            $fav_events[$i] = $fav_event;
            $i = $i + 1;
        }
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
                //if the logged in user already has favorited this event
                if (in_array("$event_id", $fav_events)) {
                    $event_tag .= "<event id='$event_id' edit='no' book='ok' favorites='ok_fav'>
                        <name>$event_name</name>
                        <startdate>$startdate</startdate>
                        <starttime>$starttime</starttime>
                        <venue>$venue</venue>
                        <creator>$creator</creator>
                        <category>$category</category>
                        <total_tickets>$total_tickets</total_tickets>
                        <available_tickets>$available_tickets</available_tickets>
                    </event>";
                //if the logged in user has NOT favorited this event
                } else {
                    $event_tag .= "<event id='$event_id' edit='no' book='ok' favorites='ok_nofav'>
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
    <menuItem link="profile.php">Profil</menuItem>
    <?php
        if(isset($_SESSION['name'])) {
            if($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'creator') {
                print "<menuItem link='create_event.php'>Skapa event</menuItem>";
            }
        }
    ?>

    <?php

        if(isset($_SESSION['name'])) {
            if($_SESSION['user_type'] == 'admin') {
                print "<menuItem link='all_users.php'>Alla användare</menuItem>";
            } 
        }
    ?>
    <?php 
        print $menuItem;
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



