<?php
require_once __DIR__ . '/includes/header.php';

$blogs = Blog::all();
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['success']);
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Blogs</h1>
        <p class="admin-section-subtitle">Publicá historias, mantené slugs brillantes y alimentá el lore de la tienda</p>
    </div>
    <a href="<?php echo admin_url('blog_crear'); ?>" class="btn-arc btn-arc--primary">
        <span>+ Crear Blog</span>
    </a>
</div>

<!-- Alerts -->
<?php if ($success): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span><?php echo htmlspecialchars($success); ?></span>
    </div>
<?php endif; ?>

<?php if ($msg === 'eliminado'): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span>Blog eliminado correctamente</span>
    </div>
<?php endif; ?>

<?php if ($error === 'no_eliminar'): ?>
    <div class="alert alert-error">
        <span class="alert__icon">✗</span>
        <span>Ocurrió un error al eliminar el blog. Intentá nuevamente</span>
    </div>
<?php endif; ?>

<!-- Blogs Table -->
<?php if (count($blogs) > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
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
                        <td>
                            <span class="admin-table__id">#<?php echo $b['id_blog']; ?></span>
                        </td>
                        <td>
                            <div>
                                <span class="admin-table__name-main"><?php echo htmlspecialchars($b['titulo']); ?></span>
                                <span class="admin-table__name-sub">Publicado: <?php echo date('d/m/Y', strtotime($b['fecha_publicacion'])); ?></span>
                            </div>
                        </td>
                        <td>
                            <code class="admin-table__slug"><?php echo htmlspecialchars($b['slug']); ?></code>
                        </td>
                        <td><?php echo htmlspecialchars($b['autor'] ?? '-'); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($b['fecha_publicacion'])); ?></td>
                        <td>
                            <div class="admin-table__actions">
                                <a href="<?php echo admin_url('blog_editar', ['id' => $b['id_blog']]); ?>" class="admin-action-link admin-action-link--edit">
                                    ✏️ Editar
                                </a>
                                <a href="#" onclick="confirmarBorrado(<?php echo $b['id_blog']; ?>, '<?php echo htmlspecialchars($b['titulo'], ENT_QUOTES); ?>'); return false;" class="admin-action-link admin-action-link--delete">
                                    🗑️ Borrar
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="admin-empty-state">
        <div class="admin-empty-state__icon">📝</div>
        <h3 class="admin-empty-state__title">Ningún artículo publicado todavía</h3>
        <p class="admin-empty-state__text">Dale voz a la tienda contando historias místicas en el blog</p>
        <a href="<?php echo admin_url('blog_crear'); ?>" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>+ Crear Entrada</span>
        </a>
    </div>
<?php endif; ?>

<script>
function confirmarBorrado(id, titulo) {
    if (confirm('¿Estás seguro de que quieres eliminar el blog "' + titulo + '"?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/blog/borrar/' + id + '?confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
