<?php
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$oldEmail = $_SESSION['old_email'] ?? '';

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_email']);
?>

<!-- Hero Section -->
<div class="login-hero">
    <h1 class="login-hero__title">Iniciar Sesión</h1>
    <p class="login-hero__subtitle">Ingresá para ver tus pedidos y seguir tu aventura mística</p>
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

<!-- Login Form -->
<div class="login-container">
    <form method="post" action="/tienda_mistica/actions/login_acc.php" class="login-form">
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($oldEmail); ?>" class="form-input">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" required class="form-input">
        </div>

        <button type="submit" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Ingresar</span>
        </button>

        <p class="login-form__link">
            ¿No tenés cuenta? <a href="<?php echo url('registro'); ?>" class="link-primary">Registrate aquí</a>
        </p>
    </form>
</div>
