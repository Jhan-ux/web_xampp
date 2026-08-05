<?php
// includes/auth.php - Manejo centralizado de sesión

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Corta la ejecución y redirige al login si no hay sesión iniciada.
 * Llamar al principio de cualquier página que requiera estar logueado.
 */
function require_login(): void
{
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }
}
