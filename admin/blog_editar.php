<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Blog.php';

$id = (int)($_GET['id'] ?? 0);
$blog = Blog::find($id);

if (!$blog) {
    ?>
    <div class="admin-empty-state">
        <div class="admin-empty-state__icon">⚠️</div>
        <h3 class="admin-empty-state__title">Blog no encontrado</h3>
        <p class="admin-empty-state__text">La entrada seleccionada no existe o ya fue archivada</p>
        <a href="<?php echo admin_url('blogs'); ?>" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Volver al listado</span>
        </a>
    </div>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['error'], $_SESSION['success']);

// Pre-llenar con datos del blog si no viene de POST
if (empty($_POST)) {
    $_POST = $blog;
}
?>

<!-- Section Header -->
<div class="admin-section-header">
    <div>
        <h1 class="admin-section-title">Editar Blog #<?php echo $id; ?></h1>
        <p class="admin-section-subtitle">Actualizá el contenido de <?php echo htmlspecialchars($blog['titulo']); ?></p>
    </div>
    <a href="<?php echo admin_url('blogs'); ?>" class="btn-arc btn-arc--ghost">
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
<form method="post" action="/tienda_mistica/admin/actions/blog_editar_acc.php" class="admin-form">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <!-- Basic Info -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Información Básica</h2>
        <div class="admin-form-grid">
            <div class="form-group form-group--full">
                <label for="titulo" class="form-label">Título*</label>
                <input type="text" id="titulo" name="titulo" required value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="slug" class="form-label">Slug (URL amigable)*</label>
                <input type="text" id="slug" name="slug" required value="<?php echo htmlspecialchars($_POST['slug'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($_POST['autor'] ?? ''); ?>" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="fecha_publicacion" class="form-label">Fecha de Publicación</label>
                <input type="date" id="fecha_publicacion" name="fecha_publicacion" value="<?php echo $_POST['fecha_publicacion'] ?? date('Y-m-d'); ?>" class="form-input">
            </div>
            
            <div class="form-group form-group--full">
                <label for="imagen_url" class="form-label">URL de Imagen de Portada</label>
                <input type="text" id="imagen_url" name="imagen_url" value="<?php echo htmlspecialchars($_POST['imagen_url'] ?? ''); ?>" class="form-input">
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Contenido</h2>
        <div class="admin-form-grid admin-form-grid--single">
            <div class="form-group">
                <label for="descripcion_corta" class="form-label">Descripción Corta</label>
                <textarea id="descripcion_corta" name="descripcion_corta" rows="3" class="form-input"><?php echo htmlspecialchars($_POST['descripcion_corta'] ?? ''); ?></textarea>
                <span class="form-help">Resumen breve para el listado</span>
            </div>
            
            <div class="form-group">
                <label for="contenido" class="form-label">Contenido Completo</label>
                <textarea id="contenido" name="contenido" rows="15" class="form-input"><?php echo htmlspecialchars($_POST['contenido'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Form Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Guardar Cambios</span>
        </button>
        <a href="<?php echo admin_url('blogs'); ?>" class="btn-arc btn-arc--ghost btn-arc--lg">
            <span>Cancelar</span>
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
