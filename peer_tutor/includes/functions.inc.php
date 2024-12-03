<?php

function invalidEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { # if email is not valid
        return true;
    } else if(!preg_match('/@portledge.org/', $email)) { # if email does not contains the pattern '@portledge.org' to check if the email is a portledge email
        return true;
    } else {
        return false;
    }
}

function createUser($conn, $first_name, $last_name, $username, $email, $password) {
    $sql = "INSERT INTO users (user_first_name, user_last_name, user_username, user_email, user_password) VALUES (?, ?, ?, ?, ?);"; # sql code that will run in the database. to secure the code, we will not enter the values until the statment is verified
    $stmt = mysqli_stmt_init($conn); # intialize prepared statement
    if(!mysqli_stmt_prepare($stmt, $sql)) { # if prepared statement has an error
        header("location: ../sign-up.php?error=statementfailed"); # send user back to sign up page with an error message
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT); # convert password to a hashed password for security

    mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $username, $email, $hashed_password); # bind the (?, ?, ?, ?, ?) to real values. the "sssss" denotes that 5 strings are being binded
    mysqli_stmt_execute($stmt); # execute statment in database

    mysqli_stmt_close($stmt); # close statement

    $username_exists = usernameExists($conn, $username, $email); # get $username_exists variable to get user_id to start session

    session_start(); # start session
    $_SESSION['user_id'] = $username_exists['user_id'];
    $_SESSION['user_first_name'] = $username_exists['user_first_name'];
    $_SESSION['user_last_name'] = $username_exists['user_last_name'];
    $_SESSION['user_username'] = $username_exists['user_username'];

    header("location: ../user-cohort.php"); # send user to user_cohort page
    exit();
}

function updateProfile($conn, $user_id, $first_name, $last_name, $username, $email, $cohort, $meeting_preference) {
    $sql = "UPDATE users SET user_first_name=?, user_last_name=?, user_username=?, user_email=?, user_cohort=?, user_meeting_preference=? WHERE user_id=?"; # sql code that will run in the database. to secure the code, we will not enter the values until the statment is verified
    $stmt = mysqli_stmt_init($conn); # intialize prepared statement
    if(!mysqli_stmt_prepare($stmt, $sql)) { # if prepared statement has an error
        header("location: ../sign-up.php?error=statementfailed"); # send user back to sign up page with an error message
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssssssi", $first_name, $last_name, $username, $email, $cohort, $meeting_preference, $user_id); # bind the (?, ?, ?, ?, ?) to real values. the "sssss" denotes that 5 strings are being binded
    mysqli_stmt_execute($stmt); # execute statment in database

    mysqli_stmt_close($stmt); # close statement

    header("location: ../profile.php"); # send user to profile page
    exit();
}

function loginUser($conn, $username, $password) {
    $username_exists = usernameExists($conn, $username, $username); # $username is a parameter twice becasue it is checking it as a username or an email

    if($username_exists == false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    # compare hashed password in table with non hashed password
    $hashed_password = $username_exists["user_password"]; # returns the users password in the table
    $check_password = password_verify($password, $hashed_password); # boolean variable if hashed password equals the parameter password variable

    if($check_password == true) {
        session_start(); # start session

        # session variables
        $_SESSION['user_id'] = $username_exists['user_id']; # create global session variable that holds the value of user_id. this vairiable han be used to check if the session has started, check if the user has logged in
        $_SESSION['user_first_name'] = $username_exists['user_first_name'];
        $_SESSION['user_last_name'] = $username_exists['user_last_name'];
        $_SESSION['user_username'] = $username_exists['user_username'];

        header("location: ../index.php");
        exit();
    }
}

function usernameExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE user_username = ? OR user_email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../login.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    if($row = mysqli_fetch_assoc($result_data)) { # assign $row to an array of the row data from the selected row in the table, if the data exists
        return $row;
    } else {
        return false;
    }
}

function createUserCohort($conn, $cohort, $id) {
    $sql = "UPDATE users SET user_cohort = ? WHERE user_id = ? "; 
    $stmt = mysqli_stmt_init($conn); 
    if(!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: ../user_cohort.php?error=statementfailed"); 
        exit();
    }
    mysqli_stmt_bind_param($stmt, "si", $cohort, $id);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);

    header("location: ../user-meeting-preference.php");
    exit();
}

function createUserMeetingPreference($conn, $meeting_preference, $id) {
    $sql = "UPDATE users SET user_meeting_preference = ? WHERE user_id = ? "; 
    $stmt = mysqli_stmt_init($conn); 
    if(!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: ../user_meeting-preference.php?error=statementfailed"); 
        exit();
    }
    mysqli_stmt_bind_param($stmt, "si", $meeting_preference, $id);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);

    header("location: ../user-availability.php");
    exit();
}

function getCourseData($conn, $subject_child, $subject) {
    $course_names = array(); # create courses names array
    
    $sql = "SELECT * FROM courses WHERE subject = ? AND subject_child = ?;"; # sql statment
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../subjects.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $subject, $subject_child); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $course_data = array();
        
        array_push($course_names, $row['course_name']); # append course name to array
    }
    return $course_names; # return courses array
}

function getWhatUserIsTutoringIn($conn, $user_id) {
    $tutor_data = array();
    $verified = "true";

    $sql = "SELECT * FROM tutors WHERE user_id = ? AND verified = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "is", $user_id, $verified); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $data = array();
        array_push($data, $row['course_id']);
        array_push($data, $row['course_name']);
        array_push($data, $row['students']);

        array_push($tutor_data, $data);
    }
    return $tutor_data;
}

function getWhatUserIsStudentIn($conn, $user_id) {
    $tutor_data = array();

    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $user_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $data = array();
        array_push($data, $row['course_name']);
        array_push($data, $row['tutor_id']);
        array_push($data, $row['accepted']);

        array_push($tutor_data, $data);
    }
    return $tutor_data;
}

function createStudent($conn, $student_id, $tutor_id, $course_id, $description, $accepted, $course_name) {
    # check if exists already
    $sql = "SELECT * FROM students WHERE student_id = ? AND course_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../course-page.php?coursename=" . $course_name . "&error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $course_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    if(!empty(mysqli_fetch_row($result_data))) {
        header("location: ../course-page.php?coursename=" . $course_name . "&error=studentexists");
        exit();
    }

    $sql = "INSERT INTO students (student_id, tutor_id, course_id, course_name, description, accepted) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../course-page.php?coursename=" . $course_name . "&error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iiisss", $student_id, $tutor_id, $course_id, $course_name, $description, $accepted);
    mysqli_stmt_execute($stmt); # execute statment in database
    mysqli_stmt_close($stmt); # close statement

    # send notification
    $notification_type = "student requested tutor";
    $notification_name = "Tutor Request: " . $course_name;

    $notification_data = "course_id=" . $course_id . "&course_name=" . $course_name . "&student_id=" . $student_id . "&description=" . $description . "";

    $sql = "INSERT INTO notifications (user_id, notification_type, notification_name, notification_data) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../course-page.php?coursename=" . $course_name . "&error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "isss", $tutor_id, $notification_type, $notification_name, $notification_data);
    mysqli_stmt_execute($stmt); # execute statment in database
    mysqli_stmt_close($stmt); # close statement

    header("location: ../course-page.php?coursename=" . $course_name . "&studentcreated=true&notificationcreated=true");
    exit();
}

function acceptStudent($conn, $student_id, $tutor_id, $course_id, $course_name) {
    # accept student
    $accepted = "true";
    $sql = "UPDATE students SET accepted = ? WHERE student_id = ? AND tutor_id = ? AND course_id = ?"; 
    $stmt = mysqli_stmt_init($conn); 
    if(!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: ../profile.php?error=statementfailed"); 
        exit();
    }
    mysqli_stmt_bind_param($stmt, "siis", $accepted, $student_id, $tutor_id, $course_id);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);

    # get student number
    $sql = "SELECT * FROM tutors WHERE user_id = ? AND course_name = ?"; # sql statment
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "is", $tutor_id, $course_name); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    #$students;

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $students = $row['students']; # append course name to array
    }

    $students++;

    # update student number
    $sql = "UPDATE tutors SET students = ? WHERE user_id = ? AND course_name = ?"; 
    $stmt = mysqli_stmt_init($conn); 
    if(!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: ../profile.php?error=statementfailed"); 
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iis", $students, $tutor_id, $course_name);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);

    # go to schedule meeting page
    header("location: schedule-meeting.inc.php?acceptedstudent=true&studentid=" . $student_id);
    exit();
}

function addSuggestedTime($conn, $day, $start_time, $end_time, $student_id, $tutor_id, $course_id) {
    $accepted = "false";

    $sql = "INSERT INTO suggested_times (student_id, tutor_id, course_id, suggested_day, suggested_start_time, suggested_end_time, accepted) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iiissss", $student_id, $tutor_id, $course_id, $day, $start_time, $end_time, $accepted);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function doTimesOverlap($start_time_1, $end_time_1, $start_time_2, $end_time_2) {
    if($start_time_1 < $end_time_2 && $start_time_2 < $end_time_1) {
        return true;
    } else {
        return false;
    }
}

function createMeeting($conn, $student_id, $tutor_id, $course_id, $day, $start_time, $end_time, $status) {
    $sql = "INSERT INTO meetings (student_id, tutor_id, course_id, day, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../meeting.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iiissss", $student_id, $tutor_id, $course_id, $day, $start_time, $end_time, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getNotifications($conn, $user_id) {
    $notification_data = array();

    $sql = "SELECT * FROM notifications WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $user_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $data = array();
        array_push($data, $row['notification_name']);
        array_push($data, $row['notification_data']);
        array_push($data, $row['resolved']);

        array_push($notification_data, $data);
    }
    return $notification_data;
}

function parseNotificationData($txt, $key) {
    foreach(explode("&", $txt) as $a) {
        if(explode("=", $a)[0] == $key) {
            return explode("=", $a)[1];
        }   
    }
}

function getName($conn, $id) {
    return getUserInformation($conn, $id)[0] . " " . getUserInformation($conn, $id)[1];
}

function addAvailability($conn, $user_id, $day, $start_time, $end_time) {
    $sql = "INSERT INTO user_availability (user_id, user_available_day, user_available_start_time, user_available_end_time) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_availability.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $day, $start_time, $end_time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function createAvailablity($conn, $user_id, $availability) {
    foreach($availability as $time_slot) {
        $sql = "INSERT INTO user_availability (user_id, user_available_day, user_available_start_time, user_available_end_time) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../user_availability.php?error=statementfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "isss", $user_id, $time_slot[2], $time_slot[0], $time_slot[1]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function clearAvailability($conn, $user_id) {
    $sql = "DELETE FROM user_availability WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../user_availability.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../profile.php");
    exit();
}

function getAvailability($conn, $user_id) {
    $availability = array();

    $sql = "SELECT * FROM user_availability WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $availability_data = array();
        array_push($availability_data, $row['user_available_day']);
        array_push($availability_data, $row['user_available_start_time']);
        array_push($availability_data, $row['user_available_end_time']);

        array_push($availability, $availability_data);
    }
    return $availability;
}

function getMeetingsTutor($conn, $user_id) {
    $meetings = array();

    $sql = "SELECT * FROM meetings WHERE tutor_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../meeting.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $meeting_data = array();
        array_push($meeting_data, $row['student_id']);
        array_push($meeting_data, $row['tutor_id']);
        array_push($meeting_data, $row['course_id']);
        array_push($meeting_data, $row['day']);
        array_push($meeting_data, $row['start_time']);
        array_push($meeting_data, $row['end_time']);
        array_push($meeting_data, $row['status']);

        array_push($meetings, $meeting_data);
    }
    return $meetings;
}

function getMeetingsStudent($conn, $user_id) {
    $meetings = array();

    $sql = "SELECT * FROM meetings WHERE student_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../meeting.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $meeting_data = array();
        array_push($meeting_data, $row['student_id']);
        array_push($meeting_data, $row['tutor_id']);
        array_push($meeting_data, $row['course_id']);
        array_push($meeting_data, $row['day']);
        array_push($meeting_data, $row['start_time']);
        array_push($meeting_data, $row['end_time']);
        array_push($meeting_data, $row['status']);

        array_push($meetings, $meeting_data);
    }
    return $meetings;
}

function getUserInformation($conn, $user_id) {
    $user_data = array();

    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        array_push($user_data, $row['user_first_name']);
        array_push($user_data, $row['user_last_name']);
        array_push($user_data, $row['user_username']);
        array_push($user_data, $row['user_email']);
        array_push($user_data, $row['user_cohort']);
        array_push($user_data, $row['user_meeting_preference']);
    }
    return $user_data;
}

function getCourseId($conn, $course_name) {
    $sql = "SELECT * FROM courses WHERE course_name = ?;"; # sql statment
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../subjects.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $course_name); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        return $row['id']; # append course name to array
    }
}

function getCourseName($conn, $course_id) {
    $sql = "SELECT * FROM courses WHERE id = ?;"; # sql statment
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../subjects.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $course_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        return $row['course_name']; # append course name to array
    }
}

function getUserId($conn, $user_first_name, $user_last_name) {
    $sql = "SELECT * FROM users WHERE user_first_name = ? AND user_last_name = ?;"; # sql statment
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../subjects.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $user_first_name, $user_last_name); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        return $row['user_id']; # append course name to array
    }
}

function getUserId2($conn, $full_name) {
    $user_first_name = explode(" ", $full_name)[1];
    $user_last_name = explode(" ", $full_name)[2];

    $sql = "SELECT * FROM users WHERE user_first_name = ? AND user_last_name = ?;"; # sql statment
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../subjects.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $user_first_name, $user_last_name); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        return $row['user_id']; # append course name to array
    }
}

function createNonVerifiedTutor($conn, $user_id, $course_name, $course_id, $description, $verified) {
    # check if tutor for this subject exists
    $sql = "SELECT * FROM tutors WHERE user_id = ? AND course_id = ?;"; # select from database where there is the same user id and course id
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../course-page.php?coursename=" . $course_name . "&error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $course_id); # bind data to statment
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    if($row = mysqli_fetch_assoc($result_data)) { # assign $row to an array of the row data from the selected row in the table, if the data exists
        header("location: ../course-page.php?coursename=" . $course_name . "&error=tutorexists"); # send user back with an error message saying tutor for this subject exists
        exit();
    }

    # create tutor
    $sql = "INSERT INTO tutors (user_id, course_id, course_name, description, verified) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../course-page.php?coursename=" . $course_name . "&error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iisss", $user_id, $course_id, $course_name, $description, $verified);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../course-page.php?coursename=" . $course_name . "&tutorcreated=true");
    exit();
}

function showNotification($number) {
    return "<span style='color: white; background-color: red; padding: 5px 10px; border-radius: 50%;'>" . $number . "</span>";
}

function checkVerifiedTutors($conn, $course_id) {
    $verified_users = array();
    $verified = "true";

    $sql = "SELECT * FROM `tutors` WHERE course_id = ? AND verified = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../course-page.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "is", $course_id, $verified); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        array_push($verified_users, $row['user_id']);
    }

    return $verified_users;
}

function getTutorsStudentCount($conn, $tutor_id, $course_id) {
    $sql = "SELECT * FROM tutors WHERE user_id=? AND course_id=?;"; # sql statment
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../subjects.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $tutor_id, $course_id); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        return $row['students']; # append course name to array
    }
}