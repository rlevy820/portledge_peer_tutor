<?php 

session_start();
require "header.php";
require "includes/connection.inc.php";
require "includes/functions.inc.php";

$user_data = getUserInformation($conn, $_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .tutor-request-div {
        width: 250px;
        background-color: #dddddd;
        border-radius: 15px;
        padding: 30px;
        margin: 20px;
        color: #00337f;
        word-wrap: break-word;
        box-shadow: 3px 5px 20px black;
    }
</style>
<script>
    $(document).ready(function() {
        $(".general-information").show();
        $(".edit-profile-btn").show();
        $(".edit-profile").hide();
        $(".cancel-edit-profile-btn").hide();

        $(".tutor-request-open-btn").show();
        $(".tutor-request-close-btn").hide();
        $(".tutor-request-div").hide();
        

        $(".edit-profile-btn").click(function() { 
            $(".general-information").hide();
            $(".edit-profile").show();
            $(".cancel-edit-profile-btn").show();
            $(".edit-profile-btn").hide();
        });
        $(".done-editing").click(function() { 
            $(".general-information").show();
            $(".edit-profile").hide();
        });
        $(".cancel-edit-profile-btn").click(function() { 
            $(".general-information").show();
            $(".edit-profile").hide();
            $(".edit-profile-btn").show();
            $(".cancel-edit-profile-btn").hide();
        });

        $(".tutor-request-open-btn").click(function() { 
            $(".tutor-request-open-btn").hide();
            $(".tutor-request-close-btn").show();
            $(".tutor-request-div").show();
        });
        $(".tutor-request-close-btn").click(function() { 
            $(".tutor-request-open-btn").show();
            $(".tutor-request-close-btn").hide();
            $(".tutor-request-div").hide();
        });
    });
</script>
<body>
    <p>Profile <button class="edit-profile-btn">Edit Profile</button> <button class="cancel-edit-profile-btn">Stop Editing Profile</button> </p>
    <div class="information">
        <p>General Information</p>

        <div class="general-information">
            <p><strong>First Name</strong> &ensp; <?php echo $user_data['0']; ?></p>
            <p><strong>Last Name</strong> &ensp; <?php echo $user_data['1']; ?></p>
            <p><strong>Username</strong> &ensp; <?php echo $user_data['2']; ?></p>
            <p><strong>Email</strong> &ensp; <?php echo $user_data['3']; ?></p>
            <p><strong>Cohort</strong> &ensp; <?php echo $user_data['4']; ?></p>
            <p><strong>Meeting Preference</strong> &ensp; <?php echo $user_data['5']; ?></p>
        </div>

        <form class="edit-profile" action="includes/edit-profile.inc.php" method="post">

            <label for="first-name"><strong>First Name</strong> &ensp; </label> <!-- label for id="first name" -->
            <input type="text" name="first_name" id="first-name" value=<?php echo $user_data['0'] ?> required></input><br><br> <!-- input for first name -->

            <label for="last-name"><strong>Last Name</strong> &ensp;</label>
            <input type="text" name="last_name" id="last-name" value=<?php echo $user_data['1']; ?> required></input><br><br>

            <label for="username"><strong>Userame</strong> &ensp;</label>
            <input type="text" name="username" disabled id="username" value=<?php echo $user_data['2']; ?> required></input><br><br>

            <label for="email"><strong>Portledge Email</strong> &ensp;</label>
            <input type="email" name="email" id="email" value=<?php echo $user_data['3']; ?> required></input><br><br>
            
            <label for="user_cohort"><strong>Cohort</strong> &ensp;</label>
            <select name="user_cohort">
                <?php if($user_data['4'] == "A") {
                    echo "
                        <option value='A' name='a' selected>A</option>
                        <option value='B' name='b'>B</option>
                        <option value='O' name='o'>O (Online)</option>
                    ";
                } ?>
                <?php if($user_data['4'] == "B") {
                    echo "
                        <option value='A' name='a'>A</option>
                        <option value='B' name='b' selected>B</option>
                        <option value='O' name='o'>O (Online)</option>
                    ";
                } ?>
                <?php if($user_data['4'] == "O") {
                    echo "
                        <option value='A' name='a'>A</option>
                        <option value='B' name='b'>B</option>
                        <option value='O' name='o' selected>O (Online)</option>
                    ";
                } ?>
            </select><br><br>

            <label for="user_meeting_preference"><strong>Meeting Preference</strong> &ensp;</label>
            <select name="user_meeting_preference">
                <?php if($user_data['5'] == "In Person") {
                    echo "
                        <option value='In Person' selected>In Person</option>
                        <option value='Online'>Online</option>
                        <option value='No Preference'>No Preference</option>
                    ";
                } ?>
                <?php if($user_data['5'] == "Online") {
                    echo "
                        <option value='In Person'>In Person</option>
                        <option value='Online' selected>Online</option>
                        <option value='No Preference'>No Preference</option>
                    ";
                } ?>
                <?php if($user_data['5'] == "No Preference") {
                    echo "
                        <option value='In Person'>In Person</option>
                        <option value='Online'>Online</option>
                        <option value='No Preference' selected>No Preference</option>
                    ";
                } ?>
            </select><br><br>

            <button type="submit" class="done-editing" name="edit_profile_submit">Update Profile</button> <!-- button that submits the form button -->
        
        </form>


    </div><br>
    <div class="availability">
        <p><strong>Available Meeting Times</strong> <button onClick="document.location.href='user-availability.php'" class="edit-add-availablility">Edit/Add Available Times</button> </p>
        <?php
            $availability = getAvailability($conn, $_SESSION['user_id']);
            if(empty($availability)) {
                print("empty");
            }
            foreach($availability as $time_slot) {
                ?>

                <div class="profile-time-slot" style="background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;">
                    <p class="profile-time-slot-start time"> <?php echo $time_slot[0] . ": " . date('h:i A', strtotime($time_slot[1])) . " to " . date('h:i A', strtotime($time_slot[2])); ?> </p>
                </div><br>

                <?php
            }
        ?>
    </div>
    <div class="tutoring-in">
        <p><strong>Tutoring In</strong></p>

        <?php
            foreach(getWhatUserIsTutoringIn($conn, $_SESSION['user_id']) as $subject) {
                echo 
                "<div class='profile-time-slot' style='background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;'>
                    <p>" . $subject[1] . " &ensp; <strong>Students:</strong> " . $subject[2] . "</p>
                </div><br>";
            }
        ?>
    </div>
    <div class="student-in">
        <p><strong>Student In</strong></p>

        <?php
            foreach(getWhatUserIsStudentIn($conn, $_SESSION['user_id']) as $subject) {
                if($subject[2] == "true") {
                    echo 
                    "<div class='profile-time-slot' style='box-shadow: 1px 1px 10px #03fc73; background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;'>
                        <p><strong>Course:</strong> " . $subject[0] . " &ensp; <strong>Tutor:</strong> " . getUserInformation($conn, $subject[1])[0] . " " . getUserInformation($conn, $subject[1])[1] . " &ensp; <strong>Accepted:</strong> " . $subject[2] . "</p>
                    </div><br>";
                } else {
                    echo 
                    "<div class='profile-time-slot' style='box-shadow: 1px 1px 10px #ff2f24; background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;'>
                        <p><strong>Course:</strong> " . $subject[0] . " &ensp; <strong>Tutor:</strong> " . getUserInformation($conn, $subject[1])[0] . " " . getUserInformation($conn, $subject[1])[1] . " &ensp; <strong>Accepted:</strong> " . $subject[2] . "</p>
                    </div><br>";
                }
            }
        ?>
    </div>
    <div class="notifications">
        <p><strong>Notifications</strong></p>
        
        <?php
            foreach(getNotifications($conn, $_SESSION['user_id']) as $notification) {
                if($notification[2] !== "true") {
                    if(strpos($notification[0], 'Tutor Request') !== false) {
                        $student_id = parseNotificationData($notification[1], "student_id");
                        $student_name = getName($conn, parseNotificationData($notification[1], "student_id"));
                        $course_name = parseNotificationData($notification[1], "course_name");
                        $description = parseNotificationData($notification[1], "description");

                        ?>

                        <div class='profile-time-slot' style='background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;'>
                            <p> <?php echo $notification[0] ?> <button class='tutor-request-open-btn'>Open</button> <button class='tutor-request-close-btn'>Close</button> </p>
                        </div><br>

                        <div class="tutor-request-div">
                            <form action='includes/schedule-meeting.inc.php?acceptedstudent=true&studentid=<?php echo $student_id; ?>&coursename=<?php echo $course_name; ?>' method='post'>
                                <p style = "margin-top: 0px;"><strong> <?php echo $notification[0] ?> </strong></p>

                                <p style = "margin-top: 0px;"> 
                                <?php echo "<span style='color: #218a48;'>" . $student_name . "</span>" ?> requested to be tutored in 
                                <?php echo "<span style='color: #218a48;'>" . $course_name . "</span>" ?></p> 
                                
                                <input type="hidden" value=" <?php echo $student_name ?> " name="student_name"></input>
                                <input type="hidden" value=" <?php echo $course_name ?> " name="course_name"></input>

                                <p> Message from <?php echo "<span style='color: #218a48;'>" . getUserInformation($conn, $student_id)[0] . "</span>" ?>: </p>
                                
                                <?php echo "<div style='padding: 2px 5px 2px 5px;border-radius: 10px; box-shadow: 1px 5px 20px gray;' > <p style='color: #218a48;'>" . $description . "</p> </div>" ?>  </p>
                                <span> <button type="submit" name="accept_student" class="accept-student">Open</button> </span>
                            </form>
                        </div>

                        <?php
                    } else if(strpos($notification[0], 'Confirm Meeting Time') !== false) {
                        $day = parseNotificationData($notification[1], "day");
                        $start_time = parseNotificationData($notification[1], "start_time");
                        $end_time = parseNotificationData($notification[1], "end_time");
                        $course_id = parseNotificationData($notification[1], "course_id");
                        $course_name = parseNotificationData($notification[1], "course_name");
                        $student_id = parseNotificationData($notification[1], "student_id");
                        $tutor_id = parseNotificationData($notification[1], "tutor_id");

                        ?>

                        <div class='profile-time-slot' style='background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;'>
                            <p> <?php echo $notification[0] ?> <button class='tutor-request-open-btn'>Open</button> <button class='tutor-request-close-btn'>Close</button> </p>
                        </div><br>

                        <div class="tutor-request-div">
                            <form action='includes/verification.inc.php' method='post'>
                                <p style = "margin-top: 0px;"><strong> <?php echo $notification[0] ?> </strong></p>

                                <p style = "margin-top: 0px;"> 
                                <?php echo "<span style='color: #218a48;'>" . $tutor_id . "</span>" ?> suggested a new meeting time for 
                                <?php echo "<span style='color: #218a48;'>" . $course_name . "</span>" ?></p> 
                                
                                <input type="hidden" value=" <?php echo $day ?> " name="day"></input>
                                <input type="hidden" value=" <?php echo $start_time ?> " name="start_time"></input>
                                <input type="hidden" value=" <?php echo $end_time ?> " name="end_time"></input>
                                <input type="hidden" value=" <?php echo $course_id ?> " name="course_id"></input>
                                <input type="hidden" value=" <?php echo $student_id ?> " name="student_id"></input>
                                <input type="hidden" value=" <?php echo $tutor_id ?> " name="tutor_id"></input>
                                
                                <?php echo "<div style='padding: 2px 1px; border-radius: 10px; box-shadow: 1px 5px 20px gray;' > <p>" . $day . ": " . date('h:i A', strtotime($start_time)) . " to " . date('h:i A', strtotime($end_time)) ."</p> </div>" ?>  </p>
                                <span> <button type="submit" name="accept-suggested-time-submit" class="accept-student">Accept Time</button> <button type="submit" name="decline-suggested-time-submit" class="decline-student">Decline Time</button> </span>
                            </form>
                        </div>

                        <?php

                    } else if(strpos($notification[0], 'Tutor Request Declined') !== false) {
                        $course_id = parseNotificationData($notification[1], "course_id");
                        $student_id = parseNotificationData($notification[1], "student_id");
                        $tutor_id = parseNotificationData($notification[1], "tutor_id");
                        $student_name =  getName($conn, $student_id);
                        $tutor_name = getName($conn, $tutor_id);
                        $notification_data = $notification[1];

                        ?>

                        <div class='profile-time-slot' style='background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;'>
                            <p> <?php echo $notification[0] ?> <button class='tutor-request-open-btn'>Open</button> <button class='tutor-request-close-btn'>Close</button> </p>
                        </div><br>

                        <div class="student-declined-div">
                            <form action='includes/student_declined.inc.php?studentid=<?php echo $student_id; ?>' method='post'>
                                <p> <?php getName($conn, $tutor_id); ?> could not meet with you. </p>
                                <input type="hidden" value=" <?php echo $notification_data ?> " name="not_data"></input>
                                <input type="hidden" value=" <?php echo $student_id ?> " name="studentid"></input>
                                <span> <button type="submit" name="ok_not" class="accept-student">Ok</button> </span>
                            </form>
                        </div>

                        <?php
                    }
                }
                
            }
        ?>
    </div>
</body>
</html>

<?php include "footer.php"; ?>