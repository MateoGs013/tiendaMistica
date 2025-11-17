<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Usuario.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$usuario = Usuario::find($id);

if (!$usuario) {
    ?>
    <div class="admin-empty-state">
        <div class="admin-empty-state__icon">⚠️</div>
        <h3 class="admin-empty-state__title">Usuario no encontrado</h3>
        <p class="admin-empty-state__text">El perfil solicitado no existe o fue dado de baja</p>
        <a href="admin/index.php?sec=usuarios" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Volver al listado</span>
        </a>
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

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Editar Usuario #<?php echo (int)$usuario['id_usuario']; ?></h1>
        <p class="admin-section-subtitle">Actualizá datos, rol o credenciales según corresponda</p>
    </div>
    <a href="admin/index.php?sec=usuarios" class="btn-arc btn-arc--ghost">
        <span>← Volver al listado</span>
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

<!-- User Form -->
<form method="post" action="/tienda_mistica/admin/actions/usuario_editar_acc.php" class="admin-form">
    <input type="hidden" name="id" value="<?php echo (int)$usuario['id_usuario']; ?>">
    
    <!-- Basic Info -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Datos Principales</h2>
        <div class="admin-form-grid">
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre*</label>
                <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($form['nombre'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($form['apellido'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group form-group--full">
                <label for="email" class="form-label">Email*</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($form['email'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="rol" class="form-label">Rol*</label>
                <?php $rolActual = $form['rol'] ?? 'usuario'; ?>
                <select id="rol" name="rol" required class="form-input">
                    <option value="usuario" <?php echo $rolActual === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                    <option value="admin" <?php echo $rolActual === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="admin-checkbox">
                    <input type="checkbox" name="activo" value="1" <?php echo !empty($form['activo']) ? 'checked' : ''; ?>>
                    <span>Usuario Activo</span>
                </label>
            </div>
        </div>
    </div>
    
    <!-- Credentials -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Contraseña</h2>
        <p class="admin-form-section__help">Dejá estos campos vacíos para mantener la contraseña actual</p>
        <div class="admin-form-grid">
            <div class="form-group">
                <label for="password" class="form-label">Nueva Contraseña (mínimo 6 caracteres)</label>
                <input type="password" id="password" name="password" minlength="6" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="password2" class="form-label">Confirmar Nueva Contraseña</label>
                <input type="password" id="password2" name="password2" minlength="6" class="form-input">
            </div>
        </div>
    </div>
    
    <!-- Form Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Guardar Cambios</span>
        </button>
        <a href="admin/index.php?sec=usuarios" class="btn-arc btn-arc--ghost btn-arc--lg">
            <span>Cancelar</span>
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
