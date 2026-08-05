<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/conexion.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: usuarios.php");
    exit();
}

// Seguridad extra: evitar que alguien se elimine a sí mismo por accidente
if ($id === (int)($_SESSION['id_usuario'] ?? 0)) {
    header("Location: usuarios.php?msg=no_autoeliminar");
    exit();
}

try {
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: usuarios.php?msg=eliminado");
    exit();

} catch (PDOException $e) {
    header("Location: usuarios.php?msg=error_eliminar");
    exit();
}
