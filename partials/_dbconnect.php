<?php 
$server = "localhost"; 
$usernam = "root";
$password = "";
$database = "data"; 

$conn = mysqli_connect($server,$usernam,$password,$database);

if($conn-> connect_error){
    die("Connection failed:" . $conn-> connect_error);
}
?>