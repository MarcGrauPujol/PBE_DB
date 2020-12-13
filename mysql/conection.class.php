<?php

    //Connexió a la base de dades:
    $conn = new mysqli('sql7.freesqldatabase.com', 'sql7381488', '1jj5niwCLx','sql7381488'); 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Successful Connection...";
    
?>