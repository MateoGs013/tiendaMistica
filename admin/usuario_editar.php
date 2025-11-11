<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Usuario.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$usuario = Usuario::find($id);

if (!$usuario) {
    echo '<p>Usuario no encontrado.</p>';
    echo '<p><a href="' . admin_url('usuarios') . '">Volver al listado</a></p>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$old = $_SESSION['old_data'] ?? [];
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_data']);

$form = array_merge($usuario, $old);
?>
<h1>Editar Usuario #<?php echo (int)$usuario['id_usuario']; ?></h1>

<?php if ($success): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 4px;">✓ <?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color: red; background: #f8d7da; padding: 10px; border-radius: 4px;">✗ <?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="/tienda_mistica/admin/actions/usuario_editar_acc.php" style="max-width: 600px;">
    <input type="hidden" name="id" value="<?php echo (int)$usuario['id_usuario']; ?>">
    <fieldset>
        <legend>Datos principales</legend>
        <label>Nombre *<br>
            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($form['nombre'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        <label>Apellido<br>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($form['apellido'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        <label>Email *<br>
            <input type="email" name="email" required value="<?php echo htmlspecialchars($form['email'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        <label>Rol *<br>
            <select name="rol" required>
                <?php $rolActual = $form['rol'] ?? 'usuario'; ?>
                <option value="usuario" <?php echo $rolActual === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                <option value="admin" <?php echo $rolActual === 'admin' ? 'selected' : ''; ?>>Administrador</option>
            </select>
        </label><br><br>
        <label>
            <input type="checkbox" name="activo" value="1" <?php echo !empty($form['activo']) ? 'checked' : ''; ?>>
            Usuario activo
        </label>
    </fieldset>

    <fieldset>
        <legend>Contraseña</legend>
        <p style="font-size: 0.9em; color: #555;">Dejá los campos vacíos si no querés modificar la contraseña.</p>
        <label>Nueva contraseña<br>
            <input type="password" name="password" minlength="6" style="width: 100%;">
        </label><br><br>
        <label>Confirmar nueva contraseña<br>
            <input type="password" name="password2" minlength="6" style="width: 100%;">
        </label>
    </fieldset>

    <p>
        <button type="submit" style="padding: 10px 20px;">Guardar cambios</button>
        <a href="<?php echo admin_url('usuarios'); ?>" style="margin-left: 10px;">Cancelar</a>
    </p>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
