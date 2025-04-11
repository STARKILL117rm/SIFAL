<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$rfc = $_POST['rfc'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$tipo = $_POST['tipo_reunion'];

// Buscar ID del cliente por RFC
$stmt = $conexion->prepare("SELECT id FROM clientes WHERE rfc = ?");
$stmt->bind_param("s", $rfc);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (!$cliente) {
    echo "<script>alert('Cliente no encontrado'); window.history.back();</script>";
    exit;
}

$cliente_id = $cliente['id'];

// Insertar nueva cita
$insert = $conexion->prepare("INSERT INTO citas (cliente_id, fecha, hora, tipo_cita) VALUES (?, ?, ?, ?)");
$insert->bind_param("isss", $cliente_id, $fecha, $hora, $tipo);

if ($insert->execute()) {
    echo "<script>alert('Cita agendada exitosamente'); window.location.href = 'historial_cliente.html';</script>";
} else {
    echo "<script>alert('Error al agendar cita'); window.history.back();</script>";
}

$stmt->close();
$insert->close();
$conexion->close();
?>
