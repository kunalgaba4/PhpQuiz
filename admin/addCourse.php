<?php  

session_start();

if($_SESSION['adminEmail'] == "")
{
   // not logged in
   header('Location: ../admin/login.php');
   exit();
}


$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: none;
                }
                #addCourseForm {
                    display: block;
                }
                #noUpdateAlert{
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "update":
        echo '<style type="text/css">
                #updateAlert {
                    display: block;
                }
                #saveAlert {
                    display: none;
                }
                #addCourseForm {
                    display: none;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;

    case "noUpdate":
        echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: none;
                }
                #addCourseForm {
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
        echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: block;
                }
                #addCourseForm {
                    display: none;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
    default:
        echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: none;
                }
                #addUserForm {
                    display: block;
                }
                #noUpdateAlert{
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

  <div id="saveAlert" role="alert" >
      Great, New Course Successfully Added!!
  </div>
  <div id="updateAlert" role="alert">
      Great, Course Successfully Updated!!
  </div>
  <div id="noUpdateAlert" role="alert">
      Updation Failed! <br>No such course exists!!
  </div>


  <div class="log-form">
      <div id="addCourseForm">
          <h2>Login to your account</h2>
          <form action="../admin/model/dataValidationCourse.php" method="post">
              <label >Course Details</label>
              Enter Course Name
              <input id="courseName" type="text" name="courseName" required>
              Enter Passing Marks
              <input id="passingMarks" type="number" name="passingMarks" required>
              <label >Course Access <br><small >Access to course by users</small></label>
              <br/>Active
              <input id="optionsRadios1" type="radio" checked="" value="1" name="courseAccess">
              Inactive
              <input id="optionsRadios2" type="radio" value="0" name="courseAccess">

              <input type="submit"  name="saveCourse" value="Save Course" class="btn">
              <input type="submit"  name="updateCourse" value="Update Course" class="btn">
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
</script>

  </body>
</html>