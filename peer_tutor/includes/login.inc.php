<?php

if(isset($_POST['login_submit'])) { # if the user got to this page by clicking the sign up submit button
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    require 'connection.inc.php'; # get access to database
    require 'functions.inc.php'; # get access to functions

    loginUser($conn, $username, $password);
    
} else {
    header("location: ../login.php");
    exit();
}

