<?php
require_once __DIR__ . '/includes/auth.php';

header("Location: " . (isset($_SESSION['usuario']) ? 'pages/inicio.php' : 'pages/login.php'));
exit();
