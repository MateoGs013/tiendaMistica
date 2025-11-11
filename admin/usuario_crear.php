<?php
require_once __DIR__ . '/includes/header.php';

$error = $_SESSION['error'] ?? null;
$old = $_SESSION['old_data'] ?? [];
unset($_SESSION['error'], $_SESSION['old_data']);
?>
<h1>Crear Usuario</h1>

<?php if ($error): ?>
    <p style="color: red; background: #f8d7da; padding: 10px; border-radius: 4px;">✗ <?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="/tienda_mistica/admin/actions/usuario_crear_acc.php" style="max-width: 600px;">
    <fieldset>
        <legend>Datos principales</legend>
        <label>Nombre *<br>
            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($old['nombre'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        <label>Apellido<br>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($old['apellido'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        <label>Email *<br>
            <input type="email" name="email" required value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        <label>Rol *<br>
            <select name="rol" required>
                <?php $rolActual = $old['rol'] ?? 'usuario'; ?>
                <option value="usuario" <?php echo $rolActual === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                <option value="admin" <?php echo $rolActual === 'admin' ? 'selected' : ''; ?>>Administrador</option>
            </select>
        </label><br><br>
        <label>
            <input type="checkbox" name="activo" value="1" <?php echo isset($old['activo']) ? ($old['activo'] ? 'checked' : '') : 'checked'; ?>>
            Usuario activo
        </label>
    </fieldset>

    <fieldset>
        <legend>Credenciales</legend>
        <label>Contraseña * (mínimo 6 caracteres)<br>
            <input type="password" name="password" required minlength="6" style="width: 100%;">
        </label><br><br>
        <label>Confirmar contraseña *<br>
            <input type="password" name="password2" required minlength="6" style="width: 100%;">
        </label>
    </fieldset>

    <p>
        <button type="submit" style="padding: 10px 20px;">Crear Usuario</button>
        <a href="<?php echo admin_url('usuarios'); ?>" style="margin-left: 10px;">Cancelar</a>
    </p>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
