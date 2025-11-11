<?php
// admin/actions/usuario_crear_acc.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../../classes/Usuario.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . admin_url('usuarios'));
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

if ($nombre === '' || $email === '' || $password === '' || $password2 === '') {
    $_SESSION['error'] = 'Completá los campos obligatorios.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . admin_url('usuario_crear'));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'El email no tiene un formato válido.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . admin_url('usuario_crear'));
    exit;
}

if (!in_array($rol, ['usuario', 'admin'], true)) {
    $_SESSION['error'] = 'El rol seleccionado no es válido.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . admin_url('usuario_crear'));
    exit;
}

if ($password !== $password2) {
    $_SESSION['error'] = 'Las contraseñas no coinciden.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . admin_url('usuario_crear'));
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . admin_url('usuario_crear'));
    exit;
}

if (Usuario::emailExists($email)) {
    $_SESSION['error'] = 'El email ya está registrado.';
    $_SESSION['old_data'] = $old;
    header('Location: ' . admin_url('usuario_crear'));
    exit;
}

$data = [
    'nombre' => $nombre,
    'apellido' => $apellido,
    'email' => $email,
    'password' => $password,
    'rol' => $rol,
    'activo' => $activo,
];

if (Usuario::createAdmin($data)) {
    $_SESSION['success'] = 'Usuario creado correctamente.';
    header('Location: ' . admin_url('usuarios'));
    exit;
}

$_SESSION['error'] = 'No se pudo crear el usuario. Intentá nuevamente.';
$_SESSION['old_data'] = $old;
header('Location: ' . admin_url('usuario_crear'));
exit;
