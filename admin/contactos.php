<?php
require_once __DIR__ . '/includes/header.php';

$contactos = Contacto::todos();
$msg = $_GET['msg'] ?? null;
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Mensajes de contacto</h1>
            <p class="text-sm text-slate-300">Monitorizá las señales entrantes y respondé a la comunidad.</p>
        </div>
    </div>

    <?php if ($msg === 'eliminado'): ?>
        <div class="alert-arcade alert-success">
            <span class="status-dot"></span>
            <span>Mensaje eliminado correctamente.</span>
        </div>
    <?php endif; ?>

    <?php if (count($contactos) > 0): ?>
        <div class="panel-glass overflow-hidden rounded-3xl border border-arcade-cyan/30 shadow-neon">
            <div class="overflow-x-auto">
                <table class="arcade-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contactos as $c): ?>
                            <tr>
                                <td class="font-mono text-sm text-slate-300">#<?php echo $c['id_contacto']; ?></td>
                                <td><?php echo htmlspecialchars($c['nombre']); ?></td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($c['email']); ?>" class="text-arcade-cyan hover:text-arcade-magenta"><?php echo htmlspecialchars($c['email']); ?></a>
                                </td>
                                <td class="max-w-xs">
                                    <p class="line-clamp-3 text-sm text-slate-200"><?php echo htmlspecialchars($c['mensaje']); ?></p>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($c['fecha_envio'])); ?></td>
                                <td class="whitespace-nowrap text-sm">
                                    <a href="<?php echo admin_url('contacto_ver', ['id' => $c['id_contacto']]); ?>" class="text-arcade-cyan hover:text-arcade-magenta">👁️ Ver</a>
                                    <span class="text-slate-500">|</span>
                                    <a href="#" onclick="confirmarBorrado(<?php echo $c['id_contacto']; ?>); return false;" class="text-arcade-magenta hover:text-arcade-gold">🗑️ Borrar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="panel-glass rounded-3xl border border-dashed border-arcade-cyan/40 p-10 text-center shadow-neon">
            <p class="text-lg font-semibold text-white">No hay mensajes de contacto registrados.</p>
            <p class="mt-2 text-sm text-slate-300">Cuando alguien envíe una señal desde la tienda, la verás aquí.</p>
        </div>
    <?php endif; ?>
</div>

<script>
function confirmarBorrado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este mensaje?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/contacto/borrar/' + id + '?confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
