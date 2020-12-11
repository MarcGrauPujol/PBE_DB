<?php

require 'config/config.php';

$conn = new mysqli($servername, $username, $password,$BD);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    print 'Connected';
}

?>