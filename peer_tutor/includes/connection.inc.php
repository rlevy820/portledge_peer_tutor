<?php

$servername = 'localhost';
$database_username = 'root';
$database_password = '';
$database_name = 'peer_tutor';

$conn = mysqli_connect($servername, $database_username, $database_password, $database_name); # connect to database with variable $conn

if(!$conn) { # if connection to the database fails
    die("Connection Failed: " . mysqli_connect_error()); # return connection error
}