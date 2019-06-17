<?php

session_start();

if ($_SESSION['adminEmail'] == "") {
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
                #addUserForm {
                    display: block;
                }
                #noUpdateAlert{
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "update":
        // echo "update";
        echo '<style type="text/css">
                #updateAlert {
                    display: block;
                }
                #saveAlert {
                    display: none;
                }
                #addUserForm {
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
        // echo "Save";
        echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: block;
                }
                #addUserForm {
                    display: none;
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
    <link rel="stylesheet" href="../courses/css/main.css">
    <link rel="stylesheet" href="css/addUser.css">



</head>
<body>
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


    <div class="log-form" style="margin-top: 10%">
        <div id="addUserForm">
            <h2>Add User</h2>
        <form action="../admin/model/dataValidationUser.php" method="post">
            <input type="hidden" name="action" value="saveUser">

            <div id="saveAlert" role="alert">
                Great, New User Successfully Added!!
            </div>
            <div id="updateAlert" role="alert">
                Great, User Successfully Updated!!
            </div>
            <div id="noUpdateAlert" role="alert">
                Updation Failed! <br>No such user exists!!
            </div>

            <input id="register-email" type="email" name="registerEmail" placeholder="Register Email Address" required>
            <input id="register-password" type="password" name="registerPassword"  placeholder="Registerd Password" required>
            <label>User is allowed to login or not</label>
            <br>
            <label style="font-size: 20px">Active</label>
            <input id="optionsRadios1" type="radio" checked="" value="1" name="userAccess">

           <label style="font-size: 20px">Not Active</label>
            <input id="optionsRadios2" type="radio" value="0" name="userAccess">



            <label>Basic Information</label><br><br>
            <input id="firstName" type="text" name="firstName" placeholder="FirstName" required>
            <input id="lastName" type="text" name="lastName" placeholder="LastName" required>
            <input id="phone" type="text" name="phoneNumber" placeholder="Phone Number" required>
            <input id="address" type="text" name="address" placeholder="Address" required>

            <input type="submit" class="btn" name="saveUser" value="Save User">
            <input type="submit" class="btn" name="updateUser" value="Update User">

        </form>
    </div>
    </div>
</main>
</body>
</html>