<?php
require 'db_connection.php';
require 'models/User.php';

$login_message = NULL;
$failed_registration_message = NULL;
$successful_registration_message = NULL;

// login 
if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
    $username =  sanitizeUserInput($_POST['username']);
    $password = sanitizeUserInput($_POST['password']);



    $user = new User($username, $password);

    if ($user->login($conn))  // conn from dbConnection.php
    {  // successful login

        session_start();
        $_SESSION['user'] = serialize($user);
        header('Location: index.php');
        exit();
    } else {   // log in failed
        $login_message = "Wrong username or password";
    }
}

// registration 
if (isset($_POST['register']) && isset($_POST['username']) && isset($_POST['password'])) {
    $username = sanitizeUserInput($_POST['username']);
    $password = sanitizeUserInput($_POST['password']);
    $confirmPassword = sanitizeUserInput($_POST['confirm-password']);
    $email = sanitizeUserInput($_POST['email']);


    if (empty($username) || empty($password) || empty($email) || empty($confirmPassword)) {
        $failed_registration_message = "You need to enter every data";
    } elseif ($confirmPassword != $password) {
        $failed_registration_message = "Passwords do not match";
    } elseif (!User::checkUsername($conn, $username)) {
        $failed_registration_message = "User with username $username already exists";
    } elseif (!User::checkEmail($conn, $email)) {
        $failed_registration_message = "User with email $email already exists";
    } else {
        $user = new User($username, $password, $email);
        $result = $user->create($conn);

        if (!$result) {
            // app failed to insert new user
            $failed_registration_message = "Failed to register new user. Try again";
        } else {
            $successful_registration_message = "You have successfully registered";
        }
    }
}

/**
 * sanitize - to prevent any unsafe data which user can enter
 */
function sanitizeUserInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);   // removes '/', this is important for showing data through app
    $data = htmlspecialchars($data); // converts HTML special chars to normal chars
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="css/login.css">
    <!-- favicon -->
    <link rel="shortcut icon" href="./assets/favicon.jpg" type="image/x-icon" />

    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" class="active" id="login-form-link">Login</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="#" id="register-form-link">Register</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="" method="post" role="form" style="display: block;">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="register-form" action="" method="post" role="form" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- login failed message popup-->

        <?php
        if (!empty($login_message)) {
            echo '<div class="alert alert-danger error-login">
            ' . $login_message . '
            </div>';
        }
        ?>

        <?php
        if (!empty($failed_registration_message)) {
            echo '<div class="alert alert-danger error-login">
            ' . $failed_registration_message . '
            </div>';
        }
        ?>
        <?php
        if (!empty($successful_registration_message)) {
            echo '<div class="alert alert-success error-login">
            ' . $successful_registration_message . '
            </div>';
        }
        ?>
    </div>

    <script src="js/login.js"></script>
</body>

</html>