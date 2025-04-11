<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$buscar = $_GET['buscar'] ?? '';
$filtro = $_GET['filtro'] ?? '';

$sql = "SELECT nombre_cliente AS cliente, nss, rfc FROM clientes WHERE 1=1";

// Si hay texto para buscar (por NSS o RFC)
if ($buscar) {
    $buscar = $conexion->real_escape_string($buscar);
    $sql .= " AND (nss LIKE '%$buscar%' OR rfc LIKE '%$buscar%')";
}

// Filtros adicionales
if ($filtro === 'completadas') {
    $sql .= " AND asesorias_completadas = 1";
} elseif ($filtro === 'afore') {
    $sql .= " AND afore_anterior != afore_nuevo";
} elseif ($filtro === 'seguimiento') {
    $sql .= " AND en_seguimiento = 1";
}

$resultado = $conexion->query($sql);
$clientes = [];

while ($fila = $resultado->fetch_assoc()) {
    $clientes[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($clientes);

$conexion->close();
?>
