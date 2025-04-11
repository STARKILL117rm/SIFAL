<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$edad    = $_POST['edad'] ?? '';
$salario = $_POST['salario'] ?? '';
$saldo   = $_POST['saldo'] ?? '';
$anioLey = $_POST['anioLey'] ?? '';
$genero  = $_POST['genero'] ?? '';
$pension = $_POST['pension'] ?? '';

// Validar que todos los campos estén presentes
if ($edad === '' || $salario === '' || $saldo === '' || $anioLey === '' || $genero === '' || $pension === '') {
    echo "Faltan datos";
    exit;
}

$stmt = $conexion->prepare("INSERT INTO simulaciones (edad, salario, saldo_afore, anio_ley, genero, pension_estimada) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iddiss", $edad, $salario, $saldo, $anioLey, $genero, $pension);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
