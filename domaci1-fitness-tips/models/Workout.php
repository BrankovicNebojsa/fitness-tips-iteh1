<?php

class Workout
{

    public $id;
    public $name;
    public $exerciseTime;
    public $difficultyLevel;
    public $firstExercise;
    public $secondExercise;
    public $thirdExercise;
    public $description;
    public $imageName;
    public $user_id;

    function __construct($id = null, $name, $exerciseTime, $difficultyLevel, $firstExercise, $secondExercise, $thirdExercise, $description, $imageName, $user_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->exerciseTime = $exerciseTime;
        $this->difficultyLevel = $difficultyLevel;
        $this->firstExercise = $firstExercise;
        $this->secondExercise = $secondExercise;
        $this->thirdExercise = $thirdExercise;
        $this->description =  $description;
        $this->imageName = $imageName;
        $this->user_id = $user_id;
    }

    // funkcija koja vraca sve treninge iz baze podataka
    static function getWorkouts(mysqli $conn)
    {
        $sql = "SELECT * FROM workout";
        $result = $conn->query($sql);
        $array = array();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
        }
        return $array;
    }

    // funkcija koja ubacuje novi trening u bazu podataka
    function insert(mysqli $conn)
    {
        $sql = "INSERT INTO workout (name,exercise_time,difficulty_level,first_exercise,
        second_exercise,third_exercise,description,image,user_id) VALUES (?,?,?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);   // using prepared statement to avoid SQL Injection
        $stmt->bind_param("siisssssi", $this->name, $this->exerciseTime, $this->difficultyLevel,
         $this->firstExercise, $this->secondExercise, $this->thirdExercise, $this->description,
          $this->imageName, $this->user_id);   //s for string

        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // funkcija koja vraca trening na osnovu id-a treninga
    static function getById(mysqli $conn, $id)
    {
        $sql = "SELECT * FROM workout WHERE id = ?";

        $stmt = $conn->prepare($sql);   // koristimo prepared statement da bismo izbegli SQL Injection napad
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();

        if ($success) {
            $res = $stmt->get_result();
            $array_res = $res->fetch_array();
            $workout = new Workout(
                $array_res['id'],
                $array_res['name'],
                $array_res['exercise_time'],
                $array_res['difficulty_level'],
                $array_res['first_exercise'],
                $array_res['second_exercise'],
                $array_res['third_exercise'],
                $array_res['description'],
                $array_res['image'],
                $array_res['user_id']
            );
            return $workout;
        }
        return false;
    }


    // funkcija koja vraca treninge koji odgovaraju unetim filterima na stranici
    static function filterWorkouts(mysqli $conn, $name, $exerciseTimeFrom, $exerciseTimeTo, $difficultyLevelFrom, $difficultyLevelTo) {
        if (!empty($name) && !Workout::getByName($conn, $name)) {
            return array();
        }
        if ((!empty($exerciseTimeTo) && $exerciseTimeTo < $exerciseTimeFrom) || (!empty($difficultyLevelTo) && $difficultyLevelTo < $difficultyLevelFrom)) {
            return array();
        }
        $sql = "SELECT * FROM workout WHERE 1=1";
        if (!empty($name)) {
            $name = strtolower($name);
            $sql .= " AND LOWER(name) LIKE '$name%'";
        }
        if (!empty($exerciseTimeFrom)) {
            $exerciseTimeFrom = (int) $exerciseTimeFrom;
            $sql .= " AND exercise_time >= $exerciseTimeFrom";
        }
        if (!empty($exerciseTimeTo)) {
            $exerciseTimeTo = (int) $exerciseTimeTo;
            $sql .= " AND exercise_time <= $exerciseTimeTo";
        }
        if (!empty($difficultyLevelFrom)) {
            $difficultyLevelFrom = (int) $difficultyLevelFrom;
            $sql .= " AND difficulty_level >= $difficultyLevelFrom";
        }
        if (!empty($difficultyLevelTo)) {
            $difficultyLevelTo = (int) $difficultyLevelTo;
            $sql .= " AND difficulty_level <= $difficultyLevelTo";
        }
        $result = $conn->query($sql);
        $array = array();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
        }
        return $array;
    }

    // funkcija koja vraca trening na osnovu imena koja se koristi za filter u funkciji iznad
    static function getByName(mysqli $conn, $name)
    {
        $sql = "SELECT * FROM workout WHERE name LIKE '%$name%'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0)
            return true;
        else
            return false;
    }
}
