<?php

require '../../db_connection.php';
require '../../models/Workout.php';

// the response is JSON file with all workouts from DB
if (isset($_GET['getAll'])) {
    $workouts = Workout::getWorkouts($conn);

    $res = json_encode(utf8ize($workouts));
    echo  $res;
}

if (isset($_GET['filter'])) {
    echo json_encode(utf8ize(Workout::filterWorkouts(
        $conn,
        sanitizeUserData($_POST['name']),
        $_POST['exerciseTimeFrom'],
        $_POST['exerciseTimeTo'],
        $_POST['difficultyLevelFrom'],
        $_POST['difficultyLevelTo']
    )));
}

function sanitizeUserData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/* Use it for json_encode some corrupt UTF-8 chars
 * useful for = malformed utf-8 characters possibly incorrectly encoded by json_encode
 */
function utf8ize($mixed)
{
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
    }
    return $mixed;
}
