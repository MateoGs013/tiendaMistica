<?php
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
$oldNombre = $_SESSION['old_nombre'] ?? '';
$oldEmail = $_SESSION['old_email'] ?? '';
$oldMensaje = $_SESSION['old_mensaje'] ?? '';

unset($_SESSION['success'], $_SESSION['error'], $_SESSION['old_nombre'], $_SESSION['old_email'], $_SESSION['old_mensaje']);
?>

<!-- Hero Section -->
<div class="contacto-hero">
    <h1 class="contacto-hero__title">Contacto</h1>
    <p class="contacto-hero__subtitle">Enviá tu mensaje para recibir asistencia mágica personalizada</p>
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

<!-- Contact Form -->
<div class="contacto-container">
    <form method="post" action="actions/contacto_acc.php" class="contacto-form">
        <div class="contacto-form__row">
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" required value="<?php echo htmlspecialchars($oldNombre); ?>" class="form-input">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email de Contacto</label>
                <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($oldEmail); ?>" class="form-input">
            </div>
        </div>

        <div class="form-group">
            <label for="mensaje" class="form-label">Mensaje</label>
            <textarea name="mensaje" id="mensaje" rows="6" required class="form-input form-textarea"><?php echo htmlspecialchars($oldMensaje); ?></textarea>
        </div>

        <div class="contacto-form__note">
            Te responderemos en menos de 24 horas con recomendaciones personalizadas
        </div>

        <button type="submit" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Enviar Mensaje</span>
        </button>
    </form>
</div>
