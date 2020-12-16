<?php

include './funcions.php';

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

$link = mysqli_connect("sql7.freesqldatabase.com", "sql7381488", "1jj5niwCLx", "sql7381488");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//PREPARACIO DEL STRING PER SER ADAPTAT A MYSQL
//PATH_INFO = a partir de la barra fins l'interrogant, es a dir: /timetables, /tasks, /marks o /students
//$path = a PATH_INFO sense la barra 
$path=substr($_SERVER['PATH_INFO'], 1);

//QUERY_STRING = a partir de l'interrogant
//Obtenim un query ben formatejat en llenguatje mysql
$query=parsing($link,$path,$_SERVER['QUERY_STRING']);

// Attempt select query execution
$path($link,$query);

?>
