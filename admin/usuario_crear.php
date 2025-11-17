<?php
require_once __DIR__ . '/includes/header.php';

$error = $_SESSION['error'] ?? null;
$old = $_SESSION['old_data'] ?? [];
unset($_SESSION['error'], $_SESSION['old_data']);
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Crear Usuario</h1>
        <p class="admin-section-subtitle">Asigná credenciales y rol para sumar a la tripulación</p>
    </div>
    <a href="index.php?sec=usuarios" class="btn-arc btn-arc--ghost">
        <span>← Volver al listado</span>
    </a>
</div>

<!-- Alerts -->
<?php if ($error): ?>
    <div class="alert alert-error">
        <span class="alert__icon">✗</span>
        <span><?php echo htmlspecialchars($error); ?></span>
    </div>
<?php endif; ?>

<!-- User Form -->
<form method="post" action="actions/usuario_crear_acc.php" class="admin-form">
    <!-- Basic Info -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Datos Principales</h2>
        <div class="admin-form-grid">
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre*</label>
                <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($old['nombre'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($old['apellido'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group form-group--full">
                <label for="email" class="form-label">Email*</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="rol" class="form-label">Rol*</label>
                <?php $rolActual = $old['rol'] ?? 'usuario'; ?>
                <select id="rol" name="rol" required class="form-input">
                    <option value="usuario" <?php echo $rolActual === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                    <option value="admin" <?php echo $rolActual === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="admin-checkbox">
                    <input type="checkbox" name="activo" value="1" <?php echo isset($old['activo']) ? ($old['activo'] ? 'checked' : '') : 'checked'; ?>>
                    <span>Usuario Activo</span>
                </label>
            </div>
        </div>
    </div>
    
    <!-- Credentials -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Credenciales</h2>
        <div class="admin-form-grid">
            <div class="form-group">
                <label for="password" class="form-label">Contraseña* (mínimo 6 caracteres)</label>
                <input type="password" id="password" name="password" required minlength="6" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="password2" class="form-label">Confirmar Contraseña*</label>
                <input type="password" id="password2" name="password2" required minlength="6" class="form-input">
            </div>
        </div>
    </div>
    
    <!-- Form Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Crear Usuario</span>
        </button>
        <a href="index.php?sec=usuarios" class="btn-arc btn-arc--ghost btn-arc--lg">
            <span>Cancelar</span>
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
