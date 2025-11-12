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
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Mística de Duendes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Orbitron:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        arcade: {
                            base: '#050816',
                            panel: '#0f172a',
                            cyan: '#06b6d4',
                            magenta: '#d946ef',
                            violet: '#6366f1',
                            gold: '#fbbf24'
                        }
                    },
                    fontFamily: {
                        retro: ['"Press Start 2P"', 'cursive'],
                        orbitron: ['Orbitron', 'sans-serif'],
                        body: ['Inter', 'system-ui', 'sans-serif']
                    },
                    boxShadow: {
                        neon: '0 0 10px rgba(6,182,212,0.6), 0 0 20px rgba(99,102,241,0.35)',
                        'neon-strong': '0 0 12px rgba(217,70,239,0.75), 0 0 32px rgba(99,102,241,0.45)'
                    },
                    backgroundImage: {
                        'arcade-grid': 'radial-gradient(circle at center, rgba(99,102,241,0.18) 0%, rgba(15,23,42,0.85) 55%, rgba(5,8,22,0.95) 100%)'
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="/tienda_mistica/assets/css/style.css">
</head>
<body class="min-h-screen bg-arcade-base text-slate-100 font-body antialiased">
<div class="relative min-h-screen overflow-hidden">
    <div class="absolute inset-0 bg-arcade-grid opacity-80"></div>
    <div class="absolute inset-0 pointer-events-none mix-blend-screen noise-layer"></div>
    <div class="relative z-10 min-h-screen flex flex-col">
        <header class="bg-arcade-panel/80 backdrop-blur border-b border-arcade-cyan/30 shadow-neon">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex flex-col gap-4 py-6">
                    <div class="flex flex-col gap-5">
                        <div class="flex items-center justify-between gap-4">
                            <a href="<?php echo url('inicio'); ?>" class="flex items-center gap-3 group">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl border border-arcade-cyan/45 bg-arcade-base shadow-neon transition-transform group-hover:scale-105">
                                    <svg class="h-7 w-7 text-arcade-cyan" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16l-2 12H6L4 6zm3-4h10v4H7V2zm3 14h4" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-retro text-[0.65rem] uppercase tracking-[0.42em] text-arcade-magenta">Tienda Mística</p>
                                    <p class="font-orbitron text-xl font-semibold text-white drop-shadow">Duendes &amp; Power-Ups</p>
                                </div>
                            </a>
                            <div class="flex items-center gap-3">
                                <div class="hidden lg:flex items-center gap-2">
                                    <a href="<?php echo url('carrito'); ?>" class="command-pill">
                                        <svg class="command-pill-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h9.6a1 1 0 0 0 .98-.804l1.2-6A1 1 0 0 0 17.8 5H5.21" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 13l-1.2-6M7 13l-2 8m2-8h10M5 21h2m10 0h2" />
                                        </svg>
                                        <span>Carrito</span>
                                        <?php if ($cantidadCarrito > 0): ?>
                                            <span class="command-pill-count"><?php echo $cantidadCarrito; ?></span>
                                        <?php endif; ?>
                                    </a>
                                    <?php if (!empty($_SESSION['usuario'])): ?>
                                        <a href="<?php echo url('cuenta'); ?>" class="command-pill">Mi cuenta</a>
                                        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                            <a href="/tienda_mistica/admin/" class="command-pill command-pill--accent">Admin</a>
                                        <?php endif; ?>
                                        <a href="<?php echo url('logout'); ?>" class="command-pill command-pill--ghost">Salir</a>
                                    <?php else: ?>
                                        <a href="<?php echo url('login'); ?>" class="command-pill">Ingresar</a>
                                        <a href="<?php echo url('registro'); ?>" class="command-pill command-pill--accent">Registrarse</a>
                                    <?php endif; ?>
                                </div>
                                <button id="btn-mobile-menu" class="lg:hidden inline-flex items-center justify-center rounded-full border border-arcade-cyan/45 bg-arcade-base/80 p-2.5 text-arcade-cyan shadow-neon transition hover:scale-105" aria-expanded="false" aria-controls="mobile-menu">
                                    <span class="sr-only">Abrir menú</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <nav class="hidden items-center gap-3 lg:flex xl:gap-5">
                            <?php if (!empty($seccionesMenu)): ?>
                                <?php foreach ($seccionesMenu as $seccion): ?>
                                    <?php if (!empty($seccion['vinculo']) && !empty($seccion['titulo'])): ?>
                                        <a href="<?php echo url($seccion['vinculo']); ?>" class="nav-link nav-link--soft"><?php echo htmlspecialchars($seccion['titulo']); ?></a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </nav>
                        <p class="hidden text-xs uppercase tracking-[0.28em] text-slate-400 lg:block">Explorá la sala retro, desbloqueá filtros inteligentes y encontrá tu duende ideal.</p>
                    </div>
                    <div id="mobile-menu" class="header-mobile-panel hidden lg:hidden">
                        <div class="space-y-2 border-t border-arcade-cyan/20 pt-4">
                            <?php if (!empty($seccionesMenu)): ?>
                                <?php foreach ($seccionesMenu as $seccion): ?>
                                    <?php if (!empty($seccion['vinculo']) && !empty($seccion['titulo'])): ?>
                                        <a href="<?php echo url($seccion['vinculo']); ?>" class="mobile-link"><?php echo htmlspecialchars($seccion['titulo']); ?></a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <a href="<?php echo url('carrito'); ?>" class="mobile-link flex items-center justify-between">
                                <span>Carrito</span>
                                <?php if ($cantidadCarrito > 0): ?>
                                    <span class="badge-glow"><?php echo $cantidadCarrito; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php if (!empty($_SESSION['usuario'])): ?>
                                <a href="<?php echo url('cuenta'); ?>" class="mobile-link">Mi cuenta</a>
                                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                    <a href="/tienda_mistica/admin/" class="mobile-link">Admin</a>
                                <?php endif; ?>
                                <a href="<?php echo url('logout'); ?>" class="mobile-link">Salir</a>
                            <?php else: ?>
                                <a href="<?php echo url('login'); ?>" class="mobile-link">Ingresar</a>
                                <a href="<?php echo url('registro'); ?>" class="mobile-link">Registrarse</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-1">
            <div class="max-w-7xl mx-auto w-full px-4 py-10 lg:px-8" id="page-content">

