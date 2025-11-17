<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Duende.php';

$id = (int)($_GET['id'] ?? 0);
$duende = Duende::find($id);

if (!$duende) {
    ?>
    <div class="panel-glass rounded-3xl border border-arcade-cyan/35 p-8 text-center shadow-neon">
        <h1 class="text-2xl font-semibold text-white">Duende no encontrado</h1>
        <p class="mt-3 text-sm text-slate-300">El duende solicitado no existe o ya fue retirado del catálogo.</p>
        <a href="index.php?sec=duendes" class="button-arcade mt-6 inline-flex">Volver al listado</a>
    </div>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['error'], $_SESSION['success']);

// Pre-llenar con datos del duende si no viene de POST
if (empty($_POST)) {
    $_POST = $duende;
}
?>

<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Editar duende</h1>
            <p class="text-sm text-slate-300">Ajustá los parámetros mágicos de <?php echo htmlspecialchars($duende['nombre']); ?>.</p>
        </div>
        <a href="index.php?sec=duendes" class="button-ghost">← Volver al listado</a>
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

    <form method="post" action="actions/duende_editar_acc.php" enctype="multipart/form-data" class="space-y-8">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($duende['imagen_url'] ?? ''); ?>">

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Información básica</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label md:col-span-2">
                    Nombre*
                    <input type="text" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" class="arcade-input mt-2" autocomplete="off">
                </label>
                <label class="arcade-label">
                    Tipo
                    <input type="text" name="tipo" value="<?php echo htmlspecialchars($_POST['tipo'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Color principal
                    <input type="text" name="color_principal" value="<?php echo htmlspecialchars($_POST['color_principal'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Altura (cm)
                    <input type="number" name="altura_cm" value="<?php echo $_POST['altura_cm'] ?? 30; ?>" min="1" max="500" class="arcade-input mt-2">
                </label>
                <label class="arcade-label md:col-span-2">
                    Personalidad
                    <textarea name="personalidad" rows="3" class="arcade-textarea mt-2"><?php echo htmlspecialchars($_POST['personalidad'] ?? ''); ?></textarea>
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Características mágicas</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <label class="arcade-label">
                    Rareza
                    <select name="id_rareza" class="arcade-select mt-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo (($_POST['id_rareza'] ?? 1) == $i) ? 'selected' : ''; ?>>
                                <?php echo $i; ?> - <?php echo ['','Común','Poco Común','Raro','Épico','Legendario'][$i]; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </label>
                <label class="arcade-label">
                    Elemento
                    <select name="id_elemento" class="arcade-select mt-2">
                        <?php $elementos = ['','Fuego','Agua','Tierra','Aire','Luz','Oscuridad']; ?>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo (($_POST['id_elemento'] ?? 1) == $i) ? 'selected' : ''; ?>>
                                <?php echo $i; ?> - <?php echo $elementos[$i]; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </label>
                <label class="arcade-label">
                    Material base
                    <select name="id_material" class="arcade-select mt-2">
                        <?php $materiales = ['','Arcilla','Madera','Piedra','Metal','Cristal']; ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo (($_POST['id_material'] ?? 1) == $i) ? 'selected' : ''; ?>>
                                <?php echo $i; ?> - <?php echo $materiales[$i]; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </label>
                <label class="arcade-label md:col-span-3">
                    Efecto mágico
                    <textarea name="efecto_magico" rows="3" class="arcade-textarea mt-2"><?php echo htmlspecialchars($_POST['efecto_magico'] ?? ''); ?></textarea>
                </label>
                <label class="arcade-label">
                    Nivel de maldad (1-10)
                    <input type="number" name="nivel_maldad" value="<?php echo $_POST['nivel_maldad'] ?? 1; ?>" min="1" max="10" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Nivel de suerte (1-10)
                    <input type="number" name="nivel_suerte" value="<?php echo $_POST['nivel_suerte'] ?? 5; ?>" min="1" max="10" class="arcade-input mt-2">
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Detalles comerciales</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label">
                    Precio en oro
                    <input type="number" step="0.01" name="precio_en_oro" value="<?php echo $_POST['precio_en_oro'] ?? 0; ?>" min="0" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Popularidad (0-100)
                    <input type="number" name="popularidad" value="<?php echo $_POST['popularidad'] ?? 50; ?>" min="0" max="100" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Fecha de creación
                    <input type="date" name="fecha_creacion" value="<?php echo $_POST['fecha_creacion'] ?? date('Y-m-d'); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label flex items-center gap-3 text-xs uppercase tracking-[0.2em]">
                    <input type="checkbox" name="disponible" value="1" class="h-5 w-5 rounded border border-arcade-cyan/40 bg-arcade-panel/70 text-arcade-cyan focus:ring-arcade-magenta/60" <?php echo ($_POST['disponible'] ?? 1) ? 'checked' : ''; ?>>
                    Disponible para la venta
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Información adicional</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label md:col-span-2">
                    Origen mitológico
                    <input type="text" name="origen_mitologico" value="<?php echo htmlspecialchars($_POST['origen_mitologico'] ?? ''); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label md:col-span-2">
                    Recomendado para
                    <textarea name="recomendado_para" rows="3" class="arcade-textarea mt-2"><?php echo htmlspecialchars($_POST['recomendado_para'] ?? ''); ?></textarea>
                </label>
                <label class="arcade-label md:col-span-2">
                    Advertencias
                    <textarea name="advertencias" rows="3" class="arcade-textarea mt-2"><?php echo htmlspecialchars($_POST['advertencias'] ?? ''); ?></textarea>
                </label>
                <?php if (!empty($duende['imagen_url'])): ?>
                    <?php
                        $imagenActual = $duende['imagen_url'];
                        $srcImagen = preg_match('/^https?:\/\//i', $imagenActual)
                            ? $imagenActual
                            : '/' . ltrim($imagenActual, '/');
                    ?>
                    <div class="md:col-span-2">
                        <p class="arcade-label">Imagen actual</p>
                        <div class="mt-3 inline-flex flex-col items-center gap-3 rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/70 p-4">
                            <img src="<?php echo htmlspecialchars($srcImagen); ?>" alt="Imagen actual" class="max-h-48 rounded-lg border border-arcade-magenta/30 object-contain">
                            <p class="text-xs text-slate-400">Se mantendrá salvo que subas una nueva imagen.</p>
                        </div>
                    </div>
                <?php endif; ?>
                <label class="arcade-label">
                    Nueva imagen (JPG, PNG, GIF o WEBP)
                    <input type="file" name="imagen" accept="image/*" class="mt-2 text-sm text-slate-300">
                </label>
                <label class="arcade-label">
                    URL de imagen
                    <input type="text" name="imagen_url" value="<?php echo htmlspecialchars($_POST['imagen_url'] ?? ''); ?>" class="arcade-input mt-2" placeholder="https://">
                </label>
                <label class="arcade-label md:col-span-2">
                    Descripción
                    <textarea name="descripcion" rows="5" class="arcade-textarea mt-2"><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                </label>
            </div>
        </section>

        <div class="flex flex-wrap items-center gap-4">
            <button type="submit" class="button-arcade">Guardar cambios</button>
            <a href="index.php?sec=duendes" class="button-ghost">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
