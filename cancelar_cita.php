<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_POST['id_cita'] ?? null;

if (!$id) {
    echo "<script>alert('No se recibió el ID de la cita.'); window.history.back();</script>";
    exit;
}

$stmt = $conexion->prepare("DELETE FROM citas WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Cita cancelada exitosamente.'); window.location.href = 'historial_cliente.html';</script>";
} else {
    echo "<script>alert('Error al cancelar la cita.'); window.history.back();</script>";
}

$stmt->close();
$conexion->close();
?>
