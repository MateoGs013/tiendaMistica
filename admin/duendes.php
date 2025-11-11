<?php
require_once __DIR__ . '/includes/header.php';

$duendes = Duende::all();
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['success']);
?>
<h1>Gestión de Duendes</h1>

<?php if ($success): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 4px;">✓ <?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if ($msg === 'eliminado'): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 4px;">✓ Duende eliminado correctamente</p>
<?php endif; ?>

<?php if ($error === 'no_eliminar'): ?>
    <p style="color: red; background: #f8d7da; padding: 10px; border-radius: 4px;">✗ Error al eliminar el duende</p>
<?php endif; ?>

<p><a href="<?php echo admin_url('duende_crear'); ?>" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">+ Crear nuevo duende</a></p>

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
<thead style="background: #f8f9fa;">
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
    <td><?php echo $d['id_duende']; ?></td>
    <td><strong><?php echo htmlspecialchars($d['nombre']); ?></strong></td>
    <td><?php echo htmlspecialchars($d['tipo'] ?? '-'); ?></td>
    <td><?php echo number_format($d['precio_en_oro'], 2); ?> 🪙</td>
    <td><?php echo htmlspecialchars($d['rareza'] ?? '-'); ?></td>
    <td><?php echo htmlspecialchars($d['elemento'] ?? '-'); ?></td>
    <td style="text-align: center;">
        <?php echo $d['disponible'] ? '✓ Sí' : '✗ No'; ?>
    </td>
    <td style="white-space: nowrap;">
        <a href="<?php echo admin_url('duende_editar', ['id' => $d['id_duende']]); ?>" style="color: #007bff;">✏️ Editar</a> |
        <a href="#" onclick="confirmarBorrado(<?php echo $d['id_duende']; ?>, '<?php echo htmlspecialchars($d['nombre'], ENT_QUOTES); ?>'); return false;" style="color: #dc3545;">🗑️ Borrar</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php if (count($duendes) === 0): ?>
    <p style="padding: 20px; background: #f8f9fa; text-align: center;">No hay duendes registrados. <a href="<?php echo admin_url('duende_crear'); ?>">Crear el primero</a></p>
<?php endif; ?>

<script>
function confirmarBorrado(id, nombre) {
    if (confirm('¿Estás seguro de que quieres eliminar el duende "' + nombre + '"?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/duende/borrar/' + id + '?confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
