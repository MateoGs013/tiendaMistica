<?php
// actions/contacto_acc.php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../classes/Contacto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    
    if (empty($nombre) || empty($email) || empty($mensaje)) {
        $_SESSION['error'] = "Completá todos los campos.";
        $_SESSION['old_nombre'] = $nombre;
        $_SESSION['old_email'] = $email;
        $_SESSION['old_mensaje'] = $mensaje;
        header("Location: ../index.php?sec=contacto");
        exit;
    }
    
    try {
        if (Contacto::crear($nombre, $email, $mensaje)) {
            $_SESSION['success'] = "Mensaje enviado correctamente.";
            header("Location: ../index.php?sec=contacto");
            exit;
        } else {
            $_SESSION['error'] = "No se pudo guardar el mensaje.";
            $_SESSION['old_nombre'] = $nombre;
            $_SESSION['old_email'] = $email;
            $_SESSION['old_mensaje'] = $mensaje;
            header("Location: ../index.php?sec=contacto");
            exit;
        }
    } catch (Exception $e) {
        error_log("Error al crear contacto: " . $e->getMessage());
        $_SESSION['error'] = "Error al enviar el mensaje. Por favor, intenta nuevamente.";
        $_SESSION['old_nombre'] = $nombre;
        $_SESSION['old_email'] = $email;
        $_SESSION['old_mensaje'] = $mensaje;
        header("Location: ../index.php?sec=contacto");
        exit;
    }
} else {
    header("Location: ../index.php?sec=contacto");
    exit;
}
