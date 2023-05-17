<?php 

session_start(); // we need this so it can populate $_SESSION, like we want to tell php engine that we want to work with session
if(isset($_GET)){   // GET request comes from login.php logout link
    session_unset(); // this clears $_SESSION variable
    session_destroy();
    header('Location: login.php');
}

?>