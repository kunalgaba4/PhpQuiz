<?php

session_start();

if ($_SESSION['adminEmail'] == "") {
    // not logged in
    header('Location: ../admin/login.php');
    exit();
}


require('model/courseDB.php');
require('model/questionDB.php');

$GLOBALS['$courseName'] = "Fun & IQ";
if (isset($_GET['id'])) {
    $GLOBALS['$courseName'] = $_GET['id'];
}

$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');
echo '<style type="text/css">
                #deleteAlert {
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "deleteAlert":
        echo '<style type="text/css">
                #deleteAlert {
                    display: block;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
    default:
        echo '<style type="text/css">
                #deleteAlert {
                    display: none;
                }
                </style>';
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Online Exam</title>
    <link rel="stylesheet" href="css/style.basic.css">
    <link rel="stylesheet" href="../courses/css/main.css">

</head>
<body>
<header>
    <div class="topnav">
        <a href="#">Changerz Quiz</a>
        <a href="index.php">Home </a>
        <a href="addUser.php">Add User</a>
        <a href="courses.php">Courses </a>
        <a href="addCourse.php">Add Course</a>
        <a href="questions.php">Question Bank </a>
        <a href="addQuestion.php">Add Questions </a>
        <a href="login.php" style="float: right">
            <?php
            echo $_SESSION['fullName'];
            ?>, Logout</a>
    </div>
</header>

<main style="margin: 3%">

    <h2>All Courses</h2>

    <section>
        <div role="group">
            <?php
            $a = getAllCourse();
            foreach ($a as $info) {
                echo '<button ><a href="../admin/questions.php?id=' . urlencode($info['courseName']) . '">' . $info['courseName'] . '</a></button>';
            }
            ?>
        </div>

        <div>

            <h3>Questions</h3>

            <div id="deleteAlert" role="alert">
                Great, Question Successfully Deleted!!
            </div>

            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Question</th>
                    <th>Option1</th>
                    <th>Option2</th>
                    <th>Option3</th>
                    <th>Option4</th>
                    <th>Correct Option</th>
                    <th>Edit Question</th>
                    <th>Delete Question</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $a = getQuestionsWithCourseName($GLOBALS['$courseName']);
                $b = 0;
                foreach ($a as $info) {
                    $b++;
                    echo "<tr>";
                    echo "<td>" . $b . "<br>" . "</td>";
                    echo "<td>" . $info['courseName'] . "</td>";
                    echo "<td>" . $info['question'] . "</td>";
                    echo "<td>" . $info['option1'] . "</td>";
                    echo "<td>" . $info['option2'] . "</td>";
                    echo "<td>" . $info['option3'] . "</td>";
                    echo "<td>" . $info['option4'] . "</td>";
                    echo "<td>" . $info['correctOption'] . "</td>";
                    echo '<td><button type="button"  data-toggle="tooltip" data-placement="top" title="Click to edit the Question details">
                                 <a style="color: black;" href="addQuestion.php?id=' . urlencode($info['questionId']) . '">Edit</a>
                            </button> </td>';
                    echo '<td><button type="button"  data-toggle="tooltip" data-placement="top" title="Clicking Delete will delete the Question permanently">
                                 <a style="color: black;" href="../admin/deletion/deleteQuestion.php?id=' . urlencode($info['questionId']) . '">Delete</a>
                            </button> </td>';
                    echo " </tr>";
                }
                ?>
                </tbody>
            </table>


        </div>
    </section>
</main>
</body>
</html>