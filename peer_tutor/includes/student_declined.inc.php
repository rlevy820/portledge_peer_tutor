<?php

session_start();

require "connection.inc.php";
require "functions.inc.php";

$resolved = "true";
$notification_data = $_POST['not_data'];
$student_id = $_POST['studentid'];

$sql = "UPDATE notifications SET resolved=? WHERE user_id=? AND notification_data=?;"; 
$stmt = mysqli_stmt_init($conn); 
if(!mysqli_stmt_prepare($stmt, $sql)) { 
    header("location: ../profile.php?error=statementfailed"); 
    exit();
}
mysqli_stmt_bind_param($stmt, "sis", $resolved, $student_id, $notification_data);
mysqli_stmt_execute($stmt); 
mysqli_stmt_close($stmt);

header("location: ../profile.php");
exit();

?>