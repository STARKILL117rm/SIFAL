<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id = $_POST['idCita'];

$sql = "DELETE FROM citas WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Cita cancelada correctamente.";
} else {
    echo "Error al cancelar la cita.";
}

$stmt->close();
$conexion->close();
?>
