<?php

session_start();

if(isset($_POST['sign_up_submit'])) { # if the user got to this page by clicking the sign up submit button
    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    require 'connection.inc.php'; # get access to database
    require 'functions.inc.php'; # get access to functions

    # error handling

    if(invalidEmail($email) !== false) { # if email is not valid
        header("location: ../sign-up.php?error=invalidemail"); # send user back to sign up page with a $_GET variable 'error' set to 'invalidemail'
        exit();
    }

    if($password !== $password_repeat) {
        header("location: ../sign-up.php?error=passworddontmatch"); # send user back to sign up page with a $_GET variable 'error' set to 'invalidemail'
        exit();
    }

    $first_initial_first_name = $first_name[0]; # first initial of frist name
    $start_index = strpos($email, ".") + 1; # start index of graduating year, taken from email, after the first period
    $end_index = strpos($email, "@"); # end index of graduating year, taken from email, before the first @ symbol
    $graduating_year = substr($email, $start_index, $end_index - $start_index); # users graduating year, taken from email, the substring between the (.) and (@) symbols
    $username = strtolower($first_initial_first_name . $last_name . "." . $graduating_year); # username is the (first initial of first name) + (last name) + (.) + (graduating year)

    if(usernameExists($conn, $username, $email)) {
        header("location: ../sign-up.php?error=userexists"); # send user back to sign up page with a $_GET variable 'error' set to 'userexists'
        exit();
    }

    createUser($conn, $first_name, $last_name, $username, $email, $password); # create user

} else {
    
    header("location: ../sign-up.php?error=invalidpageload");
    exit();

}


