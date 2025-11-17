<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/url.php';
require_admin();

$adminNav = [
    ['label' => 'Inicio', 'href' => 'index.php?sec=inicio'],
    ['label' => 'Duendes', 'href' => 'index.php?sec=duendes'],
    ['label' => 'Blogs', 'href' => 'index.php?sec=blogs'],
    ['label' => 'Pedidos', 'href' => 'index.php?sec=pedidos'],
    ['label' => 'Contactos', 'href' => 'index.php?sec=contactos'],
    ['label' => 'Usuarios', 'href' => 'index.php?sec=usuarios'],
];
?>
<!doctype html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tienda Mística</title>
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
                        body: ['Inter', 'system-ui', 'sans-serif']
                    },
                    boxShadow: {
                        neon: '0 0 10px rgba(59,130,246,0.55), 0 0 20px rgba(129,140,248,0.32)',
                        grid: '0 0 18px rgba(59,130,246,0.25)'
                    },
                    backgroundImage: {
                        'arcade-console': 'linear-gradient(160deg, rgba(9,14,32,0.92) 0%, rgba(4,7,20,0.96) 60%, rgba(2,6,16,0.96) 100%)'
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="/tienda_mistica/assets/css/style.css">
</head>
<body class="min-h-screen bg-arcade-base text-slate-100 font-body antialiased">
<div class="relative min-h-screen overflow-hidden">
    <div class="absolute inset-0 bg-arcade-console opacity-90"></div>
    <div class="absolute inset-0 pointer-events-none mix-blend-screen noise-layer"></div>
    <div class="relative z-10 min-h-screen flex flex-col">
        <header class="bg-arcade-panel/85 border-b border-arcade-cyan/30 shadow-neon">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex flex-col gap-4 py-5 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-arcade-magenta/40 bg-arcade-base shadow-neon">
                            <svg class="h-7 w-7 text-arcade-gold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4h16v16H4V4zm4 4v8h8V8H8zm2 2h4v4h-4v-4z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-retro text-[0.7rem] uppercase tracking-[0.35em] text-arcade-magenta">Arcade Console</p>
                            <p class="font-orbitron text-xl font-semibold text-white">Panel de Control</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 md:justify-end">
                        <?php foreach ($adminNav as $item): ?>
                            <a href="<?php echo $item['href']; ?>" class="nav-link"><?php echo htmlspecialchars($item['label']); ?></a>
                        <?php endforeach; ?>
                        <a href="../index.php?sec=inicio" class="nav-link">Volver al sitio</a>
                        <a href="index.php?sec=logout" class="nav-link">Salir</a>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-1">
            <div class="max-w-7xl mx-auto w-full px-4 py-10 lg:px-8">
