<?php

session_start();

require "connection.inc.php";
require "functions.inc.php";

if(isset($_POST['edit_profile_submit'])) {
    $user_id = $_SESSION['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $cohort = $_POST['user_cohort'];
    $meeting_preference = $_POST['user_meeting_preference'];

    $first_initial_first_name = $first_name[0]; # first initial of frist name
    $start_index = strpos($email, ".") + 1; # start index of graduating year, taken from email, after the first period
    $end_index = strpos($email, "@"); # end index of graduating year, taken from email, before the first @ symbol
    $graduating_year = substr($email, $start_index, $end_index - $start_index); # users graduating year, taken from email, the substring between the (.) and (@) symbols
    $username = strtolower($first_initial_first_name . $last_name . "." . $graduating_year); # username is the (first initial of first name) + (last name) + (.) + (graduating year)

    updateProfile($conn, $user_id, $first_name, $last_name, $username, $email, $cohort, $meeting_preference);
}