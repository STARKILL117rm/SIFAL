<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clientes";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar citas pasadas
$sql = "SELECT cliente_nombre, edad, regimen, afore_actual, nss, rfc, fecha_cita, hora_cita, tipo_cita FROM citas";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Retornar datos como JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
