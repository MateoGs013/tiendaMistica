<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Pedido.php';

$id = (int)($_GET['id'] ?? 0);
$pedido = Pedido::find($id);

if (!$pedido) {
    ?>
    <div class="panel-glass rounded-3xl border border-arcade-cyan/35 p-8 text-center shadow-neon">
        <h1 class="text-2xl font-semibold text-white">Pedido no encontrado</h1>
        <p class="mt-3 text-sm text-slate-300">No encontramos la orden solicitada. Puede que haya sido eliminada.</p>
        <a href="<?php echo admin_url('pedidos'); ?>" class="button-arcade mt-6 inline-flex">Volver al listado</a>
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
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Detalle del pedido #<?php echo $pedido['id_pedido']; ?></h1>
            <p class="text-sm text-slate-300">Revisá la orden y actualizá su estado en la consola arcade.</p>
        </div>
        <a href="<?php echo admin_url('pedidos'); ?>" class="button-ghost">&larr; Volver al listado</a>
    </div>

    <?php if ($success): ?>
        <div class="alert-arcade alert-success">
            <span class="status-dot"></span>
            <span><?php echo htmlspecialchars($success); ?></span>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert-arcade alert-error">
            <span class="status-dot offline"></span>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
        <h2 class="fieldset-title">Información del cliente</h2>
        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <div>
                <p class="arcade-label">Nombre</p>
                <p class="text-white"><?php echo htmlspecialchars($pedido['nombre'] ?? ''); ?></p>
            </div>
            <div>
                <p class="arcade-label">Email</p>
                <a href="mailto:<?php echo htmlspecialchars($pedido['email'] ?? ''); ?>" class="text-arcade-cyan hover:text-arcade-magenta"><?php echo htmlspecialchars($pedido['email'] ?? ''); ?></a>
            </div>
            <div>
                <p class="arcade-label">Fecha del pedido</p>
                <p class="text-sm text-slate-200"><?php echo date('d/m/Y H:i:s', strtotime($pedido['fecha_pedido'])); ?></p>
            </div>
            <div>
                <p class="arcade-label">Total</p>
                <p class="text-lg font-semibold text-white"><?php echo number_format($pedido['total'], 2); ?> monedas</p>
            </div>
        </div>
    </section>

    <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
        <h2 class="fieldset-title">Estado del pedido</h2>
        <form method="post" action="/tienda_mistica/admin/actions/pedido_actualizar_acc.php" class="mt-6 flex flex-col gap-4 md:flex-row md:items-center">
            <input type="hidden" name="id" value="<?php echo $pedido['id_pedido']; ?>">
            <select name="estado" class="arcade-select max-w-xs">
                <option value="pendiente" <?php echo $pedido['estado'] === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="procesando" <?php echo $pedido['estado'] === 'procesando' ? 'selected' : ''; ?>>Procesando</option>
                <option value="enviado" <?php echo $pedido['estado'] === 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                <option value="completado" <?php echo $pedido['estado'] === 'completado' ? 'selected' : ''; ?>>Completado</option>
                <option value="cancelado" <?php echo $pedido['estado'] === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
            </select>
            <button type="submit" class="button-arcade">Actualizar estado</button>
        </form>
    </section>

    <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
        <h2 class="fieldset-title">Productos del pedido</h2>
        <?php if (count($items) > 0): ?>
            <div class="mt-6 overflow-x-auto">
                <table class="arcade-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['duende_nombre']); ?></td>
                                <td><?php echo number_format($item['precio_unitario'], 2); ?> monedas</td>
                                <td><?php echo (int)$item['cantidad']; ?></td>
                                <td class="font-semibold text-white"><?php echo number_format($item['precio_unitario'] * $item['cantidad'], 2); ?> monedas</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th class="text-lg font-semibold text-white"><?php echo number_format($pedido['total'], 2); ?> monedas</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <p class="mt-4 text-sm text-slate-300">No se registraron productos en esta orden.</p>
        <?php endif; ?>
    </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
