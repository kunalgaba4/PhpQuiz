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
      <link rel="stylesheet" type="text/css" href="css/adminlogin.css">
  </head>
  <body>

      <div class="log-form">
          <h2>Login to your account</h2>
          <form action="../admin/model/dataValidationAdmin.php" method="post">
              <input type="hidden" name="action" value="saveUser"/>

              <div id="incorrectPassword" role="alert" style="color: red">
                  I'm afraid, but email/password didn't match!!
              </div>
              <input type="email" id="login-username" type="text" name="loginUsername" required placeholder="Enter your Email"/>
              <input id="login-password" type="password" name="loginPassword" required placeholder="Enter Password"/>
              <button type="submit" name="login" class="btn">Login</button>
              <a href="../admin/contactUs.php">Contact Us</a>
          </form>
      </div>
  </body>
</html>