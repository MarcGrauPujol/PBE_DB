<?php require 'conection.class.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <title>Index</title>
</head>
<body>
<h1>Notes</h1>

    <?php
    /*$conn = new mysqli('sql7.freesqldatabase.com', 'sql7381488', '1jj5niwCLx','sql7381488'); 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Successful Connection...";*/

    $query = "SELECT * FROM notes";  
    $res = $conn->query($query);
    echo "$res->num_rows";
    if ($res->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "NOTES: " . $row["assignatura"] . $row["nom"]. $row["nota"]. "<br>";
        }
        echo "ok!";
    }else{
        echo "no va";
    }
    echo $res;
    echo $notes;

    $conn->close();


    ?>


</body>
</html>