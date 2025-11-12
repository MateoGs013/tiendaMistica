<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Usuario.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$usuario = Usuario::find($id);

if (!$usuario) {
    ?>
    <div class="panel-glass rounded-3xl border border-arcade-cyan/35 p-8 text-center shadow-neon">
        <h1 class="text-2xl font-semibold text-white">Usuario no encontrado</h1>
        <p class="mt-3 text-sm text-slate-300">El perfil solicitado no existe o fue dado de baja.</p>
        <a href="<?php echo admin_url('usuarios'); ?>" class="button-arcade mt-6 inline-flex">Volver al listado</a>
    </div>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$old = $_SESSION['old_data'] ?? [];
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_data']);

$form = array_merge($usuario, $old);
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Editar usuario #<?php echo (int)$usuario['id_usuario']; ?></h1>
            <p class="text-sm text-slate-300">Actualizá datos, rol o credenciales según corresponda.</p>
        </div>
        <a href="<?php echo admin_url('usuarios'); ?>" class="button-ghost">← Volver al listado</a>
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

    <form method="post" action="/tienda_mistica/admin/actions/usuario_editar_acc.php" class="space-y-8">
        <input type="hidden" name="id" value="<?php echo (int)$usuario['id_usuario']; ?>">

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Datos principales</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label">
                    Nombre*
                    <input type="text" name="nombre" required value="<?php echo htmlspecialchars($form['nombre'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Apellido
                    <input type="text" name="apellido" value="<?php echo htmlspecialchars($form['apellido'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label md:col-span-2">
                    Email*
                    <input type="email" name="email" required value="<?php echo htmlspecialchars($form['email'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Rol*
                    <?php $rolActual = $form['rol'] ?? 'usuario'; ?>
                    <select name="rol" required class="arcade-select mt-2">
                        <option value="usuario" <?php echo $rolActual === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                        <option value="admin" <?php echo $rolActual === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </label>
                <label class="arcade-label flex items-center gap-3 text-xs uppercase tracking-[0.2em]">
                    <input type="checkbox" name="activo" value="1" class="h-5 w-5 rounded border border-arcade-cyan/40 bg-arcade-panel/70 text-arcade-cyan focus:ring-arcade-magenta/60" <?php echo !empty($form['activo']) ? 'checked' : ''; ?>>
                    Usuario activo
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Contraseña</h2>
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Dejá estos campos vacíos para mantener la contraseña actual.</p>
            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <label class="arcade-label">
                    Nueva contraseña
                    <input type="password" name="password" minlength="6" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Confirmar nueva contraseña
                    <input type="password" name="password2" minlength="6" class="arcade-input mt-2">
                </label>
            </div>
        </section>

        <div class="flex flex-wrap items-center gap-4">
            <button type="submit" class="button-arcade">Guardar cambios</button>
            <a href="<?php echo admin_url('usuarios'); ?>" class="button-ghost">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
