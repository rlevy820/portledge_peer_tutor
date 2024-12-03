<?php

# the website knows the user is logged in by cheking if session variables exist. So to log out, we just destroy the session variables
session_start();
session_unset();
session_destroy();

# send user back to main page
header("location: ../index.php");
exit();