<?php

session_start();

require "connection.inc.php";
require "functions.inc.php";

# check if has available times
$availability = getAvailability($conn, $_SESSION['user_id']);

if(empty($availability)) {
    header("location: ../course-page.php?coursename=" . $_GET['coursename'] . "&error=notavailable");
    exit();
}

$tutor_name = $_POST["pick_tutor"];
$tutor_first_name = explode(" ", $tutor_name)[0];
$tutor_last_name = explode(" ", $tutor_name)[1];

$student_id = $_SESSION['user_id'];
$tutor_id = getUserId($conn, $tutor_first_name, $tutor_last_name);
$course_id = getCourseId($conn, $_GET['coursename']);
$description = $_POST["description"];
$accepted = "false";

createStudent($conn, $student_id, $tutor_id, $course_id, $description, $accepted, $_GET['coursename']);