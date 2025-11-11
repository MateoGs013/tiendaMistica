<?php
// actions/login_acc.php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    
    if (empty($email) || empty($pass)) {
        $_SESSION['error'] = "Por favor completa todos los campos";
        header("Location: " . url('login'));
        exit;
    }
    
    try {
        if (login_usuario($email, $pass)) {
            // Redirigir a la cuenta del usuario después del login
            header("Location: " . url('cuenta'));
            exit;
        } else {
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            $_SESSION['old_email'] = $email;
            header("Location: " . url('login'));
            exit;
        }
    } catch (Exception $e) {
        error_log("Error en login: " . $e->getMessage());
        $_SESSION['error'] = "Error al intentar ingresar. Por favor, intenta nuevamente.";
        header("Location: " . url('login'));
        exit;
    }
} else {
    // Si no es POST, redirigir al login
    header("Location: " . url('login'));
    exit;
}
