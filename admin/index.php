<?php 

session_start();
require('model/homeDB.php');
require('model/courseDB.php');

if($_SESSION['adminEmail'] == "")
{
   // not logged in
   header('Location: ../admin/login.php');
   exit();
}

$GLOBALS['$sortDate'] = filter_input(INPUT_COOKIE, 'sortDate'); 
$GLOBALS['$sorting'] = "all";
$GLOBALS['$sortingData'] = [];


if (isset($_GET['id'])) {
    $GLOBALS['$sorting'] = $_GET['id'];
}

switch ($GLOBALS['$sorting']) {
  case 'all':
      $GLOBALS['$sortingData'] = getAllUsersAttempts();
    break;
  case 'highest':
      $GLOBALS['$sortingData'] = getAllUsersAttemptsOrderByHighest();
    break;
  case 'lowest':
      $GLOBALS['$sortingData'] = getAllUsersAttemptsOrderByLowest();
    break;
    case 'sortDate':
      $GLOBALS['$sortingData'] = getAllUsersByDate($GLOBALS['$sortDate']);
      $expire = strtotime('-1 year');
      setcookie('sortDate', '', $expire, '/');
    break;
  default:
       $GLOBALS['$sortingData'] = getAllUsersAttempts();
    break;
}

$btnCheck = filter_input(INPUT_COOKIE, 'btnCheckUser');  
echo '<style type="text/css">
        #deleteAlert1 {
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
        setcookie('btnCheckUser', '', $expire, '/');

        break;
    case "deleteAlert1":
        echo '<style type="text/css">
                #deleteAlert1 {
                    display: block;
                }
              </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheckUser', '', $expire, '/');

        break;
default:
        echo '<style type="text/css">
                #deleteAlert1 {
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
      <link rel="stylesheet" href="../courses/css/main.css">

  </head>
  <body onload="chartLoad()">
    <div>

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
      
<main class="main">
          <!-- Page Header-->
          <header >
            <div>
              <h2>Dashboard</h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
          <section>
            <div>
              <div >
                <!-- Item -->
                <div>
                  <div>
                    <div><span>Total<br>Passed users</span>
                      <div>
                        <div role="progressbar" style="width: <?php echo (count(getAllPassedUsers())/count(getAllUsersAttempts()))*100; ?>%; height: 4px;"></div>
                      </div>
                    </div>
                    <div><strong><?php echo count(getAllPassedUsers()); ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div>
                  <div>
                    <div><span>Total<br> Failed users</span>
                      <div>
                        <div role="progressbar" style="width: <?php echo (count(getAllFailedUsers())/count(getAllUsersAttempts()))*100; ?>%; height: 4px;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" ></div>
                      </div>
                    </div>
                    <div><strong><?php echo count(getAllFailedUsers()); ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div>
                  <div>
                    <div><span>All<br>Active Users</span>
                      <div>
                        <div role="progressbar" style="width: <?php echo (getAllActiveUsers()/count(getAllUsers()))*100; ?>%; height: 4px;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div><strong><?php echo getAllActiveUsers(); ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div>
                  <div>
                    <div><span>Average <br>Scores</span>
                      <div>
                        <div role="progressbar" style="width: <?php echo getAvgScore() * 10; ?>%; height: 4px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div><strong><?php echo round(getAvgScore(),2); ?></strong></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Dashboard Header Section    -->
          <section>
            <div >
              <div >
                <!-- Statistics -->
                <div>
                  <div >
                    <div style="padding: 12px;"></div>
                    <div><strong><?php echo count(getAllUsers()); ?></strong><br><small>Total users</small></div>
                  </div>
                 
                </div>
                <div>
                 <div>
                    <div style="padding: 12px;"></div>
                    <div><strong><?php echo count(getAllCourse()); ?></strong><br><small>Total courses</small></div>
                  </div>

                  </div>
                  <div>
                  <div>
                    <div style="padding: 12px;"></div>
                    <div><strong><?php echo count(getAllActiveCourse()); ?></strong><br><small>Active courses</small></div>
                  </div>

                </div>
              
                  <div>
                    <div style="padding: 12px;"></div>
                    <div><strong><?php echo $_SESSION["user_count"]; ?></strong><br><small>Users Writing Test</small></div>
                  </div>
                </div>
              </div>
            </div>
          </section>

  
<!----------All User Attempts in quiz  no-padding-top   -->
          <section>
            <div>
            <div>
               <div>
                  <h3 >All Users who appeared for Quiz</h3>
                </div>
                <div>
                      <h3>Sort data By</h3>
                    </div>
                  <div>
                    
                    <div role="group" aria-label="Basic example">
                      <?php  
                      echo '<button type="button"><a style="color: white;" href="../admin/index.php?id=all">All User Attempts</a></button>';
                      echo '<button type="button"><a style="color: white;" href="../admin/index.php?id=highest">Highest</a></button>';
                      echo '<button type="button"><a style="color: white;" href="../admin/index.php?id=lowest">Lowest</a></button>';
                     ?>
                    </div> 

                    <div>
                     <form action="../admin/model/dataValidationDate.php" autocomplete="off" method="post">
                      <div>
                        <input type="date1" name="sortDate"  title="d/m/Y" id="date1" placeholder="Select Date">
                      </div>
                      <button type="submit">Sort by Date</button>
                     </form>
                  </div>
              </div>
<!----------------- Tablse starts from here-->
                <div>
                  <div>                       
                    <table>
                      <thead>
                        <tr>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email</th>
                          <th>Phone Number</th>
                          <th>Score</th>
                          <th>Date</th>
                          <th>Course Name</th>
                          <!-- <th>Action</th> -->
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                            $a = $GLOBALS['$sortingData'];
                            foreach ($a as $info) {
                              echo "<tr>";
                              echo "<td>".$info['firstName']. "<br>"."</td>";
                              echo "<td>".$info['lastName']."</td>";
                              echo "<td>".$info['email']."</td>";
                              echo "<td>".$info['phoneNumber']."</td>";
                              echo "<td>".$info['score']."</td>";
                              echo "<td>".separateDataTime($info['date1'])."</td>";
                              echo "<td>".$info['courseName']."</td>";
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
<!----------All User from database     -->
           <section>
            <div>
            <div>
             <div>
                <h3>All Users</h3>
              </div>
              <div id="accessChange" role="alert">
                 User access to login has been changed!!
              </div>
              <div id="deleteAlert1" role="alert">
                 User deleted permanently !!
              </div>
                <div>
                  <div>                       
                    <table>
                      <thead>
                        <tr>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email</th>
                          <!-- <th>Password</th> -->
                          <th>Address</th>
                          <th>Phone Number</th>
                          <th>Is Active User</th>
                          <th>User Access control</th>
                          <th>Delete User</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                            $a = getAllUsers();
                            $salt = "8dC_9Kl?";
                            foreach ($a as $info) {
                              
                              echo "<tr>";
                              echo "<td>".$info['firstName']. "<br>"."</td>";
                              echo "<td>".$info['lastName']."</td>";
                              echo "<td>".$info['email']."</td>";
                              // echo "<td>".md5($info['password'].$salt) ."</td>";
                              echo "<td>".$info['address']."</td>";
                              echo "<td>".$info['phoneNumber']."</td>";

                              if ($info['isActive']) {
                                echo "<td>"."Yes"."</td>";
                              }
                              else{
                                echo "<td>"."No"."</td>";
                              }
                              echo '<td><button type="button" data-toggle="tooltip" data-placement="top" title="If pressed User access to login will change">
                                 <a style="color: white;" href="../admin/deletion/changeUserAccess.php?id='.$info['email'].'">Login Acess</a>
                              </button> </td>';
                             echo '<td><button type="button" data-toggle="tooltip" data-placement="top" title="This will delete the user Permanently">
                                 <a style="color: white;" href="../admin/deletion/deleteUser.php?id='.$info['email'].'">Delete</a>
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