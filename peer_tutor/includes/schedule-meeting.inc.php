<?php

session_start();

require "connection.inc.php";
require "functions.inc.php";

?>
<style>
.header-logos {
    height: 50px;
    width: 100%;
    background-color: #00337f;
    top: 0;
}
.portledge_logo {
    max-width: 75%;
    max-height: 75%;
    float: left;
    margin: 7px;
}
.user-full-name-header {
    color: #ffffff;
    float: right;
    padding-right: 20px;
    cursor: default;
}
.user-username-header {
    color: #dddddd;
    float: right;
    padding-right: 20px;
    cursor: default;
}
.profile-info-header {
    text-decoration: none;
}
.profile-info-header:hover {
    background-color: #d5dde4;
}
/* .suggest-new-time {
    width: 200px;
    background-color: #dddddd;
    border-radius: 15px;
    padding: 10px 30px 30px 30px;
    margin: 20px;
    color: #00337f;
    word-wrap: break-word;
    box-shadow: 3px 5px 20px black;
    z-index: 10;
}
.suggest-new-time-title {
    font-size: 18px;
} */
</style>
<script>
    // $(document).ready(function() {
    //     $(".path-tutor").hide(); // begin to hide path tutor div
    //     $(".path-student").hide(); // begin to hide path student div

    //     $(".tutor-btn").click(function() { // on click of button with class tutor-btn
    //         $(".path-tutor").show(); // show tutor path div
    //         $(".path-student").hide(); // hide student path div
    //     });
    //     $(".be-tutored-btn").click(function() {
    //         $(".path-tutor").hide();
    //         $(".path-student").show();
    //     });
    // });
</script>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>    
</head>

<div class="header-logos">
    <img src="../images/crest-white.png" class="portledge_logo">
    <img src="../images/peer_tutor_logo.png" class="portledge_logo">
    <a href="profile.php" class="profile-info-header"> <?php
        echo "<p class='user-username-header'>" . $_SESSION['user_username'] . "</p>";
        echo "<p class='user-full-name-header'>" . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] . "</p>";  
    ?> </a>
</div>

<?php
    
    if(!isset($_POST['student_name'])) {
        $student_id = $_GET['studentid'];
    } else {
        $student_id = getUserId2($conn, $_POST['student_name']);
    }
    $tutor_id = $_SESSION['user_id'];
    if(!isset($_POST['course_name'])) {
        $course_name = trim($_GET['coursename']);
    } else {
        $course_name = trim($_POST['course_name']);
    }
    $course_id = getCourseId($conn, $course_name);
    $accepted = "true";

    $students_times = array();
    $users_times = array();

    $availability = getAvailability($conn, $_GET['studentid']);
    foreach($availability as $time_slot) {
        $data = [$time_slot[0], $time_slot[1], $time_slot[2]];
        array_push($students_times, $data);
    }


    $availability = getAvailability($conn, $_SESSION['user_id']);
    foreach($availability as $time_slot) {
        $data = [$time_slot[0], $time_slot[1], $time_slot[2]];
        array_push($users_times, $data);
    }

    $match_count = 0;
    foreach($students_times as $st) {
        foreach($users_times as $ut) {
            if($st[0] == $ut[0]) {
                if(doTimesOverlap($st[1], $st[2], $ut[1], $ut[2])) {
                    $match_count++;
                }
            }
        }
    }
?>



<form action="verification.inc.php?coursename=<?php echo $_GET['coursename']; ?>" method="post">
    <h1>Schedule Meeting Time</h1>

    <?php
        if($match_count == 1) {
            echo "<p>It looks like you have one match! Click on the mached time and then click 'Schedule' to schedule the meeting at that time.</p>";
        } else if($match_count > 1) {
            echo "<p>It looks like you have " . $match_count . " matches! Click on the time slot you want and then click 'Schedule' to schedule the meeting at that time.</p>";
        } else {
            echo "<p>It looks like you have no overlapping free times.</p>";
        }

        if(isset($_GET['error'])) {
            if($_GET['error'] == "nooptionpicked") {
                echo "<p style='color: red;'>You must select a time slot to schedule a meeting.</p>";
            }
        }

        // if(isset($_GET['option'])) {
        //     if($_GET['option'] == "suggestnewtime") {
        //         echo "
        //         <div class='suggest-new-time name='suggest-new-time'>
        //             <p class=suggest-new-time-title>Suggest New Time</p>
        //             <form action='verification.inc.php?coursename=" . $_GET['coursename'] . "' method='post'>
        //                 <label for='day'>
        //                 <select name='day'>
        //                     <option value='Monday' name='monday'>Monday</option>
        //                     <option value='tuesday' name='tuesday'>Tuesday</option>
        //                     <option value='Wednesday' name='wednesday'>Wednesday</option>
        //                     <option value='Thursday' name='thursday'>Thursday</option>
        //                     <option value='Friday' name='friday'>Friday</option>
        //                 </select><br>

        //                 <label for'start-time'>Start Time</label>
        //                 <input type='time' name='start-time' required></input><br>

        //                 <label for'end-time'>End Time</label>
        //                 <input type='time' name='end-time' required></input><br>

        //                 <button type='submit' name='suggest-new-time-submit' class='suggest-time-class'>Suggest Time</button>
        //             </form>
        //         </div>
        //         ";
        //     }
        // }
    ?>

    <div class="times-containter">

        <div class="grid-child-a">
            <?php
                if($match_count == 1) {
                    echo "<h3 class='match'>You have 1 match!</h3><br>";
                } else if($match_count > 1) {
                    echo "<h3 class='match'>You have " . $match_count . " matches!</h3><br>";
                } else {
        
                }

                foreach($students_times as $st) {
                    foreach($users_times as $ut) {
                        if($st[0] == $ut[0]) {
                            if(doTimesOverlap($st[1], $st[2], $ut[1], $ut[2])) {
                                $later_start_time = $st[1] >= $ut[1] ? $st[1] : $ut[1]; # if $st[1] <= $ut[1] { $later_start_time = $st[1] } else { $later_start_time = $ut[1] }
                                $later_start_time = strtotime($later_start_time);
                                
                                $earlier_end_time = $st[2] <= $ut[2] ? $st[2] : $ut[2];
                                $earlier_end_time = strtotime($earlier_end_time);

                                $overlap_minutes = floor(($earlier_end_time - $later_start_time) / 60);

                                $value = "day=" . $st[0] . "&start_time=" . str_replace(' ', '', date('h:i A', $later_start_time)) . "&end_time=" . str_replace(' ', '', date('h:i A', $earlier_end_time));

                                if($overlap_minutes >= 10) {
                                    echo "
                                    <label class=radio-btn>
                                        <input type=radio value=" . $value ." name=radio_time_match></input>
                                        <div>
                                            <p>" . $st[0] . " " . date('h:i A', $later_start_time) . " to " . date('h:i A', $earlier_end_time) . "&ensp; " . $overlap_minutes . " minutes</p>
                                        </div>
                                    </label><br>
                                    ";
                                }
                                
                            } else {
                                
                            }
                        }
                    }
                }
            ?>
        </div>
        
        <div class="grid-child-b">

            <div class="grid-child-1">
                <?php

                    echo "<h3>" . getName($conn, $_GET['studentid']) . "'s Available Times</h3>";
                
                    $availability = getAvailability($conn, $_GET['studentid']);
                    foreach($availability as $time_slot) {
                        $data = [$time_slot[0], $time_slot[1], $time_slot[2]];
                        // array_push($students_times, $data);
                        ?>

                        <div class="profile-time-slot" style="background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;">
                            <p class="profile-time-slot-start time"> <?php echo $time_slot[0] . ": " . date('h:i A', strtotime($time_slot[1])) . " to " . date('h:i A', strtotime($time_slot[2])); ?> </p>
                        </div><br>

                        <?php
                    }

                ?>
                
            </div>

            <div class="grid-child-1">
                <?php

                    echo "<h3> Your Available Times</h3>";
                
                    $availability = getAvailability($conn, $_SESSION['user_id']);
                    if(empty($availability)) {
                        print("empty");
                    }
                    foreach($availability as $time_slot) {
                        $data = [$time_slot[0], $time_slot[1], $time_slot[2]];
                        // array_push($users_times, $data);
                        ?>

                        <div class="profile-time-slot" style="background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;">
                            <p class="profile-time-slot-start time"> <?php echo $time_slot[0] . ": " . date('h:i A', strtotime($time_slot[1])) . " to " . date('h:i A', strtotime($time_slot[2])); ?> </p>
                        </div><br>

                        <?php
                    }

                ?>
            </div>

        </div>

    </div>

    <?php
        if($match_count == 1) {
            echo "<button class='submit-btn' name='schedule_submit' type='submit'>Schedule Meeting</button>";
            echo "<button class='submit-btn' name='no_times_work_submit' type='submit'>None Of These Times Work</button>";
        } else if($match_count > 1) {
            echo "<button class='submit-btn' name='schedule_submit' type='submit'>Schedule Meeting</button>";
            echo "<button class='submit-btn' name='no_times_work_submit' type='submit'>None Of These Times Work</button>";
        } else {
            echo "<button class='submit-btn' name='no_times_work_submit' type='submit'>Decline Student</button>";
        }
    ?>

    <input type="hidden" value=<?php echo $student_id; ?> name='student_id' ></input>
    <input type="hidden" value=<?php echo $course_name; ?> name='coursename' ></input>
    <input type="hidden" value=<?php echo $tutor_id; ?> name='tutor_id' ></input>
    <input type="hidden" value=<?php echo $course_id; ?> name='course_id' ></input>
    <input type="hidden" value=<?php echo $accepted; ?> name='accepted' ></input>
    <input type="hidden" value=<?php echo trim(getName($conn, $student_id)) ?> name='student_name' ></input>

</form>

<!-- <button id="open" class='submit-btn'>Suggest New Time Slot</button> -->

<!-- The Modal -->
<center><div id="modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    
    <p class="modal-title">Suggest A New Time</p>

    <form action='verification.inc.php?coursename=<?php echo $_GET['coursename']; ?>' method='post'>
        <div style="margin-bottom: 15px;">
            <label for='day'>Day</label>
            <select name='day' style="font-size: 15px;">
                <option value='Monday' name='monday'>Monday</option>
                <option value='tuesday' name='tuesday'>Tuesday</option>
                <option value='Wednesday' name='wednesday'>Wednesday</option>
                <option value='Thursday' name='thursday'>Thursday</option>
                <option value='Friday' name='friday'>Friday</option>
            </select><br>
        </div>

        <div style="margin-bottom: 15px;">
            <label for='start-time'>Start Time</label>
            <input type='time' name='start-time' required></input><br>
        </div>

        <div style="margin-bottom: 15px;">
            <label for='end-time'>End Time</label>
            <input type='time' name='end-time' required></input><br>
        </div>

        <input type="hidden" value=<?php echo $student_id; ?> name='student_id' ></input>
        <input type="hidden" value=<?php echo $course_name; ?> name='coursename' ></input>
        <input type="hidden" value=<?php echo $tutor_id; ?> name='tutor_id' ></input>
        <input type="hidden" value=<?php echo $course_id; ?> name='course_id' ></input>
        <input type="hidden" value=<?php echo $accepted; ?> name='accepted' ></input>
        <input type="hidden" value=<?php echo trim(getName($conn, $student_id)) ?> name='student_name' ></input>

        <button type='submit' name='suggest-new-time-submit' class='suggest-time-submit-class'>Suggest Time</button>
    </form>

  </div>

</div></center>

<html>
<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

        /* Modal Content */
    .modal-content {
        min-width: 300px;
        display: inline-block;
        background-color: #dddddd;
        border-radius: 15px;
        padding: 10px 30px;
        margin: 20px;
        color: #00337f;
        word-wrap: break-word;
        box-shadow: 3px 5px 20px black;
        font-size: 18px;
    }

    .modal-title {
        font-size: 28px;
    }

        /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .suggest-time-submit-class {
        background-color: #8ecae6;
        padding: 10px 20px;
        border-radius: 10px;
        border: 0px;
        font-size: 18px;
        margin: 10px;
    }
    .suggest-time-submit-class:hover {
        background-color: #8ecae6;
        box-shadow: 1px 1px 10px #8ecae6;
    }
    .suggest-time-submit-class:focus {
        outline: none;
        box-shadow: none;
    }

    .submit-btn {
        background-color: #8ecae6;
        font-size: 15px;
        padding: 15px 25px;
        margin: 10px;
        border-radius: 10px;
        border: 0px;
        min-width:100px;
    }
    .submit-btn:hover {
        background-color: #8ecae6;
        box-shadow: 1px 1px 10px #8ecae6;
    }
    .submit-btn:focus {
        outline: none;
        box-shadow: none;
    }
    .times-containter {
        display: grid;
        grid-template-columns: minmax(max-content, max-content) minmax(max-content, max-content);
        grid-gap: 10px;
    }
    .grid-child-a {

    }
    .grid-child-b {
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* grid-gap: 10px; */
    }
    .grid-child-1 {

    }
    .grid-child-2 {

    }
    .match {
        min-width:100px;
        display: inline-block;
    }
    .radio-btn {
        min-width:100px;
        display: inline-block;
    }
    .radio-btn > input{ /* HIDE RADIO */
        visibility: hidden; /* Makes input not-clickable */
        position: absolute; /* Remove input from document flow */
    }
    .radio-btn > input + div{ /* DIV STYLES */
        cursor: pointer;
        background-color: #03fca9;
        padding: 5px 10px;
        margin-bottom: 10px;
        border-radius: 10px;
        min-width:100px;
        display: inline-block;
    }
    .radio-btn > input:checked + div{ /* (RADIO CHECKED) DIV STYLES */
        border: 1px black solid;
        /* box-shadow: 1px 1px 10px #03fca9; */
    }
    .radio-btn > input:hover + div{ /* (RADIO CHECKED) DIV STYLES */
        box-shadow: 1px 1px 10px #03fca9;
    }

    @media only screen and (max-width: 810px) { /* if screen width is less than or equal to 850px */
        .times-containter {
            grid-template-columns: minmax(max-content, max-content);
            grid-template-rows: minmax(max-content, max-content) minmax(max-content, max-content);
        }
    }
</style>
<script>
    var suggestNewTimePopup = document.getElementById("modal");
    var openPopup = document.getElementById("open");
    var closePopup = document.getElementsByClassName("close")[0];

    openPopup.onclick = function() {
        suggestNewTimePopup.style.display = "block";
    }

    closePopup.onclick = function() {
        suggestNewTimePopup.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            suggestNewTimePopup.style.display = "none";
        }
    }
</script>