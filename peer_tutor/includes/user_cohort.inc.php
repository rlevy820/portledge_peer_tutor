<?php

session_start();

if(isset($_POST['select_cohort_submit'])) {

    $cohort = $_POST['user_cohort'];

    require 'connection.inc.php'; # get access to database
    require 'functions.inc.php'; # get access to functions

    createUserCohort($conn, $cohort, $_SESSION['user_id']);

} else {

    header("location: ../sign-up.php?error=invalidpageload");
    exit();
}