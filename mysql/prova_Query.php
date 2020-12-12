<?php

    //Connexió a la base de dades:
    $conn = new mysqli('sql7.freesqldatabase.com', 'sql7381488', '1jj5niwCLx','sql7381488'); 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Successful Connection...";
    
//----------------------------------------QUERYS---------------------------------------------
    //query prova
    $sql = "SELECT * FROM notes";
    $notes = $conecion-> query($sql);
    
    echo "$notes->num_rows";  //prova x imprimir
    if($notes->num_rows > 0){
        echo "$notes->num_rows";  //prova x imprimir
        while($row = $notes->fetch_assoc()){ //fetch_assoc -> obtenir tots els elements guardats en notes, producto de la consulta
            echo "$row[0]";
            echo "$row[1]";
            echo "$row[2]";
            //echo "$row[estudiant]";
            //echo '<div><from action="">'.$row['nom'].'</form></div>';
        }

    }
    

    $conn->close();

?>