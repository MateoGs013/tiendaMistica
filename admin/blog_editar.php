<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Blog.php';

$id = (int)($_GET['id'] ?? 0);
$blog = Blog::find($id);

if (!$blog) {
    echo "<p>Blog no encontrado</p>";
    echo "<a href='" . admin_url('blogs') . "'>Volver al listado</a>";
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
<h1>Editar Blog: <?php echo htmlspecialchars($blog['titulo']); ?></h1>
<?php if ($success): ?>
    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="/tienda_mistica/admin/actions/blog_editar_acc.php" style="max-width: 900px;">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <fieldset>
        <legend>Información Básica</legend>
        
        <label>Título: *<br>
            <input type="text" name="titulo" required value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Slug (URL amigable): *<br>
            <input type="text" name="slug" required value="<?php echo htmlspecialchars($_POST['slug'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Autor:<br>
            <input type="text" name="autor" value="<?php echo htmlspecialchars($_POST['autor'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Fecha de Publicación:<br>
            <input type="date" name="fecha_publicacion" value="<?php echo $_POST['fecha_publicacion'] ?? date('Y-m-d'); ?>">
        </label><br><br>
        
        <label>URL de Imagen:<br>
            <input type="text" name="imagen_url" value="<?php echo htmlspecialchars($_POST['imagen_url'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
    </fieldset>
    
    <fieldset>
        <legend>Contenido</legend>
        
        <label>Descripción Corta:<br>
            <textarea name="descripcion_corta" rows="3" style="width: 100%;"><?php echo htmlspecialchars($_POST['descripcion_corta'] ?? ''); ?></textarea>
            <small>Resumen breve para el listado</small>
        </label><br><br>
        
        <label>Contenido Completo:<br>
            <textarea name="contenido" rows="15" style="width: 100%;"><?php echo htmlspecialchars($_POST['contenido'] ?? ''); ?></textarea>
        </label><br><br>
    </fieldset>
    
    <button type="submit" style="padding: 10px 20px; font-size: 16px;">Guardar Cambios</button>
    <a href="<?php echo admin_url('blogs'); ?>" style="margin-left: 10px;">Cancelar</a>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
