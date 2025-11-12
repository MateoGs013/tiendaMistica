<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Contacto.php';

$id = (int)($_GET['id'] ?? 0);
$contacto = Contacto::find($id);

if (!$contacto) {
    ?>
    <div class="panel-glass rounded-3xl border border-arcade-cyan/35 p-8 text-center shadow-neon">
        <h1 class="text-2xl font-semibold text-white">Mensaje no encontrado</h1>
        <p class="mt-3 text-sm text-slate-300">El mensaje seleccionado fue eliminado o su identificación es incorrecta.</p>
        <a href="<?php echo admin_url('contactos'); ?>" class="button-arcade mt-6 inline-flex">Volver al listado</a>
    </div>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Detalle del mensaje</h1>
            <p class="text-sm text-slate-300">Analizá la señal recibida y definí próximos pasos.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="<?php echo admin_url('contactos'); ?>" class="button-ghost">← Volver al listado</a>
            <a href="#" onclick="confirmarBorrado(<?php echo $contacto['id_contacto']; ?>); return false;" class="button-arcade">🗑️ Eliminar mensaje</a>
        </div>
    </div>

    <div class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <p class="arcade-label">ID</p>
                <p class="font-mono text-lg text-arcade-cyan">#<?php echo $contacto['id_contacto']; ?></p>
            </div>
            <div>
                <p class="arcade-label">Fecha de envío</p>
                <p class="text-sm text-slate-200"><?php echo date('d/m/Y H:i:s', strtotime($contacto['fecha_envio'])); ?></p>
            </div>
            <div>
                <p class="arcade-label">Nombre</p>
                <p class="text-base text-white"><?php echo htmlspecialchars($contacto['nombre']); ?></p>
            </div>
            <div>
                <p class="arcade-label">Email</p>
                <a href="mailto:<?php echo htmlspecialchars($contacto['email']); ?>" class="text-arcade-cyan hover:text-arcade-magenta"><?php echo htmlspecialchars($contacto['email']); ?></a>
            </div>
        </div>
        <div class="glow-divider"></div>
        <div>
            <p class="arcade-label">Mensaje</p>
            <div class="mt-3 rounded-2xl border border-arcade-magenta/30 bg-arcade-panel/60 p-5 text-sm leading-relaxed text-slate-200 shadow-inner">
                <?php echo nl2br(htmlspecialchars($contacto['mensaje'])); ?>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarBorrado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este mensaje?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/contacto/borrar/' + id + '?confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
