<?php
require_once __DIR__ . '/includes/header.php';

$contactos = Contacto::todos();
$msg = $_GET['msg'] ?? null;
?>
<h1>Mensajes de Contacto</h1>

<?php if ($msg === 'eliminado'): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 4px;">✓ Mensaje eliminado correctamente</p>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
<thead style="background: #f8f9fa;">
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
    <td><?php echo $c['id_contacto']; ?></td>
    <td><?php echo htmlspecialchars($c['nombre']); ?></td>
    <td><?php echo htmlspecialchars($c['email']); ?></td>
    <td style="max-width: 400px;"><?php echo htmlspecialchars(substr($c['mensaje'], 0, 100)); ?><?php echo strlen($c['mensaje']) > 100 ? '...' : ''; ?></td>
    <td><?php echo date('d/m/Y H:i', strtotime($c['fecha_envio'])); ?></td>
    <td style="white-space: nowrap;">
        <a href="<?php echo admin_url('contacto_ver', ['id' => $c['id_contacto']]); ?>" style="color: #007bff;">👁️ Ver</a> |
        <a href="#" onclick="confirmarBorrado(<?php echo $c['id_contacto']; ?>); return false;" style="color: #dc3545;">🗑️ Borrar</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php if (count($contactos) === 0): ?>
    <p style="padding: 20px; background: #f8f9fa; text-align: center;">No hay mensajes de contacto</p>
<?php endif; ?>

<script>
function confirmarBorrado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este mensaje?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '/tienda_mistica/admin/contacto/borrar/' + id + '?confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
