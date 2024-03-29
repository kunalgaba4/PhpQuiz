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
      <link rel="stylesheet" href="css/dashboard.css">


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
    <div>
        <h2>Dashboard</h2>
    </div>
    <!-- Dashboard Counts Section-->
    <div>
        <div class="pure-u-1 pure-u-md-1-3">
            <div class="column-block">
                <div class="column-block-header column-success">
                    <h2 >Total<br>Passed users
                        <br><?php echo count(getAllPassedUsers()); ?> </h2>
                </div>
            </div>
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
            <div class="column-block">
                <div class="column-block-header column-warning">

                    <h2 class="column-block-info">Total<br>Failed users
                        <br><?php echo count(getAllFailedUsers()); ?></h2>
                </div>
            </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-3">
            <div class="column-block">
                <div class="column-block-header">

                    <h2 class="column-block-info">All<br>Active Users
                        <br><?php echo getAllActiveUsers(); ?></h2>
                </div>
            </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-3">
            <div class="column-block">
                <div class="column-block-header column-success">

                    <h2 class="column-block-info">Average <br>Scores
                        <br><?php echo round(getAvgScore(),2); ?></h2>
                </div>
            </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-3">
            <div class="column-block">
                <div class="column-block-header column-warning">

                    <h2 class="column-block-info">Total users
                        <br><?php echo count(getAllUsers()); ?></h2>
                </div>
            </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-3">
            <div class="column-block">
                <div class="column-block-header column-warning">

                    <h2 class="column-block-info">Total courses
                        <br><?php echo count(getAllCourse()); ?></h2>
                </div>
            </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-3">
            <div class="column-block">
                <div class="column-block-header column-success">

                    <h2 class="column-block-info">Active courses
                        <br><?php echo count(getAllActiveCourse()); ?></h2>
                </div>
            </div>
        </div>
        <div class="pure-u-1 pure-u-md-1-3">
            <div class="column-block">
                <div class="column-block-header">

                    <h2 class="column-block-info">User Count
                        <br><?php echo $_SESSION["user_count"]; ?></h2>
                </div>
            </div>
        </div>

    </div>



    <!----------All User Attempts in quiz  no-padding-top   -->
    <section>
        <div>
            <div>
                <div>
                    <h3 >All Users who appeared for Quiz</h3>
                </div>
                <div class="pure-g">
                    <div class="pure-u-1 pure-u-md-1-3">
                        <div class="column-block">
                            <table class="pure-table pure-table-horizontal">
                                <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Score</th>
                                    <th>Date</th>
                                    <th>Course Name</th>
                                </tr>
                                </thead>
                                <tbody>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="pure-u-1 pure-u-md-2-3">
            <div class="column-block">
                <table class="pure-table pure-table-horizontal">
                    <div>
                        <h3>All Users</h3>
                    </div>
                    <div id="accessChange" role="alert">
                        User access to login has been changed!!
                    </div>
                    <div id="deleteAlert1" role="alert">
                        User deleted permanently !!
                    </div>
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
    </section>

    </main>
  </body>
</html>