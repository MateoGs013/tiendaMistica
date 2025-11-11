<?php
require_once __DIR__ . '/includes/header.php';

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$oldData = $_SESSION['old_data'] ?? [];

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_data']);
?>
<h1>Crear Nuevo Blog</h1>
<?php if ($success): ?>
    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="/tienda_mistica/admin/actions/blog_crear_acc.php" style="max-width: 900px;">
    <fieldset>
        <legend>Información Básica</legend>
        
        <label>Título: *<br>
            <input type="text" name="titulo" required value="<?php echo htmlspecialchars($oldData['titulo'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Slug (URL amigable): *<br>
            <input type="text" name="slug" value="<?php echo htmlspecialchars($oldData['slug'] ?? ''); ?>" style="width: 100%;">
            <small>Se genera automáticamente si se deja vacío</small>
        </label><br><br>
        
        <label>Autor:<br>
            <input type="text" name="autor" value="<?php echo htmlspecialchars($oldData['autor'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Fecha de Publicación:<br>
            <input type="date" name="fecha_publicacion" value="<?php echo $oldData['fecha_publicacion'] ?? date('Y-m-d'); ?>">
        </label><br><br>
        
        <label>URL de Imagen:<br>
            <input type="text" name="imagen_url" value="<?php echo htmlspecialchars($oldData['imagen_url'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
    </fieldset>
    
    <fieldset>
        <legend>Contenido</legend>
        
        <label>Descripción Corta:<br>
            <textarea name="descripcion_corta" rows="3" style="width: 100%;"><?php echo htmlspecialchars($oldData['descripcion_corta'] ?? ''); ?></textarea>
            <small>Resumen breve para el listado</small>
        </label><br><br>
        
        <label>Contenido Completo:<br>
            <textarea name="contenido" rows="15" style="width: 100%;"><?php echo htmlspecialchars($oldData['contenido'] ?? ''); ?></textarea>
        </label><br><br>
    </fieldset>
    
    <button type="submit" style="padding: 10px 20px; font-size: 16px;">Crear Blog</button>
    <a href="<?php echo admin_url('blogs'); ?>" style="margin-left: 10px;">Cancelar</a>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
