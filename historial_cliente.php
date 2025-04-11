<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$rfc = $_GET['rfc'] ?? '';

if (!$rfc) {
    die("RFC no proporcionado.");
}

// Obtener datos del cliente
$consultaCliente = $conexion->prepare("SELECT id, nombre, apellido_paterno, apellido_materno, regimen, nss, rfc, TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad FROM clientes WHERE rfc = ?");
$consultaCliente->bind_param("s", $rfc);
$consultaCliente->execute();
$datosCliente = $consultaCliente->get_result()->fetch_assoc();

// Obtener historial de citas
$clienteId = $datosCliente['id'];
$consultaCitas = $conexion->prepare("SELECT fecha, hora, tipo_cita FROM citas WHERE cliente_id = ? ORDER BY fecha DESC");
$consultaCitas->bind_param("i", $clienteId);
$consultaCitas->execute();
$resultadoCitas = $consultaCitas->get_result();

$citas = [];
while ($fila = $resultadoCitas->fetch_assoc()) {
    $citas[] = $fila;
}

// Enviar como JSON
header('Content-Type: application/json');
echo json_encode([
    "cliente" => $datosCliente,
    "citas" => $citas
]);

$consultaCliente->close();
$consultaCitas->close();
$conexion->close();
?>
