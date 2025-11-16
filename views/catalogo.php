<?php
require_once __DIR__ . '/../includes/url.php';
require_once "classes/Duende.php";

$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);

$usuarioLogueado = !empty($_SESSION['usuario']);

$filtrosDisponibles = Duende::filtrosDisponibles();

$filtros = [
    'rareza' => isset($_GET['rareza']) ? (array)$_GET['rareza'] : [],
    'elemento' => isset($_GET['elemento']) ? (array)$_GET['elemento'] : [],
    'material' => isset($_GET['material']) ? (array)$_GET['material'] : [],
    'precio_min' => isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : null,
    'precio_max' => isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : null,
    'orden' => $_GET['orden'] ?? 'popularidad',
    'poder_min' => isset($_GET['poder_min']) ? (int)$_GET['poder_min'] : null,
    'page' => isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1,
    'solo_disponibles' => true,
];

$filtros['per_page'] = 8;

$catalogo = Duende::catalogoInteractivo($filtros, true);
$duendes = $catalogo['items'];
$total = $catalogo['total'];
$page = $catalogo['page'];
$pages = $catalogo['pages'];
$perPage = $catalogo['per_page'];

$buildQuery = static function (array $params) {
    $base = array_filter($_GET, static fn($value) => $value !== '' && $value !== null);
    $merged = array_merge($base, $params);
    return http_build_query($merged);
};

$rangos = $filtrosDisponibles['rangos'] ?? ['minimo' => null, 'maximo' => null];

$opcionesOrden = [
    'popularidad' => 'Popularidad',
    'precio_asc' => 'Precio ascendente',
    'precio_desc' => 'Precio descendente',
    'suerte' => 'Mayor suerte',
    'riesgo' => 'Menor riesgo',
    'reciente' => 'Más recientes',
    'antiguo' => 'Más antiguos',
];

$rarezaMap = [];
foreach ($filtrosDisponibles['rarezas'] as $rarezaDisponible) {
    $rarezaMap[(string)$rarezaDisponible['id_rareza']] = $rarezaDisponible['nombre'];
}

$elementoMap = [];
foreach ($filtrosDisponibles['elementos'] as $elementoDisponible) {
    $elementoMap[(string)$elementoDisponible['id_elemento']] = $elementoDisponible['nombre'];
}

$materialMap = [];
foreach ($filtrosDisponibles['materiales'] as $materialDisponible) {
    $materialMap[(string)$materialDisponible['id_material']] = $materialDisponible['nombre'];
}

$activeChips = [];

if (!empty($filtros['rareza'])) {
    $labels = [];
    foreach ($filtros['rareza'] as $id) {
        $key = (string)$id;
        if (isset($rarezaMap[$key])) {
            $labels[] = $rarezaMap[$key];
        }
    }
    if ($labels) {
        $activeChips[] = 'Rareza: ' . implode(', ', $labels);
    }
}

if (!empty($filtros['elemento'])) {
    $labels = [];
    foreach ($filtros['elemento'] as $id) {
        $key = (string)$id;
        if (isset($elementoMap[$key])) {
            $labels[] = $elementoMap[$key];
        }
    }
    if ($labels) {
        $activeChips[] = 'Elemento: ' . implode(', ', $labels);
    }
}

if (!empty($filtros['material'])) {
    $labels = [];
    foreach ($filtros['material'] as $id) {
        $key = (string)$id;
        if (isset($materialMap[$key])) {
            $labels[] = $materialMap[$key];
        }
    }
    if ($labels) {
        $activeChips[] = 'Material: ' . implode(', ', $labels);
    }
}

$precioMinActivo = $filtros['precio_min'];
$precioMaxActivo = $filtros['precio_max'];

if ($precioMinActivo !== null || $precioMaxActivo !== null) {
    $rango = 'Precio: ';
    if ($precioMinActivo !== null && $precioMaxActivo !== null) {
        $rango .= number_format($precioMinActivo, 0) . ' - ' . number_format($precioMaxActivo, 0);
    } elseif ($precioMinActivo !== null) {
        $rango .= 'Desde ' . number_format($precioMinActivo, 0);
    } else {
        $rango .= 'Hasta ' . number_format($precioMaxActivo, 0);
    }
    $activeChips[] = $rango . ' oro';
}

if (!empty($filtros['poder_min'])) {
    $activeChips[] = 'Poder >= ' . (int)$filtros['poder_min'];
}

if ($filtros['orden'] !== 'popularidad' && isset($opcionesOrden[$filtros['orden']])) {
    $activeChips[] = 'Orden: ' . $opcionesOrden[$filtros['orden']];
}

$panelShouldStartOpen = !empty($activeChips);
?>

<div class="catalogo-shell">

<?php if ($mensaje): ?>
    <div style="padding: 0 1.5rem;">
        <div style="border-radius: 8px; border: 1px solid rgba(34, 197, 94, 0.5); background: rgba(34, 197, 94, 0.15); padding: 1rem; text-align: center; color: #22c55e;">
            ✓ <?php echo htmlspecialchars($mensaje); ?>
        </div>
    </div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Animaciones suaves para los accordions
    var accordions = document.querySelectorAll('.arcade-filter-accordion');
    accordions.forEach(function(accordion) {
        accordion.addEventListener('toggle', function(e) {
            if (this.open) {
                var options = this.querySelector('.arcade-filter-options');
                if (options) {
                    options.style.animation = 'none';
                    setTimeout(function() {
                        options.style.animation = '';
                    }, 10);
                }
            }
        });
    });
});
</script>

<?php if ($error): ?>
    <div style="padding: 0 1.5rem; margin-bottom: 1rem;">
        <div style="border-radius: 8px; border: 1px solid rgba(239, 68, 68, 0.5); background: rgba(239, 68, 68, 0.15); padding: 1rem; text-align: center; color: #ef4444;">
            ✗ <?php echo htmlspecialchars($error); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Filters Section -->
<section class="arcade-features">
    <div class="catalog-hero-header">
        <div class="catalog-hero-badge">
            <i class="fas fa-store"></i>
            <span>ITEM SHOP</span>
        </div>
        <h1 class="catalog-hero-title">CATÁLOGO DE DUENDES</h1>
        <p class="catalog-hero-description">
            <?php echo $total; ?> duendes místicos disponibles para desbloquear
        </p>
        <div class="catalog-hero-stats">
            <div class="catalog-hero-stat">
                <i class="fas fa-coins"></i>
                <span>
                    <?php
                    $promedio = 0.0;
                    if (!empty($duendes)) {
                        $sum = array_sum(array_map(static fn($d) => (float)($d['precio_en_oro'] ?? 0), $duendes));
                        $promedio = $sum / count($duendes);
                    }
                    echo number_format($promedio, 0);
                    ?> ORO
                </span>
            </div>
            <div class="catalog-hero-stat">
                <i class="fas fa-bolt"></i>
                <span>
                    <?php
                    $maxPoder = !empty($duendes) ? max(array_map(static fn($d) => (int)($d['poder_total'] ?? 0), $duendes)) : 0;
                    echo $maxPoder;
                    ?> PWR
                </span>
            </div>
            <div class="catalog-hero-stat">
                <i class="fas fa-clover"></i>
                <span>
                    <?php
                    if (!empty($duendes)) {
                        $min = min(array_map(static fn($d) => (int)($d['nivel_suerte'] ?? 0), $duendes));
                        $max = max(array_map(static fn($d) => (int)($d['nivel_suerte'] ?? 0), $duendes));
                        echo $min . '–' . $max;
                    } else {
                        echo '0';
                    }
                    ?> LCK
                </span>
            </div>
        </div>
    </div>
    
    <div class="arcade-section-header" style="margin-top: 3rem;">
        <span class="arcade-section-badge">
            <i class="fas fa-sliders-h"></i>
            <span>FILTROS</span>
        </span>
        <h2 class="arcade-section-title">Personalizá tu búsqueda</h2>
        <?php if ($activeChips): ?>
            <div class="arcade-section-chips">
                <?php foreach ($activeChips as $chip): ?>
                    <span class="arcade-chip"><?php echo htmlspecialchars($chip); ?></span>
                <?php endforeach; ?>
                <a href="<?php echo url('catalogo'); ?>" class="arcade-chip arcade-chip--clear">
                    <i class="fas fa-times"></i>
                    <span>Limpiar</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <form method="get" class="arcade-filter-form">
        <div class="arcade-filter-grid">
            <div class="arcade-filter-group">
                <label class="arcade-filter-label">
                    <i class="fas fa-sort"></i>
                    <span>Ordenar por</span>
                </label>
                <select name="orden" class="arcade-select">
                    <?php foreach ($opcionesOrden as $valor => $label): ?>
                        <option value="<?php echo $valor; ?>" <?php echo $filtros['orden'] === $valor ? 'selected' : ''; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="arcade-filter-group">
                <label class="arcade-filter-label">
                    <i class="fas fa-bolt"></i>
                    <span>Poder mínimo</span>
                </label>
                <input type="number" name="poder_min" min="0" step="10" value="<?php echo $filtros['poder_min'] ?? ''; ?>" class="arcade-input" placeholder="Ej. 150">
            </div>
            
            <div class="arcade-filter-group">
                <label class="arcade-filter-label">
                    <i class="fas fa-coins"></i>
                    <span>Precio mínimo</span>
                </label>
                <input type="number" name="precio_min" min="0" step="5" value="<?php echo $filtros['precio_min'] ?? ''; ?>" class="arcade-input" placeholder="Min">
            </div>
            
            <div class="arcade-filter-group">
                <label class="arcade-filter-label">
                    <i class="fas fa-coins"></i>
                    <span>Precio máximo</span>
                </label>
                <input type="number" name="precio_max" min="0" step="5" value="<?php echo $filtros['precio_max'] ?? ''; ?>" class="arcade-input" placeholder="Max">
            </div>
        </div>
        
        <div class="arcade-filter-accordions">
            <details class="arcade-filter-accordion<?php echo !empty($filtros['rareza']) ? ' open' : ''; ?>">
                <summary>
                    <span>RAREZA</span>
                    <?php if (!empty($filtros['rareza'])): ?>
                        <span class="arcade-filter-count"><?php echo count($filtros['rareza']); ?></span>
                    <?php endif; ?>
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="arcade-filter-options">
                    <?php foreach ($filtrosDisponibles['rarezas'] as $rareza):
                        $id = (int)$rareza['id_rareza'];
                        $activo = in_array((string)$id, array_map('strval', $filtros['rareza']), true);
                    ?>
                        <label class="arcade-filter-option <?php echo $activo ? 'arcade-filter-option--active' : ''; ?>">
                            <input type="checkbox" name="rareza[]" value="<?php echo $id; ?>" <?php echo $activo ? 'checked' : ''; ?>>
                            <span><?php echo htmlspecialchars($rareza['nombre']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </details>
            
            <details class="arcade-filter-accordion<?php echo !empty($filtros['elemento']) ? ' open' : ''; ?>">
                <summary>
                    <span>ELEMENTO</span>
                    <?php if (!empty($filtros['elemento'])): ?>
                        <span class="arcade-filter-count"><?php echo count($filtros['elemento']); ?></span>
                    <?php endif; ?>
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="arcade-filter-options">
                    <?php foreach ($filtrosDisponibles['elementos'] as $elemento):
                        $id = (int)$elemento['id_elemento'];
                        $activo = in_array((string)$id, array_map('strval', $filtros['elemento']), true);
                    ?>
                        <label class="arcade-filter-option <?php echo $activo ? 'arcade-filter-option--active' : ''; ?>">
                            <input type="checkbox" name="elemento[]" value="<?php echo $id; ?>" <?php echo $activo ? 'checked' : ''; ?>>
                            <span><?php echo htmlspecialchars($elemento['nombre']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </details>
            
            <details class="arcade-filter-accordion<?php echo !empty($filtros['material']) ? ' open' : ''; ?>">
                <summary>
                    <span>MATERIAL</span>
                    <?php if (!empty($filtros['material'])): ?>
                        <span class="arcade-filter-count"><?php echo count($filtros['material']); ?></span>
                    <?php endif; ?>
                    <i class="fas fa-chevron-down"></i>
                </summary>
                <div class="arcade-filter-options">
                    <?php foreach ($filtrosDisponibles['materiales'] as $material):
                        $id = (int)$material['id_material'];
                        $activo = in_array((string)$id, array_map('strval', $filtros['material']), true);
                    ?>
                        <label class="arcade-filter-option <?php echo $activo ? 'arcade-filter-option--active' : ''; ?>">
                            <input type="checkbox" name="material[]" value="<?php echo $id; ?>" <?php echo $activo ? 'checked' : ''; ?>>
                            <span><?php echo htmlspecialchars($material['nombre']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </details>
        </div>
        
        <div class="arcade-filter-actions">
            <button type="submit" class="arcade-hero__btn arcade-hero__btn--primary">
                <i class="fas fa-check"></i>
                <span>APLICAR FILTROS</span>
            </button>
        </div>
    </form>
</section>

<?php if (empty($duendes)): ?>
    <div class="catalogo-results-empty rounded-2xl border border-arcade-magenta/40 bg-arcade-panel/70 p-10 text-center text-slate-200 shadow-neon">
        <p class="font-orbitron text-xl text-arcade-magenta">No encontramos duendes con esos filtros</p>
        <p class="mt-3 text-sm text-slate-300">Probá ampliando el rango de precio o quitando algunos elementos. La magia adecuada te espera.</p>
    </div>
<?php else: ?>
    <section class="catalogo-results">
        <div class="cards" role="list" data-card-list>
        <?php foreach ($duendes as $duende):
            $id = (int)($duende['id_duende'] ?? 0);
            $detalleUrl = url('detalle_duende', ['id' => $id]);
            $carritoDisponible = $usuarioLogueado;
            $isDisponible = (int)($duende['disponible'] ?? 0) === 1;
            $imagenUrl = $duende['imagen_url'] ?? '';
            $imagenUrl = $imagenUrl ? asset_url($imagenUrl) : null;
            $rarezaLabel = strtoupper($duende['rareza'] ?? 'COMÚN');
            $rarezaColor = $duende['rareza_color'] ?? 'rgba(var(--rareza-rgb-poco-comun), 0.55)';
            $rarezaColorCss = htmlspecialchars($rarezaColor, ENT_QUOTES, 'UTF-8');
            $rarezaNormalized = strtr((string)($duende['rareza'] ?? 'comun'), [
                'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'Ñ' => 'N',
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n',
            ]);
            $rarezaSlug = strtolower($rarezaNormalized);
            $rarezaSlug = preg_replace('/[^a-z0-9]+/', '-', $rarezaSlug);
            $rarezaSlug = trim((string)$rarezaSlug, '-');
            if ($rarezaSlug === '') {
                $rarezaSlug = 'comun';
            }
            $popularidad = (int)($duende['popularidad'] ?? 0);
            $elementoAbrev = strtoupper(substr((string)($duende['elemento'] ?? ''), 0, 3));
            $elementoAbrev = $elementoAbrev !== '' ? $elementoAbrev : '???';
            $tipo = strtoupper($duende['tipo'] ?? 'DUENDE');
            $precio = number_format((float)($duende['precio_en_oro'] ?? 0), 0, '.', '.');
            $alturaCm = (int)($duende['altura_cm'] ?? 0);
            $nivelSuerte = (int)($duende['nivel_suerte'] ?? 0);
            $recomendado = strtoupper($duende['recomendado_para'] ?? 'TODOS');
            $origen = strtoupper($duende['origen_mitologico'] ?? 'DESCONOCIDO');
            $poderTotal = (int)($duende['poder_total'] ?? 0);
            $indiceSuerte = (float)($duende['indice_suerte'] ?? 0);
            $nivelRiesgo = (int)($duende['nivel_riesgo'] ?? 0);
            $accesorios = $duende['accesorios_list'] ?? [];
            $descripcion = trim((string)($duende['descripcion'] ?? ''));
        ?>
        <article class="card card--rareza-<?php echo htmlspecialchars($rarezaSlug, ENT_QUOTES, 'UTF-8'); ?>" role="listitem" aria-labelledby="duende-<?php echo $id; ?>-title" aria-describedby="duende-<?php echo $id; ?>-desc" data-rareza="<?php echo htmlspecialchars($rarezaSlug, ENT_QUOTES, 'UTF-8'); ?>" data-rareza-label="<?php echo htmlspecialchars($rarezaLabel, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="card__content">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="badge pixel-font pixel-xs" style="border-color: <?php echo $rarezaColorCss; ?>; box-shadow: 0 0 8px <?php echo $rarezaColorCss; ?>; color: <?php echo $rarezaColorCss; ?>;">
                        <?php echo htmlspecialchars($rarezaLabel); ?>
                    </span>
                    <?php if ($popularidad >= 90): ?>
                        <span class="chip pixel-font pixel-xs blink-decoration">★ HOT</span>
                    <?php else: ?>
                        <span class="chip pixel-font pixel-xs">⚡ <?php echo $popularidad; ?>%</span>
                    <?php endif; ?>
                </div>

                <div class="duende-img-wrapper">
                    <?php if ($imagenUrl): ?>
                        <img src="<?php echo htmlspecialchars($imagenUrl); ?>" alt="<?php echo htmlspecialchars($duende['nombre']); ?>" class="duende-img" loading="lazy">
                    <?php else: ?>
                        <div class="duende-img duende-img--placeholder pixel-font pixel-xs">Sin imagen</div>
                    <?php endif; ?>
                    <div class="card-element-chip">
                        <span class="pixel-font pixel-xs text-neon-cyan"><?php echo htmlspecialchars($elementoAbrev); ?></span>
                    </div>
                    <?php if (!$isDisponible): ?>
                        <div class="soldout-mini">
                            <div class="label pixel-font pixel-xs">Agotado</div>
                        </div>
                    <?php endif; ?>
                </div>

                <h3 id="duende-<?php echo $id; ?>-title" class="pixel-font pixel-md text-neon-cyan text-glow mb-3 text-center">
                    <?php echo htmlspecialchars(strtoupper($duende['nombre'] ?? 'Duende')); ?>
                </h3>

                <div class="text-center mb-4">
                    <div class="pixel-font pixel-xs text-neon-green mb-2">🧙 <?php echo htmlspecialchars($tipo); ?></div>
                    <p class="pixel-font pixel-lg precio-oro"><?php echo $precio; ?> ORO</p>
                </div>

                <div id="duende-<?php echo $id; ?>-desc" class="duende-info pixel-font pixel-xs text-center mb-4">
                    <div class="text-neon-green">⚡ <?php echo $alturaCm; ?>CM • Lvl <?php echo $nivelSuerte; ?></div>
                    <div class="text-neon-yellow">🎯 <?php echo htmlspecialchars($recomendado); ?></div>
                    <div class="text-neon-pink">🏛️ <?php echo htmlspecialchars($origen); ?></div>
                </div>

                <div class="card-info-row pixel-font pixel-xs text-center mb-4">
                    <div class="text-neon-cyan">Poder <?php echo $poderTotal; ?></div>
                    <div class="text-neon-yellow">Suerte <?php echo number_format($indiceSuerte, 1); ?></div>
                    <div class="text-neon-pink">Riesgo <?php echo $nivelRiesgo; ?></div>
                </div>

                <div class="flex gap-2 justify-center mt-auto">
                    <?php if ($carritoDisponible && $isDisponible): ?>
                        <form id="carrito-form-<?php echo $id; ?>" method="post" action="/tienda_mistica/actions/carrito_actualizar.php" class="card-cart-form">
                            <input type="hidden" name="action" value="agregar">
                            <input type="hidden" name="id_duende" value="<?php echo $id; ?>">
                            <input type="hidden" name="redirect" value="catalogo">
                        </form>
                        <button type="button" class="btn-arc secondary pixel-font pixel-xs" onclick="agregarAlCarrito(<?php echo $id; ?>)">+ Agregar</button>
                    <?php elseif (!$isDisponible): ?>
                        <button type="button" class="btn-arc secondary pixel-font pixel-xs" disabled>Agotado</button>
                    <?php else: ?>
                        <a href="<?php echo url('login'); ?>" class="btn-arc secondary pixel-font pixel-xs">Ingresá</a>
                    <?php endif; ?>
                    <a href="<?php echo $detalleUrl; ?>" class="btn-arc primary pixel-font pixel-xs">👁️ Ver</a>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
        </div>

        <?php if ($usuarioLogueado): ?>
            <script>
            function agregarAlCarrito(id) {
                var form = document.getElementById('carrito-form-' + id);
                if (!form) {
                    return;
                }
                window.requestAnimationFrame(function () {
                    form.submit();
                });
            }
            </script>
        <?php else: ?>
            <script>
            function agregarAlCarrito() {
                window.location.href = "<?php echo url('login'); ?>";
            }
            </script>
        <?php endif; ?>

        <?php if ($pages > 1): ?>
            <nav class="catalogo-pagination" aria-label="Paginación del catálogo">
                <?php if ($page > 1): ?>
                    <a href="?<?php echo $buildQuery(['page' => $page - 1]); ?>" class="btn-arc secondary pixel-font pixel-xs">Anterior</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $pages; $i++):
                    $activo = $i === $page;
                ?>
                    <a href="?<?php echo $buildQuery(['page' => $i]); ?>" class="btn-arc secondary pixel-font pixel-xs <?php echo $activo ? '' : 'opacity-70'; ?>" style="<?php echo $activo ? 'border-color: rgba(var(--rareza-rgb-legendario), 0.45);' : ''; ?>"<?php echo $activo ? ' aria-current="page"' : ''; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $pages): ?>
                    <a href="?<?php echo $buildQuery(['page' => $page + 1]); ?>" class="btn-arc secondary pixel-font pixel-xs">Siguiente</a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    </section>
<?php endif; ?>
</div>
