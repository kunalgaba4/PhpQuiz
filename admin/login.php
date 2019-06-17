<?php 
session_start();

$_SESSION['adminEmail'] = "";

$btnCheck = filter_input(INPUT_COOKIE, 'accessCheck');  
echo '<style type="text/css">
                #incorrectPassword {
                    display: none;
                }
                </style>';
  if ($btnCheck == "incorrectPassword") {
    echo '<style type="text/css">
                #incorrectPassword {
                    display: block;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('accessCheck', '', $expire, '/');
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Online Exam</title>
  </head>
  <body>
    <div>
      <div>
        <div>
          <div>
            <!-- Logo & Information Panel-->
            
              <div>
                <div>
                  <div>
                    <h1>Administrator Access</h1>
                  </div>
                  <p>Power to control the system!</p>
                </div>
              </div>
            
            <!-- Form Panel    -->
          
              <div>
                <div>
                  <div c id="incorrectPassword" role="alert">
                     I'm afraid, but email/password didn't match!!
                  </div>
                  <!-- <div id="loginForm"> -->
                  <form action="../admin/model/dataValidationAdmin.php" method="post">
                     <input type="hidden" name="action" value="saveUser">
                     
                    <div>
                      <input id="login-username" type="text" name="loginUsername" required data-msg="Please enter your username">
                      <label for="login-username">Email</label>
                    </div>
                    <div>
                      <input id="login-password" type="password" name="loginPassword" required data-msg="Please enter your password">
                      <label for="login-password" >Password</label><br>
                    </div>
                      <input type="submit" name="login" value="Login" >
                  </form>
                  <a href="../admin/contactUs.php">Contact Us</a>
                  </div>
                </div>
              </div>
            <!-- </div> -->
          
        </div>
  </body>
</html>