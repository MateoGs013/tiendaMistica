<?php
require_once __DIR__ . '/includes/header.php';

$contactos = Contacto::todos();
$msg = $_GET['msg'] ?? null;
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Contactos</h1>
        <p class="admin-section-subtitle">Monitorizá las señales entrantes y respondé a la comunidad</p>
    </div>
</div>

<!-- Alerts -->
<?php if ($msg === 'eliminado'): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span>Mensaje eliminado correctamente</span>
    </div>
<?php endif; ?>

<!-- Contacts Table -->
<?php if (count($contactos) > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactos as $c): ?>
                    <tr>
                        <td>
                            <span class="admin-table__id">#<?php echo $c['id_contacto']; ?></span>
                        </td>
                        <td>
                            <span class="admin-table__name-main"><?php echo htmlspecialchars($c['nombre']); ?></span>
                        </td>
                        <td>
                            <a href="mailto:<?php echo htmlspecialchars($c['email']); ?>" class="admin-action-link admin-action-link--edit">
                                <?php echo htmlspecialchars($c['email']); ?>
                            </a>
                        </td>
                        <td>
                            <div class="admin-table__message"><?php echo htmlspecialchars($c['mensaje']); ?></div>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($c['fecha_envio'])); ?></td>
                        <td>
                            <td class="admin-table__actions">
                                <a href="admin/index.php?sec=contacto_ver&id=<?php echo $c['id_contacto']; ?>" class="admin-action-link admin-action-link--edit">
                                    👁️ Ver
                                </a>
                                <a href="#" onclick="confirmarBorrado(<?php echo $c['id_contacto']; ?>); return false;" class="admin-action-link admin-action-link--delete">
                                    🗑️ Borrar
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="admin-empty-state">
        <div class="admin-empty-state__icon">📬</div>
        <h3 class="admin-empty-state__title">No hay mensajes de contacto</h3>
        <p class="admin-empty-state__text">Cuando alguien envíe una señal desde la tienda, la verás aquí</p>
    </div>
<?php endif; ?>

<script>
function confirmarBorrado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este mensaje?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/actions/contacto_borrar_acc.php?id=' + id + '&confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
