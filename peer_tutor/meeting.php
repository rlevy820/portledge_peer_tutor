<?php 

session_start();
require "header.php";
require "includes/connection.inc.php";
require "includes/functions.inc.php";

$user_data = getUserInformation($conn, $_SESSION['user_id']);

// if(strpos($start_time, 'A') !== false) {
//     $start_time = str_replace('A', ' A', $start_time);
// } else if(strpos($start_time, 'P') !== false) {
//     $start_time = str_replace('P', ' P', $start_time);
// }

// if(strpos($end_time, 'A') !== false) {
//     $end_time = str_replace('A', ' A', $end_time);
// } else if(strpos($end_time, 'P') !== false) {
//     $end_time = str_replace('P', ' P', $end_time);
// }

// getMeetingsTutor($conn, $user_id) getMeetingsStudent($conn, $user_id)

?>

<p><strong>Meetings</strong></p>

<div class="meetings">
        <?php
            $meetingsTutor = getMeetingsTutor($conn, $_SESSION['user_id']);
            $meetingsStudent = getMeetingsStudent($conn, $_SESSION['user_id']);

            foreach($meetingsTutor as $meeting) {
                ?>

                <div class="meeting" style="background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;">
                    <span> Tutor &ensp; </span>
                    
                    <span> <?php echo $meeting[3]; ?>  with <?php echo getName($conn, $meeting[0]); ?> from </span>
                    <span> <?php echo date('h:i A', strtotime($meeting[4])); ?> </span>
                    <span> to </span>
                    <span> <?php echo date('h:i A', strtotime($meeting[5])); ?> </span>
                    
                    <span> &ensp; <?php echo $meeting[6]; ?> </span>
                </div><br>

                <?php
            }

            foreach($meetingsStudent as $meeting) {
                ?>

                <div class="meeting" style="background-color: #dddddd; padding: 10px 20px; margin-bottom: 10px; border-radius: 10px; min-width:100px; display: inline-block;">
                    <span> Student &ensp; </span>
                    
                    <span> <?php echo $meeting[3]; ?> with <?php echo getName($conn, $meeting[1]); ?> from </span>
                    <span> <?php echo date('h:i A', strtotime($meeting[4])); ?> </span>
                    <span> to </span>
                    <span> <?php echo date('h:i A', strtotime($meeting[5])); ?> </span>
                    
                    <span> &ensp; <?php echo $meeting[6]; ?> </span>
                </div><br>

                <?php
            }
        ?>
    </div>

<?php include "footer.php"; ?>
