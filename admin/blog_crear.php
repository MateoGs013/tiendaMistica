<?php
require_once __DIR__ . '/includes/header.php';

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$oldData = $_SESSION['old_data'] ?? [];

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_data']);
?>
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Crear entrada de blog</h1>
            <p class="text-sm text-slate-300">Redactá nueva sabiduría arcade para la comunidad.</p>
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

    <form method="post" action="/tienda_mistica/admin/actions/blog_crear_acc.php" class="space-y-8">
        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Información básica</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label md:col-span-2">
                    Título*
                    <input type="text" name="titulo" required value="<?php echo htmlspecialchars($oldData['titulo'] ?? ''); ?>" class="arcade-input mt-2" placeholder="Ej: Rutas secretas de las hadas">
                </label>
                <label class="arcade-label">
                    Slug (URL amigable)
                    <input type="text" name="slug" value="<?php echo htmlspecialchars($oldData['slug'] ?? ''); ?>" class="arcade-input mt-2" placeholder="rutas-secretas-hadas">
                    <span class="mt-2 block text-xs text-slate-400">Se genera automáticamente si lo dejás vacío.</span>
                </label>
                <label class="arcade-label">
                    Autor
                    <input type="text" name="autor" value="<?php echo htmlspecialchars($oldData['autor'] ?? ''); ?>" class="arcade-input mt-2" placeholder="Arcadia Team">
                </label>
                <label class="arcade-label">
                    Fecha de publicación
                    <input type="date" name="fecha_publicacion" value="<?php echo $oldData['fecha_publicacion'] ?? date('Y-m-d'); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label md:col-span-2">
                    URL de imagen de portada
                    <input type="text" name="imagen_url" value="<?php echo htmlspecialchars($oldData['imagen_url'] ?? ''); ?>" class="arcade-input mt-2" placeholder="https://">
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Contenido</h2>
            <div class="space-y-6">
                <label class="arcade-label">
                    Descripción corta
                    <textarea name="descripcion_corta" rows="3" class="arcade-textarea mt-2" placeholder="Pequeño resumen que se verá en el listado."><?php echo htmlspecialchars($oldData['descripcion_corta'] ?? ''); ?></textarea>
                </label>
                <label class="arcade-label">
                    Contenido completo
                    <textarea name="contenido" rows="15" class="arcade-textarea mt-2" placeholder="Escribí la aventura completa del artículo."><?php echo htmlspecialchars($oldData['contenido'] ?? ''); ?></textarea>
                </label>
            </div>
        </section>

        <div class="flex flex-wrap items-center gap-4">
            <button type="submit" class="button-arcade">Crear blog</button>
            <a href="<?php echo admin_url('blogs'); ?>" class="button-ghost">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
