<?php
$url="localhost";
$user="id8526660_root";
$pass="root2019";
$database="id8526660_sudokudb";

$conexion = new mysqli($url,$user,$pass,$database);
// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

?>