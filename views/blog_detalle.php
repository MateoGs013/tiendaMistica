<?php
require_once "classes/Blog.php";

// Get slug from URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: index.php?sec=blog');
    exit;
}

$blog = Blog::findBySlug($slug);

if (!$blog) {
    header('Location: index.php?sec=404');
    exit;
}

?>

<!-- Blog Detail Hero -->
<div class="blog-detalle-hero">
    <a href="index.php?sec=blog" class="blog-detalle-back">
        <span>←</span> Volver al Blog
    </a>
</div>

<!-- Blog Detail Content -->
<article class="blog-detalle">
    <header class="blog-detalle__header">
        <span class="blog-detalle__category"><?php echo htmlspecialchars($blog['categoria'] ?? 'Sin categoría'); ?></span>
        
        <h1 class="blog-detalle__title"><?php echo htmlspecialchars($blog['titulo']); ?></h1>
        
        <?php if (!empty($blog['descripcion_corta'])): ?>
            <p class="blog-detalle__excerpt"><?php echo htmlspecialchars($blog['descripcion_corta']); ?></p>
        <?php endif; ?>
        
        <div class="blog-detalle__meta">
            <div class="blog-detalle__meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <span><?php echo htmlspecialchars($blog['autor'] ?? 'Anónimo'); ?></span>
            </div>
            <div class="blog-detalle__meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
                <span><?php echo htmlspecialchars($blog['fecha_publicacion'] ?? ''); ?></span>
            </div>
            <?php if (!empty($blog['popularidad'])): ?>
                <div class="blog-detalle__meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                    <span><?php echo htmlspecialchars($blog['popularidad']); ?>% Popular</span>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <div class="blog-detalle__content">
        <?php echo $blog['contenido'] ?? '<p>Sin contenido disponible.</p>'; ?>
    </div>

    <footer class="blog-detalle__footer">
        <div class="blog-detalle__footer-info">
            <div class="blog-detalle__footer-item">
                <strong>ID del Artículo:</strong> #<?php echo htmlspecialchars($blog['id_blog']); ?>
            </div>
            <div class="blog-detalle__footer-item">
                <strong>Slug:</strong> <?php echo htmlspecialchars($blog['slug']); ?>
            </div>
        </div>
        <a href="index.php?sec=blog" class="btn-arc btn-arc--primary">
            <span>← Volver al Blog</span>
        </a>
    </footer>
</article>

<!-- Related Posts -->
<?php
try {
    $categoria = $blog['categoria'] ?? '';
    $relatedBlogs = [];
    
    if (!empty($categoria)) {
        $allBlogs = Blog::latest();
        $relatedBlogs = array_filter($allBlogs, function($b) use ($blog, $categoria) {
            return $b['id_blog'] != $blog['id_blog'] && 
                   strtolower(trim($b['categoria'] ?? '')) === strtolower(trim($categoria));
        });
        $relatedBlogs = array_slice($relatedBlogs, 0, 3);
    }
} catch (Exception $e) {
    $relatedBlogs = [];
}
?>

<?php if (!empty($relatedBlogs)): ?>
    <section class="blog-relacionados">
        <h2 class="blog-relacionados__title">Historias Relacionadas</h2>
        <div class="blog-relacionados__grid">
            <?php foreach ($relatedBlogs as $relacionado): ?>
                <article class="blog-card">
                    <div class="blog-card__content">
                        <span class="blog-card__category"><?php echo htmlspecialchars($relacionado['categoria'] ?? ''); ?></span>
                        <h3 class="blog-card__title"><?php echo htmlspecialchars($relacionado['titulo'] ?? 'Sin título'); ?></h3>
                        <p class="blog-card__excerpt"><?php echo htmlspecialchars($relacionado['descripcion_corta'] ?? ''); ?></p>
                        <a href="index.php?sec=blog&slug=<?php echo urlencode($relacionado['slug']); ?>" class="btn-arc btn-arc--secondary">
                            <span>Leer Historia</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
