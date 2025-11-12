<?php
require_once __DIR__ . '/includes/header.php';

$pedidos = Pedido::todos();
$msg = $_GET['msg'] ?? null;
?>
<?php
$statusStyles = [
    'pendiente' => 'border-amber-400/40 bg-amber-500/20 text-amber-200',
    'completado' => 'border-emerald-400/40 bg-emerald-500/20 text-emerald-200',
    'cancelado' => 'border-rose-400/40 bg-rose-500/20 text-rose-200',
    'en_proceso' => 'border-sky-400/40 bg-sky-500/20 text-sky-200',
];
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Gestión de pedidos</h1>
            <p class="text-sm text-slate-300">Controlá el flujo dimensional de entregas y ajustá estados.</p>
        </div>
    </div>

    <?php if ($msg === 'actualizado'): ?>
        <div class="alert-arcade alert-success">
            <span class="status-dot"></span>
            <span>Estado del pedido actualizado correctamente.</span>
        </div>
    <?php endif; ?>

    <?php if (count($pedidos) > 0): ?>
        <div class="panel-glass overflow-hidden rounded-3xl border border-arcade-cyan/30 shadow-neon">
            <div class="overflow-x-auto">
                <table class="arcade-table">
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
                            <?php $estado = strtolower($p['estado']); ?>
                            <?php $estadoClass = $statusStyles[$estado] ?? 'border-slate-400/40 bg-slate-500/20 text-slate-200'; ?>
                            <tr>
                                <td class="font-mono text-sm text-slate-300">#<?php echo $p['id_pedido']; ?></td>
                                <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($p['email']); ?>" class="text-arcade-cyan hover:text-arcade-magenta"><?php echo htmlspecialchars($p['email']); ?></a>
                                </td>
                                <td class="font-semibold text-white"><?php echo number_format($p['total'], 2); ?> 🪙</td>
                                <td>
                                    <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] <?php echo $estadoClass; ?>">
                                        <span class="h-2 w-2 rounded-full bg-current"></span>
                                        <?php echo ucfirst($estado); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($p['fecha_pedido'])); ?></td>
                                <td class="whitespace-nowrap text-sm">
                                    <a href="<?php echo admin_url('pedido_ver', ['id' => $p['id_pedido']]); ?>" class="text-arcade-cyan hover:text-arcade-magenta">👁️ Ver detalles</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="panel-glass rounded-3xl border border-dashed border-arcade-cyan/40 p-10 text-center shadow-neon">
            <p class="text-lg font-semibold text-white">No hay pedidos registrados.</p>
            <p class="mt-2 text-sm text-slate-300">Cuando un cliente active un pedido, lo vas a ver aquí.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
