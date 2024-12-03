<?php

session_start(); 
include "header.php";
require "includes/functions.inc.php";
require "includes/connection.inc.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subjects</title>
</head>
<script>
    $(document).ready(function() {
        $(".path-tutor").hide(); // begin to hide path tutor div
        $(".path-student").hide(); // begin to hide path student div

        $(".tutor-btn").click(function() { // on click of button with class tutor-btn
            $(".path-tutor").show(); // show tutor path div
            $(".path-student").hide(); // hide student path div
        });
        $(".be-tutored-btn").click(function() {
            $(".path-tutor").hide();
            $(".path-student").show();
        });
    });
</script>
<style>
    .subject-nav-div ul li {
        float: left;
        width: 12.5%;
        text-align: center;
    }
</style>
<body>
    <div class="subject-nav-div">
        <div class="column">
            <ul>

                <div class="row math">
                    <li class="dropdown">
                        <a class="dropdown-btn">Math ▾</a>
                        <div class="dropdown-content">
                            <a href="subject-topic-page.php?subjectchild=Geometry&subject=Math">Geometry</a>
                            <a href="subject-topic-page.php?subjectchild=Algebra&subject=Math">Algebra</a>
                            <a href="subject-topic-page.php?subjectchild=Calculus&subject=Math">Calculus</a>
                            <a href="subject-topic-page.php?subjectchild=AP&subject=Math">AP</a>
                            <a href="subject-topic-page.php?subjectchild=IB&subject=Math">IB</a>
                        </div>
                    </li>
                </div>

                <div class="row english">
                    <li class="dropdown">
                        <a class="dropdown-btn">English ▾</a>
                        <div class="dropdown-content">
                            <a href="subject-topic-page.php?subjectchild=EnglishCourses&subject=English">English Courses</a>
                        </div>
                    </li>
                </div>

                <div class="row science">
                    <li class="dropdown">
                        <a class="dropdown-btn">Science ▾</a>
                        <div class="dropdown-content">
                            <a href="subject-topic-page.php?subjectchild=Biology&subject=Science">Biology</a>
                            <a href="subject-topic-page.php?subjectchild=Chemistry&subject=Science">Chemistry</a>
                            <a href="subject-topic-page.php?subjectchild=Physics&subject=Science">Physics</a>
                            <a href="subject-topic-page.php?subjectchild=AP&subject=Science">AP</a>
                            <a href="subject-topic-page.php?subjectchild=IB&subject=Science">IB</a>
                            <a href="subject-topic-page.php?subjectchild=Other&subject=Science">Other</a>
                        </div>
                    </li>
                </div>

                <div class="row history">
                    <li class="dropdown">
                        <a class="dropdown-btn">History ▾</a>
                        <div class="dropdown-content">
                            <a href="subject-topic-page.php?subjectchild=HistoryCourses&subject=History">History Courses</a>
                        </div>
                    </li>
                </div>

                <div class="row language">
                    <li class="dropdown">
                        <a class="dropdown-btn">Language ▾</a>
                        <div class="dropdown-content">
                            <a href="subject-topic-page.php?subjectchild=French&subject=Language">French</a>
                            <a href="subject-topic-page.php?subjectchild=Spanish&subject=Language">Spanish</a>
                            <a href="subject-topic-page.php?subjectchild=Mandarin&subject=Language">Mandarin</a>
                            <a href="subject-topic-page.php?subjectchild=Other&subject=Language">Other</a>
                        </div>
                    </li>
                </div>

                <div class="row comp_sci">
                    <li class="dropdown">
                        <a class="dropdown-btn">Comp Sci ▾</a>
                        <div class="dropdown-content">
                            <a href="subject-topic-page.php?subjectchild=CompSciCourses&subject=CompSci">Comp Sci Courses</a>
                        </div>
                    </li>
                </div>

                <div class="row arts">
                    <li class="dropdown">
                        <a class="dropdown-btn">Arts ▾</a>
                        <div class="dropdown-content">
                            <a href="subject-topic-page.php?subjectchild=TheatreCourses&subject=Arts">Theatre</a>
                            <a href="subject-topic-page.php?subjectchild=ArtCourses&subject=Arts">Art</a>
                            <a href="subject-topic-page.php?subjectchild=Music&subject=Arts">Music</a>
                        </div>
                    </li>
                </div>

                <div class="row ib">
                    <li class="dropdown">
                        <a class="dropdown-btn">IB ▾</a>
                            <div class="dropdown-content">
                                <a href="subject-topic-page.php?subjectchild=CoreIB&subject=IB">Core IB</a>
                            </div>
                            
                        </div>
                    </li>
                </div>

            </ul>
        </div>
    </div>

    <p style='font-size: 20px;
        text-align: center;
        color: #00337f;
        font-weight: bold;'> <?php echo $_GET['coursename']; ?> </p>

    <div class="course-info-card">
        <!-- <p>Teacher: teacher_name</p>
        <p>Email: teacher_email</p> -->
        <center><button class="tutor-btn">Tutor</button><center>

        <?php 
            # check if there is a row in tutors with given class
            # check if, within those rows, there is a tutor who is verified
            $verified_tutor_id_array = checkVerifiedTutors($conn, getCourseId($conn, $_GET['coursename'])); # if there are tutors in this class that are verified
            if(!empty($verified_tutor_id_array)) {
                echo "<center><button class='be-tutored-btn'>Be Tutored</button><center><br>"; # show button that allows you to opern the "be tutored" div
            } else { # else
                echo "<button disabled class='be-tutored-btn'>Be Tutored</button><center><br>"; # show the button but disable it
            }
        ?>
    </div>

    <div class="path-tutor">
        <form action='includes/tutor-request.inc.php?coursename=<?php echo $_GET['coursename']?>' method='post'>
            <h3>Tutor</h3>
            <p>Describe why you think you would be a good tutor for this subject</p>
            <textarea name="description" class="description" required></textarea>
            <p class="note">*Note: this will be sent to the teacher of this course</p>
            <p>To become a tutor you must be verified by the teacher of this course. An email will be sent to them and you will be notified when they verify you</p>
            <button name="submit-tutor-request" type="submit">Request to be a tutor</button>
        </form>
    </div>


    <?php
        if(!empty($verified_tutor_id_array)) {
    ?>

        <div class="path-student">
            <form action='includes/be-tutored-request.inc.php?coursename=<?php echo $_GET['coursename']?>' method='post'>
                <h3>Student</h3>
                <p>List some of the topics in this course you need help with or what assignment you need help with</p>
                <textarea name="description" class="description" required></textarea>
                <p class="note">*Note: this will be sent to the path-tutor of this course</p>
                <label>Pick a tutor: </label>

                <select name="pick_tutor" required>
                    <?php

                        foreach($verified_tutor_id_array as $tutor_id) {
                            $verified_tutor_name =  getUserInformation($conn, $tutor_id)[0] . " " . getUserInformation($conn, $tutor_id)[1];
                            echo "<option class='tutor-option'> ". $verified_tutor_name . "  </option>";
                        }

                    ?>
                </select>
                <button type="submit" >Request to be a tutor</button>
            </form>
        </div>
        
    <?php
        }
    ?>

    <div class="error">
        <?php
            if(isset($_GET['error'])) {
                if($_GET['error'] == 'tutorexists') {
                    echo "<p>You are already a tutor for this subject.</p>";
                }
                if($_GET["error"] == "notavailable") {
                    echo "
                    <div>
                        <p>You must add available times before you request to be tutored.</p>
                        <p>Go to Profile > [Edit/Add Available Times]</p>
                    </div>
                    ";
                }
                if($_GET["error"] == "studentexists") {
                    echo "<p>You are already a student or tutor for this subject.</p>";
                }
                
            }
        ?>
    </div>
</body>
</html>
<style>
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