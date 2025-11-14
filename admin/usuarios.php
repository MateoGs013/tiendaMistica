<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Usuario.php';

$usuarios = Usuario::all();
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
$usuarioActual = $_SESSION['usuario']['id_usuario'] ?? null;
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Gestión de usuarios</h1>
            <p class="text-sm text-slate-300">Administrá roles, accesos y estados de la tripulación de la tienda.</p>
        </div>
        <a href="<?php echo admin_url('usuario_crear'); ?>" class="button-arcade">+ Crear nuevo usuario</a>
    </div>

    <?php if ($success): ?>
        <div class="alert-arcade alert-success">
            <span class="status-dot"></span>
            <span><?php echo htmlspecialchars($success); ?></span>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert-arcade alert-error">
            <span class="status-dot offline"></span>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <?php if (count($usuarios) > 0): ?>
        <div class="panel-glass overflow-hidden rounded-3xl border border-arcade-cyan/30 shadow-neon">
            <div class="overflow-x-auto">
                <table class="arcade-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha alta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <?php $activo = (int)($usuario['activo'] ?? 0) === 1; ?>
                            <tr>
                                <td class="font-mono text-sm text-slate-300">#<?php echo (int)$usuario['id_usuario']; ?></td>
                                <td><?php echo htmlspecialchars(trim(($usuario['nombre'] ?? '') . ' ' . ($usuario['apellido'] ?? '')) ?: ($usuario['nombre'] ?? '')); ?></td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($usuario['email']); ?>" class="text-arcade-cyan hover:text-arcade-magenta"><?php echo htmlspecialchars($usuario['email']); ?></a>
                                </td>
                                <td><?php echo htmlspecialchars(ucfirst($usuario['rol'] ?? 'usuario')); ?></td>
                                <td class="text-center">
                                    <?php if ($activo): ?>
                                        <span class="stat-chip text-xs">Activo</span>
                                    <?php else: ?>
                                        <span class="stat-chip text-xs" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-mistico), 0.72), rgba(var(--rareza-rgb-raro), 0.72));">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_alta'] ?? 'now')); ?></td>
                                <td class="whitespace-nowrap text-sm">
                                    <a href="<?php echo admin_url('usuario_editar', ['id' => $usuario['id_usuario']]); ?>" class="text-arcade-cyan hover:text-arcade-magenta">✏️ Editar</a>
                                    <?php if ((int)$usuario['id_usuario'] !== (int)$usuarioActual): ?>
                                        <span class="text-slate-500">|</span>
                                        <form method="post" action="/tienda_mistica/admin/actions/usuario_estado_acc.php" class="inline">
                                            <input type="hidden" name="id" value="<?php echo (int)$usuario['id_usuario']; ?>">
                                            <input type="hidden" name="activo" value="<?php echo $activo ? 0 : 1; ?>">
                                            <button type="submit" class="inline-flex items-center gap-1 text-xs uppercase tracking-[0.2em] <?php echo $activo ? 'text-arcade-rose hover:text-arcade-magenta' : 'text-arcade-emerald hover:text-arcade-gold'; ?>">
                                                <?php echo $activo ? 'Desactivar' : 'Activar'; ?>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="ml-2 text-xs uppercase tracking-[0.2em] text-slate-500">Sesión actual</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="panel-glass rounded-3xl border border-dashed border-arcade-cyan/40 p-10 text-center shadow-neon">
            <p class="text-lg font-semibold text-white">No hay usuarios registrados.</p>
            <p class="mt-2 text-sm text-slate-300">Creá el primero para compartir el control del panel.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
