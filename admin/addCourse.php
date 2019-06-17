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
  </head>
  <body>
    <div>
      <!-- Main Navbar-->
      <header>
        <nav>

                <!-- Navbar Brand -->
                <a href="index.php">
              <span>Online Exam</span><strong>Admin</strong>
                <!-- Toggle Button-->
                <a id="toggle-btn" href="#"><span></span><span></span><span></span></a>

              <!-- Navbar Menu -->
              <ul>
                <!-- Logout    -->
                <li><a href="login.php" > Logout</a></li>
              </ul>

        </nav>
      </header>

        <!-- Side Navbar -->
        <nav class="sidenav" >
          <!-- Sidebar Header-->

              <h1><?php echo $_SESSION['fullName']; ?></h1>
              <p>Admin</p>

          <ul >
            <li><a href="index.php"> Home </a></li>
            <li><a href="addUser.php"> Add User</a></li>
            <li><a href="courses.php"> Courses </a></li>
            <li><a href="addCourse.php"> Add Course</a></li>
            <li><a href="questions.php"> Question Bank </a></li>
            <li><a href="addQuestion.php"> Add Questions </a></li>
            <li><a href="login.php">Login page </a></li>
          </ul>
        </nav>
      
       <main class="main">
              <h2 >Forms</h2>
            



          <!-- Forms Section-->
          <section> 
            <div>
              <div>
                <!-- Form Elements -->
                <div>
                  <div >
                    <div >
                      <h3 >Add Course</h3>
                    </div>
                    <div >
<!-- ------------------ Form Starts here -->
                      <div id="saveAlert" role="alert" >
                           Great, New Course Successfully Added!!
                        </div>
                        <div id="updateAlert" role="alert">
                           Great, Course Successfully Updated!!
                        </div>
                        <div id="noUpdateAlert" role="alert">
                           Updation Failed! <br>No such course exists!!
                        </div>
                        <div id="addCourseForm" >
                      <form action="../admin/model/dataValidationCourse.php" method="post">
                        <div >
                          
                          <label >Course Details</label>
                          <div>
                            <div >
                              <input id="courseName" type="text" name="courseName" required>
                              <label for="courseName" >Subject Name      </label>
                            </div>
                           
                            <div >
                              <input id="passingMarks" type="number" name="passingMarks" required>
                              <label for="passingMarks" >Passing Marks</label>
                            </div>

                          </div>


                        </div>
                        <div>
                             <label >Course Access <br><small >Access to course by users</small></label>
                            <div >
                            <div>
                              <input id="optionsRadios1" type="radio" checked="" value="1" name="courseAccess">
                              <label for="optionsRadios1">Active</label>
                            </div>
                            <div>
                              <input id="optionsRadios2" type="radio" value="0" name="courseAccess">
                              <label for="optionsRadios2">Not Active</label>
                            </div>
                          </div>
                        </div>
                        <div>
                          <div>
                            <input type="submit"  name="saveCourse" value="Save Course">
                            <input type="submit"  name="updateCourse" value="Update Course">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

       </main>

    <!-- JavaScript files-->
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