<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
</head>
<body>
    <div class="sign-up-div"> <!-- signup div -->

        <h1>Signup</h1>

        <form action="includes/sign-up.inc.php" method="post">

            <label for="first-name">First Name</label> <!-- label for id="first name" -->
            <input type="text" name="first_name" id="first-name" placeholder="First Name" required></input><br> <!-- input for first name -->

            <label for="last-name">Last Name</label>
            <input type="text" name="last_name" id="last-name" placeholder="Last Name" required></input><br>

            <label for="email">Portledge Email</label>
            <input type="email" name="email" id="email" placeholder="Portledge Email" required></input><br>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required></input><br>

            <label for="password-repeat">Repeat Password</label>
            <input type="password" name="password_repeat" id="password-repeat" placeholder="Repeat Password" required></input><br>
            
            <button type="submit" name="sign_up_submit">Next</button> <!-- button that submits the form button -->
        
        </form>

        <a href="login.php">Already have an account? Login!</a>

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
    p {
        font-size: 20px;
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