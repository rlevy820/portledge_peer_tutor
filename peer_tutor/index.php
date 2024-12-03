<?php

# @author: Ryan Levy
# @version: December 23, 2020
# @title: peer_tutor

session_start();

if(isset($_SESSION['user_id'])) {
    header("location: subjects.php");
    exit();
} else {
    header("location: login.php"); # send user to login page
    exit();
}