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
    header("Location: index.php?sec=carrito");
    exit;
}
?>

<?php if ($pedidoCreado && $success): ?>
    <section class="checkout-success">
        <div class="success-icon">✓</div>
        <h1 class="success-title">¡Pedido Confirmado!</h1>
        <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
        <p class="success-note">Recibirás un correo con los detalles de tu compra</p>
        <div class="success-actions">
            <a href="index.php?sec=cuenta" class="btn-arc btn-arc--primary">
                Ver Mis Pedidos
            </a>
            <a href="index.php?sec=catalogo" class="btn-arc btn-arc--secondary">
                Seguir Comprando
            </a>
        </div>
    </section>
    <?php
    unset($_SESSION['ultimo_pedido'], $_SESSION['success']);
    ?>
<?php else: ?>
    <section class="checkout-hero">
        <h1 class="checkout-hero__title">Checkout</h1>
        <p class="checkout-hero__subtitle">Finalizá tu compra y recibí tus power-ups</p>
    </section>

    <?php if ($error): ?>
        <div class="alert-error">
            ✗ <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="checkout-container">
        <div class="checkout-form-section">
            <form method="post" action="/tienda_mistica/actions/checkout_acc.php" class="checkout-form">
                <div class="form-section">
                    <h2 class="form-section-title">Información de Envío</h2>
                    
                    <div class="form-row">
                        <label class="form-label">
                            <span class="label-text">Nombre Completo*</span>
                            <input type="text" name="nombre" required 
                                   value="<?php echo htmlspecialchars($oldNombre ?: ($_SESSION['usuario']['nombre'] ?? '')); ?>" 
                                   class="form-input">
                        </label>
                        <label class="form-label">
                            <span class="label-text">Teléfono</span>
                            <input type="tel" name="telefono" 
                                   value="<?php echo htmlspecialchars($oldTelefono); ?>" 
                                   class="form-input">
                        </label>
                    </div>

                    <label class="form-label">
                        <span class="label-text">Dirección*</span>
                        <input type="text" name="direccion" required 
                               value="<?php echo htmlspecialchars($oldDireccion); ?>" 
                               class="form-input">
                    </label>

                    <div class="form-row">
                        <label class="form-label">
                            <span class="label-text">Ciudad*</span>
                            <input type="text" name="ciudad" required 
                                   value="<?php echo htmlspecialchars($oldCiudad); ?>" 
                                   class="form-input">
                        </label>
                        <label class="form-label">
                            <span class="label-text">Código Postal</span>
                            <input type="text" name="codigo_postal" 
                                   value="<?php echo htmlspecialchars($oldCodigoPostal); ?>" 
                                   class="form-input">
                        </label>
                    </div>

                    <label class="form-label">
                        <span class="label-text">Notas del Pedido (Opcional)</span>
                        <textarea name="notas" rows="4" class="form-input form-textarea"></textarea>
                    </label>
                </div>

                <div class="form-section">
                    <h2 class="form-section-title">Método de Pago</h2>
                    <label class="payment-option">
                        <input type="radio" name="metodo_pago" value="monedas_oro" checked class="payment-radio">
                        <span class="payment-label">💰 Monedas de Oro Místicas</span>
                        <span class="payment-description">Envío protegido incluido</span>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-arc btn-arc--checkout">
                        Confirmar Pedido
                    </button>
                    <a href="index.php?sec=carrito" class="btn-arc btn-arc--secondary">
                        ← Volver al Carrito
                    </a>
                </div>
            </form>
        </div>

        <aside class="checkout-sidebar">
            <h2 class="sidebar-title">Resumen del Pedido</h2>
            
            <div class="sidebar-items">
                <?php foreach ($items as $item): ?>
                    <div class="summary-item">
                        <p class="summary-item__name"><?php echo htmlspecialchars($item['nombre'] ?? ''); ?></p>
                        <p class="summary-item__qty">
                            <?php echo (int)($item['cantidad'] ?? 0); ?> × <?php echo number_format($item['precio_unitario'] ?? 0, 0, '.', '.'); ?> ORO
                        </p>
                        <p class="summary-item__subtotal">
                            <?php echo number_format($item['subtotal'] ?? 0, 0, '.', '.'); ?> ORO
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="sidebar-total">
                <span class="total-label">Total</span>
                <div class="total-display">
                    <span class="total-amount"><?php echo number_format($total, 0, '.', '.'); ?></span>
                    <span class="total-currency">ORO</span>
                </div>
            </div>

            <div class="sidebar-info">
                <div class="info-item">✓ Envío gratis</div>
                <div class="info-item">✓ Entrega 3-5 días</div>
                <div class="info-item">✓ Garantía 30 días</div>
            </div>
        </aside>
    </div>
<?php endif; ?>
