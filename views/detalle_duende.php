<?php
require_once "classes/Duende.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$duende = null;
try {
    $duende = Duende::find($id);
} catch (Exception $e) {
    error_log("Error al obtener detalle del duende: " . $e->getMessage());
}

if (!$duende): ?>
<p>Duende no encontrado.</p>
<?php else: ?>
<h1><?php echo htmlspecialchars($duende['nombre'] ?? 'Sin nombre'); ?></h1>
<p>Tipo: <?php echo htmlspecialchars($duende['tipo'] ?? '-'); ?></p>
<p>Rareza: <?php echo htmlspecialchars($duende['rareza'] ?? '-'); ?></p>
<p>Elemento: <?php echo htmlspecialchars($duende['elemento'] ?? '-'); ?></p>
<p>Efecto mágico: <?php echo htmlspecialchars($duende['efecto_magico'] ?? '-'); ?></p>
<p>Precio: <?php echo isset($duende['precio_en_oro']) ? number_format($duende['precio_en_oro'], 2) : '0.00'; ?> oro</p>
<p><?php echo nl2br(htmlspecialchars($duende['descripcion'] ?? '')); ?></p>
<?php if (!empty($_SESSION['usuario'])): ?>
    <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php">
        <input type="hidden" name="action" value="agregar">
        <input type="hidden" name="id_duende" value="<?php echo $duende['id_duende']; ?>">
        <input type="hidden" name="redirect" value="detalle_duende&id=<?php echo $duende['id_duende']; ?>">
        <button type="submit">Agregar al carrito</button>
    </form>
<?php else: ?>
    <p><a href="<?php echo url('login'); ?>">Ingresá</a> para agregar al carrito.</p>
<?php endif; ?>
<?php endif; ?>
