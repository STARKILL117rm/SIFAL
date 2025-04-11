<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$buscar = $_GET['buscar'] ?? '';
$filtro = $_GET['filtro'] ?? '';

$query = "SELECT nombre, apellido_paterno, apellido_materno, nss, rfc FROM clientes WHERE 1";

if (!empty($buscar)) {
    $buscar = "%$buscar%";
    $query .= " AND (nss LIKE '$buscar' OR rfc LIKE '$buscar')";
}

if ($filtro === 'completadas') {
    $query .= " AND asesorias_completadas = 1";
} elseif ($filtro === 'afore') {
    $query .= " AND cambio_afore = 1";
} elseif ($filtro === 'seguimiento') {
    $query .= " AND seguimiento = 1";
}

$resultado = $conexion->query($query);

$clientes = [];

while ($row = $resultado->fetch_assoc()) {
    $clientes[] = [
        'cliente' => $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'],
        'nss' => $row['nss'],
        'rfc' => $row['rfc']
    ];
}

header('Content-Type: application/json');
echo json_encode($clientes);

$conexion->close();
?>
