<?php
require_once __DIR__ . '/../includes/url.php';
require_once "classes/Duende.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$duende = null;
try {
    $duende = Duende::detalleEnriquecido($id);
} catch (Exception $e) {
    error_log("Error al obtener detalle del duende: " . $e->getMessage());
}

if (!$duende): ?>
    <div class="panel-glass mt-10 p-10 text-center text-slate-200">
        <p class="font-orbitron text-2xl text-arcade-magenta">Duende no encontrado</p>
        <p class="mt-3 text-sm text-slate-300">La ficha solicitada fue absorbida por la niebla mágica. Volvé al <a class="text-arcade-cyan hover:text-arcade-gold" href="index.php?sec=catalogo">catálogo</a> para seguir explorando.</p>
    </div>
<?php else:
    $imagenUrl = $duende['imagen_url'] ?? '';
    if ($imagenUrl) {
        $imagenUrl = asset_url($imagenUrl);
    }

    $recomendados = Duende::catalogoInteractivo([
        'elemento' => [$duende['id_elemento'] ?? 0],
        'rareza' => [$duende['id_rareza'] ?? 0],
        'poder_min' => max(0, (int)($duende['poder_total'] ?? 0) - 20),
        'solo_disponibles' => true,
        'page' => 1,
        'per_page' => 3,
    ], true)['items'];

    $recomendados = array_values(array_filter($recomendados, static fn($item) => (int)$item['id_duende'] !== (int)$duende['id_duende']));
?>

<article class="panel-glass overflow-hidden">
    <div class="grid gap-10 px-6 py-10 lg:grid-cols-2 lg:px-12">
        <div class="space-y-6">
            <p class="font-retro text-xs uppercase tracking-[0.4em] text-arcade-magenta">Ficha de power-up</p>
            <h1 class="font-orbitron text-4xl text-white drop-shadow-sm"><?php echo htmlspecialchars($duende['nombre']); ?></h1>
            <p class="text-sm uppercase tracking-[0.2em] text-slate-300">
                Tipo: <span class="text-arcade-cyan"><?php echo htmlspecialchars($duende['tipo'] ?? '-'); ?></span> &bull;
                Rareza: <span style="color: <?php echo $duende['rareza_color']; ?>; font-weight: 600;">
                    <?php echo htmlspecialchars($duende['rareza'] ?? '-'); ?>
                </span>
            </p>
            <p class="text-base text-slate-200">
                <?php echo nl2br(htmlspecialchars($duende['descripcion'] ?? '')); ?>
            </p>
            <div class="glow-divider"></div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-arcade-cyan/40 bg-arcade-base/70 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Efecto mágico</p>
                    <p class="mt-2 text-slate-100"><?php echo htmlspecialchars($duende['efecto_magico'] ?? 'Sin registro'); ?></p>
                </div>
                <div class="rounded-xl border border-arcade-magenta/40 bg-arcade-base/70 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Recomendado para</p>
                    <p class="mt-2 text-slate-100"><?php echo htmlspecialchars($duende['recomendado_para'] ?? 'Aventureros versátiles'); ?></p>
                </div>
                <div class="rounded-xl border border-arcade-cyan/40 bg-arcade-base/70 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Origen</p>
                    <p class="mt-2 text-slate-100"><?php echo htmlspecialchars($duende['origen_mitologico'] ?? 'Bosques arcanos desconocidos'); ?></p>
                </div>
                <div class="rounded-xl border border-arcade-cyan/40 bg-arcade-base/70 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Material</p>
                    <p class="mt-2 text-slate-100"><?php echo htmlspecialchars($duende['material'] ?? 'Materia arcana'); ?></p>
                </div>
            </div>
            <?php if (!empty($duende['advertencias'])): ?>
                <div class="rounded-xl border border-arcade-amber/60 bg-arcade-amber/10 p-4 text-sm text-arcade-amber">
                    <p class="font-orbitron text-xs uppercase tracking-[0.25em] text-arcade-amber">Advertencia arcade</p>
                    <p class="mt-2"><?php echo htmlspecialchars($duende['advertencias']); ?></p>
                </div>
            <?php endif; ?>
            <div class="flex flex-wrap items-center gap-4">
                <span class="stat-chip" style="background: linear-gradient(135deg, <?php echo $duende['rareza_color']; ?>, rgba(var(--rareza-rgb-poco-comun), 0.92));">
                    <?php echo number_format((float)($duende['precio_en_oro'] ?? 0), 2); ?> oro
                </span>
                <?php if (!empty($_SESSION['usuario'])): ?>
                    <form method="post" action="actions/carrito_actualizar.php" class="inline-flex">
                        <input type="hidden" name="action" value="agregar">
                        <input type="hidden" name="id_duende" value="<?php echo $duende['id_duende']; ?>">
                        <input type="hidden" name="redirect" value="detalle_duende&id=<?php echo $duende['id_duende']; ?>">
                        <button type="submit" class="button-arcade px-6">Agregar al carrito</button>
                    </form>
                <?php else: ?>
                    <a href="index.php?sec=login" class="button-arcade px-6" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-raro), 0.35), rgba(var(--rareza-rgb-mistico), 0.35));">Ingresá para comprar</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="space-y-6">
            <?php if ($imagenUrl): ?>
                <div class="neon-card overflow-hidden">
                    <img src="<?php echo htmlspecialchars($imagenUrl); ?>" alt="<?php echo htmlspecialchars($duende['nombre']); ?>" class="h-full w-full object-cover">
                </div>
            <?php endif; ?>
            <div class="grid grid-cols-2 gap-4 text-xs uppercase tracking-[0.18em] text-slate-300">
                <div class="rounded-xl border border-arcade-cyan/40 bg-arcade-panel/80 p-4">
                    Poder total
                    <p class="mt-2 font-orbitron text-3xl text-arcade-gold"><?php echo (int)($duende['poder_total'] ?? 0); ?></p>
                </div>
                <div class="rounded-xl border border-arcade-cyan/40 bg-arcade-panel/80 p-4">
                    Índice de suerte
                    <p class="mt-2 font-orbitron text-3xl text-arcade-cyan"><?php echo (float)($duende['indice_suerte'] ?? 0); ?></p>
                </div>
                <div class="rounded-xl border border-arcade-cyan/40 bg-arcade-panel/80 p-4">
                    Nivel de riesgo
                    <p class="mt-2 font-orbitron text-3xl text-arcade-magenta"><?php echo (int)($duende['nivel_riesgo'] ?? 0); ?></p>
                </div>
                <div class="rounded-xl border border-arcade-cyan/40 bg-arcade-panel/80 p-4">
                    Popularidad
                    <p class="mt-2 font-orbitron text-3xl text-arcade-cyan"><?php echo (int)($duende['popularidad'] ?? 0); ?></p>
                </div>
            </div>

            <?php if (!empty($duende['accesorios_list'])): ?>
                <div class="rounded-xl border border-arcade-magenta/40 bg-arcade-panel/80 p-5">
                    <p class="font-orbitron text-xs uppercase tracking-[0.25em] text-arcade-magenta">Accesorios vinculados</p>
                    <div class="mt-3 flex flex-wrap gap-2 text-[0.65rem] uppercase tracking-[0.18em] text-slate-200">
                        <?php foreach ($duende['accesorios_list'] as $accesorio): ?>
                            <span class="rounded-full border border-arcade-magenta/30 bg-arcade-base/70 px-3 py-1"><?php echo htmlspecialchars($accesorio); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>

<?php if (!empty($duende['personalidad']) || !empty($duende['efecto_magico'])): ?>
    <section class="mt-12 panel-glass p-8">
        <div class="grid gap-6 md:grid-cols-3">
            <div>
                <p class="font-orbitron text-xs uppercase tracking-[0.25em] text-arcade-magenta">Personalidad</p>
                <p class="mt-3 text-sm text-slate-200"><?php echo htmlspecialchars($duende['personalidad'] ?? 'Cambiante'); ?></p>
            </div>
            <div>
                <p class="font-orbitron text-xs uppercase tracking-[0.25em] text-arcade-magenta">Elemento</p>
                <p class="mt-3 text-sm text-slate-200"><?php echo htmlspecialchars($duende['elemento'] ?? '-'); ?></p>
            </div>
            <div>
                <p class="font-orbitron text-xs uppercase tracking-[0.25em] text-arcade-magenta">Altura</p>
                <p class="mt-3 text-sm text-slate-200"><?php echo $duende['altura_cm'] ? $duende['altura_cm'] . ' cm' : 'Variable'; ?></p>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($recomendados)): ?>
    <section class="mt-14">
        <h2 class="font-orbitron text-2xl text-white">Otros power-ups compatibles</h2>
        <p class="mt-2 text-sm text-slate-300">Combiná rarezas similares para desbloquear efectos acumulados. Estos duendes comparten elemento o rareza con <?php echo htmlspecialchars($duende['nombre']); ?>.</p>
        <div class="mt-6 card-grid">
            <?php foreach ($recomendados as $reco):
                $recoImg = $reco['imagen_url'] ?? '';
                if ($recoImg) {
                    $recoImg = asset_url($recoImg);
                }
            ?>
                <article class="neon-card overflow-hidden">
                    <?php if ($recoImg): ?>
                        <img src="<?php echo htmlspecialchars($recoImg); ?>" alt="<?php echo htmlspecialchars($reco['nombre']); ?>" class="h-40 w-full object-cover">
                    <?php endif; ?>
                    <div class="space-y-3 p-5">
                        <h3 class="font-orbitron text-lg text-white">
                            <a href="index.php?sec=detalle_duende&id=<?php echo $reco['id_duende']; ?>"><?php echo htmlspecialchars($reco['nombre']); ?></a>
                        </h3>
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400"><?php echo htmlspecialchars($reco['rareza'] ?? '-'); ?> &bull; <?php echo htmlspecialchars($reco['elemento'] ?? '-'); ?></p>
                        <p class="text-sm text-slate-300 line-clamp-3"><?php echo htmlspecialchars($reco['descripcion'] ?? ''); ?></p>
                        <div class="flex items-center justify-between text-xs uppercase tracking-[0.18em] text-slate-200">
                            <span class="stat-chip" style="background: linear-gradient(135deg, <?php echo $reco['rareza_color']; ?>, rgba(var(--rareza-rgb-poco-comun), 0.92));"><?php echo number_format((float)($reco['precio_en_oro'] ?? 0), 2); ?> oro</span>
                            <span class="rounded-full border border-arcade-cyan/40 bg-arcade-base/70 px-3 py-1">Poder <?php echo (int)($reco['poder_total'] ?? 0); ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php endif; ?>
