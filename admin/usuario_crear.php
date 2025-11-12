<?php
require_once __DIR__ . '/includes/header.php';

$error = $_SESSION['error'] ?? null;
$old = $_SESSION['old_data'] ?? [];
unset($_SESSION['error'], $_SESSION['old_data']);
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Crear usuario</h1>
            <p class="text-sm text-slate-300">Asigná credenciales y rol para sumar a la tripulación.</p>
        </div>
        <a href="<?php echo admin_url('usuarios'); ?>" class="button-ghost">← Volver al listado</a>
    </div>

    <?php if ($error): ?>
        <div class="alert-arcade alert-error">
            <span class="status-dot offline"></span>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <form method="post" action="/tienda_mistica/admin/actions/usuario_crear_acc.php" class="space-y-8">
        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Datos principales</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label">
                    Nombre*
                    <input type="text" name="nombre" required value="<?php echo htmlspecialchars($old['nombre'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Apellido
                    <input type="text" name="apellido" value="<?php echo htmlspecialchars($old['apellido'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label md:col-span-2">
                    Email*
                    <input type="email" name="email" required value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Rol*
                    <?php $rolActual = $old['rol'] ?? 'usuario'; ?>
                    <select name="rol" required class="arcade-select mt-2">
                        <option value="usuario" <?php echo $rolActual === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                        <option value="admin" <?php echo $rolActual === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </label>
                <label class="arcade-label flex items-center gap-3 text-xs uppercase tracking-[0.2em]">
                    <input type="checkbox" name="activo" value="1" class="h-5 w-5 rounded border border-arcade-cyan/40 bg-arcade-panel/70 text-arcade-cyan focus:ring-arcade-magenta/60" <?php echo isset($old['activo']) ? ($old['activo'] ? 'checked' : '') : 'checked'; ?>>
                    Usuario activo
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Credenciales</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label">
                    Contraseña* (mínimo 6 caracteres)
                    <input type="password" name="password" required minlength="6" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Confirmar contraseña*
                    <input type="password" name="password2" required minlength="6" class="arcade-input mt-2">
                </label>
            </div>
        </section>

        <div class="flex flex-wrap items-center gap-4">
            <button type="submit" class="button-arcade">Crear usuario</button>
            <a href="<?php echo admin_url('usuarios'); ?>" class="button-ghost">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
