
<?php 

session_start();

require('model/database.php');
  /* exit if user not logged in already */
  if(!isset($_SESSION['user_email']))
{
    // not logged in
    header('Location: login.php');
    exit();
}


$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #updateProfileForm {
                    display: block;
                }
                #noUpdateAlert{
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "update":
        echo "update";
        echo '<style type="text/css">
                #updateAlert {
                    display: block;
                }
                #updateProfileForm {
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
                #updateProfileForm {
                    display: none;
                }
                #noUpdateAlert{
                    display: block;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;

  
    default:
        // echo "Form";
        echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: none;
                }
                #updateProfileForm {
                    display: block;
                }
                #noUpdateAlert{
                    display: none;
                }
                </style>';
}


function getUserAttempt($email){
  
  global $db;

  $query1 = 'SELECT _courseId, date1, score FROM testattempt WHERE email = :email';
  $statement1 = $db->prepare($query1);
  $statement1->bindValue(':email', $email);
  $statement1->execute();
  $dataFetching = $statement1->fetchAll();
  $statement1->closeCursor();
  return $dataFetching;
}


  function getUserName($email){
      global $db;
      $query = "SELECT firstName, lastName FROM user WHERE email = '$email'";

      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      // print_r($data);
      return $data;   
  }


  function getCourseName($courseId){
      global $db;
      $query = "SELECT courseName FROM courses WHERE courseId = '$courseId'";

      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      // print_r($data);
      return $data['courseName'];   
  }

?>

<!DOCTYPE html>
<html>
  <head>

      <title>Online Exam</title>
      <link rel="stylesheet" href="css/style.basic.css">
      <link rel="stylesheet" href="css/main.css">

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
      <main class="main">

                <h2 > Quiz Attempts </h2>
                <h3 class="h4">Attempt Details</h3>
                <div id="updateProfileForm" >
                    <form action="quizattempt.php" method="post" >
                    <table >
                      <thead>
                        <tr>
                        
                          <th>Course Name</th>
                          <th>Score</th>
                          <th>Date</th>
                          <!-- <th>Action</th> -->
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                            $a = getUserAttempt($_SESSION['user_email']);                           

                            foreach ($a as $info) {
                              $attemptDate = Date("Y-m-d", strtotime($info['date1']));
                              $courseName = getCourseName($info['_courseId']);
                              echo "<tr>";
                              echo "<td>".$courseName."</td>";
                              echo "<td>".$info['score']. "<br>"."</td>";
                              echo "<td>".$attemptDate."</td>";
                              echo " </tr>";
                            }
                          ?>
                        </tbody>
                    </table>
                  </div>
                </div>
                    </form>
                           <div class="alert alert-success" id="updateAlert" role="alert" >
                               Great, User Successfully Updated!!
                           </div>
                           <div class="alert alert-danger" id="noUpdateAlert" role="alert">
                               Updation Failed! <br>No such user exists!!
                           </div>


        </main>


  </body>
</html>