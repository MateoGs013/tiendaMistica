<?php
require_login();
require_once "classes/Carrito.php";

$items = [];
$total = 0.0;
try {
    if (!empty($_SESSION['usuario']['id_usuario'])) {
        $items = Carrito::items($_SESSION['usuario']['id_usuario']);
        $total = Carrito::calcularTotal($_SESSION['usuario']['id_usuario']);
    }
} catch (Exception $e) {
    error_log("Error al cargar carrito: " . $e->getMessage());
    $_SESSION['error'] = "Error al cargar el carrito. Por favor, inténtalo de nuevo.";
}

$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);
?>

<h1>Mi Carrito de Compras</h1>

<?php if ($mensaje): ?>
    <p><strong>✓ <?php echo htmlspecialchars($mensaje); ?></strong></p>
<?php endif; ?>

<?php if ($error): ?>
    <p><strong>✗ <?php echo htmlspecialchars($error); ?></strong></p>
<?php endif; ?>

<?php if (empty($items)): ?>
    <p>Tu carrito está vacío</p>
    <p><a href="<?php echo url('catalogo'); ?>">Ver Catálogo</a></p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($item['nombre']); ?></strong></td>
                <td><?php echo number_format($item['precio_unitario'], 2); ?> oro</td>
                <td>
                    <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php">
                        <input type="hidden" name="action" value="actualizar">
                        <input type="hidden" name="id_duende" value="<?php echo $item['id_duende']; ?>">
                        <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" max="99">
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
                <td><strong><?php echo number_format($item['subtotal'], 2); ?> oro</strong></td>
                <td>
                    <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php">
                        <input type="hidden" name="action" value="eliminar">
                        <input type="hidden" name="id_duende" value="<?php echo $item['id_duende']; ?>">
                        <button type="submit" onclick="return confirm('¿Eliminar este producto del carrito?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><strong>TOTAL: <?php echo number_format($total, 2); ?> oro</strong></p>

    <p>
        <a href="<?php echo url('catalogo'); ?>">← Seguir Comprando</a> |
        <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" style="display: inline;">
            <input type="hidden" name="action" value="vaciar">
            <button type="submit" onclick="return confirm('¿Vaciar todo el carrito?')">Vaciar Carrito</button>
        </form> |
        <a href="<?php echo url('checkout'); ?>">Proceder al Pago →</a>
    </p>
<?php endif; ?>
