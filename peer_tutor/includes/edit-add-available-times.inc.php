<?php

session_start();

require "connection.inc.php";
require "functions.inc.php";

# if avaiable times were made, get them
$availability = getAvailability($conn, $_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- include JQuery -->
    <title>Availability</title>
</head>
<script>
    $(document).ready(function() {
        // $(".time-slot").hide();
        $(".add-new-time-monday").click(function() { // on click of button with class tutor-btn
            $("<div class='time-slot'> <input type='time' name='start-time-monday[]' required></input> to <input type='time' name='end-time-monday[]' required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>").appendTo($(".times-monday")); // name = 'start-time-monday[]' so i can collect all the start times as an array 
        });
        $(".add-new-time-tuesday").click(function() {
            $("<div class='time-slot'> <input type='time' name='start-time-tuesday[]' required></input> to <input type='time' name='end-time-tuesday[]' required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>").appendTo($(".times-tuesday"));
        });
        $(".add-new-time-wednesday").click(function() {
            $("<div class='time-slot'> <input type='time' name='start-time-wednesday[]' required></input> to <input type='time' name='end-time-wednesday[]' required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>").appendTo($(".times-wednesday"));
        });
        $(".add-new-time-thursday").click(function() {
            $("<div class='time-slot'> <input type='time' name='start-time-thursday[]' required></input> to <input type='time' name='end-time-thursday[]' required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>").appendTo($(".times-thursday"));
        });
        $(".add-new-time-friday").click(function() {
            $("<div class='time-slot'> <input type='time' name='start-time-friday[]' required></input> to <input type='time' name='end-time-friday[]' required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>").appendTo($(".times-friday"));
        });
    });
    $(document).on("click", ".remove-time-slot", function() {
        $(this).closest(".time-slot").remove();
    });
</script>

<form action="user-availability.inc.php" method="post">

<p>Add/Remove your availilbilty (your free times) <a href="../profile.php" style="
    font: 12px Arial;
    text-decoration: none;
    background-color: #EEEEEE;
    color: black;
    padding: 3px 7px 3px 7px;
    border-top: 1px solid #CCCCCC;
    border-right: 1px solid #333333;
    border-bottom: 1px solid #333333;
    border-left: 1px solid #CCCCCC;
    border-radius: 2.5px;
    ">Cancel Editing Availability</a> </p>
<p>You can always change this in your profile settings, but you will need to set this before scheduling meetings</p>

<div class="week-days-table">

    <div class="week-column monday">
        <p class="day-of-the-week">Monday</p>
        <div class="times-monday">
            <!-- This is where time slots will be added -->
            <?php

                if(!empty($availability)) { # if there are available times
                    foreach($availability as $time_slot) {
                        $day_of_week = $time_slot[0];
                        $start_time = $time_slot[1];
                        $end_time = $time_slot[2];

                        if($day_of_week == "Monday") {
                            echo "<div class='time-slot'> <input type='time' name='start-time-monday[]' value=" . $start_time . " required></input> to <input type='time' name='end-time-monday[]' value=" . $end_time . " required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>";
                        }
                    }
                }

            ?>
        </div>
        <input type='button' class="add-new-time-monday add-new-time" value='✚'> Add new times</input>
    </div>

    <div class="week-column tuesday">
        <p class="day-of-the-week">Tuesday</p>
        <div class="times-tuesday">
            <!-- This is where time slots will be added -->
            <?php

                if(!empty($availability)) { # if there are available times
                    foreach($availability as $time_slot) {
                        $day_of_week = $time_slot[0];
                        $start_time = $time_slot[1];
                        $end_time = $time_slot[2];

                        if($day_of_week == "Tuesday") {
                            echo "<div class='time-slot'> <input type='time' name='start-time-tuesday[]' value=" . $start_time . " required></input> to <input type='time' name='end-time-tuesday[]' value=" . $end_time . " required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>";
                        }
                    }
                }

            ?>
        </div>
        <input type='button' class="add-new-time-tuesday add-new-time" value='✚'> Add new times</input>
    </div>

    <div class="week-column wednesday">
        <p class="day-of-the-week">Wednesday</p>
        <div class="times-wednesday">
            <!-- This is where time slots will be added -->
            <?php

                if(!empty($availability)) { # if there are available times
                    foreach($availability as $time_slot) {
                        $day_of_week = $time_slot[0];
                        $start_time = $time_slot[1];
                        $end_time = $time_slot[2];

                        if($day_of_week == "Wednesday") {
                            echo "<div class='time-slot'> <input type='time' name='start-time-wednesday[]' value=" . $start_time . " required></input> to <input type='time' name='end-time-wednesday[]' value=" . $end_time . " required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>";
                        }
                    }
                }

            ?>
        </div>
        <input type='button' class="add-new-time-wednesday add-new-time" value='✚'> Add new times</input>
    </div>

    <div class="week-column thursday">
        <p class="day-of-the-week">Thursday</p>
        <div class="times-thursday">
            <!-- This is where time slots will be added -->
            <?php

                if(!empty($availability)) { # if there are available times
                    foreach($availability as $time_slot) {
                        $day_of_week = $time_slot[0];
                        $start_time = $time_slot[1];
                        $end_time = $time_slot[2];

                        if($day_of_week == "Thursday") {
                            echo "<div class='time-slot'> <input type='time' name='start-time-thursday[]' value=" . $start_time . " required></input> to <input type='time' name='end-time-thursday[]' value=" . $end_time . " required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>";
                        }
                    }
                }

            ?>
        </div>
        <input type='button' class="add-new-time-thursday add-new-time" value='✚'> Add new times</input>
    </div>

    <div class="week-column friday">
        <p class="day-of-the-week">Friday</p>
        <div class="times-friday">
            <!-- This is where time slots will be added -->
            <?php

                if(!empty($availability)) { # if there are available times
                    foreach($availability as $time_slot) {
                        $day_of_week = $time_slot[0];
                        $start_time = $time_slot[1];
                        $end_time = $time_slot[2];

                        if($day_of_week == "Friday") {
                            echo "<div class='time-slot'> <input type='time' name='start-time-friday[]' value=" . $start_time . " required></input> to <input type='time' name='end-time-friday[]' value=" . $end_time . " required></input> <input type='button' class='remove-time-slot' value='✕'></input> <br> </div>";
                        }
                    }
                }

            ?>
        </div>
        <input type='button' class="add-new-time-friday add-new-time" value='✚'> Add new times</input>
    </div>

</div>

<br><button type="submit" name="edit_add_availability_submit" class="set-availability-submit">Update Availability</button> 

</form>