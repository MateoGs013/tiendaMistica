<?php
require_once __DIR__ . '/includes/header.php';

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$oldData = $_SESSION['old_data'] ?? [];

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_data']);
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Crear Blog</h1>
        <p class="admin-section-subtitle">Redactá nueva sabiduría arcade para la comunidad</p>
    </div>
    <a href="index.php?sec=blogs" class="btn-arc btn-arc--ghost">
        <span>← Volver al listado</span>
    </a>
</div>

<!-- Alerts -->
<?php if ($success): ?>
    <div class="alert alert-success">
        <span class="alert__icon">✓</span>
        <span><?php echo htmlspecialchars($success); ?></span>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error">
        <span class="alert__icon">✗</span>
        <span><?php echo htmlspecialchars($error); ?></span>
    </div>
<?php endif; ?>

<!-- Blog Form -->
<form method="post" action="actions/blog_crear_acc.php" class="admin-form">
    <!-- Basic Info -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Información Básica</h2>
        <div class="admin-form-grid">
            <div class="form-group form-group--full">
                <label for="titulo" class="form-label">Título*</label>
                <input type="text" id="titulo" name="titulo" required value="<?php echo htmlspecialchars($oldData['titulo'] ?? ''); ?>" class="form-input" placeholder="Ej: Rutas secretas de las hadas">
            </div>
            
            <div class="form-group">
                <label for="slug" class="form-label">Slug (URL amigable)</label>
                <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($oldData['slug'] ?? ''); ?>" class="form-input" placeholder="rutas-secretas-hadas">
                <span class="form-help">Se genera automáticamente si lo dejás vacío</span>
            </div>
            
            <div class="form-group">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($oldData['autor'] ?? ''); ?>" class="form-input" placeholder="Arcadia Team">
            </div>
            
            <div class="form-group">
                <label for="fecha_publicacion" class="form-label">Fecha de Publicación</label>
                <input type="date" id="fecha_publicacion" name="fecha_publicacion" value="<?php echo $oldData['fecha_publicacion'] ?? date('Y-m-d'); ?>" class="form-input">
            </div>
            
            <div class="form-group form-group--full">
                <label for="imagen_url" class="form-label">URL de Imagen de Portada</label>
                <input type="text" id="imagen_url" name="imagen_url" value="<?php echo htmlspecialchars($oldData['imagen_url'] ?? ''); ?>" class="form-input" placeholder="https://">
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Contenido</h2>
        <div class="admin-form-grid admin-form-grid--single">
            <div class="form-group">
                <label for="descripcion_corta" class="form-label">Descripción Corta</label>
                <textarea id="descripcion_corta" name="descripcion_corta" rows="3" class="form-input" placeholder="Pequeño resumen que se verá en el listado"><?php echo htmlspecialchars($oldData['descripcion_corta'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="contenido" class="form-label">Contenido Completo</label>
                <textarea id="contenido" name="contenido" rows="15" class="form-input" placeholder="Escribí la aventura completa del artículo"><?php echo htmlspecialchars($oldData['contenido'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Form Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Crear Blog</span>
        </button>
        <a href="index.php?sec=blogs" class="btn-arc btn-arc--ghost btn-arc--lg">
            <span>Cancelar</span>
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
