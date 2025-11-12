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
    <section class="panel-glass mt-8 p-10 text-center text-slate-200">
        <h1 class="font-orbitron text-3xl text-arcade-gold">✓ Pedido confirmado</h1>
        <p class="mt-4 text-sm text-slate-300"><?php echo htmlspecialchars($success); ?></p>
        <p class="mt-2 text-xs uppercase tracking-[0.24em] text-arcade-cyan">Recibirás un correo con los pasos para la activación mística.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <a href="<?php echo url('cuenta'); ?>" class="button-arcade px-6 py-3 text-xs">Ver mis pedidos</a>
            <a href="<?php echo url('catalogo'); ?>" class="button-arcade px-6 py-3 text-xs" style="background: linear-gradient(135deg, rgba(6,182,212,0.35), rgba(147,51,234,0.45));">Seguir comprando</a>
        </div>
    </section>
    <?php
    unset($_SESSION['ultimo_pedido'], $_SESSION['success']);
    ?>
<?php else: ?>
    <section class="panel-glass overflow-hidden">
        <div class="px-6 py-8 lg:px-10">
            <h1 class="font-orbitron text-3xl text-white">Finalizar compra</h1>
            <p class="mt-2 text-sm text-slate-300">Completá tus datos para que el envío atraviese el portal correcto. Tus duendes viajarán con escolta de luz.</p>
        </div>
    </section>

    <?php if ($error): ?>
        <div class="mt-6 rounded-lg border border-rose-500/50 bg-rose-500/15 p-4 text-sm text-rose-200 shadow-neon">
            ✗ <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form method="post" action="/tienda_mistica/actions/checkout_acc.php" class="space-y-6 rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/70 p-6 shadow-neon">
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
                        Nombre completo*
                        <input type="text" name="nombre" required value="<?php echo htmlspecialchars($oldNombre ?: ($_SESSION['usuario']['nombre'] ?? '')); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
                    </label>
                    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
                        Teléfono
                        <input type="tel" name="telefono" value="<?php echo htmlspecialchars($oldTelefono); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
                    </label>
                </div>
                <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
                    Dirección de envío*
                    <input type="text" name="direccion" required value="<?php echo htmlspecialchars($oldDireccion); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
                </label>
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
                        Ciudad*
                        <input type="text" name="ciudad" required value="<?php echo htmlspecialchars($oldCiudad); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
                    </label>
                    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
                        Código postal
                        <input type="text" name="codigo_postal" value="<?php echo htmlspecialchars($oldCodigoPostal); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
                    </label>
                </div>
                <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
                    Notas del pedido (opcional)
                    <textarea name="notas" rows="4" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none"></textarea>
                </label>
                <fieldset class="rounded-xl border border-arcade-magenta/30 bg-arcade-base/70 p-4">
                    <legend class="font-orbitron text-xs uppercase tracking-[0.25em] text-arcade-magenta">Método de pago</legend>
                    <label class="mt-3 flex items-center gap-3 text-sm text-slate-200">
                        <input type="radio" name="metodo_pago" value="monedas_oro" checked>
                        Monedas de oro místicas (incluye resguardo de duendes custodios)
                    </label>
                </fieldset>
                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="button-arcade px-6 py-3 text-xs">Confirmar pedido</button>
                    <a href="<?php echo url('carrito'); ?>" class="button-arcade px-6 py-3 text-xs" style="background: linear-gradient(135deg, rgba(99,102,241,0.35), rgba(147,51,234,0.35));">← Volver al carrito</a>
                </div>
            </form>
        </div>
        <aside class="space-y-4 rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/70 p-6 shadow-neon">
            <h2 class="font-orbitron text-xl text-white">Resumen del pedido</h2>
            <div class="space-y-3 text-sm text-slate-200">
                <?php foreach ($items as $item): ?>
                    <div class="rounded-lg border border-arcade-cyan/25 bg-arcade-base/70 p-3">
                        <p class="font-orbitron text-base text-arcade-cyan"><?php echo htmlspecialchars($item['nombre'] ?? ''); ?></p>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Cantidad: <?php echo (int)($item['cantidad'] ?? 0); ?> × <?php echo number_format($item['precio_unitario'] ?? 0, 2); ?> oro</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.2em] text-arcade-gold">Subtotal: <?php echo number_format($item['subtotal'] ?? 0, 2); ?> oro</p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="rounded-lg border border-arcade-magenta/30 bg-arcade-base/80 p-4">
                <p class="text-xs uppercase tracking-[0.2em] text-arcade-magenta">Total</p>
                <p class="mt-2 font-orbitron text-3xl text-arcade-gold"><?php echo number_format($total, 2); ?> oro</p>
            </div>
            <ul class="space-y-1 text-xs uppercase tracking-[0.18em] text-slate-400">
                <li>Envío: gratis con ruta protegida</li>
                <li>Entrega: 3-5 días hábiles</li>
                <li>Garantía: 30 días de devolución</li>
            </ul>
        </aside>
    </div>
<?php endif; ?>
