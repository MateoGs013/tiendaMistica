<?php
$error = $_SESSION['error'] ?? null;
$oldNombre = $_SESSION['old_nombre'] ?? '';
$oldEmail = $_SESSION['old_email'] ?? '';

unset($_SESSION['error'], $_SESSION['old_nombre'], $_SESSION['old_email']);
?>

<!-- Hero Section -->
<div class="login-hero">
    <h1 class="login-hero__title">Crear Cuenta</h1>
    <p class="login-hero__subtitle">Sumate para guardar favoritos, adoptar duendes y seguir misiones retro</p>
</div>

<!-- Alert -->
<?php if ($error): ?>
    <div class="alert alert-error">
        <span class="alert__icon">✗</span>
        <span><?php echo htmlspecialchars($error); ?></span>
    </div>
<?php endif; ?>

<!-- Registration Form -->
<div class="login-container">
    <form method="post" action="/tienda_mistica/actions/registro_acc.php" class="login-form">
        <div class="form-group">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" required value="<?php echo htmlspecialchars($oldNombre); ?>" class="form-input">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($oldEmail); ?>" class="form-input">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Contraseña (mínimo 6 caracteres)</label>
            <input type="password" name="password" id="password" required minlength="6" class="form-input">
        </div>

        <div class="form-group">
            <label for="password2" class="form-label">Repetir Contraseña</label>
            <input type="password" name="password2" id="password2" required minlength="6" class="form-input">
        </div>

        <button type="submit" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Registrarme</span>
        </button>

        <p class="login-form__link">
            ¿Ya tenés cuenta? <a href="index.php?sec=login" class="link-primary">Ingresá aquí</a>
        </p>
    </form>
</div>
