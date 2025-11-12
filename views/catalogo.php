<?php
require_once __DIR__ . '/../includes/url.php';
require_once "classes/Duende.php";

$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);

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
                    <span class="stat-chip" style="background: linear-gradient(135deg, rgba(6,182,212,0.92), rgba(147,51,234,0.92));">
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
                    <span class="stat-chip" style="background: linear-gradient(135deg, rgba(251,191,36,0.92), rgba(59,130,246,0.92));">
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
    <div class="mt-6 rounded-lg border border-emerald-400/50 bg-emerald-500/15 p-4 text-sm text-emerald-200 shadow-neon">
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
    <div class="mt-6 rounded-lg border border-rose-500/50 bg-rose-500/15 p-4 text-sm text-rose-200 shadow-neon">
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
    <div class="mt-10 rounded-2xl border border-arcade-magenta/40 bg-arcade-panel/70 p-10 text-center text-slate-200 shadow-neon">
        <p class="font-orbitron text-xl text-arcade-magenta">No encontramos duendes con esos filtros</p>
        <p class="mt-3 text-sm text-slate-300">Probá ampliando el rango de precio o quitando algunos elementos. La magia adecuada te espera.</p>
    </div>
<?php else: ?>
    <div class="mt-10 card-grid">
        <?php foreach ($duendes as $duende):
            $detalleUrl = url('detalle_duende', ['id' => $duende['id_duende']]);
            $carritoDisponible = !empty($_SESSION['usuario']);
            $imagenUrl = $duende['imagen_url'] ?? '';
            if ($imagenUrl) {
                $imagenUrl = asset_url($imagenUrl);
            }
        ?>
            <article class="neon-card flex flex-col overflow-hidden">
                <?php if ($imagenUrl): ?>
                    <div class="relative h-48 w-full overflow-hidden">
                        <img src="<?php echo htmlspecialchars($imagenUrl); ?>" alt="<?php echo htmlspecialchars($duende['nombre']); ?>" class="h-full w-full object-cover transition duration-300 hover:scale-105">
                        <span class="absolute left-4 top-4 rounded-full border border-white/30 bg-black/40 px-3 py-1 text-xs uppercase tracking-[0.18em] text-white" style="box-shadow: 0 0 15px <?php echo $duende['rareza_color']; ?>;">
                            <?php echo htmlspecialchars($duende['rareza'] ?? ''); ?>
                        </span>
                    </div>
                <?php endif; ?>
                <div class="flex flex-1 flex-col gap-4 p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="font-orbitron text-xl text-white drop-shadow"><a href="<?php echo $detalleUrl; ?>"><?php echo htmlspecialchars($duende['nombre']); ?></a></h2>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Elemento: <span style="color: <?php echo $duende['elemento_color']; ?>;"><?php echo htmlspecialchars($duende['elemento'] ?? '-'); ?></span></p>
                        </div>
                        <span class="stat-chip" style="background: linear-gradient(135deg, <?php echo $duende['rareza_color']; ?>, rgba(6,182,212,0.92));">
                            <?php echo number_format((float)($duende['precio_en_oro'] ?? 0), 2); ?> oro
                        </span>
                    </div>
                    <p class="text-sm text-slate-300 line-clamp-3"><?php echo htmlspecialchars($duende['descripcion'] ?? ''); ?></p>
                    <div class="grid grid-cols-2 gap-2 text-[0.7rem] uppercase tracking-[0.15em] text-slate-200">
                        <span class="rounded-lg border border-arcade-cyan/40 bg-arcade-base/70 px-2 py-2">Poder: <strong class="block text-lg text-arcade-gold"><?php echo (int)($duende['poder_total'] ?? 0); ?></strong></span>
                        <span class="rounded-lg border border-arcade-cyan/40 bg-arcade-base/70 px-2 py-2">Suerte: <strong class="block text-lg text-arcade-cyan"><?php echo (float)($duende['indice_suerte'] ?? 0); ?></strong></span>
                        <span class="rounded-lg border border-arcade-cyan/40 bg-arcade-base/70 px-2 py-2">Riesgo: <strong class="block text-lg text-arcade-magenta"><?php echo (int)($duende['nivel_riesgo'] ?? 0); ?></strong></span>
                        <span class="rounded-lg border border-arcade-cyan/40 bg-arcade-base/70 px-2 py-2">Popularidad: <strong class="block text-lg text-arcade-cyan"><?php echo (int)($duende['popularidad'] ?? 0); ?></strong></span>
                    </div>
                    <?php if (!empty($duende['accesorios_list'])): ?>
                        <div class="flex flex-wrap gap-2 text-[0.65rem] uppercase tracking-[0.18em] text-slate-200">
                            <?php foreach ($duende['accesorios_list'] as $accesorio): ?>
                                <span class="rounded-full border border-arcade-magenta/30 bg-arcade-panel/70 px-3 py-1"><?php echo htmlspecialchars($accesorio); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mt-auto flex items-center justify-between gap-3">
                        <a href="<?php echo $detalleUrl; ?>" class="button-arcade px-4 py-2 text-xs">Ver ficha</a>
                        <?php if ($carritoDisponible): ?>
                            <form method="post" action="/tienda_mistica/actions/carrito_actualizar.php" class="inline-flex">
                                <input type="hidden" name="action" value="agregar">
                                <input type="hidden" name="id_duende" value="<?php echo $duende['id_duende']; ?>">
                                <input type="hidden" name="redirect" value="catalogo">
                                <button type="submit" class="button-arcade px-4 py-2 text-xs" style="background: linear-gradient(135deg, rgba(6,182,212,0.35), rgba(217,70,239,0.4));">Agregar</button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo url('login'); ?>" class="button-arcade px-4 py-2 text-xs" style="background: linear-gradient(135deg, rgba(99,102,241,0.35), rgba(147,51,234,0.35));">Ingresá</a>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if ($pages > 1): ?>
        <nav class="mt-10 flex items-center justify-center gap-3 text-sm text-slate-200">
            <?php if ($page > 1): ?>
                <a href="?<?php echo $buildQuery(['page' => $page - 1]); ?>" class="button-arcade px-4 py-2 text-xs">Anterior</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++):
                $activo = $i === $page;
            ?>
                <a href="?<?php echo $buildQuery(['page' => $i]); ?>" class="button-arcade px-4 py-2 text-xs <?php echo $activo ? '' : 'opacity-70'; ?>" style="<?php echo $activo ? 'background: linear-gradient(135deg, rgba(217,70,239,0.4), rgba(6,182,212,0.4));' : 'background: linear-gradient(135deg, rgba(15,23,42,0.9), rgba(30,41,59,0.9));'; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
                <a href="?<?php echo $buildQuery(['page' => $page + 1]); ?>" class="button-arcade px-4 py-2 text-xs">Siguiente</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
<?php endif; ?>
