<?php 

session_start();

if($_SESSION['adminEmail'] == "")
{
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
</head>
  <body>

      <header >
        <nav >
                <!-- Navbar Brand --><a href="index.php" >
                  <span>Knowlegde Calculator </span><strong>Admin</strong>
                <!-- Toggle Button-->
                <a id="toggle-btn" href="#" ><span></span><span></span><span></span></a>

              <!-- Navbar Menu -->
              <ul >
              
                <!-- Logout    -->
                <li ><a href="login.php">Logout</a></li>
              </ul>

        </nav>
      </header>

        <!-- Side Navbar -->
        <nav class="sidenav" >

              <h1><?php echo $_SESSION['fullName']; ?></h1>
              <p>Admin</p>

          <!-- Sidebar Navidation Menus--><span >Main</span>
          <ul >
            <li><a href="index.php">Home </a></li>
            <li><a href="addUser.php">Add User</a></li>
            <li><a href="courses.php">Courses </a></li>
            <li><a href="addCourse.php">Add Course</a></li>
            <li><a href="questions.php">Question Bank </a></li>
            <li><a href="addQuestion.php">Add Questions </a></li>
            <li><a href="login.php">Login page </a></li>
          </ul>
        </nav>
      
<main class="main">

              <h2 >All Courses</h2>

          <!-- Breadcrumb-->
          <div >
            <ul >
              <li><a href="index.php">Home</a></li>
              <li>Question Bank   </li>
            </ul>
          </div>
          <section >
              <div role="group" aria-label="Basic example">
                <?php 
                  $a = getAllCourse();
                  foreach ($a as $info) {
                      echo '<button type="button" ><a style="color: white;" href="../admin/questions.php?id='.urlencode($info['courseName']).'">'.$info['courseName'].'</a></button>';
                    }
                ?>
              </div>
            <div>
              <div>
               <div>
                  <h3>Questions</h3>
                </div>
                <div id="deleteAlert" role="alert">
                 Great, Question Successfully Deleted!!
                </div>
                  <div >
                    <div>                       
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
                            echo "<td>".$b. "<br>"."</td>";
                            echo "<td>".$info['courseName']."</td>";
                            echo "<td>".$info['question']."</td>";
                            echo "<td>".$info['option1']."</td>";
                            echo "<td>".$info['option2']."</td>";
                            echo "<td>".$info['option3']."</td>";
                            echo "<td>".$info['option4']."</td>";
                            echo "<td>".$info['correctOption']."</td>";
                            // echo "<td>  <a href='addQuestion.php?id=".urlencode($info['questionId'])."'>Edit Question</a> </td>";
                            // echo "<td>  <a href='questions.php?id=id=".urlencode($info['questionId'])."'>Delete Question</a> </td>";
                            echo '<td><button type="button"  data-toggle="tooltip" data-placement="top" title="Click to edit the Question details">
                                 <a style="color: white;" href="addQuestion.php?id='.urlencode($info['questionId']).'">Edit</a>
                            </button> </td>';
                            echo '<td><button type="button"  data-toggle="tooltip" data-placement="top" title="Clicking Delete will delete the Question permanently">
                                 <a style="color: white;" href="../admin/deletion/deleteQuestion.php?id='.urlencode($info['questionId']).'">Delete</a>
                            </button> </td>';
                            echo " </tr>";
                          }
                        ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
          </section>
</main>
  </body>
</html>