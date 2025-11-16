<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Pedido.php';

$id = (int)($_GET['id'] ?? 0);
$pedido = Pedido::find($id);

if (!$pedido) {
    ?>
    <div class="admin-empty-state">
        <div class="admin-empty-state__icon">⚠️</div>
        <h3 class="admin-empty-state__title">Pedido no encontrado</h3>
        <p class="admin-empty-state__text">No encontramos la orden solicitada. Puede que haya sido eliminada</p>
        <a href="<?php echo admin_url('pedidos'); ?>" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Volver al listado</span>
        </a>
    </div>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$items = Pedido::getItems($id);
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

unset($_SESSION['success'], $_SESSION['error']);
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Pedido #<?php echo $pedido['id_pedido']; ?></h1>
        <p class="admin-section-subtitle">Revisá la orden y actualizá su estado en la consola arcade</p>
    </div>
    <a href="<?php echo admin_url('pedidos'); ?>" class="btn-arc btn-arc--ghost">
        <span>← Volver al listado</span>
    </a>
</div>

<!-- Alerts -->
<?php if ($success): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span><?php echo htmlspecialchars($success); ?></span>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error">
        <span class="alert__icon">✗</span>
        <span><?php echo htmlspecialchars($error); ?></span>
    </div>
<?php endif; ?>

<!-- Order Details -->
<div class="admin-form">
    <!-- Customer Info -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Información del Cliente</h2>
        <div class="admin-form-grid">
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <p class="form-value"><?php echo htmlspecialchars($pedido['nombre'] ?? ''); ?></p>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <a href="mailto:<?php echo htmlspecialchars($pedido['email'] ?? ''); ?>" class="form-value form-value--link">
                    <?php echo htmlspecialchars($pedido['email'] ?? ''); ?>
                </a>
            </div>
            <div class="form-group">
                <label class="form-label">Fecha del Pedido</label>
                <p class="form-value"><?php echo date('d/m/Y H:i:s', strtotime($pedido['fecha_pedido'])); ?></p>
            </div>
            <div class="form-group">
                <label class="form-label">Total</label>
                <p class="form-value form-value--highlight"><?php echo number_format($pedido['total'], 2); ?> 🪙</p>
            </div>
        </div>
    </div>
    
    <!-- Order Status -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Estado del Pedido</h2>
        <form method="post" action="/tienda_mistica/admin/actions/pedido_actualizar_acc.php" class="admin-form-inline">
            <input type="hidden" name="id" value="<?php echo $pedido['id_pedido']; ?>">
            <div class="form-group">
                <select name="estado" class="form-input">
                    <option value="pendiente" <?php echo $pedido['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="procesando" <?php echo $pedido['estado'] === 'procesando' ? 'selected' : ''; ?>>Procesando</option>
                    <option value="enviado" <?php echo $pedido['estado'] === 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                    <option value="completado" <?php echo $pedido['estado'] === 'completado' ? 'selected' : ''; ?>>Completado</option>
                    <option value="cancelado" <?php echo $pedido['estado'] === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                </select>
            </div>
            <button type="submit" class="btn-arc btn-arc--primary">
                <span>Actualizar Estado</span>
            </button>
        </form>
    </div>
    
    <!-- Order Items -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Productos del Pedido</h2>
        <?php if (count($items) > 0): ?>
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <span class="admin-table__name-main"><?php echo htmlspecialchars($item['duende_nombre']); ?></span>
                                </td>
                                <td>
                                    <span class="admin-table__price"><?php echo number_format($item['precio_unitario'], 2); ?> 🪙</span>
                                </td>
                                <td><?php echo (int)$item['cantidad']; ?></td>
                                <td>
                                    <span class="admin-table__price"><?php echo number_format($item['precio_unitario'] * $item['cantidad'], 2); ?> 🪙</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align: right; font-family: 'Orbitron', monospace; font-size: 1rem; text-transform: uppercase;">Total</th>
                            <th>
                                <span class="admin-table__price" style="font-size: 1.125rem;"><?php echo number_format($pedido['total'], 2); ?> 🪙</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <p class="admin-form-section__help">No se registraron productos en esta orden</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
