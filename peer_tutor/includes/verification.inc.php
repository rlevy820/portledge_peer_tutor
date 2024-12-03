<script>
    document.getElementById("errornooptionpicked").submit();
</script>

<?php


session_start();

require "connection.inc.php";
require "functions.inc.php";

if(isset($_POST['accept_student'])) {
    // $student_id = getUserId2($conn, $_POST['student_name']);
    // $tutor_id = $_SESSION['user_id'];
    // $course_name = trim($_POST['course_name']);
    // $course_id = getCourseId($conn, $course_name);
    // $accepted = "true";

    // echo $student_id  . " " . $tutor_id . " " . $course_name;

    // acceptStudent($conn, $student_id, $tutor_id, $course_id, $course_name);


} 

else if(isset($_POST['ok_not'])) {
    $resolved = "true";

    $student_id = $_POST['student_id'];

    $notification = getNotifications($conn, $student_id);
    $notification_data;
    foreach($notification as $not) {
        $notification_data = $not[1];
    }

    // echo $notification_name . " " . $notification_data;

    $sql = "UPDATE notifications SET resolved=? WHERE user_id=? AND notification_data=?;"; 
    $stmt = mysqli_stmt_init($conn); 
    if(!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: ../meeting.php?error=statementfailed"); 
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sis", $resolved, $tutor_id, $notification_data);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);

    header("location: ../profile.php");
    exit();
}

else if(isset($_POST['schedule_submit'])) {
    if(!isset($_POST['radio_time_match'])) {
        echo "
        <form id='errornooptionpicked' action='schedule-meeting.inc.php?studentid=" . $_POST['student_id'] . "&error=nooptionpicked' method='post'>
            <input type='hidden' value=" . $_POST['student_id'] . " name='student_id' ></input>
            <input type='hidden' value=" . $_POST['student_name'] . " name='student_name' ></input>
            <input type='hidden' value=" . $_POST['tutor_id'] . " name='tutor_id' ></input>
            <input type='hidden' value=" . $_POST['coursename'] . " name='coursename' ></input>
            <input type='hidden' value=" . $_POST['course_id'] . " name='course_id' ></input>
            <input type='hidden' value=" . $_POST['accepted'] . " name='accepted' ></input>
        </form>
        ";
        header("location: schedule-meeting.inc.php?studentid=" . $_POST['student_id'] . "&coursename=" . $_GET['coursename'] . "&error=nooptionpicked");
        exit();
    }

    echo $_POST['radio_time_match'] . "<br><br>";

    $data = $_POST['radio_time_match'];

    $day = parseNotificationData($data, 'day');
    $start_time = parseNotificationData($data, 'start_time');
    $end_time = parseNotificationData($data, 'end_time');

    if(strpos($start_time, 'A') !== false) {
        $start_time = str_replace('A', ' A', $start_time);
    } else if(strpos($start_time, 'P') !== false) {
        $start_time = str_replace('P', ' P', $start_time);
    }

    $start_time_final = date('H:i', strtotime($start_time));
    $end_time_final = date('H:i', strtotime($end_time));
    
    if(strpos($end_time, 'A') !== false) {
        $end_time = str_replace('A', ' A', $end_time);
    } else if(strpos($end_time, 'P') !== false) {
        $end_time = str_replace('P', ' P', $end_time);
    }
    
    $student_id = $_POST['student_id'];
    $tutor_id = $_POST['tutor_id'];
    $course_id = $_POST['course_id'];
    $status = "Occuring";
    $accepted = "true";

    $sql = "UPDATE students SET accepted = ? WHERE student_id=? AND tutor_id=? AND course_id=?"; 
    $stmt = mysqli_stmt_init($conn); 
    if(!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: ../meeting.php?error=statementfailed"); 
        exit();
    }
    mysqli_stmt_bind_param($stmt, "siii", $accepted, $student_id, $tutor_id, $course_id);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);

    $tutors_student_count = getTutorsStudentCount($conn, $tutor_id, $course_id);
    $tutors_student_count += 1;

    $sql = "UPDATE tutors SET students=? WHERE user_id=? AND course_id=?"; 
    $stmt = mysqli_stmt_init($conn); 
    if(!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: ../meeting.php?error=statementfailed"); 
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iii", $tutors_student_count, $tutor_id, $course_id);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);

    $sql = "INSERT INTO meetings (student_id, tutor_id, course_id, day, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../meeting.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iiissss", $student_id, $tutor_id, $course_id, $day, $start_time_final, $end_time_final, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $resolved = "true";

    $notification = getNotifications($conn, $tutor_id);
    $notification_data;
    foreach($notification as $not) {
        $notification_data = $not[1];
    }

    // echo $notification_name . " " . $notification_data;

    $sql = "UPDATE notifications SET resolved=? WHERE user_id=? AND notification_data=?;"; 
    $stmt = mysqli_stmt_init($conn); 
    if(!mysqli_stmt_prepare($stmt, $sql)) { 
        header("location: ../meeting.php?error=statementfailed"); 
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sis", $resolved, $tutor_id, $notification_data);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);

    header("location: ../meeting.php");
    exit();

    // createMeeting($conn, $_POST['student_id'], $_POST['tutor_id'], $_POST['course_id'], $day, $start_time, $end_time, "Occuring");
}

else if(isset($_POST['decline_student'])) {
    # send notification to student declining

    $student_id = $_POST['student_id'];
    $tutor_id = $_POST['tutor_id'];
    $course_id = $_POST['course_id'];

    $notification_type = "tutor decline student";
    $notification_name = "Tutor Request Declined";
    $notification_data = "student_id=" . $student_id . "&tutor_id=" . $tutor_id . "&course_id=" . $course_id;

    $sql = "INSERT INTO notifications (user_id, notification_type, notification_name, notification_data) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "isss", $student_id, $notification_type, $notification_name, $notification_data);
    mysqli_stmt_execute($stmt); # execute statment in database
    mysqli_stmt_close($stmt); # close statement

    header("location: ../subjects.php");
    exit();
}

else if(isset($_POST['no_times_work_submit'])) {
    # send notification to student declining

    $student_id = $_POST['student_id'];
    $tutor_id = $_POST['tutor_id'];
    $course_id = $_POST['course_id'];

    $notification_type = "tutor decline student";
    $notification_name = "Tutor Request Declined";
    $notification_data = "student_id=" . $student_id . "&tutor_id=" . $tutor_id . "&course_id=" . $course_id;

    $sql = "INSERT INTO notifications (user_id, notification_type, notification_name, notification_data) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "isss", $student_id, $notification_type, $notification_name, $notification_data);
    mysqli_stmt_execute($stmt); # execute statment in database
    mysqli_stmt_close($stmt); # close statement

    header("location: ../subjects.php");
    exit();

}



else if(isset($_POST['suggest-new-time-submit'])) {
    $day = $_POST["day"];
    $start_time = $_POST['start-time'];
    $end_time = $_POST['end-time'];

    $student_id = $_POST['student_id'];
    $tutor_id = $_POST['tutor_id'];
    $course_id = $_POST['course_id'];

    echo $day;
    echo $start_time;
    echo $end_time;
    echo $student_id;
    echo $tutor_id;
    echo $course_id;

    // addSuggestedTime($conn, $day, $start_time, $end_time, $student_id, $tutor_id, $course_id);

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

    # send notification to student to confirm the time
    $notification_type = "tutor suggest new time";
    $notification_name = "Confirm Meeting Time: " . getCourseName($conn, $course_id);

    $notification_data = "day=" . $day ."&start_time=" . $start_time . "&end_time=" . $end_time . "&course_id=" . $course_id . "&course_name=" . getCourseName($conn, $course_id) . "&student_id=" . $student_id . "&tutor_id=" . $tutor_id;

    $sql = "INSERT INTO notifications (user_id, notification_type, notification_name, notification_data) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../profile.php?error=statementfailed");
        // exit();
    }
    mysqli_stmt_bind_param($stmt, "isss", $student_id, $notification_type, $notification_name, $notification_data);
    mysqli_stmt_execute($stmt); # execute statment in database
    mysqli_stmt_close($stmt); # close statement

    # get notification id
    $sql = "SELECT * FROM notifications WHERE user_id=? AND notification_type=? AND notification_name=? AND notification_data=?;"; # sql statment
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "isss", $student_id, $notification_type, $notification_name, $notification_data); # bind data
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt); # the data collected from the SELECT sql statement

    $id;

    while($row = mysqli_fetch_assoc($result_data)) { # while there is data in the database
        $id = $row['id']; # append course name to array
    }

    # resolve notification
    $resolved = "true";
    $sql = "UPDATE notifications SET resolved=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../profile.php?error=statementfailed");
        // exit();
    }
    mysqli_stmt_bind_param($stmt, "si", $resolved, $id);
    mysqli_stmt_execute($stmt); # execute statment in database
    mysqli_stmt_close($stmt); # close statement
    
    // $sql = "DELETE FROM notifications WHERE resolved=?;";
    // $stmt = mysqli_stmt_init($conn);
    // if(!mysqli_stmt_prepare($stmt, $sql)) {
    //     // header("location: ../profile.php?error=statementfailed");
    //     // exit();
    // }
    // mysqli_stmt_bind_param($stmt, "s", $resolved);
    // mysqli_stmt_execute($stmt); # execute statment in database
    // mysqli_stmt_close($stmt); # close statement

    header("location: ../profile.php?suggestedtimeadded=true");
    exit();
}

else if(isset($_POST['accept-suggested-time-submit'])) {
    echo "accept-suggested-time-submit";
}
else if(isset($_POST['decline-suggested-time-submit'])) {
    echo "decline-suggested-time-submit";
}