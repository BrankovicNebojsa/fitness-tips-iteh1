<?php

require '../../db_connection.php';
require '../../models/User.php';

// Ovaj php fajl handluje POST zahtev za izmenu korisnickog imena i email-a kao i promenu sifre korisnika

if (isset($_POST['username']) && isset($_POST['email'])) {
    session_start();
    $username = sanitizeUserInput($_POST['username']);
    $email = sanitizeUserInput($_POST['email']);

    if (!User::isUsernameUnique($conn, $username)) {
        header("Location: ../../index.php?message='Username already exists'");
        exit();
    }

    if (!User::isEmailUnique($conn, $email)) {
        header("Location: ../../index.php?message='Email already exists'");
        exit();
    }

    $user = unserialize($_SESSION['user']);
    $user->setUsername($username);
    $user->setEmail($email);

    if ($user->update($conn)) {
        $_SESSION['user'] = serialize($user);
        header("Location: ../../index.php?message='User data updated successfully'");
    } else {
        header("Location: ../../index.php?message='User data update failed'");
    }

    exit();
}

if (isset($_POST['old-password']) && isset($_POST['new-password'])) {
    session_start();
    $oldPassword = sanitizeUserInput($_POST['old-password']);
    $newPassword = sanitizeUserInput($_POST['new-password']);

    $user = unserialize($_SESSION['user']);
    if ($user->getPassword() != $oldPassword) {
        header("Location: ../../index.php?message='Wrong old password'");
    } elseif ($newPassword == null || empty($newPassword)) {
        header("Location: ../../index.php?message='New password can not be blank'");
    } else {
        $user->setPassword($newPassword);
        $_SESSION['user'] = serialize($user);
        if ($user->update($conn)) {
            header("Location: ../../index.php?message='You have successfully changed the password'");
        } else {
            header("Location: ../../index.php?message='Error changing password'");
        }
    }

    exit();
}

// prevencija loseg unosa korisnika
function sanitizeUserInput($data)
{
    $data = trim($data);                // uklanja blanko karaktere na pocektu i na kraju unosa
    $data = stripslashes($data);        // uklanja znak '/' kako ne bi remetio tok aplikacije
    $data = htmlspecialchars($data);    // prebacuje specijalne HTML karaktere u obicne karaktere
    return $data;
}
