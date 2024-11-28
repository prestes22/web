<?php
$conexion = new mysqli("localhost", "root", "", "pasteleria");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa a la base de datos.";
}
?>
