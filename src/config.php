<?php 
$servername = "127.0.0.1:3306";
$username = "root";
$password = "121312";
$dbname = "movies";

//Connect DB
 $conn = new mysqli($servername,$username,$password,$dbname);

//Find error

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}