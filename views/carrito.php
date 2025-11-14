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

<section class="panel-glass overflow-hidden">
    <div class="px-6 py-8 lg:px-10">
        <h1 class="font-orbitron text-3xl text-white">Carrito Arcade</h1>
        <p class="mt-2 text-sm text-slate-300">Gestioná tus duendes como si fueran power-ups listos para activar. Ajustá cantidades, vaciá slots o avanzá al checkout iluminado.</p>
        <p class="mt-2 text-xs uppercase tracking-[0.24em] text-arcade-cyan">Slots activos: <?php echo count($items); ?> &bull; Poder total acumulado: <?php echo number_format(array_sum(array_map(static fn($item) => (float)$item['subtotal'], $items)), 2); ?> oro</p>
    </div>
</section>

<?php if ($mensaje): ?>
    <div class="mt-6 rounded-lg border border-arcade-emerald/50 bg-arcade-emerald/15 p-4 text-sm text-arcade-emerald shadow-neon">
        ✓ <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="mt-6 rounded-lg border border-arcade-rose/50 bg-arcade-rose/15 p-4 text-sm text-arcade-rose shadow-neon">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if (empty($items)): ?>
    <div class="mt-10 rounded-2xl border border-arcade-magenta/40 bg-arcade-panel/70 p-10 text-center text-slate-200 shadow-neon">
        <p class="font-orbitron text-xl text-arcade-magenta">Tu carrito está vacío</p>
        <p class="mt-3 text-sm text-slate-300">Volvé al <a class="text-arcade-cyan hover:text-arcade-gold" href="<?php echo url('catalogo'); ?>">catálogo</a> y coleccioná nuevos power-ups antes de que la sala se oscurezca.</p>
    </div>
<?php else: ?>
    <div class="mt-8 overflow-x-auto rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/60 p-4 shadow-neon">
        <table class="arcade-table min-w-full">
            <thead>
                <tr>
                    <th>Power-up</th>
                    <th>Precio unitario</th>
                    <th>Slots</th>
                    <th>Subtotal</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <p class="font-orbitron text-base text-arcade-cyan"><?php echo htmlspecialchars($item['nombre']); ?></p>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">ID #<?php echo (int)$item['id_duende']; ?></p>
                        </td>
                        <td class="text-sm text-slate-200"><?php echo number_format($item['precio_unitario'], 2); ?> oro</td>
                        <td>
                            <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" class="flex items-center gap-2">
                                <input type="hidden" name="action" value="actualizar">
                                <input type="hidden" name="id_duende" value="<?php echo $item['id_duende']; ?>">
                                <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" max="99" class="w-20 rounded-lg border border-arcade-cyan/30 bg-arcade-base/70 px-2 py-1 text-slate-100 focus:border-arcade-magenta/50 focus:outline-none">
                                <button type="submit" class="button-arcade px-4 py-2 text-xs" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-poco-comun), 0.35), rgba(var(--rareza-rgb-raro), 0.4));">Actualizar</button>
                            </form>
                        </td>
                        <td class="text-sm font-semibold text-arcade-gold"><?php echo number_format($item['subtotal'], 2); ?> oro</td>
                        <td>
                            <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" class="inline-flex" onsubmit="return confirm('¿Eliminar este power-up del carrito?');">
                                <input type="hidden" name="action" value="eliminar">
                                <input type="hidden" name="id_duende" value="<?php echo $item['id_duende']; ?>">
                                <button type="submit" class="button-arcade px-4 py-2 text-xs" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-epico), 0.35), rgba(var(--rareza-rgb-mitico), 0.45));">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex flex-col gap-4 rounded-2xl border border-arcade-magenta/30 bg-arcade-panel/70 p-6 text-slate-200 shadow-neon md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-arcade-magenta">Total acumulado</p>
            <p class="mt-2 font-orbitron text-3xl text-arcade-gold"><?php echo number_format($total, 2); ?> oro</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="<?php echo url('catalogo'); ?>" class="button-arcade px-5 py-3 text-xs">← Seguir explorando</a>
            <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" class="inline-flex" onsubmit="return confirm('¿Vaciar todo el carrito? Esta acción no se puede deshacer.');">
                <input type="hidden" name="action" value="vaciar">
                <button type="submit" class="button-arcade px-5 py-3 text-xs" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-epico), 0.35), rgba(var(--rareza-rgb-mitico), 0.45));">Vaciar slots</button>
            </form>
            <a href="<?php echo url('checkout'); ?>" class="button-arcade px-5 py-3 text-xs" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-poco-comun), 0.4), rgba(var(--rareza-rgb-raro), 0.45));">Proceder al checkout →</a>
        </div>
    </div>
<?php endif; ?>
