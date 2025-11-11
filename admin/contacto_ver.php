<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Contacto.php';

$id = (int)($_GET['id'] ?? 0);
$contacto = Contacto::find($id);

if (!$contacto) {
    echo "<p>Mensaje no encontrado</p>";
    echo "<a href='" . admin_url('contactos') . "'>Volver al listado</a>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
?>
<h1>Detalle del Mensaje de Contacto</h1>

<div style="max-width: 800px; background: #f8f9fa; padding: 20px; border-radius: 8px;">
    <p><strong>ID:</strong> <?php echo $contacto['id_contacto']; ?></p>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($contacto['nombre']); ?></p>
    <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($contacto['email']); ?>"><?php echo htmlspecialchars($contacto['email']); ?></a></p>
    <p><strong>Fecha de Envío:</strong> <?php echo date('d/m/Y H:i:s', strtotime($contacto['fecha_envio'])); ?></p>
    
    <hr>
    
    <p><strong>Mensaje:</strong></p>
    <div style="background: white; padding: 15px; border-radius: 4px; white-space: pre-wrap;">
<?php echo htmlspecialchars($contacto['mensaje']); ?>
    </div>
</div>

<p style="margin-top: 20px;">
    <a href="<?php echo admin_url('contactos'); ?>" style="background: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">← Volver al listado</a>
    <a href="#" onclick="confirmarBorrado(<?php echo $contacto['id_contacto']; ?>); return false;" style="background: #dc3545; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; margin-left: 10px;">🗑️ Eliminar mensaje</a>
</p>

<script>
function confirmarBorrado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este mensaje?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = 'actions/contacto_borrar_acc.php?id=' + id + '&confirmar=1';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
