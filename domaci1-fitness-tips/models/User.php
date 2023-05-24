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

    // geteri za promenljive klase
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

    // seteri za promenljive klase

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
    
    // funkcija za registrovanje korisnika
    function login(mysqli $conn)
    {
        $sql = "SELECT id,username,password,email FROM user WHERE username = ? AND password = ?";

        $stmt = $conn->prepare($sql);   // koristimo prepared statement da bismo izbegli SQL Injection napad
        $stmt->bind_param("ss", $this->username, $this->password);   // s predstavlja String

        $stmt->execute();

        $result = $stmt->get_result();
        $success = false;

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $this->id = $row['id'];
            $this->email = $row['email'];

            $success = true;
        }

        $stmt->close();
        return $success;
    }

    // funkcija za dodavanje novog korisnika u bazu
    function create(mysqli $conn)
    {
        $sql = "INSERT INTO user (username,password,email) VALUES (?,?,?)";

        $stmt = $conn->prepare($sql);   // koristimo prepared statement da bismo izbegli SQL Injection napad
        $stmt->bind_param("sss", $this->username, $this->password, $this->email);   // s predstavlja String


        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // funkcija za promenu podataka korisnika
    function update(mysqli $conn)
    {
        $sql = "UPDATE user SET username = ?, password = ?, email = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $this->username, $this->password, $this->email, $this->id);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // funkcija za brisanje korisnika
    static function delete(mysqli $conn, $id)
    {
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

    // u ovoj funkciji proveravamo da li je korisnicko ime jedinstveno (vraca true ako jeste, a false ako nije)
    static function isUsernameUnique(mysqli $conn, $username)
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

    // u ovoj funkciji proveravamo da li je mail jedinstven (vraca true ako jeste, a false ako nije)
    static function isEmailUnique(mysqli $conn, $email)
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
}
