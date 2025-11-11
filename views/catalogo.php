<?php
require_once "classes/Duende.php";

$duendes = [];
try {
    $duendes = Duende::allDisponibles();
} catch (Exception $e) {
    error_log("Error al obtener duendes: " . $e->getMessage());
}

$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);
?>

<h1>Catálogo de Duendes</h1>

<?php if ($mensaje): ?>
    <p style="color:green; padding:10px; background:#e8f5e9; border:1px solid #4caf50;">
        <strong>✓ <?php echo htmlspecialchars($mensaje); ?></strong>
    </p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color:red; padding:10px; background:#ffebee; border:1px solid #f44336;">
        <strong>✗ <?php echo htmlspecialchars($error); ?></strong>
    </p>
<?php endif; ?>

<p><?php echo count($duendes); ?> duendes disponibles</p>

<?php if (empty($duendes)): ?>
    <p>No hay duendes disponibles en este momento</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nombre</th>
            <th>Rareza</th>
            <th>Elemento</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($duendes as $d): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($d['nombre']); ?></strong></td>
                <td><?php echo htmlspecialchars($d['rareza'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($d['elemento'] ?? '-'); ?></td>
                <td><?php echo number_format($d['precio_en_oro'], 2); ?> oro</td>
                <td>
                    <a href="<?php echo url('detalle_duende', ['id' => $d['id_duende']]); ?>">Ver</a>
                    <?php if (!empty($_SESSION['usuario'])): ?>
                        <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" style="display: inline;">
                            <input type="hidden" name="action" value="agregar">
                            <input type="hidden" name="id_duende" value="<?php echo $d['id_duende']; ?>">
                            <input type="hidden" name="redirect" value="catalogo">
                            <button type="submit">Agregar al Carrito</button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo url('login'); ?>">Login para comprar</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
