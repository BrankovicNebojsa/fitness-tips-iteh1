<?php

require '../../db_connection.php';
require '../../models/User.php';

// ovaj fajl handluje POST zahtev za brisanje korisnika

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
