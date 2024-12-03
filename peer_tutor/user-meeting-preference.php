<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Meeting Preference Selection</title>
</head>
<body>
    <div class="sign-up-div"> 

        <form action="includes/user-meeting-preference.inc.php" method="post">

            <p class="title">Select your meeting preference</p>
            <p class="second">You can always change this in your profile settings</p>

            <center><select name="user_meeting_preference">
                <option value="In Person">In Person</option>
                <option value="Online">Online</option>
                <option value="No Preference">No Preference</option>
            </select><center>
            
            <button type="submit" name="select_meeting_preference_submit">Next</button> <br>

        </form>

        <a href="user-meeting-preference.php">Choose Later</a>

    </div>
</body>
</html>
<style>
    html {
        background-color: #ededed;
    }
    .sign-up-div {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);

        padding: 5px 20px 20px 20px;
        background-color: #dddddd;
        border-radius: 20px;
    }
    .title {
        font-size: 20px;
        text-align: center;
        color: #00337f;
        font-weight: bold;
    }
    .second {
        font-size: 15px;
        text-align: center;
        color: #00337f;
        font-weight: bold;
    }
    input {
        width: 100%;
        padding: 12px 10px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 1px solid #555;
        outline: none;
    }
    input:focus {
        background-color: lightblue;
    }
    label {
        font-size: 15px;
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