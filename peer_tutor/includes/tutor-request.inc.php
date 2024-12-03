<?php

session_start();

require "functions.inc.php";
require "connection.inc.php";

# send email to teacher

# create tutor in table with verified = false
if(isset($_POST['submit-tutor-request'])) {

    $user_id = $_SESSION['user_id'];
    $course_name = $_GET['coursename'];
    $course_id = getCourseId($conn, $course_name);
    $description = $_POST['description'];
    $verified = 'true';

    createNonVerifiedTutor($conn, $user_id, $course_name, $course_id, $description, $verified);

} else {
    header("location: ../course-page.php");
    exit();
}