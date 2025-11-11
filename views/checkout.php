<?php
require_login();
require_once "classes/Carrito.php";
require_once "classes/Pedido.php";

$items = [];
$total = 0.0;
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$pedidoCreado = !empty($_SESSION['ultimo_pedido']);

$oldNombre = $_SESSION['old_nombre'] ?? '';
$oldDireccion = $_SESSION['old_direccion'] ?? '';
$oldCiudad = $_SESSION['old_ciudad'] ?? '';
$oldCodigoPostal = $_SESSION['old_codigo_postal'] ?? '';
$oldTelefono = $_SESSION['old_telefono'] ?? '';

unset($_SESSION['error'], $_SESSION['old_nombre'], $_SESSION['old_direccion']);
unset($_SESSION['old_ciudad'], $_SESSION['old_codigo_postal'], $_SESSION['old_telefono']);

try {
    if (!empty($_SESSION['usuario']['id_usuario'])) {
        $items = Carrito::items($_SESSION['usuario']['id_usuario']);
        $total = Carrito::calcularTotal($_SESSION['usuario']['id_usuario']);
    }
} catch (Exception $e) {
    error_log("Error al cargar datos de checkout: " . $e->getMessage());
    $error = "Error al cargar el carrito. Por favor, intenta nuevamente.";
}

// Si el carrito está vacío y no hay pedido creado, redirigir
if (empty($items) && !$pedidoCreado) {
    header("Location: " . url('carrito'));
    exit;
}
?>

<?php if ($pedidoCreado && $success): ?>
    <h1>✓ ¡Pedido Confirmado!</h1>
    <p><?php echo htmlspecialchars($success); ?></p>
    <p>Recibirás un email de confirmación en breve.</p>
    <p>
        <a href="<?php echo url('cuenta'); ?>">Ver Mis Pedidos</a> |
        <a href="<?php echo url('catalogo'); ?>">Seguir Comprando</a>
    </p>
    <?php 
    // Limpiar la sesión del último pedido después de mostrar
    unset($_SESSION['ultimo_pedido'], $_SESSION['success']);
    ?>
<?php else: ?>
    <h1>Finalizar Compra</h1>
    
    <?php if ($error): ?>
        <p><strong>✗ <?php echo htmlspecialchars($error); ?></strong></p>
    <?php endif; ?>
    
    <table border="0" cellpadding="10" width="100%">
    <tr>
        <td valign="top" width="60%">
            <form method="post" action="/tienda_mistica/actions/checkout_acc.php">
                <h2>Información de Envío</h2>
                
                <p>
                    <label>Nombre Completo *<br>
                    <input type="text" name="nombre" required size="50"
                           value="<?php echo htmlspecialchars($oldNombre ?: ($_SESSION['usuario']['nombre'] ?? '')); ?>">
                    </label>
                </p>
                
                <p>
                    <label>Dirección de Envío *<br>
                    <input type="text" name="direccion" required size="50"
                           value="<?php echo htmlspecialchars($oldDireccion); ?>">
                    </label>
                </p>
                
                <p>
                    <label>Ciudad *<br>
                    <input type="text" name="ciudad" required size="50"
                           value="<?php echo htmlspecialchars($oldCiudad); ?>">
                    </label>
                </p>
                
                <p>
                    <label>Código Postal<br>
                    <input type="text" name="codigo_postal" size="20"
                           value="<?php echo htmlspecialchars($oldCodigoPostal); ?>">
                    </label>
                </p>
                
                <p>
                    <label>Teléfono<br>
                    <input type="tel" name="telefono" size="30"
                           value="<?php echo htmlspecialchars($oldTelefono); ?>">
                    </label>
                </p>
                
                <p>
                    <label>Notas del Pedido (Opcional)<br>
                    <textarea name="notas" rows="4" cols="50"></textarea>
                    </label>
                </p>
                
                <h2>Método de Pago</h2>
                <p>
                    <label>
                        <input type="radio" name="metodo_pago" value="monedas_oro" checked>
                        Monedas de Oro Mágicas
                    </label>
                </p>
                
                <p><button type="submit">Confirmar Pedido</button></p>
            </form>
        </td>
        
        <td valign="top">
            <h2>Resumen del Pedido</h2>
            
            <table border="1" cellpadding="5" width="100%">
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($item['nombre'] ?? ''); ?></strong><br>
                        <small>Cantidad: <?php echo (int)($item['cantidad'] ?? 0); ?> × <?php echo number_format($item['precio_unitario'] ?? 0, 2); ?> oro</small>
                    </td>
                    <td align="right">
                        <strong><?php echo number_format($item['subtotal'] ?? 0, 2); ?> oro</strong>
                    </td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td><strong>TOTAL:</strong></td>
                    <td align="right"><strong><?php echo number_format($total, 2); ?> oro</strong></td>
                </tr>
            </table>
            
            <p><small>
                <strong>Envío:</strong> Gratis<br>
                <strong>Entrega:</strong> 3-5 días hábiles<br>
                <strong>Garantía:</strong> 30 días de devolución
            </small></p>
            
            <p><a href="<?php echo url('carrito'); ?>">← Volver al carrito</a></p>
        </td>
    </tr>
    </table>
<?php endif; ?>
