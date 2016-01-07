<div class="menu">
    <h2>Meny</h2>
    <ul>
        
        <li><a href="index.php">Startsida</a></li>
    <?php
        if(!isset($_SESSION['name'])) {
            $loginItem = "<li><a href='login.php'>Logga in</a></li>";
        } else {
            $loginItem = "<li><a href='logout.php'>Logga ut</a></li>";

        }
        if(isset($_SESSION['name'])) {
            if($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'creator') {
                print utf8_encode("<li><a href='create_event.php'>Skapa event</a></li>");
            }
        }
    ?>
    <li><a href="profile.php">Profil</a></li>
    <?php
        if(isset($_SESSION['name'])) {
            if($_SESSION['user_type'] == 'admin') {
                print "<li><a href='all_users.php'>Alla användare</a></li>";
            } 
        }
    ?>
    <?php 
        print utf8_encode($loginItem);
    ?>
    </ul>

</div>

