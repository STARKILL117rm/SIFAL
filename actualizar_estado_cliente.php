<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$rfc = $_POST['rfc'] ?? '';
$campo = $_POST['campo'] ?? '';
$accion = $_POST['accion'] ?? ''; // "1" para agregar, "0" para retirar

if ($rfc && in_array($campo, ['asesorias_completadas', 'cambio_afore', 'seguimiento'])) {
    $stmt = $conexion->prepare("UPDATE clientes SET $campo = ? WHERE rfc = ?");
    $stmt->bind_param("is", $accion, $rfc);
    if ($stmt->execute()) {
        echo "ok";
    } else {
        echo "Error al actualizar.";
    }
    $stmt->close();
} else {
    echo "Datos inválidos.";
}

$conexion->close();
?>
