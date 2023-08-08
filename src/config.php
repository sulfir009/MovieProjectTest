<?php 
$servername = "127.0.0.1:3306";
$username = "root";
$password = "121312";
$dbname = "movies";

//Підключення до DB
 $conn = new mysqli($servername,$username,$password,$dbname);

//Find error
mysqli_report(MYSQLI_REPORT_OFF); 
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}