<?php
// includes/header.php
require_once __DIR__ . '/url.php';
require_once __DIR__ . '/../classes/Secciones.php';

$cantidadCarrito = 0;
if (!empty($_SESSION['usuario']) && isset($_SESSION['usuario']['id_usuario'])) {
    try {
        require_once __DIR__ . '/../classes/Carrito.php';
        $cantidadCarrito = Carrito::cantidadTotal($_SESSION['usuario']['id_usuario']);
    } catch (Exception $e) {
        error_log("Error al obtener cantidad del carrito: " . $e->getMessage());
        $cantidadCarrito = 0;
    }
}

// Obtener secciones del menú desde la base de datos
$seccionesMenu = Secciones::secciones_menu();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Mística de Duendes</title>
</head>
<body>
<header>
    <h1>Tienda Mística de Duendes</h1>
    <nav>
        <?php if (!empty($seccionesMenu)): ?>
            <?php foreach ($seccionesMenu as $seccion): ?>
                <?php if (!empty($seccion['vinculo']) && !empty($seccion['titulo'])): ?>
                    <a href="<?php echo url($seccion['vinculo']); ?>"><?php echo htmlspecialchars($seccion['titulo']); ?></a>
                    <?php if ($seccion !== end($seccionesMenu)): ?>|<?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        |
        <a href="<?php echo url('carrito'); ?>">Carrito <?php if ($cantidadCarrito > 0): ?>(<?php echo $cantidadCarrito; ?>)<?php endif; ?></a>
        <?php if (!empty($_SESSION['usuario'])): ?>
            | <a href="<?php echo url('cuenta'); ?>">Mi cuenta</a>
            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                | <a href="/tienda_mistica/admin/">Admin</a>
            <?php endif; ?>
            | <a href="<?php echo url('logout'); ?>">Salir</a>
        <?php else: ?>
            | <a href="<?php echo url('login'); ?>">Ingresar</a>
            | <a href="<?php echo url('registro'); ?>">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>
<hr>

