<?php 

$host = 'localhost';
$username = 'root';
$password = '';
$db = 'workout_db';

$conn = new mysqli($host,$username,$password,$db);

if($conn->connect_errno)
{
    exit("Connection with database failure> message: $conn->connect_error with code: $conn->connect_errno");
}

?>