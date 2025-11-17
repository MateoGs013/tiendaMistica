<?php
// actions/registro_acc.php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $p1 = $_POST['password'] ?? '';
    $p2 = $_POST['password2'] ?? '';
    
    if (empty($nombre) || empty($email) || empty($p1) || empty($p2)) {
        $_SESSION['error'] = "Por favor completa todos los campos";
        $_SESSION['old_nombre'] = $nombre;
        $_SESSION['old_email'] = $email;
        header("Location: ../index.php?sec=registro");
        exit;
    }
    
    if ($p1 !== $p2) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
        $_SESSION['old_nombre'] = $nombre;
        $_SESSION['old_email'] = $email;
        header("Location: ../index.php?sec=registro");
        exit;
    }
    
    if (strlen($p1) < 6) {
        $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
        $_SESSION['old_nombre'] = $nombre;
        $_SESSION['old_email'] = $email;
        header("Location: ../index.php?sec=registro");
        exit;
    }
    
    try {
        if (Usuario::create($nombre, $email, $p1)) {
            $_SESSION['success'] = 'Registro exitoso. Ya puedes ingresar.';
            header("Location: ../index.php?sec=login");
            exit;
        } else {
            $_SESSION['error'] = "No se pudo registrar. El email ya está en uso.";
            $_SESSION['old_nombre'] = $nombre;
            $_SESSION['old_email'] = $email;
            header("Location: ../index.php?sec=registro");
            exit;
        }
    } catch (Exception $e) {
        error_log("Error al registrar usuario: " . $e->getMessage());
        $_SESSION['error'] = "Error al registrar el usuario. Por favor, intenta nuevamente.";
        $_SESSION['old_nombre'] = $nombre;
        $_SESSION['old_email'] = $email;
        header("Location: ../index.php?sec=registro");
        exit;
    }
} else {
    header("Location: ../index.php?sec=registro");
    exit;
}
