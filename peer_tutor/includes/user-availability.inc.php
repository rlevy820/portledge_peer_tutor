<?php

session_start();

if(isset($_POST['set_availability_submit'])) { 

    require 'connection.inc.php'; # get access to database
    require 'functions.inc.php'; # get access to functions

    $availability = array();

    # if the week day times array is empty, set the start and end variables and create a row in the users_available table in the database
    if(!empty($_POST['start-time-monday'])) {
        $start_times_monday = $_POST['start-time-monday'];
        $end_times_monday = $_POST['end-time-monday'];

        $monday_times = array();
        for($i = 0; $i < count($start_times_monday); $i++) {
            array_push($monday_times, $start_times_monday[$i]);
            array_push($monday_times, $end_times_monday[$i]);
            array_push($monday_times, "Monday");

            array_push($availability, $monday_times);
        }
    }
    if(!empty($_POST['start-time-tuesday'])) {
        $start_times_tuesday = $_POST['start-time-tuesday'];
        $end_times_tuesday = $_POST['end-time-tuesday'];

        $tuesday_times = array();
        for($i = 0; $i < count($start_times_tuesday); $i++) {
            array_push($tuesday_times, $start_times_tuesday[$i]);
            array_push($tuesday_times, $end_times_tuesday[$i]);
            array_push($tuesday_times, "Tuesday");

            array_push($availability, $tuesday_times);
        } 
    }
    if(!empty($_POST['start-time-wednesday'])) {
        $start_times_wednesday = $_POST['start-time-wednesday'];
        $end_times_wednesday = $_POST['end-time-wednesday'];

        $wednesday_times = array();
        for($i = 0; $i < count($start_times_wednesday); $i++) {
            array_push($wednesday_times, $start_times_wednesday[$i]);
            array_push($wednesday_times, $end_times_wednesday[$i]);
            array_push($wednesday_times, "Wednesday");

            array_push($availability, $wednesday_times);
        }
    }
    if(!empty($_POST['start-time-thursday'])) {
        $start_times_thursday = $_POST['start-time-thursday'];
        $end_times_thursday = $_POST['end-time-thursday'];

        $thursday_times = array();
        for($i = 0; $i < count($start_times_thursday); $i++) {
            array_push($thursday_times, $start_times_thursday[$i]);
            array_push($thursday_times, $end_times_thursday[$i]);
            array_push($thursday_times, "Thursday");

            array_push($availability, $thursday_times);
        }
    }
    if(!empty($_POST['start-time-friday'])) {
        $start_times_friday = $_POST['start-time-friday'];
        $end_times_friday = $_POST['end-time-friday'];

        $friday_times = array();
        for($i = 0; $i < count($start_times_friday); $i++) {
            array_push($friday_times, $start_times_friday[$i]);
            array_push($friday_times, $end_times_friday[$i]);
            array_push($friday_times, "Friday");

            array_push($availability, $friday_times);
        }
    }

    if(!empty($availability)) {
        createAvailablity($conn, $_SESSION['user_id'], $availability);
        // foreach($availability as $time_slot) {
        //     createAvailablity($conn, $_SESSION['user_id'], $time_slot[0], $time_slot[1], $time_slot[2]); # time_slot[0] = start_time, time_start[1] = end time, time_start[2] = day of the week
        // }
    }

    header("location: ../index.php");
    exit();

} else if(isset($_POST['add_time_submit'])) {

    require 'connection.inc.php'; # get access to database
    require 'functions.inc.php'; # get access to functions

    $day = $_POST["day"];
    $start_time = $_POST['start-time'];
    $end_time = $_POST['end-time'];

    addAvailability($conn, $_SESSION["user_id"], $day, $start_time, $end_time);

    header("location: ../user-availability.php");
    exit();

} else if(isset($_POST['edit_add_availability_submit'])) { # if editing availablility

    require 'connection.inc.php'; # get access to database
    require 'functions.inc.php'; # get access to functions

    # clear

    $availability = array();

    # if the week day times array is empty, set the start and end variables and create a row in the users_available table in the database
    if(!empty($_POST['start-time-monday'])) {
        $start_times_monday = $_POST['start-time-monday'];
        $end_times_monday = $_POST['end-time-monday'];

        $monday_times = array();
        for($i = 0; $i < count($start_times_monday); $i++) {
            array_push($monday_times, $start_times_monday[$i]);
            array_push($monday_times, $end_times_monday[$i]);
            array_push($monday_times, "Monday");

            array_push($availability, $monday_times);
        }
    }
    if(!empty($_POST['start-time-tuesday'])) {
        $start_times_tuesday = $_POST['start-time-tuesday'];
        $end_times_tuesday = $_POST['end-time-tuesday'];

        $tuesday_times = array();
        for($i = 0; $i < count($start_times_tuesday); $i++) {
            array_push($tuesday_times, $start_times_tuesday[$i]);
            array_push($tuesday_times, $end_times_tuesday[$i]);
            array_push($tuesday_times, "Tuesday");

            array_push($availability, $tuesday_times);
        } 
    }
    if(!empty($_POST['start-time-wednesday'])) {
        $start_times_wednesday = $_POST['start-time-wednesday'];
        $end_times_wednesday = $_POST['end-time-wednesday'];

        $wednesday_times = array();
        for($i = 0; $i < count($start_times_wednesday); $i++) {
            array_push($wednesday_times, $start_times_wednesday[$i]);
            array_push($wednesday_times, $end_times_wednesday[$i]);
            array_push($wednesday_times, "Wednesday");

            array_push($availability, $wednesday_times);
        }
    }
    if(!empty($_POST['start-time-thursday'])) {
        $start_times_thursday = $_POST['start-time-thursday'];
        $end_times_thursday = $_POST['end-time-thursday'];

        $thursday_times = array();
        for($i = 0; $i < count($start_times_thursday); $i++) {
            array_push($thursday_times, $start_times_thursday[$i]);
            array_push($thursday_times, $end_times_thursday[$i]);
            array_push($thursday_times, "Thursday");

            array_push($availability, $thursday_times);
        }
    }
    if(!empty($_POST['start-time-friday'])) {
        $start_times_friday = $_POST['start-time-friday'];
        $end_times_friday = $_POST['end-time-friday'];

        $friday_times = array();
        for($i = 0; $i < count($start_times_friday); $i++) {
            array_push($friday_times, $start_times_friday[$i]);
            array_push($friday_times, $end_times_friday[$i]);
            array_push($friday_times, "Friday");

            array_push($availability, $friday_times);
        }
    }

    if(!empty($availability)) {
        createAvailablity($conn, $_SESSION['user_id'], $availability);
        // foreach($availability as $time_slot) {
        //     createAvailablity($conn, $_SESSION['user_id'], $time_slot[0], $time_slot[1], $time_slot[2]); # time_slot[0] = start_time, time_start[1] = end time, time_start[2] = day of the week
        // }
    }
    
} else {
    header("location: ../sign-up.php?error=invalidpageload");
    exit();
}
