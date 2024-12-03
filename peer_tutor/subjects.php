<?php 

session_start(); 
include "header.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subjects</title>
</head>
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

    <center><div><h2 style="color: #00337f">Welcome to Portledge Peer Tutor</h2></div></center>
</body>
</html>

<?php include "footer.php"; ?>