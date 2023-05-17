<?php

class User
{

    private $id;
    private $username;
    private $password;
    private $email;

    function __construct($username = null, $password = null, $email = null)
    {
        $this->id = NULL;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * function to log in user
     */
    function login(mysqli $conn)
    {

        $sql = "SELECT id,username,password,email FROM user WHERE username = ? AND password = ?";

        $stmt = $conn->prepare($sql);   // using prepared statement to avoid SQL Injection
        $stmt->bind_param("ss", $this->username, $this->password);   //s for string


        $stmt->execute();

        $result = $stmt->get_result();
        $success = false;

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();   //return assoc array, where each element is column with name in table

            $this->id = $row['id'];
            $this->email = $row['email'];

            $success = true;
        }

        $stmt->close();
        return $success;
    }


    /**
     * function to create in user
     */

    function create(mysqli $conn)
    {
        $sql = "INSERT INTO user (username,password,email) VALUES (?,?,?)";

        $stmt = $conn->prepare($sql);   // using prepared statement to avoid SQL Injection
        $stmt->bind_param("sss", $this->username, $this->password, $this->email);   //s for string


        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    /**
     * function to update in user
     */

    function update(mysqli $conn)
    {
        $sql = "UPDATE user SET username = ?, password = ?, email = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $this->username, $this->password, $this->email, $this->id);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    /**
     * static function to delete in user
     * trying static functions, it doesn't need to be
     */

    static function delete(mysqli $conn, $id)
    {
        // TODO : Deleting workouts

        $sql = "DELETE FROM workout WHERE user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();

        if (!$success) {
            throw new Exception("Error deleting user's workouts");
        }

        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        $success = $stmt->execute();


        return $success;
    }

    /**
     * static function to check if username enterd in registration form, already exists
     * @param - mysqli connection and entered username
     * @return - true if username is unique, false  if it is not
     */

    static function checkUsername(mysqli $conn, $username)
    {
        $sql = "SELECT *  FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);

        $success = $stmt->execute();


        if ($success) {

            $result = $stmt->get_result();
            return mysqli_num_rows($result) == 0 ? true : false;
        }

        return false;
    }

    /**
     * static function to check if email enterd in registration form, already exists
     * @param - mysqli connection and entered email
     * @return - true if email is unique, false  if it is not
     */

    static function checkEmail(mysqli $conn, $email)
    {
        $sql = "SELECT *  FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);

        $success = $stmt->execute();


        if ($success) {

            $result = $stmt->get_result();
            return mysqli_num_rows($result) == 0 ? true : false;
        }

        return false;
    }




    // getters

    function getUsername()
    {
        return $this->username;
    }

    function getEmail()
    {
        return $this->email;
    }


    function getPassword()
    {
        return $this->password;
    }


    function getId()
    {
        return $this->id;
    }

    // setters

    function setUsername($username)
    {
        $this->username = $username;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }


    function setPassword($password)
    {
        $this->password = $password;
    }
}
