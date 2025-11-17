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

// Determinar si mostrar el gateway solo en la página de inicio
$currentSection = isset($_GET['sec']) ? $_GET['sec'] : 'inicio';
$showGateway = ($currentSection === 'inicio' || $currentSection === '');

// Permitir saltar manualmente con ?intro=off
$skipIntro = false;
if (isset($_GET['intro']) && $_GET['intro'] === 'off') {
    $skipIntro = true;
}

// Si no estamos en inicio, siempre saltar el gateway
if (!$showGateway) {
    $skipIntro = true;
}

global $currentView;
$bodyClassList = [
    'min-h-screen',
    'bg-arcade-base',
    'text-slate-100',
    'font-body',
    'antialiased'
];

if (!$skipIntro) {
    $bodyClassList[] = 'has-gateway';
}

$bodyClassAttribute = implode(' ', $bodyClassList);
?>
<!doctype html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Mística de Duendes</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;800&family=Space+Mono:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        arcade: {
                            base: '#040714',
                            panel: '#090e20',
                            cyan: '#3b82f6',
                            magenta: '#ec4899',
                            violet: '#818cf8',
                            gold: '#fbbf24',
                            emerald: '#22c55e',
                            amber: '#f97316',
                            rose: '#ef4444',
                            mystic: '#a58bff'
                        }
                    },
                    fontFamily: {
                        retro: ['"Press Start 2P"', 'cursive'],
                        orbitron: ['Orbitron', 'sans-serif'],
                        body: ['VT323', 'monospace']
                    },
                    boxShadow: {
                        neon: '0 0 10px rgba(59,130,246,0.55), 0 0 20px rgba(129,140,248,0.32)',
                        'neon-strong': '0 0 12px rgba(236,72,153,0.72), 0 0 32px rgba(251,191,36,0.45)'
                    },
                    backgroundImage: {
                        'arcade-grid': 'radial-gradient(circle at center, rgba(129,140,248,0.18) 0%, rgba(9,14,32,0.85) 55%, rgba(4,7,20,0.95) 100%)'
                    }
                }
            }
        };
    </script>
    <!-- GSAP Core + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <link rel="stylesheet" href="/tienda_mistica/assets/css/style.css">
</head>
<body class="<?php echo $bodyClassAttribute; ?>">
<?php if (!$skipIntro): ?>
<div id="game-gateway" class="game-gateway" aria-hidden="false" tabindex="-1">
    <div class="game-gateway__screen">
        <div class="game-gateway__scanlines"></div>
        <div class="game-gateway__content">
            <div class="game-gateway__loading">
                <div class="game-gateway__spinner">
                    <i class="fas fa-hat-wizard"></i>
                </div>
            </div>
            <h1 id="game-gateway-title" class="game-gateway__title">
                <span class="game-gateway__title-main">CARGANDO LA MAGIA</span>
                <span class="game-gateway__title-sub">PREPARANDO DIMENSIÓN ARCADE</span>
            </h1>
            <div class="game-gateway__progress">
                <div class="game-gateway__progress-bar">
                    <div class="game-gateway__progress-fill"></div>
                </div>
                <div class="game-gateway__progress-text">
                    <span id="loading-percent">0</span>%
                </div>
            </div>
            <div class="game-gateway__status-text">
                <span id="loading-status">Inicializando portal místico...</span>
            </div>
            <button type="button" class="game-gateway__btn game-gateway__btn--skip" data-gateway-skip style="opacity: 0; pointer-events: none;">
                <i class="fas fa-forward"></i>
                <span>SKIP</span>
            </button>
        </div>
        <div class="game-gateway__footer">
            <div class="game-gateway__credits">
                <i class="fas fa-gamepad"></i>
                <span>TIENDA MÍSTICA v2.0</span>
            </div>
            <div class="game-gateway__status">
                <span class="game-gateway__status-dot"></span>
                <span id="system-status">LOADING</span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="arcade-wrapper">
    <!-- Grid Background -->
    <div class="arcade-grid"></div>
    
    <!-- Minimal Arcade Header -->
    <header class="arcade-header" id="main-header">
            <div class="arcade-header__inner">
                <!-- Logo -->
                <a href="index.php?sec=inicio" class="arcade-logo">
                    <div class="arcade-logo__icon">
                        <i class="fas fa-hat-wizard"></i>
                    </div>
                    <div class="arcade-logo__text">
                        <span class="arcade-logo__title">TIENDA MÍSTICA</span>
                        <span class="arcade-logo__subtitle">Arcade Shop</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="arcade-nav" aria-label="Navegación principal">
                    <?php if (!empty($seccionesMenu)): ?>
                        <?php foreach ($seccionesMenu as $seccion): ?>
                            <?php if (!empty($seccion['vinculo']) && !empty($seccion['titulo'])): ?>
                                <a href="index.php?sec=<?php echo $seccion['vinculo']; ?>" class="arcade-nav__link">
                                    <?php echo htmlspecialchars($seccion['titulo']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </nav>

                <!-- User Actions -->
                <div class="arcade-actions">
                    <!-- Cart -->
                    <a href="index.php?sec=carrito" class="arcade-action-btn arcade-action-btn--cart" title="Carrito">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if ($cantidadCarrito > 0): ?>
                            <span class="arcade-badge"><?php echo $cantidadCarrito; ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- User Menu -->
                    <?php if (!empty($_SESSION['usuario'])): ?>
                        <div class="arcade-user-menu">
                            <button class="arcade-action-btn arcade-action-btn--user" id="user-menu-btn" aria-expanded="false" aria-haspopup="true">
                                <i class="fas fa-user-circle"></i>
                            </button>
                            <div class="arcade-dropdown" id="user-menu" hidden>
                                <a href="index.php?sec=cuenta" class="arcade-dropdown__item">
                                    <i class="fas fa-user"></i>
                                    <span>Mi Cuenta</span>
                                </a>
                                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                    <a href="admin/index.php?sec=inicio" class="arcade-dropdown__item">
                                        <i class="fas fa-shield-alt"></i>
                                        <span>Admin</span>
                                    </a>
                                <?php endif; ?>
                                <div class="arcade-dropdown__divider"></div>
                                <a href="index.php?sec=logout" class="arcade-dropdown__item arcade-dropdown__item--danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Salir</span>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="index.php?sec=login" class="arcade-action-btn" title="Iniciar sesión">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                        <a href="index.php?sec=registro" class="arcade-btn arcade-btn--primary">
                            <span>REGISTRARSE</span>
                        </a>
                    <?php endif; ?>

                    <!-- Mobile Menu Toggle -->
                    <button class="arcade-mobile-toggle" id="mobile-menu-toggle" aria-expanded="false" aria-controls="mobile-menu" aria-label="Abrir menú">
                        <span class="arcade-mobile-toggle__bar"></span>
                        <span class="arcade-mobile-toggle__bar"></span>
                        <span class="arcade-mobile-toggle__bar"></span>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="arcade-mobile-menu" id="mobile-menu" hidden>
                <nav class="arcade-mobile-nav">
                    <?php if (!empty($seccionesMenu)): ?>
                        <?php foreach ($seccionesMenu as $seccion): ?>
                            <?php if (!empty($seccion['vinculo']) && !empty($seccion['titulo'])): ?>
                                <a href="index.php?sec=<?php echo $seccion['vinculo']; ?>" class="arcade-mobile-nav__link">
                                    <span><?php echo htmlspecialchars($seccion['titulo']); ?></span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <div class="arcade-mobile-nav__divider"></div>
                    
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="index.php?sec=cuenta" class="arcade-mobile-nav__link">
                            <span><i class="fas fa-user"></i> Mi Cuenta</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                            <a href="admin/index.php?sec=inicio" class="arcade-mobile-nav__link">
                                <span><i class="fas fa-shield-alt"></i> Admin</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                        <a href="index.php?sec=logout" class="arcade-mobile-nav__link arcade-mobile-nav__link--danger">
                            <span><i class="fas fa-sign-out-alt"></i> Salir</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <a href="index.php?sec=login" class="arcade-mobile-nav__link">
                            <span><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="index.php?sec=registro" class="arcade-mobile-nav__link arcade-mobile-nav__link--primary">
                            <span><i class="fas fa-user-plus"></i> Registrarse</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
    </header>

    <div class="arcade-container">
        <!-- Main Content -->
        <main class="arcade-main" id="main-content">
            <div class="arcade-content">

