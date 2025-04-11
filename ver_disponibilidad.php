<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$fecha = $_POST['fecha'];
$tipo = $_POST['tipo_reunion'];

// Consulta cuántas citas hay ese día
$stmt = $conexion->prepare("SELECT COUNT(*) AS total FROM citas WHERE fecha = ?");
$stmt->bind_param("s", $fecha);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();
$citasOcupadas = $resultado['total'];

// Puedes definir un límite de citas por día, por ejemplo 10
$limite = 10;

if ($citasOcupadas >= $limite) {
    echo "<script>alert('No hay disponibilidad para esta fecha'); window.history.back();</script>";
} else {
    echo "<script>alert('¡Fecha disponible! Puedes proceder a agendar.'); window.location.href = 'agendar_cita.html';</script>";
}

$stmt->close();
$conexion->close();
?>
