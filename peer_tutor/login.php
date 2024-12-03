

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <div class="login-div"> <!-- login div -->

        <p>Login</p>

        <form action="includes/login.inc.php" method="post"> 
        <!-- form data will be sent to file named includes/login.inc.php and it will be send 
        through the post method: ex. i can retrieve the data under the name="username" with $_POST['username']  -->
            
            <label for="username">Username or Email</label> <br> <!-- label for id="username" -->
            <input type="text" name="username" id="username" placeholder="Username or Email" required></input><br> <!-- input for usename or email -->

            <label for="password">Password</label> <br>
            <input type="password" name="password" id="password" placeholder="Password" required></input><br> 

            <button type="submit" name="login_submit">Login</button> <!-- button that submits the form button -->

        </form>

        <!-- <a href="includes/enter-email-forgot-password.inc.php">Forgot your password?</a> &ensp; &ensp; &ensp; -->

        &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;

        <a href="sign-up.php">Don't have an account? Sign up!</a>

    </div>
</body>
</html>

<?php include "footer.php"; ?>

<style>
    html {
        background-color: #ededed;
    }
    .login-div {
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