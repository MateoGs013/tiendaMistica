<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Usuario.php';

$usuarios = Usuario::all();
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
$usuarioActual = $_SESSION['usuario']['id_usuario'] ?? null;
?>
<h1>Gestión de Usuarios</h1>

<?php if ($success): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 4px;">✓ <?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color: red; background: #f8d7da; padding: 10px; border-radius: 4px;">✗ <?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<p><a href="<?php echo admin_url('usuario_crear'); ?>" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">+ Crear nuevo usuario</a></p>

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
<thead style="background: #f8f9fa;">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Fecha Alta</th>
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
<?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td>#<?php echo (int)$usuario['id_usuario']; ?></td>
        <td><?php echo htmlspecialchars(trim(($usuario['nombre'] ?? '') . ' ' . ($usuario['apellido'] ?? '')) ?: $usuario['nombre']); ?></td>
        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
        <td><?php echo htmlspecialchars(ucfirst($usuario['rol'] ?? 'usuario')); ?></td>
        <td style="text-align: center;">
            <?php echo (int)$usuario['activo'] === 1 ? '✓ Activo' : '✗ Inactivo'; ?>
        </td>
        <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_alta'] ?? 'now')); ?></td>
        <td style="white-space: nowrap;">
            <a href="<?php echo admin_url('usuario_editar', ['id' => $usuario['id_usuario']]); ?>" style="color: #007bff;">✏️ Editar</a>
            <?php if ((int)$usuario['id_usuario'] !== (int)$usuarioActual): ?>
                |
                <form method="post" action="/tienda_mistica/admin/actions/usuario_estado_acc.php" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo (int)$usuario['id_usuario']; ?>">
                    <input type="hidden" name="activo" value="<?php echo (int)$usuario['activo'] === 1 ? 0 : 1; ?>">
                    <button type="submit" style="background: none; border: none; color: <?php echo (int)$usuario['activo'] === 1 ? '#dc3545' : '#28a745'; ?>; cursor: pointer;">
                        <?php echo (int)$usuario['activo'] === 1 ? 'Desactivar' : 'Activar'; ?>
                    </button>
                </form>
            <?php else: ?>
                <span style="color: #6c757d;">(Sesión actual)</span>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>

<?php if (count($usuarios) === 0): ?>
    <p style="padding: 20px; background: #f8f9fa; text-align: center;">No hay usuarios registrados.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
