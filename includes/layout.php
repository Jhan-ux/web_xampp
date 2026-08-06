<?php
// includes/layout.php - Premium Layout System

function render_header($title = "Sistema de Gestión", $active_page = "") {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?> | Admin Panel</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../assets/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        <?php if (isset($_SESSION['usuario'])): ?>
        <nav class="navbar">
            <div class="nav-container">
                <a href="inicio.php" class="nav-logo">
                    <i class="fas fa-bolt-lightning"></i>
                    <span>NEXUS</span>
                </a>
                <ul class="nav-links">
                    <li>
                        <a href="inicio.php" class="<?= $active_page === 'inicio' ? 'active' : '' ?>">
                            <i class="fas fa-chart-pie"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="usuarios.php" class="<?= $active_page === 'usuarios' ? 'active' : '' ?>">
                            <i class="fas fa-user-group"></i> Usuarios
                        </a>
                    </li>
                    <li>
                        <a href="reporte.php" target="_blank">
                            <i class="fas fa-file-contract"></i> Reportes
                        </a>
                    </li>
                </ul>
                <div class="nav-actions">
                    <a href="logout.php" class="btn btn-white btn-sm nav-logout">
                        <i class="fas fa-power-off"></i> Salir
                    </a>
                </div>
            </div>
        </nav>
        <?php endif; ?>
        <main class="main-content">
    <?php
}

function render_footer() {
    ?>
        </main>
        <footer style="margin-top: auto; padding: 3rem 0; border-top: 1px solid var(--border); text-align: center; color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">
            <p>&copy; <?php echo date('Y'); ?> <strong>Nexus Admin</strong>. Diseñado con elegancia.</p>
        </footer>
    </body>
    </html>
    <?php
}

function get_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("Error de seguridad: Token inválido.");
    }
}
?>
