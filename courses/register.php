
<?php  
  $btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
  echo '<style type="text/css">
                 
                  #saveAlert {
                      display: none;
                  }
                  #registerUserForm {
                      display: block;
                  }
                  #userExistAlert{
                    display: none;
                  }
                 
                  </style>';

  switch ($btnCheck) {

      case "saveUser":
          // echo "Save";
          echo '<style type="text/css">
                  #saveAlert {
                      display: block;
                  }
                  #registerUserForm {
                      display: block;
                  }
                  #userExistAlert{
                    display: none;
                  }
                  </style>';
          $expire = strtotime('-1 year');
          setcookie('btnCheck', '', $expire, '/');

          break;

          case "userExist":
             echo '<style type="text/css">
                  #saveAlert {
                      display: none;
                  }
                  #registerUserForm {
                      display: block;
                  }
                  #userExistAlert{
                    display: block;
                  }
                  </style>';
            break;
      default:
          // echo "Form";
          echo '<style type="text/css">
                  #saveAlert {
                      display: none;
                  }
                  #registerUserForm {
                      display: block;
                  }
                  #userExistAlert{
                    display: none;
                  }
                  </style>';
  }
?>





<html>
  <head>

    <title>Online Exam</title>

  </head>
  <body>
   <main class="content">




                   <div id="registerUserForm" >
                  <form action="model/dataValidationRegister.php" method="POST">
                    <input type="hidden" name="action" value="saveUser">
                    <div >
                        <label for="register-fname" >First Name</label>
                      <input id="register-fname" type="text" name="registerFname" required data-msg="Please enter your First Name">

                    </div>
                    <div >
                        <label for="register-lname" >Last Name</label>
                      <input id="register-lname" type="text" name="registerLname" required data-msg="Please enter your Last Name" >

                    </div>
                    <div >
                        <label for="register-email" >Email Address      </label>
                      <input id="register-email" type="email" name="registerEmail" required data-msg="Please enter a valid email address" >

                    </div>
                    <div >
                        <label for="register-password" >password        </label>
                      <input id="register-password" type="password" name="registerPassword" required data-msg="Please enter your password" >

                    </div>
                   
                    <div >
                      <button id="regidter" type="submit" name="registerSubmit" >Register</button>
                    </div>
                  </form>
                </div>


       <!-- ------------------ Form Starts here -->
       <div class="alert alert-success" id="saveAlert" role="alert" >
           Great, New User Successfully Added!!
       </div>

       <!-- validation error -->
       <div class="alert alert-danger" id="userExistAlert" role="alert">
           User already exists, please try again!!
       </div>
       <small>Already have an account? </small><a href="login.php" class="signup">Login</a>
   </main>

  </body>
</html>