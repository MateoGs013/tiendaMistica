<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Blog.php';

$id = (int)($_GET['id'] ?? 0);
$blog = Blog::find($id);

if (!$blog) {
    ?>
    <div class="panel-glass rounded-3xl border border-arcade-cyan/35 p-8 text-center shadow-neon">
        <h1 class="text-2xl font-semibold text-white">Blog no encontrado</h1>
        <p class="mt-3 text-sm text-slate-300">La entrada seleccionada no existe o ya fue archivada.</p>
        <a href="<?php echo admin_url('blogs'); ?>" class="button-arcade mt-6 inline-flex">Volver al listado</a>
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
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Editar entrada</h1>
            <p class="text-sm text-slate-300">Actualizá el contenido de <?php echo htmlspecialchars($blog['titulo']); ?>.</p>
        </div>
        <a href="<?php echo admin_url('blogs'); ?>" class="button-ghost">← Volver al listado</a>
    </div>

    <?php if ($success): ?>
        <div class="alert-arcade alert-success">
            <span class="status-dot"></span>
            <span><?php echo htmlspecialchars($success); ?></span>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert-arcade alert-error">
            <span class="status-dot offline"></span>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <form method="post" action="/tienda_mistica/admin/actions/blog_editar_acc.php" class="space-y-8">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Información básica</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label md:col-span-2">
                    Título*
                    <input type="text" name="titulo" required value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Slug (URL amigable)
                    <input type="text" name="slug" required value="<?php echo htmlspecialchars($_POST['slug'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Autor
                    <input type="text" name="autor" value="<?php echo htmlspecialchars($_POST['autor'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Fecha de publicación
                    <input type="date" name="fecha_publicacion" value="<?php echo $_POST['fecha_publicacion'] ?? date('Y-m-d'); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label md:col-span-2">
                    URL de imagen de portada
                    <input type="text" name="imagen_url" value="<?php echo htmlspecialchars($_POST['imagen_url'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Contenido</h2>
            <div class="space-y-6">
                <label class="arcade-label">
                    Descripción corta
                    <textarea name="descripcion_corta" rows="3" class="arcade-textarea mt-2"><?php echo htmlspecialchars($_POST['descripcion_corta'] ?? ''); ?></textarea>
                    <span class="mt-1 block text-xs text-slate-400">Resumen breve para el listado.</span>
                </label>
                <label class="arcade-label">
                    Contenido completo
                    <textarea name="contenido" rows="15" class="arcade-textarea mt-2"><?php echo htmlspecialchars($_POST['contenido'] ?? ''); ?></textarea>
                </label>
            </div>
        </section>

        <div class="flex flex-wrap items-center gap-4">
            <button type="submit" class="button-arcade">Guardar cambios</button>
            <a href="<?php echo admin_url('blogs'); ?>" class="button-ghost">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
