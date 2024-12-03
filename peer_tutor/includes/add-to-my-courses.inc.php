<?php

if(isset($_POST['add_to_my_courses'])) {
    $subject = $_POST['subject'];
    $subject_child = $_POST['subject_child'];
    $course_name = $_POST['course_name'];

    if($_POST['add_to_my_courses'] == 'true') {
        # checkbox checked
    } else {
        # checkbox unchecked
    }

    echo $subject . "<br>";
    echo $subject_child . "<br>";
    echo $course_name . "<br>";
}