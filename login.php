<?php
$conexion = new mysqli("localhost", "root", "", "sifal");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Consulta SQL segura usando prepared statements
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ? AND rol = ?");
$stmt->bind_param("sss", $username, $password, $role);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    if ($role === "administrador") {
        header("Location: acciones.html");
    } else if ($role === "cliente") {
        header("Location: acciones_cliente.html");
    }
    exit;
} else {
    echo "<script>alert('Credenciales incorrectas'); window.location.href = 'index.html';</script>";
}

$stmt->close();
$conexion->close();
?>
