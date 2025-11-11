<?php
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
$oldNombre = $_SESSION['old_nombre'] ?? '';
$oldEmail = $_SESSION['old_email'] ?? '';
$oldMensaje = $_SESSION['old_mensaje'] ?? '';

unset($_SESSION['success'], $_SESSION['error'], $_SESSION['old_nombre'], $_SESSION['old_email'], $_SESSION['old_mensaje']);
?>
<h1>Contacto</h1>
<?php if ($success): ?><p style="color:green;"><?php echo htmlspecialchars($success); ?></p><?php endif; ?>
<?php if ($error): ?><p style="color:red;"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
<form method="post" action="/tienda_mistica/actions/contacto_acc.php">
    <label>Nombre: <input type="text" name="nombre" required value="<?php echo htmlspecialchars($oldNombre); ?>"></label><br>
    <label>Email: <input type="email" name="email" required value="<?php echo htmlspecialchars($oldEmail); ?>"></label><br>
    <label>Mensaje:<br><textarea name="mensaje" required><?php echo htmlspecialchars($oldMensaje); ?></textarea></label><br>
    <button type="submit">Enviar</button>
</form>
