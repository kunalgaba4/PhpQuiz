<?php

session_start();
require('model/database.php');


/* exit if user not logged in already */
if (!isset($_SESSION['user_email'])) {
    // not logged in
    header('Location: login.php');
    exit();
}


function getAllCourses()
{
    global $db;
    $query = 'SELECT courseId, courseName, passingMarks FROM Courses
                WHERE isCourseActive = true
                ORDER BY courseId';
    $statement = $db->prepare($query);
    $statement->execute();
    $data = $statement->fetchAll();
    $statement->closeCursor();
    return $data;

}

function getHighestScore($courseId)
{
    global $db;
    $query = "SELECT max(score) FROM TestAttempt WHERE _courseId = '$courseId' limit 1";

    $statement = $db->prepare($query);
    $statement->execute();
    $data = $statement->fetch();
    $statement->closeCursor();
    return $data;
}


function getUserName($email)
{
    global $db;
    $query = "SELECT firstName, lastName FROM user WHERE email = '$email'";

    $statement = $db->prepare($query);
    $statement->execute();
    $data = $statement->fetch();
    $statement->closeCursor();
    // print_r($data);
    return $data;
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Exam</title>
    <link rel="stylesheet" href="css/style.basic.css">
    <link rel="stylesheet" href="css/main.css">


    <style type="text/css">
        a {
            text-decoration: none !important;
        }

    </style>

</head>
<body>

<header>

    <div class="topnav">
        <a href="#">Changerz Quiz</a>
        <a href="course.php"> Courses </a>
        <a href="profile.php"> Profile </a>
        <a href="quizattempt.php"> Quiz Attempts</a>
        <a href="login.php" style="float: right">
            <?php
            if (isset($_SESSION['user_email'])) {
                $user = getUserName($_SESSION['user_email']);
                echo $user['firstName'] . " " . $user['lastName'];
            }
            ?>, Logout</a>
    </div>
</header>

<main class="data" style="margin-left: 20%">
    <h2>Courses</h2>

        <?php $i = 0 ?>
        <?php $courses = getAllCourses(); ?>
        <?php foreach ($courses as $course):?>
        <?php $i = $i + 1; ?>
            <a href= <?php echo "../questions?id=" . $course['courseId'] ?>>
                <h2> <?php echo "Quiz " . $i ?> </h2>
                <h3><?php echo $course['courseName']; ?></h3>
                <?php
                $passingMarks = $course['passingMarks'];
                echo "Passing marks: " . $passingMarks . "<br>";
                $highScore = getHighestScore($course['courseId']);

                if (isset($highScore[0])) {
                    echo "Highest Score: " . $highScore[0];
                } else {
                    echo "Highest Score: " . 0;
                }; ?>
            </a>

    <?php endforeach; ?>


</main>


</body>
</html>