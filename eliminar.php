<?php
session_start();
require "conexion.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: usuarios.php");
    exit();
}

// Seguridad extra: evitar que alguien se elimine a sí mismo por accidente
if ($id == $_SESSION['id_usuario'] ?? 0) {
    header("Location: usuarios.php?msg=no_autoeliminar");
    exit();
}

try {
    // Tabla correcta = usuarios (con s)
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: usuarios.php?msg=eliminado");
    exit();

} catch (PDOException $e) {
    header("Location: usuarios.php?msg=error_eliminar");
    exit();
}
?>