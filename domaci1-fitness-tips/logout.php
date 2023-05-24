<?php 

session_start();

if(isset($_GET)){   
    session_unset();                
    session_destroy();              // praznjenje svih podataka unutar sesije
    header('Location: login.php');  // vracamo korisnika na login stranicu
}

?>