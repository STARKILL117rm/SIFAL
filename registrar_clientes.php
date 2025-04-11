<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$regimen = $_POST['regimen'];
$rfc = $_POST['rfc'];
$nss = $_POST['nss'];
$afore = $_POST['afore'];
$telefono = $_POST['telefono'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

$stmt = $conexion->prepare("INSERT INTO clientes (nombre, apellido_paterno, apellido_materno, regimen, rfc, nss, afore, telefono, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $nombre, $apellido_paterno, $apellido_materno, $regimen, $rfc, $nss, $afore, $telefono, $fecha_nacimiento);

if ($stmt->execute()) {
    echo "<script>alert('Cliente registrado exitosamente.'); window.location.href = 'acciones.html';</script>";
} else {
    echo "<script>alert('Error al registrar cliente.'); window.history.back();</script>";
}

$stmt->close();
$conexion->close();
?>
