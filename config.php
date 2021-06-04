<?php
    
// https://www.w3schools.com/php/php_mysql_connect.asp

$servername = "localhost";
$username = "root";
$password = "";
$db = 'test';
 
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
 
// Check connection
if($conn -> connect_error){
    die("Connection failed: " . $conn->connect_error);
}

?>