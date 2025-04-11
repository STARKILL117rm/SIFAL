<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$filtro = $_GET['filtro'] ?? "";

$sql = "SELECT nombre, apellido_paterno, apellido_materno, nss, rfc FROM clientes 
        WHERE nss LIKE ? OR rfc LIKE ?";
$stmt = $conexion->prepare($sql);
$likeFiltro = "%$filtro%";
$stmt->bind_param("ss", $likeFiltro, $likeFiltro);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultados - Buscar Cliente</title>
  <link rel="icon" href="SIFAL.jpg" type="image/jpeg">
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 40px;
      background-color: #f5f5f5;
    }
    .form-container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      border: 2px solid black;
      width: 700px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    th {
      background: black;
      color: white;
    }
    .volver {
      margin-top: 20px;
      display: inline-block;
      padding: 8px 16px;
      background: #007bff;
      color: white;
      border-radius: 5px;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Resultados de la Búsqueda</h1>
    <table>
      <thead>
        <tr>
          <th>Cliente</th>
          <th>NSS</th>
          <th>RFC</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($resultado->num_rows > 0): ?>
          <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
              <td><?= $fila['nombre'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] ?></td>
              <td><?= $fila['nss'] ?></td>
              <td><?= $fila['rfc'] ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="3">No se encontraron resultados.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
    <a href="buscar_cliente.html" class="volver">← Volver</a>
  </div>
</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
