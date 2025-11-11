<?php
require_login();
require_once "classes/Pedido.php";
$pedidos = Pedido::todos(); // para simplificar; podés filtrar por usuario
?>
<h1>Mi cuenta</h1>
<p>Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>.</p>
<h2>Mis pedidos</h2>
<ul>
<?php foreach ($pedidos as $p): ?>
    <li>Pedido #<?php echo $p['id_pedido']; ?> - Total: <?php echo $p['total']; ?> - Estado: <?php echo $p['estado']; ?></li>
<?php endforeach; ?>
</ul>
