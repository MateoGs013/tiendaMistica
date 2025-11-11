<?php
$error = $_SESSION['error'] ?? null;
$oldNombre = $_SESSION['old_nombre'] ?? '';
$oldEmail = $_SESSION['old_email'] ?? '';

unset($_SESSION['error'], $_SESSION['old_nombre'], $_SESSION['old_email']);
?>
<h1>Registro</h1>
<?php if ($error): ?><p style="color:red;"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
<form method="post" action="/tienda_mistica/actions/registro_acc.php">
    <label>Nombre: <input type="text" name="nombre" required value="<?php echo htmlspecialchars($oldNombre); ?>"></label><br>
    <label>Email: <input type="email" name="email" required value="<?php echo htmlspecialchars($oldEmail); ?>"></label><br>
    <label>Contraseña: <input type="password" name="password" required minlength="6"></label><br>
    <label>Repetir: <input type="password" name="password2" required minlength="6"></label><br>
    <button type="submit">Registrarse</button>
</form>
<p>¿Ya tienes cuenta? <a href="<?php echo url('login'); ?>">Ingresa aquí</a></p>
