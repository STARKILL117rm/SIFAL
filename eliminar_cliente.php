<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$rfc = $_POST['rfc'];

// Validación básica
if (!$rfc) {
    echo "<script>alert('RFC no recibido.'); window.history.back();</script>";
    exit;
}

// Eliminar de la base
$stmt = $conexion->prepare("DELETE FROM clientes WHERE rfc = ?");
$stmt->bind_param("s", $rfc);

if ($stmt->execute()) {
    echo "<script>alert('Cliente eliminado exitosamente.'); window.location.href = 'eliminar_cliente.html';</script>";
} else {
    echo "<script>alert('Error al eliminar.'); window.history.back();</script>";
}

$stmt->close();
$conexion->close();
?>
