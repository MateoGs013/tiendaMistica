<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/url.php';
require_admin();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Admin - Tienda Mística</title>
</head>
<body>
<nav>
    <a href="<?php echo admin_url('inicio'); ?>">Inicio admin</a> |
    <a href="<?php echo admin_url('duendes'); ?>">Duendes</a> |
    <a href="<?php echo admin_url('blogs'); ?>">Blogs</a> |
    <a href="<?php echo admin_url('pedidos'); ?>">Pedidos</a> |
    <a href="<?php echo admin_url('contactos'); ?>">Contactos</a> |
    <a href="/tienda_mistica/">Volver al sitio</a>
</nav>
<hr>
