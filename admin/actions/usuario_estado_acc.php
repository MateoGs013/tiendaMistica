<?php
// admin/actions/usuario_estado_acc.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../../classes/Usuario.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . '../index.php?sec=usuarios');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$activo = isset($_POST['activo']) ? (int)$_POST['activo'] : null;

if ($id <= 0 || ($activo !== 0 && $activo !== 1)) {
    $_SESSION['error'] = 'Datos inválidos para actualizar el usuario.';
    header('Location: ' . '../index.php?sec=usuarios');
    exit;
}

$sesion = $_SESSION['usuario'] ?? null;
if ($sesion && (int)$sesion['id_usuario'] === $id) {
    $_SESSION['error'] = 'No podés cambiar el estado de tu propia cuenta desde aquí.';
    header('Location: ' . '../index.php?sec=usuarios');
    exit;
}

if (Usuario::setActivo($id, (bool)$activo)) {
    $_SESSION['success'] = $activo ? 'Usuario activado correctamente.' : 'Usuario desactivado correctamente.';
    header('Location: ' . '../index.php?sec=usuarios');
    exit;
}

$_SESSION['error'] = 'No se pudo actualizar el estado del usuario.';
header('Location: ' . '../index.php?sec=usuarios');
exit;
