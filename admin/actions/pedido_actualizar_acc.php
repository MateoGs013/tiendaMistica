<?php
// admin/actions/pedido_actualizar_acc.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../../classes/Pedido.php';

// Verificar que el usuario sea admin
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $estado = trim($_POST['estado'] ?? '');
    
    if ($id <= 0) {
        $_SESSION['error'] = "ID de pedido inválido";
        header("Location: " . '../index.php?sec=pedidos');
        exit;
    }
    
    $estadosValidos = ['pendiente', 'procesando', 'enviado', 'completado', 'cancelado'];
    if (!in_array($estado, $estadosValidos)) {
        $_SESSION['error'] = "Estado inválido";
        header("Location: " . '../index.php?sec=pedido_ver&id=' . $id);
        exit;
    }
    
    try {
        if (Pedido::updateEstado($id, $estado)) {
            $_SESSION['success'] = "Estado del pedido actualizado exitosamente";
            header("Location: " . '../index.php?sec=pedido_ver&id=' . $id);
            exit;
        } else {
            $_SESSION['error'] = "Error al actualizar el estado del pedido";
            header("Location: " . '../index.php?sec=pedido_ver&id=' . $id);
            exit;
        }
    } catch (Exception $e) {
        error_log("Error al actualizar estado del pedido: " . $e->getMessage());
        $_SESSION['error'] = "Error al actualizar el estado. Por favor, intenta nuevamente.";
        header("Location: " . '../index.php?sec=pedido_ver&id=' . $id);
        exit;
    }
} else {
    header("Location: " . '../index.php?sec=pedidos');
    exit;
}
