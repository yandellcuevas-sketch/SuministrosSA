<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "suministrossa";

$conn = new mysqli($servername, $username, $password, $database);

$conn->connect_error && die("Conexión fallida: " . $conn->connect_error);
?>
