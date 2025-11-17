<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Usuario.php';

$usuarios = Usuario::all();
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
$usuarioActual = $_SESSION['usuario']['id_usuario'] ?? null;
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Usuarios</h1>
        <p class="admin-section-subtitle">Administrá roles, accesos y estados de la tripulación de la tienda</p>
    </div>
    <a href="index.php?sec=usuario_crear" class="btn-arc btn-arc--primary">
        <span>+ Crear Usuario</span>
    </a>
</div>

<!-- Alerts -->
<?php if ($success): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span><?php echo htmlspecialchars($success); ?></span>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error">
        <span class="alert__icon">✗</span>
        <span><?php echo htmlspecialchars($error); ?></span>
    </div>
<?php endif; ?>

<!-- Users Table -->
<?php if (count($usuarios) > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
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
                    <?php $activo = (int)($usuario['activo'] ?? 0) === 1; ?>
                    <tr>
                        <td>
                            <span class="admin-table__id">#<?php echo (int)$usuario['id_usuario']; ?></span>
                        </td>
                        <td>
                            <span class="admin-table__name-main"><?php echo htmlspecialchars(trim(($usuario['nombre'] ?? '') . ' ' . ($usuario['apellido'] ?? '')) ?: ($usuario['nombre'] ?? '')); ?></span>
                        </td>
                        <td>
                            <a href="mailto:<?php echo htmlspecialchars($usuario['email']); ?>" class="admin-action-link admin-action-link--edit">
                                <?php echo htmlspecialchars($usuario['email']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars(ucfirst($usuario['rol'] ?? 'usuario')); ?></td>
                        <td>
                            <?php if ($activo): ?>
                                <span class="admin-badge admin-badge--success">Activo</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge--inactive">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_alta'] ?? 'now')); ?></td>
                        <td class="admin-table__actions">
                            <a href="index.php?sec=usuario_editar&id=<?php echo $usuario['id_usuario']; ?>" class="admin-action-link admin-action-link--edit">
                                ✏️ Editar
                            </a>
                            <?php if ((int)$usuario['id_usuario'] !== (int)$usuarioActual): ?>
                                <form method="post" action="actions/usuario_estado_acc.php" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo (int)$usuario['id_usuario']; ?>">
                                    <input type="hidden" name="activo" value="<?php echo $activo ? 0 : 1; ?>">
                                    <button type="submit" class="admin-action-link <?php echo $activo ? 'admin-action-link--delete' : 'admin-action-link--activate'; ?>">
                                        <?php echo $activo ? '🔴 Desactivar' : '✅ Activar'; ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="admin-badge admin-badge--warning">Sesión Actual</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="admin-empty-state">
        <div class="admin-empty-state__icon">👥</div>
        <h3 class="admin-empty-state__title">No hay usuarios registrados</h3>
        <p class="admin-empty-state__text">Creá el primero para compartir el control del panel</p>
        <a href="index.php?sec=usuario_crear" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>+ Crear Usuario</span>
        </a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
