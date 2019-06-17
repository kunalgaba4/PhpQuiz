<?php 

session_start();

if($_SESSION['adminEmail'] == "")
{
   // not logged in
   header('Location: ../admin/login.php');
   exit();
}


require('model/questionDB.php');
$GLOBALS['$questionId'] = "";
$GLOBALS['$questionData']['courseName'] = "";
$GLOBALS['$questionData']['question'] = "";
$GLOBALS['$questionData']['option1'] = "";
$GLOBALS['$questionData']['option2'] = "";
$GLOBALS['$questionData']['option3'] = "";
$GLOBALS['$questionData']['option4'] = "";
$GLOBALS['$questionData']['correctOption'] = "";

if (isset($_GET['id'])) {
    $GLOBALS['$questionId'] = $_GET['id'];

    $GLOBALS['$questionData'] = getQuestionWithQuestionId($GLOBALS['$questionId']);
}


$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: none;
                }
                #addQuestionForm {
                    display: block;
                }
                #noUpdateAlert{
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "update":
        // echo "update";
        echo '<style type="text/css">
                #updateAlert {
                    display: block;
                }
                #addQuestionForm {
                    display: none;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
    case "noUpdate":
        echo '<style type="text/css">
                #addQuestionForm {
                    display: none;
                }
                #noUpdateAlert{
                    display: block;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;

    case "save":
        // echo "Save";
        echo '<style type="text/css">
                #saveAlert {
                    display: block;
                }
                #addQuestionForm {
                    display: none;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
    default:
        // echo "Form";
        echo '<style type="text/css">
                #addQuestionForm {
                    display: block;
                }
                </style>';
}
?>



<!DOCTYPE html>
<html>
  <head>

    <title>Challengerz quiz</title>
      <link rel="stylesheet" href="css/style.basic.css">
      <link rel="stylesheet" href="../courses/css/main.css">
      <link rel="stylesheet" href="css/addUser.css">


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

<div id="saveAlert" role="alert">
    Great, New Question Successfully Added!!
</div>
<div id="updateAlert" role="alert">
    Great, Question Successfully Updated!!
</div>
<div id="noUpdateAlert" role="alert">
    Updation Failed! <br>No such question exists!!
</div>


<div class="log-form" style="margin-top: 6%">
    <div id="addQuestionForm" >
        <h2>Question</h2>
        <form action="../admin/model/dataValidationQuestion.php" method="post">
            <label>Course & Question</label>
            Course Name
            <input id="courseName" type="text" name="courseName" required  value="<?php print_r($GLOBALS['$questionData']['courseName']); ?>">
            New Question
            <input id="newQuestion" type="text" name="question" required  value="<?php print_r($GLOBALS['$questionData']['question']); ?>">
            <label>Options</label>
            Option 1
            <input id="option1" type="text" name="option1" required value="<?php print_r($GLOBALS['$questionData']['option1']); ?>">
            Option 2
            <input id="option2" type="text" name="option2" required value="<?php print_r($GLOBALS['$questionData']['option2']); ?>">
            Option 3
            <input id="option3" type="text" name="option3" required value="<?php print_r($GLOBALS['$questionData']['option3']); ?>">
            Option 4
            <input id="option4" type="text" name="option4" required value="<?php print_r($GLOBALS['$questionData']['option4']); ?>">
            <label>Correct Options</label>
            <input id="correctOption" type="text" name="correctOption" required value="<?php print_r($GLOBALS['$questionData']['correctOption']); ?>">
            <input type="submit"  name="saveQuestion" value="Save Question" class="btn">
            <input type="submit"  name="updateQuestion" value="Update Question" class="btn">
        </form>
    </div>


</div>
    <script>
    function myFunction() {
    var x = document.getElementById("successAlert");
    var y = document.getElementById("failAlert");
      if (x.style.display === "none")             // check the data from the data base an then send alerts
      {
          x.style.display = "block";
      } else {
          x.style.display = "none";
      }
    }
  </body>
</html>