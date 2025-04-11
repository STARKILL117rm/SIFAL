<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$cliente_id = $_GET['cliente_id'];  // Este ID debe venir del frontend

$sql = "SELECT * FROM traspasos_afore WHERE cliente_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$resultado = $stmt->get_result();

$traspasos = [];
while ($fila = $resultado->fetch_assoc()) {
    $traspasos[] = $fila;
}

echo json_encode($traspasos);

$stmt->close();
$conexion->close();
?>
