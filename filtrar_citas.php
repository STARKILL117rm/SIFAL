<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clientes";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los parámetros de filtrado
$criterio = $_GET['criterio'] ?? ''; // Campo de búsqueda
$tipoFiltro = $_GET['tipoFiltro'] ?? ''; // Tipo de filtro: tipo o fecha

// Construir consulta SQL dinámicamente
$sql = "SELECT cliente_nombre, fecha, hora, tipo FROM citas";
if (!empty($criterio)) {
    if ($tipoFiltro == 'tipo') {
        $sql .= " WHERE tipo LIKE '%$criterio%'";
    } elseif ($tipoFiltro == 'fecha') {
        $sql .= " WHERE fecha LIKE '%$criterio%'";
    }
}

$result = $conn->query($sql);

$citas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }
}

// Retornar datos como JSON
header('Content-Type: application/json');
echo json_encode($citas);

$conn->close();
?>