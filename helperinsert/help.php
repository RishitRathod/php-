<?php
function dbConnect() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "world1";
    
    $con = new mysqli($server, $username, $password, $dbname);
    
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    return $con;
}
?>