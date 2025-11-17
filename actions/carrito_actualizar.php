<?php
// actions/carrito_actualizar.php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../classes/Carrito.php';
require_login();

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$idDuende = (int)($_POST['id_duende'] ?? $_GET['id_duende'] ?? 0);
$idUsuario = $_SESSION['usuario']['id_usuario'];

switch ($action) {
    case 'agregar':
        $cantidad = (int)($_POST['cantidad'] ?? 1);
        try {
            if (Carrito::agregar($idUsuario, $idDuende, $cantidad)) {
                $_SESSION['mensaje'] = 'Producto agregado al carrito';
            } else {
                $_SESSION['error'] = 'No se pudo agregar el producto. El duende puede no estar disponible.';
            }
        } catch (Exception $e) {
            error_log("Error en agregar carrito: " . $e->getMessage());
            $_SESSION['error'] = 'Error al agregar: ' . $e->getMessage();
        }
        break;
        
    case 'actualizar':
        $cantidad = (int)($_POST['cantidad'] ?? 1);
        if (Carrito::actualizarCantidad($idUsuario, $idDuende, $cantidad)) {
            $_SESSION['mensaje'] = 'Cantidad actualizada';
        } else {
            $_SESSION['error'] = 'No se pudo actualizar la cantidad';
        }
        break;
        
    case 'eliminar':
        if (Carrito::eliminarItem($idUsuario, $idDuende)) {
            $_SESSION['mensaje'] = 'Producto eliminado del carrito';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el producto';
        }
        break;
        
    case 'vaciar':
        if (Carrito::vaciar($idUsuario)) {
            $_SESSION['mensaje'] = 'Carrito vaciado';
        } else {
            $_SESSION['error'] = 'No se pudo vaciar el carrito';
        }
        break;
}

// Redirigir según el origen
$redirect = $_POST['redirect'] ?? $_GET['redirect'] ?? 'carrito';
header("Location: ../index.php?sec=" . $redirect);
exit;
