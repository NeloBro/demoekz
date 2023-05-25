<?php 
$conn = new mysqli("localhost", "root", "","freed");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
?>