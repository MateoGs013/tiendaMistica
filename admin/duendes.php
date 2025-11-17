<?php
require_once __DIR__ . '/includes/header.php';

$duendes = Duende::all();
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['success']);
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Duendes</h1>
        <p class="admin-section-subtitle">Supervisá fichas mágicas, disponibilidad y rarezas directamente desde la consola</p>
    </div>
    <a href="admin/index.php?sec=duende_crear" class="btn-arc btn-arc--primary">
        <span>+ Crear Duende</span>
    </a>
</div>

<!-- Alerts -->
<?php if ($success): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span><?php echo htmlspecialchars($success); ?></span>
    </div>
<?php endif; ?>

<?php if ($msg === 'eliminado'): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span>Duende eliminado correctamente.</span>
    </div>
<?php endif; ?>

<?php if ($error === 'no_eliminar'): ?>
    <div class="alert alert-error">
        <span class="alert__icon">✗</span>
        <span>Ocurrió un error al eliminar el duende. Probá nuevamente.</span>
    </div>
<?php endif; ?>

<!-- Duendes Table -->
<?php if (count($duendes) > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Rareza</th>
                    <th>Elemento</th>
                    <th>Disponible</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($duendes as $d): ?>
                    <tr>
                        <td>
                            <span class="admin-table__id">#<?php echo $d['id_duende']; ?></span>
                        </td>
                        <td>
                            <div class="admin-table__name">
                                <span class="admin-table__name-main"><?php echo htmlspecialchars($d['nombre']); ?></span>
                                <span class="admin-table__name-sub">Popularidad: <?php echo (int)($d['popularidad'] ?? 0); ?>/100</span>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($d['tipo'] ?? '-'); ?></td>
                        <td>
                            <span class="admin-table__price"><?php echo number_format($d['precio_en_oro'], 2); ?> 🪙</span>
                        </td>
                        <td><?php echo htmlspecialchars($d['rareza'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($d['elemento'] ?? '-'); ?></td>
                        <td>
                            <?php if ($d['disponible']): ?>
                                <span class="admin-badge admin-badge--success">Activo</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge--inactive">Pausado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <td class="admin-table__actions">
                                <a href="admin/index.php?sec=duende_editar&id=<?php echo $d['id_duende']; ?>" class="admin-action-link admin-action-link--edit">
                                    ✏️ Editar
                                </a>
                                <a href="#" onclick="confirmarBorrado(<?php echo $d['id_duende']; ?>, '<?php echo htmlspecialchars($d['nombre'], ENT_QUOTES); ?>'); return false;" class="admin-action-link admin-action-link--delete">
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
        <div class="admin-empty-state__icon">⚙️</div>
        <h3 class="admin-empty-state__title">Todavía no hay duendes registrados</h3>
        <p class="admin-empty-state__text">Creá el primero para abrir el portal de criaturas místicas</p>
        <a href="admin/index.php?sec=duende_crear" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>+ Crear Duende</span>
        </a>
    </div>
<?php endif; ?>

<script>
function confirmarBorrado(id, nombre) {
    if (confirm('¿Estás seguro de que quieres eliminar el duende "' + nombre + '"?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/actions/duende_borrar_acc.php?id=' + id + '&confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
