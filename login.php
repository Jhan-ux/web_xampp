<?php
session_start();
require "conexion.php";

// Si no viene por POST, lo mandamos al formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.html");
    exit();
}

$usuario  = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';

if ($usuario === '' || $password === '') {
    header("Location: login.html?error=1");
    exit();
}

try {
    // Buscamos al usuario en la tabla "usuarios" (¡con s!)
    $stmt = $conexion->prepare("SELECT id, usuario, password FROM usuarios WHERE usuario = ? LIMIT 1");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no existe o la contraseña no coincide
    if (!$user || !password_verify($password, $user['password'])) {
        header("Location: login.html?error=1");
        exit();
    }

    // LOGIN CORRECTO → creamos sesión
    $_SESSION['usuario']     = $user['usuario'];
    $_SESSION['id_usuario']  = $user['id'];   // útil para evitar auto-eliminación

    header("Location: usuarios.php");   // o inicio.php, como prefieras
    exit();

} catch (Exception $e) {
    // En producción nunca muestres el error real
    header("Location: login.html?error=1");
    exit();
}
?>