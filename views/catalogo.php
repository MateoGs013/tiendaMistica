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
    'q' => trim($_GET['q'] ?? ''),
    'poder_min' => isset($_GET['poder_min']) ? (int)$_GET['poder_min'] : null,
    'page' => isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1,
    'solo_disponibles' => true,
];

$filtros['per_page'] = 6;

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

if ($filtros['q'] !== '') {
    $activeChips[] = 'Búsqueda: ' . $filtros['q'];
}

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
<section class="panel-glass overflow-hidden">
    <div class="flex flex-col gap-6 px-6 py-8 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="font-retro text-xs uppercase tracking-[0.4em] text-arcade-magenta">Sala de power-ups</p>
            <h1 class="mt-3 font-orbitron text-3xl text-white drop-shadow">Catálogo de Duendes</h1>
            <p class="mt-2 text-sm text-slate-300">
                Filtrá por rareza, elemento y precio. Calculamos poder total, índice de suerte y nivel de riesgo
                para que desbloquees el combo perfecto.
            </p>
            <p class="mt-4 text-xs uppercase tracking-[0.28em] text-arcade-cyan">
                <?php echo $total; ?> resultados &bull; página <?php echo $page; ?> de <?php echo max(1, $pages); ?>
            </p>
        </div>
        <div class="neon-card max-w-sm p-5 text-sm text-slate-200">
            <p class="font-orbitron text-sm uppercase tracking-[0.24em] text-arcade-magenta">Stats en vivo</p>
            <ul class="mt-4 space-y-2">
                <li class="flex items-center justify-between">
                    <span>Precio promedio</span>
                    <span class="stat-chip" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-poco-comun), 0.92), rgba(var(--rareza-rgb-mistico), 0.92));">
                        <?php
                        $promedio = 0.0;
                        if (!empty($duendes)) {
                            $sum = array_sum(array_map(static fn($d) => (float)($d['precio_en_oro'] ?? 0), $duendes));
                            $promedio = $sum / count($duendes);
                        }
                        echo number_format($promedio, 2);
                        ?> oro
                    </span>
                </li>
                <li class="flex items-center justify-between">
                    <span>Poder total máximo</span>
                    <span class="stat-chip">
                        <?php
                        $maxPoder = !empty($duendes) ? max(array_map(static fn($d) => (int)($d['poder_total'] ?? 0), $duendes)) : 0;
                        echo $maxPoder;
                        ?>
                    </span>
                </li>
                <li class="flex items-center justify-between">
                    <span>Rango de suerte</span>
                    <span class="stat-chip" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-legendario), 0.92), rgba(var(--rareza-rgb-poco-comun), 0.92));">
                        <?php
                        if (!empty($duendes)) {
                            $min = min(array_map(static fn($d) => (int)($d['nivel_suerte'] ?? 0), $duendes));
                            $max = max(array_map(static fn($d) => (int)($d['nivel_suerte'] ?? 0), $duendes));
                            echo $min . ' – ' . $max;
                        } else {
                            echo '0';
                        }
                        ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</section>

<?php if ($mensaje): ?>
    <div class="mt-6 rounded-lg border border-arcade-emerald/50 bg-arcade-emerald/15 p-4 text-sm text-arcade-emerald shadow-neon">
        ✓ <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.querySelector('[data-filter-toggle]');
    var panel = document.getElementById('panel-filtros');
    if (!toggle || !panel) {
        return;
    }
    var labelOpen = toggle.getAttribute('data-label-open') || 'Ocultar filtros';
    var labelClosed = toggle.getAttribute('data-label-closed') || 'Mostrar filtros';
    toggle.addEventListener('click', function () {
        var isHidden = panel.classList.contains('hidden');
        if (isHidden) {
            panel.classList.remove('hidden');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.textContent = labelOpen;
        } else {
            panel.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.textContent = labelClosed;
        }
    });
});
</script>

<?php if ($error): ?>
    <div class="mt-6 rounded-lg border border-arcade-rose/50 bg-arcade-rose/15 p-4 text-sm text-arcade-rose shadow-neon">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="filter-toolbar panel-glass mt-8 border border-arcade-cyan/30 bg-arcade-panel/70 p-6 shadow-neon">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="font-orbitron text-xs uppercase tracking-[0.26em] text-arcade-magenta">Filtros activos</p>
            <?php if ($activeChips): ?>
                <div class="filter-chip-row mt-3">
                    <?php foreach ($activeChips as $chip): ?>
                        <span class="filter-chip"><?php echo htmlspecialchars($chip); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="filter-toolbar__empty mt-3 text-sm">Sin filtros aplicados. Ajustá los criterios para personalizar el catálogo.</p>
            <?php endif; ?>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" class="button-ghost filter-toggle" data-filter-toggle data-label-closed="Mostrar filtros" data-label-open="Ocultar filtros" aria-expanded="<?php echo $panelShouldStartOpen ? 'true' : 'false'; ?>">
                <?php echo $panelShouldStartOpen ? 'Ocultar filtros' : 'Mostrar filtros'; ?>
            </button>
            <a href="<?php echo url('catalogo'); ?>" class="button-ghost filter-reset">Limpiar</a>
        </div>
    </div>
</div>

<form method="get" id="panel-filtros" class="filter-panel mt-6 flex flex-col gap-6 rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/60 p-6 shadow-neon <?php echo $panelShouldStartOpen ? '' : 'hidden'; ?>">
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <label class="flex flex-col gap-2 text-sm uppercase tracking-[0.18em] text-slate-300">
            Búsqueda
            <input type="text" name="q" value="<?php echo htmlspecialchars($filtros['q']); ?>" class="arcade-input" placeholder="Nombre, rareza, accesorio...">
        </label>
        <label class="flex flex-col gap-2 text-sm uppercase tracking-[0.18em] text-slate-300">
            Ordenar por
            <select name="orden" class="arcade-select">
                <?php foreach ($opcionesOrden as $valor => $label): ?>
                    <option value="<?php echo $valor; ?>" <?php echo $filtros['orden'] === $valor ? 'selected' : ''; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="flex flex-col gap-2 text-sm uppercase tracking-[0.18em] text-slate-300">
            Poder mínimo
            <input type="number" name="poder_min" min="0" step="10" value="<?php echo $filtros['poder_min'] ?? ''; ?>" class="arcade-input" placeholder="Ej. 150">
        </label>
        <div class="flex flex-col gap-2 text-sm uppercase tracking-[0.18em] text-slate-300">
            Precio (oro)
            <div class="grid grid-cols-2 gap-3 text-[0.72rem] uppercase tracking-[0.15em] text-slate-400">
                <label>
                    Mínimo
                    <input type="number" name="precio_min" min="0" step="5" value="<?php echo $filtros['precio_min'] ?? ($rangos['minimo'] ?? ''); ?>" class="arcade-input mt-1">
                </label>
                <label>
                    Máximo
                    <input type="number" name="precio_max" min="0" step="5" value="<?php echo $filtros['precio_max'] ?? ($rangos['maximo'] ?? ''); ?>" class="arcade-input mt-1">
                </label>
            </div>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <details class="filter-accordion<?php echo !empty($filtros['rareza']) ? ' open' : ''; ?>">
            <summary>
                <span>Rareza</span>
                <?php if (!empty($filtros['rareza'])): ?>
                    <span class="filter-count"><?php echo count($filtros['rareza']); ?></span>
                <?php endif; ?>
            </summary>
            <div class="filter-options">
                <?php foreach ($filtrosDisponibles['rarezas'] as $rareza):
                    $id = (int)$rareza['id_rareza'];
                    $activo = in_array((string)$id, array_map('strval', $filtros['rareza']), true);
                ?>
                    <label class="filter-option <?php echo $activo ? 'filter-option--active' : ''; ?>">
                        <input type="checkbox" name="rareza[]" value="<?php echo $id; ?>" <?php echo $activo ? 'checked' : ''; ?> class="filter-option-input">
                        <span><?php echo htmlspecialchars($rareza['nombre']); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </details>

        <details class="filter-accordion<?php echo !empty($filtros['elemento']) ? ' open' : ''; ?>">
            <summary>
                <span>Elemento</span>
                <?php if (!empty($filtros['elemento'])): ?>
                    <span class="filter-count"><?php echo count($filtros['elemento']); ?></span>
                <?php endif; ?>
            </summary>
            <div class="filter-options">
                <?php foreach ($filtrosDisponibles['elementos'] as $elemento):
                    $id = (int)$elemento['id_elemento'];
                    $activo = in_array((string)$id, array_map('strval', $filtros['elemento']), true);
                ?>
                    <label class="filter-option <?php echo $activo ? 'filter-option--active' : ''; ?>">
                        <input type="checkbox" name="elemento[]" value="<?php echo $id; ?>" <?php echo $activo ? 'checked' : ''; ?> class="filter-option-input">
                        <span><?php echo htmlspecialchars($elemento['nombre']); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </details>

        <details class="filter-accordion<?php echo !empty($filtros['material']) ? ' open' : ''; ?>">
            <summary>
                <span>Material</span>
                <?php if (!empty($filtros['material'])): ?>
                    <span class="filter-count"><?php echo count($filtros['material']); ?></span>
                <?php endif; ?>
            </summary>
            <div class="filter-options">
                <?php foreach ($filtrosDisponibles['materiales'] as $material):
                    $id = (int)$material['id_material'];
                    $activo = in_array((string)$id, array_map('strval', $filtros['material']), true);
                ?>
                    <label class="filter-option <?php echo $activo ? 'filter-option--active' : ''; ?>">
                        <input type="checkbox" name="material[]" value="<?php echo $id; ?>" <?php echo $activo ? 'checked' : ''; ?> class="filter-option-input">
                        <span><?php echo htmlspecialchars($material['nombre']); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </details>
    </div>

    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end">
        <button type="submit" class="button-arcade w-full sm:w-auto">Aplicar filtros</button>
    </div>
</form>

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
