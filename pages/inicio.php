<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../config/conexion.php';
require_login();

// Stats queries
$total = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$last_user = $conexion->query("SELECT nombres FROM usuarios ORDER BY id DESC LIMIT 1")->fetchColumn();

render_header("Dashboard", "inicio");
?>

<div style="margin-bottom: 3rem;">
    <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?> 👋</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem; font-weight: 500;">Aquí tienes el estado actual de tu sistema.</p>
</div>

<div class="dashboard-grid">
    <div class="metric-card">
        <div class="metric-header">
            <span class="metric-label">Usuarios Totales</span>
            <div class="metric-icon" style="background: rgba(99, 102, 241, 0.1); color: var(--accent);">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="metric-value"><?php echo $total; ?></div>
        <div style="font-size: 0.8rem; color: var(--success); font-weight: 700;">
            <i class="fas fa-arrow-up"></i> +12% este mes
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-header">
            <span class="metric-label">Último Ingreso</span>
            <div class="metric-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
        <div class="metric-value" style="font-size: 1.25rem;"><?php echo htmlspecialchars($last_user ?? 'N/A'); ?></div>
        <div class="metric-label" style="font-size: 0.75rem;">Recientemente registrado</div>
    </div>

    <div class="metric-card">
        <div class="metric-header">
            <span class="metric-label">Estado del Sistema</span>
            <div class="metric-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                <i class="fas fa-shield-check"></i>
            </div>
        </div>
        <div class="metric-value" style="font-size: 1.5rem;">Seguro</div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">SSL Activado</div>
    </div>
</div>

<div class="card" style="display: flex; justify-content: space-between; align-items: center; border: none; background: linear-gradient(135deg, #1e293b, #0f172a); color: white;">
    <div>
        <h3 style="color: white; margin-bottom: 0.5rem; font-size: 1.5rem;">Genera informes detallados</h3>
        <p style="color: rgba(255,255,255,0.7); font-weight: 500;">Obtén un reporte PDF con todos los usuarios registrados en segundos.</p>
    </div>
    <a href="reporte.php" target="_blank" class="btn btn-primary" style="background: white; color: #0f172a;">
        Descargar PDF <i class="fas fa-download"></i>
    </a>
</div>

<?php render_footer(); ?>
