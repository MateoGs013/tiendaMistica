<?php
/* Front controller estilo Ej.Parcial adaptado a Tienda Mística */

require_once "includes/functions.php";
require_once "classes/Secciones.php";

$secciones_validas = [];
$secciones_menu = [];

try {
    $secciones_validas = Secciones::secciones_validas();
    $secciones_menu   = Secciones::secciones_menu();
} catch (Exception $e) {
    error_log("Error al cargar secciones en index.php: " . $e->getMessage());
}

// Si no hay parámetro sec, redirigir a inicio con GET explícito
if (!isset($_GET['sec'])) {
    header("Location: index.php?sec=inicio");
    exit;
}

$sec = $_GET['sec'];

// Handle blog detail with slug
if ($sec === 'blog' && !empty($_GET['slug'])) {
    $sec = 'blog_detalle';
}

if (!in_array($sec, $secciones_validas) && !in_array($sec, [
    'detalle_duende','agregar_carrito','carrito','checkout',
    'login','registro','logout','cuenta','blog','blog_detalle','contacto'
])) {
    $vista = '404';
} else {
    $vista = $sec;
    $currentView = $vista;
}

/* Acciones simples que redirigen a vistas o ejecutan lógica */
if ($sec === 'logout') {
    logout_usuario();
    header("Location: index.php?sec=inicio");
    exit;
}

if ($sec === 'agregar_carrito' && !empty($_GET['id'])) {
    require_login();
    require_once "classes/Carrito.php";
    try {
        if (Carrito::agregar($_SESSION['usuario']['id_usuario'], (int)$_GET['id'], 1)) {
            $_SESSION['mensaje'] = 'Producto agregado al carrito';
        } else {
            $_SESSION['error'] = 'No se pudo agregar el producto';
        }
    } catch (Exception $e) {
        error_log("Error al agregar producto al carrito: " . $e->getMessage());
        $_SESSION['error'] = 'Error al agregar el producto';
    }
    header("Location: index.php?sec=carrito");
    exit;
}

require_once "includes/header.php";

if (file_exists("views/{$vista}.php")) {
    require_once "views/{$vista}.php";
} else {
    require_once "views/404.php";
}

require_once "includes/footer.php";
