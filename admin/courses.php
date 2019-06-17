<?php 

session_start();

if($_SESSION['adminEmail'] == "")
{
   // not logged in
   header('Location: ../admin/login.php');
   exit();
}

require('model/courseDB.php');

$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
echo '<style type="text/css">
                #deleteAlert {
                    display: none;
                }
                #accessChange {
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "accessChange":
        echo '<style type="text/css">
                #accessChange {
                    display: block;
                }
              </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
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
                #accessChange {
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


        <nav  >

                <!-- Navbar Brand --><a href="index.php" >
                 <span>Knowlegde Calculator </span><strong>Admin</strong>
                <!-- Toggle Button-->
                <a id="toggle-btn" href="#" ><span></span><span></span><span></span></a>

              <!-- Navbar Menu -->
              <ul >
              
                <!-- Logout    -->
                <li ><a href="login.php" > <span >Logout</span><i ></i></a></li>
              </ul>

        </nav>
      </header>

        <!-- Side Navbar -->
        <nav  class="sidenav">
          <!-- Sidebar Header-->
          <div >
            <div >
              <h1 ><?php echo $_SESSION['fullName']; ?></h1>
              <p>Admin</p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span >Main</span>
          <ul >
            <li><a href="index.php"> Home </a></li>
            <li><a href="addUser.php"> Add User</a></li>
            <li><a href="courses.php"> Courses </a></li>
            <li><a href="addCourse.php"> Add Course</a></li>
            <li><a href="questions.php"> Question Bank </a></li>
            <li><a href="addQuestion.php"> Add Questions </a></li>
            <li><a href="login.php"> Login page </a></li>
          </ul>
        </nav>
      
        <div >
          <!-- Page Header-->

  <main class="main">

              <h2 >All Courses</h2>


          <section >
            <div >
              <div>
                  <h3>Courses Details</h3>
              </div>
              <div id="accessChange" role="alert">
                 User access to login has been changed!!
              </div>
              <div id="deleteAlert" role="alert">
                 Great, Course Successfully Deleted!!
              </div>
              <div >
                <div >                       
                  <table>
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Course Name</th>
                        <th>Number of Questions</th>
                        <th>Passing Marks</th>
                        <th>Is Active</th>
                        <th>Course Access Control</th>
                        <th>Delete Course</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $a = getAllCourse();
                         $b = 0;
                          foreach ($a as $info) {
                            
                          $b++;
                          echo "<tr>";
                          echo "<td>".$b. "<br>"."</td>";
                          echo "<td>".$info['courseName']."</td>";
                          echo "<td>".getNumberOfQuestionWithCourseName($info['courseName'])."</td>";
                          echo "<td>".$info['passingMarks']."</td>";
                          // echo "<td>".$info['isCourseActive']."</td>";
                          if ($info['isCourseActive']) {
                                echo "<td>"."Yes"."</td>";
                              }
                              else{
                                echo "<td>"."No"."</td>";
                              }

                          echo '<td><button type="button"  data-toggle="tooltip" data-placement="top" title="Active/Disable Course">
                                 <a style="color: white;" href="../admin/deletion/changeCourseAccess.php?id='.urlencode($info['courseName']).'">Course Access</a>
                              </button> </td>';

                          echo '<td><button type="button"  data-toggle="tooltip" data-placement="top" title="Deleting Course will delete all questions in this course as well">
                                 <a style="color: white;" href="../admin/deletion/deleteCourse.php?id='.urlencode($info['courseName']).'">Delete Course</a>
                            </button> </td>';

                            echo " </tr>";
                        }
                      ?>
                   </tbody>
                  </table>
                </div>
              </div>
            </div>
            
          </section>
        </div>
        </main>
  </body>
</html>