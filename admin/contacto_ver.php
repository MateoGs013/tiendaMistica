<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Contacto.php';

$id = (int)($_GET['id'] ?? 0);
$contacto = Contacto::find($id);

if (!$contacto) {
    ?>
    <div class="admin-empty-state">
        <div class="admin-empty-state__icon">⚠️</div>
        <h3 class="admin-empty-state__title">Mensaje no encontrado</h3>
        <p class="admin-empty-state__text">El mensaje seleccionado fue eliminado o su identificación es incorrecta</p>
        <a href="admin/index.php?sec=contactos" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Volver al listado</span>
        </a>
    </div>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Mensaje #<?php echo $contacto['id_contacto']; ?></h1>
        <p class="admin-section-subtitle">Analizá la señal recibida y definí próximos pasos</p>
    </div>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="admin/index.php?sec=contactos" class="btn-arc btn-arc--ghost">
            <span>← Volver al listado</span>
        </a>
        <a href="#" onclick="confirmarBorrado(<?php echo $contacto['id_contacto']; ?>); return false;" class="btn-arc btn-arc--danger">
            <span>🗑️ Eliminar</span>
        </a>
    </div>
</div>

<!-- Contact Details -->
<div class="admin-form">
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Datos del Remitente</h2>
        <div class="admin-form-grid">
            <div class="form-group">
                <label class="form-label">ID</label>
                <p class="form-value" style="font-family: 'Space Mono', monospace; color: #818CF8;">#<?php echo $contacto['id_contacto']; ?></p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Fecha de Envío</label>
                <p class="form-value"><?php echo date('d/m/Y H:i:s', strtotime($contacto['fecha_envio'])); ?></p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <p class="form-value"><?php echo htmlspecialchars($contacto['nombre']); ?></p>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <a href="mailto:<?php echo htmlspecialchars($contacto['email']); ?>" class="form-value form-value--link">
                    <?php echo htmlspecialchars($contacto['email']); ?>
                </a>
            </div>
        </div>
    </div>
    
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Mensaje</h2>
        <div class="admin-message-box">
            <?php echo nl2br(htmlspecialchars($contacto['mensaje'])); ?>
        </div>
    </div>
</div>

<script>
function confirmarBorrado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este mensaje de contacto?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/actions/contacto_borrar_acc.php?id=' + id + '&confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
