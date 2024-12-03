<?php 

session_start();

require 'includes/connection.inc.php'; # get access to database
require 'includes/functions.inc.php'; # get access to functions
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- include JQuery -->
    <link rel="stylesheet" href="css/styles.css">
    <title>Availability</title>
</head>
<script>
    $(document).ready(function() {
        $(".add-time-div").hide();
        $(".cancel-btn").hide();

        $(".add-time").click(function() { 
            $(".add-time-div").show();
            $(".cancel-btn").show();
        });
        $(".cancel-btn").click(function() {
            $(".add-time-div").hide();
            $(".cancel-btn").hide();
        });
    });
</script>
<style>
    .add-time-div {
        width: 200px;
        background-color: #dddddd;
        border-radius: 15px;
        padding: 30px;
        margin: 20px;
        color: #00337f;
        word-wrap: break-word;
        box-shadow: 3px 5px 20px black;
    }
</style>
<body>

    <div class="sign-up-div">

            <p class="title">Add your availilbilty (your free periods)</p>
            <p style='text-align: center;'>You can always change this in your profile settings, but you will need to set this before scheduling meetings</p>

            <center><button class="add-time">Add Available Time</button>  <button class="cancel-btn">Cancel</button> <br><center>
            <div class="add-time-div">
                <form action='includes/user-availability.inc.php' method='post'>
                    <label for="day">Day</label>
                    <select name="day">
                        <option value="Monday" name="monday">Monday</option>
                        <option value="Tuesday" name="tuesday">Tuesday</option>
                        <option value="Wednesday" name="wednesday">Wednesday</option>
                        <option value="Thursday" name="thursday">Thursday</option>
                        <option value="Friday" name="friday">Friday</option>
                    </select><br>

                    <label for="start-time">Start Time</label>
                    <input type='time' name='start-time' required></input><br>
                    
                    <label for="end-time">End Time</label>
                    <input type='time' name='end-time' required></input><br>


                    <button type="submit" name="add_time_submit" class="add-time-submit">Add Time</button>
                </form>
            </div><br>

            <div class="created-times">
                <?php
                    $availability = getAvailability($conn, $_SESSION['user_id']);
                    if(empty($availability)) {
                        print("empty");
                    }
                    foreach($availability as $time_slot) {
                        ?>

                        <div class="profile-time-slot" style="background-color: #dddddd; padding: 10px; margin-bottom: 10px; border-radius: 10px; width: 300px;">
                            <p class="profile-time-slot-start time"> <?php echo $time_slot[0] . ": " . date('h:i A', strtotime($time_slot[1])) . " to " . date('h:i A', strtotime($time_slot[2])); ?> </p>
                        </div>

                        <?php
                    }
                ?>
            </div>

             <!-- <div class=".add-time-div">
                <form action="includes/user-availability.inc.php" method="post">

                    <label for="day">Day</label>
                    <select name="day">
                        <option value="Monday" name="monday">Monday</option>
                        <option value="Tuesday" name="tuesday">Tuesday</option>
                        <option value="Wednesday" name="wednesday">Wednesday</option>
                        <option value="Thursday" name="thursday">Thursday</option>
                        <option value="Friday" name="friday">Friday</option>
                    </select><br>

                    <label for="start-time">Start Time</label>
                    <input type='time' name='start-time' required></input><br>
                    
                    <label for="end-time">End Time</label>
                    <input type='time' name='end-time' required></input><br>


                    <button type="submit" name="add_time_submit" class="add-time-submit">Add Time</button>
                    <button class="cancel-add-time-submit">Cancel</button><br><br>
                </form>
            </div> -->

            <button onClick="window.location.href='index.php'">Done</button> 

    </div>

</body>
<!-- <body>
    <div class="sign-up-div"> 

        <form action="includes/user-availability.inc.php" method="post">

            <p>Select your availilbilty (your free times)</p>
            <p>You can always change this in your profile settings, but you will need to set this before scheduling meetings</p>

            <div class="week-days-table">

                <div class="week-column monday">
                    <p class="day-of-the-week">Monday</p>
                    <div class="times-monday">
                        
                    </div>
                    <input type='button' class="add-new-time-monday add-new-time" value='✚'> Add new times</input>
                </div>

                <div class="week-column tuesday">
                    <p class="day-of-the-week">Tuesday</p>
                    <div class="times-tuesday">
                        
                    </div>
                    <input type='button' class="add-new-time-tuesday add-new-time" value='✚'> Add new times</input>
                </div>

                <div class="week-column wednesday">
                    <p class="day-of-the-week">Wednesday</p>
                    <div class="times-wednesday">
                        
                    </div>
                    <input type='button' class="add-new-time-wednesday add-new-time" value='✚'> Add new times</input>
                </div>

                <div class="week-column thursday">
                    <p class="day-of-the-week">Thursday</p>
                    <div class="times-thursday">
                        
                    </div>
                    <input type='button' class="add-new-time-thursday add-new-time" value='✚'> Add new times</input>
                </div>

                <div class="week-column friday">
                    <p class="day-of-the-week">Friday</p>
                    <div class="times-friday">
                        
                    </div>
                    <input type='button' class="add-new-time-friday add-new-time" value='✚'> Add new times</input>
                </div>

            </div>
            
            <button type="submit" name="set_availability_submit" class="set-availability-submit">Next</button> 

        </form>

        <a href="index.php">Choose Later</a>

    </div>
</body> -->
</html>
<style>
    .title {
        font-size: 20px;
        text-align: center;
        color: #00337f;
        font-weight: bold;
    }
    button {
        background-color: #00337f;
        border: none;
        color: white;
        padding: 12px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
        margin: 10px 0;
        border-radius: 5px;
    }
    button:hover {
        box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
    }

</style>

<?php include "footer.php"; ?>