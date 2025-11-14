<?php
require_once __DIR__ . '/includes/header.php';

$duendes = Duende::all();
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['success']);
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Gestión de duendes</h1>
            <p class="text-sm text-slate-300">Supervisá fichas mágicas, disponibilidad y rarezas directamente desde la consola.</p>
        </div>
        <a href="<?php echo admin_url('duende_crear'); ?>" class="button-arcade">+ Crear nuevo duende</a>
    </div>

    <?php if ($success): ?>
        <div class="alert-arcade alert-success">
            <span class="status-dot"></span>
            <span><?php echo htmlspecialchars($success); ?></span>
        </div>
    <?php endif; ?>

    <?php if ($msg === 'eliminado'): ?>
        <div class="alert-arcade alert-success">
            <span class="status-dot"></span>
            <span>Duende eliminado correctamente.</span>
        </div>
    <?php endif; ?>

    <?php if ($error === 'no_eliminar'): ?>
        <div class="alert-arcade alert-error">
            <span class="status-dot offline"></span>
            <span>Ocurrió un error al eliminar el duende. Probá nuevamente.</span>
        </div>
    <?php endif; ?>

    <?php if (count($duendes) > 0): ?>
        <div class="panel-glass overflow-hidden rounded-3xl border border-arcade-cyan/30 shadow-neon">
            <div class="overflow-x-auto">
                <table class="arcade-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Rareza</th>
                            <th>Elemento</th>
                            <th>Disponible</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($duendes as $d): ?>
                            <tr>
                                <td class="font-mono text-sm text-slate-300">#<?php echo $d['id_duende']; ?></td>
                                <td>
                                    <p class="font-semibold text-white"><?php echo htmlspecialchars($d['nombre']); ?></p>
                                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Popularidad: <?php echo (int)($d['popularidad'] ?? 0); ?>/100</p>
                                </td>
                                <td><?php echo htmlspecialchars($d['tipo'] ?? '-'); ?></td>
                                <td><?php echo number_format($d['precio_en_oro'], 2); ?> 🪙</td>
                                <td><?php echo htmlspecialchars($d['rareza'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($d['elemento'] ?? '-'); ?></td>
                                <td class="text-center">
                                    <?php if ($d['disponible']): ?>
                                        <span class="stat-chip text-xs">Activo</span>
                                    <?php else: ?>
                                        <span class="stat-chip text-xs" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-mitico), 0.85), rgba(var(--rareza-rgb-raro), 0.75));">Pausado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="whitespace-nowrap text-sm">
                                    <a href="<?php echo admin_url('duende_editar', ['id' => $d['id_duende']]); ?>" class="text-arcade-cyan hover:text-arcade-magenta">✏️ Editar</a>
                                    <span class="text-slate-500">|</span>
                                    <a href="#" onclick="confirmarBorrado(<?php echo $d['id_duende']; ?>, '<?php echo htmlspecialchars($d['nombre'], ENT_QUOTES); ?>'); return false;" class="text-arcade-magenta hover:text-arcade-gold">🗑️ Borrar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="panel-glass rounded-3xl border border-dashed border-arcade-cyan/40 p-10 text-center shadow-neon">
            <p class="text-lg font-semibold text-white">Todavía no hay duendes registrados.</p>
            <p class="mt-2 text-sm text-slate-300">Creá el primero para abrir el portal de criaturas místicas.</p>
            <a href="<?php echo admin_url('duende_crear'); ?>" class="button-arcade mt-6">+ Crear duende</a>
        </div>
    <?php endif; ?>
</div>

<script>
function confirmarBorrado(id, nombre) {
    if (confirm('¿Estás seguro de que quieres eliminar el duende "' + nombre + '"?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/duende/borrar/' + id + '?confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
