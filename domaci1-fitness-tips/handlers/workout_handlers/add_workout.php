<?php

require '../../db_connection.php';
require '../../models/User.php';
require '../../models/Workout.php';

// Ovaj fajl handluje POST zahtev za dodavanje treninga

session_start();
$user = unserialize($_SESSION['user']);

$name = sanitizeUserInput($_POST['name']);
$exercise_time = $_POST['exercise_time'];
$difficulty_level = $_POST['difficulty_level'];
$first_exercise = $_POST['exercise_1'];
$second_exercise = $_POST['exercise_2'];
$third_exercise = $_POST['exercise_3'];
$description = $_POST['description'];
$user_id = $user->getId();

$image = $_FILES['image'];
$image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);    // to get extension of image (example .jpeg .png)
$image['name'] = guidv4() . '.' . $image_extension;                 // because images can maybe have same names, i generate random names to store them in db

move_uploaded_file($image['tmp_name'], '../../assets/workouts/' . $image['name']);

$imageName = $image['name'];

if (
    isset($name) && isset($exercise_time) && isset($difficulty_level) && isset($first_exercise) && isset($second_exercise) && isset($third_exercise) &&
    isset($description) && isset($user_id) && isset($image)
) {
    $workout = new Workout(null, $name, $exercise_time, $difficulty_level, $first_exercise, $second_exercise, $third_exercise, $description, $imageName, $user_id);
    if ($workout->insert($conn)) {
        echo "Success";
        exit();
    } else {
        echo "Failure";
        exit();
    };
} else {
    echo "Error";
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

/**
 * function to generate random GUID - globally unique identifier
 */

 // da ne bismo imali 2 fajla koji predstavljaju sliku treninga koja se zovu isto u bazi podataka
function guidv4($data = null)
{
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
