<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sifal";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$cliente = $_POST['cliente'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$tipo = $_POST['tipo'];
$descripcion = $_POST['descripcion'];

$sql = "INSERT INTO citas (cliente, fecha, hora, tipo, descripcion)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $cliente, $fecha, $hora, $tipo, $descripcion);

if ($stmt->execute()) {
    echo "Cita guardada con éxito.";
} else {
    echo "Error al guardar la cita: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
