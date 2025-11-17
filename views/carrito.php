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

<section class="carrito-hero">
    <h1 class="carrito-hero__title">Carrito Arcade</h1>
    <div class="carrito-hero__stats">
        <div class="hero-stat">
            <span class="hero-stat__icon">🎮</span>
            <span class="hero-stat__value"><?php echo count($items); ?></span>
            <span class="hero-stat__label">Items</span>
        </div>
        <div class="hero-stat">
            <span class="hero-stat__icon">💰</span>
            <span class="hero-stat__value"><?php echo number_format($total, 0, '.', '.'); ?></span>
            <span class="hero-stat__label">Oro Total</span>
        </div>
    </div>
</section>

<?php if ($mensaje): ?>
    <div class="alert-success">
        ✓ <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert-error">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if (empty($items)): ?>
    <div class="carrito-empty">
        <div class="empty-icon">🛒</div>
        <h2 class="empty-title">Tu carrito está vacío</h2>
        <p class="empty-text">Explorá el catálogo y agregá power-ups a tu colección</p>
        <a href="index.php?sec=catalogo" class="btn-arc btn-arc--primary">
            Ver Catálogo
        </a>
    </div>
<?php else: ?>
    <div class="carrito-items">
        <?php foreach ($items as $item): ?>
            <article class="carrito-item">
                <div class="carrito-item__info">
                    <h3 class="carrito-item__name"><?php echo htmlspecialchars($item['nombre']); ?></h3>
                    <p class="carrito-item__id">ID #<?php echo (int)$item['id_duende']; ?></p>
                    <p class="carrito-item__price"><?php echo number_format($item['precio_unitario'], 0, '.', '.'); ?> ORO</p>
                </div>
                
                <div class="carrito-item__quantity">
                    <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" class="quantity-form">
                        <input type="hidden" name="action" value="actualizar">
                        <input type="hidden" name="id_duende" value="<?php echo $item['id_duende']; ?>">
                        <label class="quantity-label">Cantidad:</label>
                        <div class="quantity-controls">
                            <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" max="99" class="quantity-input">
                            <button type="submit" class="btn-quantity">Actualizar</button>
                        </div>
                    </form>
                </div>
                
                <div class="carrito-item__subtotal">
                    <span class="subtotal-label">Subtotal</span>
                    <span class="subtotal-value"><?php echo number_format($item['subtotal'], 0, '.', '.'); ?></span>
                    <span class="subtotal-currency">ORO</span>
                </div>
                
                <div class="carrito-item__actions">
                    <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" onsubmit="return confirm('¿Eliminar este item del carrito?');">
                        <input type="hidden" name="action" value="eliminar">
                        <input type="hidden" name="id_duende" value="<?php echo $item['id_duende']; ?>">
                        <button type="submit" class="btn-remove">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <div class="carrito-footer">
        <div class="carrito-total">
            <span class="total-label">Total</span>
            <div class="total-display">
                <span class="total-amount"><?php echo number_format($total, 0, '.', '.'); ?></span>
                <span class="total-currency">ORO</span>
            </div>
        </div>
        
        <div class="carrito-actions">
            <a href="index.php?sec=catalogo" class="btn-arc btn-arc--secondary">
                ← Seguir Comprando
            </a>
            <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" class="inline-form" onsubmit="return confirm('¿Vaciar todo el carrito?');">
                <input type="hidden" name="action" value="vaciar">
                <button type="submit" class="btn-arc btn-arc--danger">
                    Vaciar Carrito
                </button>
            </form>
            <a href="index.php?sec=checkout" class="btn-arc btn-arc--checkout">
                Proceder al Checkout →
            </a>
        </div>
    </div>
<?php endif; ?>
