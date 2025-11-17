<?php
require_once __DIR__ . '/includes/header.php';

$pedidos = Pedido::todos();
$msg = $_GET['msg'] ?? null;
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Pedidos</h1>
        <p class="admin-section-subtitle">Controlá el flujo dimensional de entregas y ajustá estados</p>
    </div>
</div>

<!-- Alerts -->
<?php if ($msg === 'actualizado'): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span>Estado del pedido actualizado correctamente</span>
    </div>
<?php endif; ?>

<!-- Orders Table -->
<?php if (count($pedidos) > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $p): ?>
                    <?php 
                    $estado = strtolower($p['estado']);
                    $badgeClass = 'admin-badge';
                    switch($estado) {
                        case 'completado':
                            $badgeClass .= ' admin-badge--success';
                            break;
                        case 'cancelado':
                            $badgeClass .= ' admin-badge--danger';
                            break;
                        case 'procesando':
                        case 'enviado':
                            $badgeClass .= ' admin-badge--warning';
                            break;
                        default:
                            $badgeClass .= ' admin-badge--inactive';
                    }
                    ?>
                    <tr>
                        <td>
                            <span class="admin-table__id">#<?php echo $p['id_pedido']; ?></span>
                        </td>
                        <td>
                            <span class="admin-table__name-main"><?php echo htmlspecialchars($p['nombre']); ?></span>
                        </td>
                        <td>
                            <a href="mailto:<?php echo htmlspecialchars($p['email']); ?>" class="admin-action-link admin-action-link--edit">
                                <?php echo htmlspecialchars($p['email']); ?>
                            </a>
                        </td>
                        <td>
                            <span class="admin-table__price"><?php echo number_format($p['total'], 2); ?> 🪙</span>
                        </td>
                        <td>
                            <span class="<?php echo $badgeClass; ?>"><?php echo ucfirst($estado); ?></span>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($p['fecha_pedido'])); ?></td>
                        <td>
                            <td class="admin-table__actions">
                                <a href="admin/index.php?sec=pedido_ver&id=<?php echo $p['id_pedido']; ?>" class="admin-action-link admin-action-link--edit">
                                    👁️ Ver Detalles
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
        <div class="admin-empty-state__icon">📦</div>
        <h3 class="admin-empty-state__title">No hay pedidos registrados</h3>
        <p class="admin-empty-state__text">Cuando un cliente active un pedido, lo vas a ver aquí</p>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
