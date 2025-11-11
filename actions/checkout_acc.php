<?php
// actions/checkout_acc.php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../classes/Carrito.php';
require_once __DIR__ . '/../classes/Pedido.php';

// Verificar que el usuario esté logueado
if (empty($_SESSION['usuario'])) {
    header("Location: " . url('login'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar datos de envío
    $nombre = trim($_POST['nombre'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $ciudad = trim($_POST['ciudad'] ?? '');
    $codigo_postal = trim($_POST['codigo_postal'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    
    if (empty($nombre) || empty($direccion) || empty($ciudad)) {
        $_SESSION['error'] = "Por favor completa todos los campos obligatorios";
        $_SESSION['old_nombre'] = $nombre;
        $_SESSION['old_direccion'] = $direccion;
        $_SESSION['old_ciudad'] = $ciudad;
        $_SESSION['old_codigo_postal'] = $codigo_postal;
        $_SESSION['old_telefono'] = $telefono;
        header("Location: " . url('checkout'));
        exit;
    }
    
    try {
        // Crear el pedido
        $idPedido = Pedido::crearDesdeCarrito($_SESSION['usuario']['id_usuario']);
        
        if ($idPedido) {
            $_SESSION['ultimo_pedido'] = $idPedido;
            $_SESSION['success'] = "¡Pedido confirmado! Tu número de pedido es: #$idPedido";
            // Limpiar datos temporales
            unset($_SESSION['old_nombre'], $_SESSION['old_direccion'], $_SESSION['old_ciudad']);
            unset($_SESSION['old_codigo_postal'], $_SESSION['old_telefono']);
            header("Location: " . url('checkout'));
            exit;
        } else {
            $_SESSION['error'] = "No se pudo procesar el pedido. Intenta nuevamente.";
            $_SESSION['old_nombre'] = $nombre;
            $_SESSION['old_direccion'] = $direccion;
            $_SESSION['old_ciudad'] = $ciudad;
            $_SESSION['old_codigo_postal'] = $codigo_postal;
            $_SESSION['old_telefono'] = $telefono;
            header("Location: " . url('checkout'));
            exit;
        }
    } catch (Exception $e) {
        error_log("Error al crear pedido: " . $e->getMessage());
        $_SESSION['error'] = "Error al procesar el pedido. Por favor, intenta nuevamente.";
        $_SESSION['old_nombre'] = $nombre;
        $_SESSION['old_direccion'] = $direccion;
        $_SESSION['old_ciudad'] = $ciudad;
        $_SESSION['old_codigo_postal'] = $codigo_postal;
        $_SESSION['old_telefono'] = $telefono;
        header("Location: " . url('checkout'));
        exit;
    }
} else {
    header("Location: " . url('checkout'));
    exit;
}
