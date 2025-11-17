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

    <!-- Hero Section -->
    <div class="blog-hero">
        <h1 class="blog-hero__title">Blog Retro Arcade</h1>
        <p class="blog-hero__subtitle">Rituales, historias y tácticas para dominar el salón místico de duendes</p>
    </div>

    <!-- Category Filters -->
    <?php if (!empty($categorias)): ?>
        <div class="blog-filters">
            <a href="index.php?sec=blog" class="blog-filter <?php echo $categoriaSeleccionada === '' ? 'blog-filter--active' : ''; ?>">
                Todas
            </a>
            <?php foreach ($categorias as $categoria): ?>
                <a href="index.php?sec=blog&categoria=<?php echo urlencode($categoria); ?>" 
                   class="blog-filter <?php echo $categoriaSeleccionada === $categoria ? 'blog-filter--active' : ''; ?>">
                    <?php echo ucfirst($categoria); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Blog Grid -->
    <?php if (empty($blogs)): ?>
        <div class="blog-empty">
            <div class="blog-empty__icon">📚</div>
            <h3 class="blog-empty__title">Sin artículos disponibles</h3>
            <p class="blog-empty__text">
                Pronto cargaremos nuevas crónicas para tu consola mística. 
                Mientras tanto revisá el <a href="index.php?sec=catalogo" class="link-primary">catálogo</a>.
            </p>
        </div>
    <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($blogs as $entrada): ?>
                <article class="blog-card">
                    <div class="blog-card__content">
                        <span class="blog-card__category"><?php echo htmlspecialchars($entrada['categoria'] ?? ''); ?></span>
                        
                        <h2 class="blog-card__title"><?php echo htmlspecialchars($entrada['titulo'] ?? 'Sin título'); ?></h2>
                        
                        <p class="blog-card__date">Publicado: <?php echo htmlspecialchars($entrada['fecha_publicacion'] ?? ''); ?></p>
                        
                        <p class="blog-card__excerpt"><?php echo htmlspecialchars($entrada['descripcion_corta'] ?? ''); ?></p>
                        
                        <a href="index.php?sec=blog&slug=<?php echo urlencode($entrada['slug']); ?>" class="btn-arc btn-arc--secondary">
                            <span>Leer Historia</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
