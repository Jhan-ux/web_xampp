<?php
// conexion.php - Versión corregida y garantizada

$host = 'localhost';
$db   = 'bd_entregable';  // CAMBIA ESTO por el nombre real de tu BD
$user = 'root';                      // normalmente root en XAMPP
$pass = '';                          // normalmente vacío en XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conexion = new PDO($dsn, $user, $pass, $options);  // AQUÍ SE CREA LA VARIABLE $conexion
    // echo "Conexión exitosa"; // (puedes descomentar para probar)
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>