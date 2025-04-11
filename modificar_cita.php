<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id = $_POST['idCita'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$tipo = $_POST['tipo'];
$descripcion = $_POST['descripcion'];

$sql = "UPDATE citas SET fecha='$fecha', hora='$hora', tipo='$tipo', descripcion='$descripcion' WHERE id=$id";

if ($conexion->query($sql) === TRUE) {
    echo "Cita actualizada correctamente";
} else {
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>
