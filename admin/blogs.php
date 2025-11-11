<?php
require_once __DIR__ . '/includes/header.php';

$blogs = Blog::all();
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['success']);
?>
<h1>Gestión de Blogs</h1>

<?php if ($success): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 4px;">✓ <?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if ($msg === 'eliminado'): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 4px;">✓ Blog eliminado correctamente</p>
<?php endif; ?>

<?php if ($error === 'no_eliminar'): ?>
    <p style="color: red; background: #f8d7da; padding: 10px; border-radius: 4px;">✗ Error al eliminar el blog</p>
<?php endif; ?>

<p><a href="<?php echo admin_url('blog_crear'); ?>" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">+ Crear nuevo blog</a></p>

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
<thead style="background: #f8f9fa;">
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
    <td><?php echo $b['id_blog']; ?></td>
    <td><strong><?php echo htmlspecialchars($b['titulo']); ?></strong></td>
    <td><?php echo htmlspecialchars($b['slug']); ?></td>
    <td><?php echo htmlspecialchars($b['autor'] ?? '-'); ?></td>
    <td><?php echo date('d/m/Y', strtotime($b['fecha_publicacion'])); ?></td>
    <td style="white-space: nowrap;">
        <a href="<?php echo admin_url('blog_editar', ['id' => $b['id_blog']]); ?>" style="color: #007bff;">✏️ Editar</a> |
        <a href="#" onclick="confirmarBorrado(<?php echo $b['id_blog']; ?>, '<?php echo htmlspecialchars($b['titulo'], ENT_QUOTES); ?>'); return false;" style="color: #dc3545;">🗑️ Borrar</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php if (count($blogs) === 0): ?>
    <p style="padding: 20px; background: #f8f9fa; text-align: center;">No hay blogs registrados. <a href="<?php echo admin_url('blog_crear'); ?>">Crear el primero</a></p>
<?php endif; ?>

<script>
function confirmarBorrado(id, titulo) {
    if (confirm('¿Estás seguro de que quieres eliminar el blog "' + titulo + '"?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/blog/borrar/' + id + '?confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
