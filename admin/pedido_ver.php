<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Pedido.php';

$id = (int)($_GET['id'] ?? 0);
$pedido = Pedido::find($id);

if (!$pedido) {
    echo "<p>Pedido no encontrado</p>";
    echo "<a href='" . admin_url('pedidos') . "'>Volver al listado</a>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$items = Pedido::getItems($id);

$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

unset($_SESSION['success'], $_SESSION['error']);
?>
<h1>Detalle del Pedido #<?php echo $pedido['id_pedido']; ?></h1>

<?php if ($success): ?>
    <p style="color:green;"><strong><?php echo htmlspecialchars($success); ?></strong></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color:red;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
<?php endif; ?>

<div style="max-width: 900px;">
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h2>Información del Cliente</h2>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($pedido['nombre'] ?? ''); ?></p>
        <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($pedido['email'] ?? ''); ?>"><?php echo htmlspecialchars($pedido['email'] ?? ''); ?></a></p>
        <p><strong>Fecha del Pedido:</strong> <?php echo date('d/m/Y H:i:s', strtotime($pedido['fecha_pedido'])); ?></p>
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h2>Estado del Pedido</h2>
        <form method="post" action="/tienda_mistica/admin/actions/pedido_actualizar_acc.php" style="display: flex; align-items: center; gap: 10px;">
            <input type="hidden" name="id" value="<?php echo $pedido['id_pedido']; ?>">
            <select name="estado" style="padding: 8px; font-size: 14px;">
                <option value="pendiente" <?php echo $pedido['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="procesando" <?php echo $pedido['estado'] === 'procesando' ? 'selected' : ''; ?>>Procesando</option>
                <option value="enviado" <?php echo $pedido['estado'] === 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                <option value="completado" <?php echo $pedido['estado'] === 'completado' ? 'selected' : ''; ?>>Completado</option>
                <option value="cancelado" <?php echo $pedido['estado'] === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
            </select>
            <button type="submit" style="padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Actualizar Estado</button>
        </form>
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
        <h2>Productos del Pedido</h2>
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
            <thead style="background: #e9ecef;">
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
                    <td><?php echo htmlspecialchars($item['duende_nombre']); ?></td>
                    <td><?php echo number_format($item['precio_unitario'], 2); ?> 🪙</td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td><strong><?php echo number_format($item['precio_unitario'] * $item['cantidad'], 2); ?> 🪙</strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot style="background: #e9ecef;">
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>TOTAL:</strong></td>
                    <td><strong style="font-size: 18px;"><?php echo number_format($pedido['total'], 2); ?> 🪙</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<p style="margin-top: 20px;">
    <a href="<?php echo admin_url('pedidos'); ?>" style="background: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">← Volver al listado</a>
</p>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
