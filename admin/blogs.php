<?php
require_once __DIR__ . '/includes/header.php';

$blogs = Blog::all();
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['success']);
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Gestión de blogs</h1>
            <p class="text-sm text-slate-300">Publicá historias, mantené slugs brillantes y alimentá el lore de la tienda.</p>
        </div>
        <a href="<?php echo admin_url('blog_crear'); ?>" class="button-arcade">+ Crear nuevo blog</a>
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
            <span>Blog eliminado correctamente.</span>
        </div>
    <?php endif; ?>

    <?php if ($error === 'no_eliminar'): ?>
        <div class="alert-arcade alert-error">
            <span class="status-dot offline"></span>
            <span>Ocurrió un error al eliminar el blog. Intentá nuevamente.</span>
        </div>
    <?php endif; ?>

    <?php if (count($blogs) > 0): ?>
        <div class="panel-glass overflow-hidden rounded-3xl border border-arcade-cyan/30 shadow-neon">
            <div class="overflow-x-auto">
                <table class="arcade-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Slug</th>
                            <th>Autor</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blogs as $b): ?>
                            <tr>
                                <td class="font-mono text-sm text-slate-300">#<?php echo $b['id_blog']; ?></td>
                                <td>
                                    <p class="font-semibold text-white"><?php echo htmlspecialchars($b['titulo']); ?></p>
                                    <p class="text-xs text-slate-400">Publicado: <?php echo date('d/m/Y', strtotime($b['fecha_publicacion'])); ?></p>
                                </td>
                                <td><code class="rounded bg-arcade-panel/60 px-2 py-1 text-xs text-arcade-cyan"><?php echo htmlspecialchars($b['slug']); ?></code></td>
                                <td><?php echo htmlspecialchars($b['autor'] ?? '-'); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($b['fecha_publicacion'])); ?></td>
                                <td class="whitespace-nowrap text-sm">
                                    <a href="<?php echo admin_url('blog_editar', ['id' => $b['id_blog']]); ?>" class="text-arcade-cyan hover:text-arcade-magenta">✏️ Editar</a>
                                    <span class="text-slate-500">|</span>
                                    <a href="#" onclick="confirmarBorrado(<?php echo $b['id_blog']; ?>, '<?php echo htmlspecialchars($b['titulo'], ENT_QUOTES); ?>'); return false;" class="text-pink-400 hover:text-pink-300">🗑️ Borrar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="panel-glass rounded-3xl border border-dashed border-arcade-cyan/40 p-10 text-center shadow-neon">
            <p class="text-lg font-semibold text-white">Ningún artículo publicado todavía.</p>
            <p class="mt-2 text-sm text-slate-300">Dale voz a la tienda contando historias místicas en el blog.</p>
            <a href="<?php echo admin_url('blog_crear'); ?>" class="button-arcade mt-6">+ Crear entrada</a>
        </div>
    <?php endif; ?>
</div>

<script>
function confirmarBorrado(id, titulo) {
    if (confirm('¿Estás seguro de que quieres eliminar el blog "' + titulo + '"?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/blog/borrar/' + id + '?confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
