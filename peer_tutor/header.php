<?php 
    if(session_id() == '' || !isset($_SESSION)) {
        session_start(); # only start session if session does not exist
    }
    // require "includes/connection.inc.php";
    // require "includes/functions.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peer Tutor</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- include JQuery -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
        <div class="header-logos">
            <img src="images/crest-white.png" class="portledge_logo">
            <img src="images/peer_tutor_logo.png" class="portledge_logo">
            <a href="profile.php" class="profile-info-header"> <?php
                echo "<p class='user-username-header'>" . $_SESSION['user_username'] . "</p>";
                echo "<p class='user-full-name-header'>" . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] . "</p>";  
            ?> </a>
        </div>

        <nav>
            <ul class="main-nav-ul" style="
                padding-left: 0px;
                margin-top: 0px;
                width: 100%;
                margin-bottom: 0px;">
                <li class="main-nav-ul-li"><a class="main-nav-ul-li-a" href="subjects.php">Subjects</a></li>
                <li class="main-nav-ul-li"><a class="main-nav-ul-li-a" href="meeting.php">Meetings</a></li>
                <li class="main-nav-ul-li"><a class="main-nav-ul-li-a" href="profile.php">Profile  </a></li>
                <li class="main-nav-ul-li"><a class="main-nav-ul-li-a" href="includes/logout.inc.php">Log Out</a></li>
            </ul>
        </nav>
</body>
</html>