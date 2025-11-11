<?php
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$oldEmail = $_SESSION['old_email'] ?? '';

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_email']);
?>
<h1>Ingresar</h1>
<?php if ($success): ?><p style="color:green;"><?php echo htmlspecialchars($success); ?></p><?php endif; ?>
<?php if ($error): ?><p style="color:red;"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
<form method="post" action="/tienda_mistica/actions/login_acc.php">
    <label>Email: <input type="email" name="email" required value="<?php echo htmlspecialchars($oldEmail); ?>"></label><br>
    <label>Contraseña: <input type="password" name="password" required></label><br>
    <button type="submit">Ingresar</button>
</form>
<p>¿No tienes cuenta? <a href="<?php echo url('registro'); ?>">Regístrate aquí</a></p>
