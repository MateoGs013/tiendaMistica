<?php
require_once "classes/Blog.php";

$blogs = [];
try {
    $blogs = Blog::latest();
} catch (Exception $e) {
    error_log("Error al cargar blogs: " . $e->getMessage());
}

$categorias = [];
foreach ($blogs as $entrada) {
    if (!empty($entrada['categoria'])) {
        $categorias[] = strtolower(trim($entrada['categoria']));
    }
}
$categorias = array_unique($categorias);
sort($categorias);

$categoriaSeleccionada = strtolower(trim($_GET['categoria'] ?? ''));
if ($categoriaSeleccionada !== '') {
    $blogs = array_values(array_filter($blogs, static function ($entrada) use ($categoriaSeleccionada) {
        return strtolower(trim($entrada['categoria'] ?? '')) === $categoriaSeleccionada;
    }));
}
?>

<section class="panel-glass overflow-hidden">
    <div class="px-6 py-8 lg:px-10">
        <p class="font-retro text-xs uppercase tracking-[0.4em] text-arcade-magenta">Crónicas del bosque</p>
        <h1 class="mt-3 font-orbitron text-3xl text-white">Blog Retro Arcade</h1>
        <p class="mt-2 text-sm text-slate-300">Rituales, historias y tácticas para dominar el salón místico de duendes. Filtrá por categoría para ajustar la vibra de tus lecturas.</p>
    </div>
</section>

<?php if (!empty($categorias)): ?>
    <div class="mt-6 flex flex-wrap gap-3">
    <a href="<?php echo url('blog'); ?>" class="button-arcade px-4 py-2 text-xs <?php echo $categoriaSeleccionada === '' ? '' : 'opacity-75'; ?>" style="<?php echo $categoriaSeleccionada === '' ? 'background: linear-gradient(135deg, rgba(var(--rareza-rgb-poco-comun), 0.35), rgba(var(--rareza-rgb-epico), 0.45));' : 'background: linear-gradient(135deg, rgba(9,14,32,0.9), rgba(4,7,20,0.92));'; ?>">Todas</a>
        <?php foreach ($categorias as $categoria):
            $isActive = $categoriaSeleccionada === $categoria;
        ?>
            <a href="<?php echo url('blog'); ?>?categoria=<?php echo urlencode($categoria); ?>" class="button-arcade px-4 py-2 text-xs <?php echo $isActive ? '' : 'opacity-75'; ?>" style="<?php echo $isActive ? 'background: linear-gradient(135deg, rgba(var(--rareza-rgb-epico), 0.35), rgba(var(--rareza-rgb-poco-comun), 0.45));' : 'background: linear-gradient(135deg, rgba(9,14,32,0.9), rgba(4,7,20,0.92));'; ?>"><?php echo ucfirst($categoria); ?></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (empty($blogs)): ?>
    <div class="mt-10 rounded-2xl border border-arcade-magenta/40 bg-arcade-panel/70 p-10 text-center text-slate-200 shadow-neon">
        <p class="font-orbitron text-xl text-arcade-magenta">Sin artefactos disponibles</p>
        <p class="mt-3 text-sm text-slate-300">Pronto cargaremos nuevas crónicas para tu consola mística. Mientras tanto revisá el <a href="<?php echo url('catalogo'); ?>" class="text-arcade-cyan hover:text-arcade-gold">catálogo</a>.</p>
    </div>
<?php else: ?>
    <div class="mt-8 card-grid">
        <?php foreach ($blogs as $entrada):
            $imagen = $entrada['imagen_portada'] ?? '';
            if ($imagen) {
                $imagen = preg_match('/^https?:\/\//i', $imagen) ? $imagen : '/' . ltrim($imagen, '/');
            }
        ?>
            <article class="neon-card overflow-hidden">
                <?php if ($imagen): ?>
                    <img src="<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($entrada['titulo'] ?? ''); ?>" class="h-40 w-full object-cover">
                <?php endif; ?>
                <div class="space-y-3 p-6">
                    <p class="text-xs uppercase tracking-[0.18em] text-arcade-magenta"><?php echo htmlspecialchars($entrada['categoria'] ?? ''); ?></p>
                    <h2 class="font-orbitron text-xl text-white"><?php echo htmlspecialchars($entrada['titulo'] ?? 'Sin título'); ?></h2>
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Publicado: <?php echo htmlspecialchars($entrada['fecha_publicacion'] ?? ''); ?></p>
                    <p class="text-sm text-slate-300 line-clamp-3"><?php echo htmlspecialchars($entrada['descripcion_corta'] ?? ''); ?></p>
                    <a href="<?php echo url('blog'); ?>?ver=<?php echo urlencode($entrada['slug']); ?>" class="button-arcade px-4 py-2 text-xs" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-poco-comun), 0.35), rgba(var(--rareza-rgb-mistico), 0.45));">Leer historia</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
