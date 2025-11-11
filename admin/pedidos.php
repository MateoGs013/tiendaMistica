<?php
require_once __DIR__ . '/includes/header.php';

$pedidos = Pedido::todos();
$msg = $_GET['msg'] ?? null;
?>
<h1>Gestión de Pedidos</h1>

<?php if ($msg === 'actualizado'): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 4px;">✓ Estado del pedido actualizado</p>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
<thead style="background: #f8f9fa;">
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Email</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
<?php foreach ($pedidos as $p): ?>
<tr>
    <td><strong>#<?php echo $p['id_pedido']; ?></strong></td>
    <td><?php echo htmlspecialchars($p['nombre']); ?></td>
    <td><?php echo htmlspecialchars($p['email']); ?></td>
    <td><strong><?php echo number_format($p['total'], 2); ?> 🪙</strong></td>
    <td>
        <span style="padding: 4px 8px; border-radius: 4px; background: <?php 
            echo $p['estado'] === 'pendiente' ? '#ffc107' : 
                ($p['estado'] === 'completado' ? '#28a745' : 
                ($p['estado'] === 'cancelado' ? '#dc3545' : '#6c757d')); 
        ?>; color: white;">
            <?php echo ucfirst($p['estado']); ?>
        </span>
    </td>
    <td><?php echo date('d/m/Y H:i', strtotime($p['fecha_pedido'])); ?></td>
    <td style="white-space: nowrap;">
        <a href="<?php echo admin_url('pedido_ver', ['id' => $p['id_pedido']]); ?>" style="color: #007bff;">👁️ Ver detalles</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php if (count($pedidos) === 0): ?>
    <p style="padding: 20px; background: #f8f9fa; text-align: center;">No hay pedidos registrados</p>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
