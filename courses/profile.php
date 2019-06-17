
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

$userInfo = getUserInfo($_SESSION['user_email']);
$firstName = $userInfo['firstName'];
$lastName = $userInfo['lastName'];
$address = $userInfo['address'];
$phoneNumber = $userInfo['phoneNumber'];

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


function getUserInfo($email){
  
   global $db;

  $query1 = 'SELECT firstName, lastName, address, phoneNumber FROM User WHERE email = :email';
  $statement1 = $db->prepare($query1);
  $statement1->bindValue(':email', $email);
  $statement1->execute();
  $dataFetching = $statement1->fetch();
  // print_r($dataFetching['firstName']);
  // $GLOBALS['firstName'] = $dataFetching['firstName'];
  $lastName = $dataFetching['lastName'];
  $address = $dataFetching['address'];
  $phoneNumber = $dataFetching['phoneNumber'];
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

?>

<!DOCTYPE html>
<html>
  <head>
      <title></title>
      <link rel="stylesheet" href="css/style.basic.css">
      <link rel="stylesheet" href="css/main.css">
      <link rel="stylesheet" href="css/login.css">

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

   <div id="updateAlert" role="alert" >
       Great, User Successfully Updated!!
   </div>
   <div id="noUpdateAlert" role="alert">
       Updation Failed! <br>No such user exists!!
   </div>

   <div class="log-form" style="margin-top: 2%">
       <div id="updateProfileForm">
           <h2>User Profile</h2>
           <form action="../courses/model/dataValidationProfile.php" method="post">
               Email
               <input id="register-email" type="email" name="registerEmail" value="<?php echo $_SESSION['user_email']; ?>" required readonly="readonly" >
               FirstName
               <input id="firstName" type="text" name="firstName" value="<?php echo $firstName ?>" required >
               LastName
               <input id="lastName" type="text" name="lastName" value="<?php echo $lastName ?>" required >
               Phone Number
               <input id="phone" type="text" name="phoneNumber" value="<?php echo $phoneNumber ?>" required >
               Address
               <input id="address" type="text" name="address" value="<?php echo $address ?>" required >
               <button type="submit" class="btn btn-primary" name="update">Update</button>

           </form>
       </div>


   </div>
  </body>
</html>