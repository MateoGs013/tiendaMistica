<?php
// admin/actions/usuario_editar_acc.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../../classes/Usuario.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . 'admin/index.php?sec=usuarios');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['error'] = 'ID de usuario inválido.';
    header('Location: ' . 'admin/index.php?sec=usuarios');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$email = trim($_POST['email'] ?? '');
$rol = trim($_POST['rol'] ?? 'usuario');
$activo = isset($_POST['activo']) ? 1 : 0;
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

$old = [
    'nombre' => $nombre,
    'apellido' => $apellido,
    'email' => $email,
    'rol' => $rol,
    'activo' => $activo,
];

if ($nombre === '' || $email === '') {
    $_SESSION['error'] = 'El nombre y el email son obligatorios.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . 'admin/index.php?sec=usuario_editar&id=' . $id);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'El email no es válido.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . 'admin/index.php?sec=usuario_editar&id=' . $id);
    exit;
}

if (!in_array($rol, ['usuario', 'admin'], true)) {
    $_SESSION['error'] = 'El rol seleccionado no es válido.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . 'admin/index.php?sec=usuario_editar&id=' . $id);
    exit;
}

if ($password !== '' || $password2 !== '') {
    if ($password !== $password2) {
        $_SESSION['error'] = 'Las contraseñas no coinciden.';
        $_SESSION['old_data'] = $old;
        header('Location: ' . 'admin/index.php?sec=usuario_editar&id=' . $id);
        exit;
    }
    if (strlen($password) < 6) {
        $_SESSION['error'] = 'La nueva contraseña debe tener al menos 6 caracteres.';
        $_SESSION['old_data'] = $old;
        header('Location: ' . 'admin/index.php?sec=usuario_editar&id=' . $id);
        exit;
    }
}

if (Usuario::emailExists($email, $id)) {
    $_SESSION['error'] = 'Ya existe un usuario con ese email.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . 'admin/index.php?sec=usuario_editar&id=' . $id);
    exit;
}

$sesion = $_SESSION['usuario'] ?? null;
$esActual = $sesion && (int)$sesion['id_usuario'] === $id;

if ($esActual && (!$activo || $rol !== 'admin')) {
    $_SESSION['error'] = 'No podés desactivar tu propia cuenta ni quitarte el rol de administrador mientras estés logueado.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . 'admin/index.php?sec=usuario_editar&id=' . $id);
    exit;
}

$data = [
    'nombre' => $nombre,
    'apellido' => $apellido,
    'email' => $email,
    'rol' => $rol,
    'activo' => $activo,
];

if ($password !== '') {
    $data['password'] = $password;
}

if (Usuario::updateAdmin($id, $data)) {
    if ($esActual) {
        $_SESSION['usuario']['nombre'] = $nombre;
        $_SESSION['usuario']['email'] = $email;
    }
    $_SESSION['success'] = 'Usuario actualizado correctamente.';
    header('Location: ' . 'admin/index.php?sec=usuarios');
    exit;
}

$_SESSION['error'] = 'No se pudo actualizar el usuario.';
$_SESSION['old_data'] = $old;
header('Location: ' . 'admin/index.php?sec=usuario_editar&id=' . $id);
exit;
