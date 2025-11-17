<?php
/* Admin front controller */

$sec = isset($_GET['sec']) ? $_GET['sec'] : 'inicio';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Handle logout
if ($sec === 'logout') {
    require_once __DIR__ . '/includes/functions.php';
    logout_usuario();
    header('Location: ../index.php?sec=inicio');
    exit;
}

// Map sections to files
$secciones_validas = [
    'inicio' => 'inicio.php',
    'duendes' => 'duendes.php',
    'duende_crear' => 'duende_crear.php',
    'duende_editar' => 'duende_editar.php',
    'blogs' => 'blogs.php',
    'blog_crear' => 'blog_crear.php',
    'blog_editar' => 'blog_editar.php',
    'usuarios' => 'usuarios.php',
    'usuario_crear' => 'usuario_crear.php',
    'usuario_editar' => 'usuario_editar.php',
    'pedidos' => 'pedidos.php',
    'pedido_ver' => 'pedido_ver.php',
    'contactos' => 'contactos.php',
    'contacto_ver' => 'contacto_ver.php'
];

// Validate section
if (!isset($secciones_validas[$sec])) {
    $sec = 'inicio';
}

// Load the corresponding file
$file = __DIR__ . '/' . $secciones_validas[$sec];

if (file_exists($file)) {
    require_once $file;
} else {
    require_once __DIR__ . '/inicio.php';
}
?>
