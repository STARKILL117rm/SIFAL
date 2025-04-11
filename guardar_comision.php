<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'] ?? '';
$monto = $_POST['monto'] ?? 0;
$comision = $_POST['comision'] ?? 0;
$monto_final = $_POST['monto_final'] ?? 0;

$stmt = $conexion->prepare("INSERT INTO comisiones (nombre_cliente, monto_retirar, porcentaje_comision, monto_final) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sddd", $nombre, $monto, $comision, $monto_final);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "Error al guardar";
}

$stmt->close();
$conexion->close();
?>
