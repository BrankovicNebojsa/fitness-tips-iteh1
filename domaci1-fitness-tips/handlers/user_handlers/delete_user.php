<?php

require '../../db_connection.php';
require '../../models/User.php';


// this file handles POST

$id = 0;

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}


if ($id > 0) {

    $result = User::delete($conn, $id);
    if ($result) {
        echo "Success";

        session_start();
        session_unset();
        session_destroy();

        exit();
    }
}

echo "Failure";
exit();
