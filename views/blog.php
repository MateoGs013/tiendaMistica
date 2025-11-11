<?php
require_once "classes/Blog.php";

$blogs = [];
try {
    $blogs = Blog::latest();
} catch (Exception $e) {
    error_log("Error al cargar blogs: " . $e->getMessage());
}
?>
<h1>Crónicas del Bosque</h1>
<?php if (empty($blogs)): ?>
    <p>No hay artículos disponibles en este momento.</p>
<?php else: ?>
<ul>
<?php foreach ($blogs as $b): ?>
    <li>
        <strong><?php echo htmlspecialchars($b['titulo'] ?? 'Sin título'); ?></strong>
        (<?php echo htmlspecialchars($b['fecha_publicacion'] ?? ''); ?>)<br>
        <?php echo htmlspecialchars($b['descripcion_corta'] ?? ''); ?>
    </li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
