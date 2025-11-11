<?php
require_login();
require_once "classes/Pedido.php";
$idUsuario = (int)($_SESSION['usuario']['id_usuario'] ?? 0);
$pedidos = $idUsuario > 0 ? Pedido::porUsuario($idUsuario) : [];
?>
<h1>Mi cuenta</h1>
<p>Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>.</p>
<h2>Mis pedidos</h2>
<?php if (empty($pedidos)): ?>
    <p>No registramos pedidos con tu cuenta todavía.</p>
<?php else: ?>
    <ul>
    <?php foreach ($pedidos as $p): ?>
        <li>Pedido #<?php echo $p['id_pedido']; ?> - Total: <?php echo number_format($p['total'], 2); ?> - Estado: <?php echo htmlspecialchars($p['estado']); ?> - <?php echo date('d/m/Y H:i', strtotime($p['fecha_pedido'])); ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
