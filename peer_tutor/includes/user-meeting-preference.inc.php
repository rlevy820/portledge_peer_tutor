<?php

session_start();

if(isset($_POST['select_meeting_preference_submit'])) {

    $meeting_preference = $_POST['user_meeting_preference'];

    require 'connection.inc.php'; # get access to database
    require 'functions.inc.php'; # get access to functions

    createUserMeetingPreference($conn, $meeting_preference, $_SESSION['user_id']);

} else {

    header("location: ../sign-up.php?error=invalidpageload");
    exit();

}
