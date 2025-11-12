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
            <h1 class="text-3xl font-semibold text-white">Crear nuevo duende</h1>
            <p class="text-sm text-slate-300">Configurá todos los parámetros del duende antes de abrir el portal de venta.</p>
        </div>
        <a href="<?php echo admin_url('duendes'); ?>" class="button-ghost">← Volver al listado</a>
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

    <form method="post" action="/tienda_mistica/admin/actions/duende_crear_acc.php" enctype="multipart/form-data" class="space-y-8">
        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Información básica</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label md:col-span-2">
                    Nombre*
                    <input type="text" name="nombre" required value="<?php echo htmlspecialchars($oldData['nombre'] ?? ''); ?>" class="arcade-input mt-2" placeholder="Ej: Hexa, guardián del portal" autocomplete="off">
                </label>
                <label class="arcade-label">
                    Tipo
                    <input type="text" name="tipo" value="<?php echo htmlspecialchars($oldData['tipo'] ?? ''); ?>" class="arcade-input mt-2" placeholder="Guardián, artesano, etc.">
                </label>
                <label class="arcade-label">
                    Color principal
                    <input type="text" name="color_principal" value="<?php echo htmlspecialchars($oldData['color_principal'] ?? ''); ?>" class="arcade-input mt-2" placeholder="#8B5CF6">
                </label>
                <label class="arcade-label">
                    Altura (cm)
                    <input type="number" name="altura_cm" value="<?php echo $oldData['altura_cm'] ?? 30; ?>" min="1" max="500" class="arcade-input mt-2">
                </label>
                <label class="arcade-label md:col-span-2">
                    Personalidad
                    <textarea name="personalidad" rows="3" class="arcade-textarea mt-2" placeholder="Describe los rasgos clave del duende."><?php echo htmlspecialchars($oldData['personalidad'] ?? ''); ?></textarea>
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Características mágicas</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <label class="arcade-label">
                    Rareza
                    <select name="id_rareza" class="arcade-select mt-2">
                        <option value="1" <?php echo (($oldData['id_rareza'] ?? '') == 1) ? 'selected' : ''; ?>>1 - Común</option>
                        <option value="2" <?php echo (($oldData['id_rareza'] ?? '') == 2) ? 'selected' : ''; ?>>2 - Poco Común</option>
                        <option value="3" <?php echo (($oldData['id_rareza'] ?? '') == 3) ? 'selected' : ''; ?>>3 - Raro</option>
                        <option value="4" <?php echo (($oldData['id_rareza'] ?? '') == 4) ? 'selected' : ''; ?>>4 - Épico</option>
                        <option value="5" <?php echo (($oldData['id_rareza'] ?? '') == 5) ? 'selected' : ''; ?>>5 - Legendario</option>
                    </select>
                </label>
                <label class="arcade-label">
                    Elemento
                    <select name="id_elemento" class="arcade-select mt-2">
                        <option value="1" <?php echo (($oldData['id_elemento'] ?? '') == 1) ? 'selected' : ''; ?>>1 - Fuego</option>
                        <option value="2" <?php echo (($oldData['id_elemento'] ?? '') == 2) ? 'selected' : ''; ?>>2 - Agua</option>
                        <option value="3" <?php echo (($oldData['id_elemento'] ?? '') == 3) ? 'selected' : ''; ?>>3 - Tierra</option>
                        <option value="4" <?php echo (($oldData['id_elemento'] ?? '') == 4) ? 'selected' : ''; ?>>4 - Aire</option>
                        <option value="5" <?php echo (($oldData['id_elemento'] ?? '') == 5) ? 'selected' : ''; ?>>5 - Luz</option>
                        <option value="6" <?php echo (($oldData['id_elemento'] ?? '') == 6) ? 'selected' : ''; ?>>6 - Oscuridad</option>
                    </select>
                </label>
                <label class="arcade-label">
                    Material base
                    <select name="id_material" class="arcade-select mt-2">
                        <option value="1" <?php echo (($oldData['id_material'] ?? '') == 1) ? 'selected' : ''; ?>>1 - Arcilla</option>
                        <option value="2" <?php echo (($oldData['id_material'] ?? '') == 2) ? 'selected' : ''; ?>>2 - Madera</option>
                        <option value="3" <?php echo (($oldData['id_material'] ?? '') == 3) ? 'selected' : ''; ?>>3 - Piedra</option>
                        <option value="4" <?php echo (($oldData['id_material'] ?? '') == 4) ? 'selected' : ''; ?>>4 - Metal</option>
                        <option value="5" <?php echo (($oldData['id_material'] ?? '') == 5) ? 'selected' : ''; ?>>5 - Cristal</option>
                    </select>
                </label>
                <label class="arcade-label md:col-span-3">
                    Efecto mágico
                    <textarea name="efecto_magico" rows="3" class="arcade-textarea mt-2" placeholder="Describe el efecto especial que otorga."><?php echo htmlspecialchars($oldData['efecto_magico'] ?? ''); ?></textarea>
                </label>
                <label class="arcade-label">
                    Nivel de maldad (1-10)
                    <input type="number" name="nivel_maldad" value="<?php echo $oldData['nivel_maldad'] ?? 1; ?>" min="1" max="10" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Nivel de suerte (1-10)
                    <input type="number" name="nivel_suerte" value="<?php echo $oldData['nivel_suerte'] ?? 5; ?>" min="1" max="10" class="arcade-input mt-2">
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Detalles comerciales</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label">
                    Precio en oro
                    <input type="number" step="0.01" name="precio_en_oro" value="<?php echo $oldData['precio_en_oro'] ?? 0; ?>" min="0" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Popularidad (0-100)
                    <input type="number" name="popularidad" value="<?php echo $oldData['popularidad'] ?? 50; ?>" min="0" max="100" class="arcade-input mt-2">
                </label>
                <label class="arcade-label">
                    Fecha de creación
                    <input type="date" name="fecha_creacion" value="<?php echo $oldData['fecha_creacion'] ?? date('Y-m-d'); ?>" class="arcade-input mt-2">
                </label>
                <label class="arcade-label flex items-center gap-3 text-xs uppercase tracking-[0.2em]">
                    <input type="checkbox" name="disponible" value="1" class="h-5 w-5 rounded border border-arcade-cyan/40 bg-arcade-panel/70 text-arcade-cyan focus:ring-arcade-magenta/60" <?php echo isset($oldData['disponible']) || !$oldData ? 'checked' : ''; ?>>
                    Disponible para la venta
                </label>
            </div>
        </section>

        <section class="panel-glass rounded-3xl border border-arcade-cyan/30 p-8 shadow-neon">
            <h2 class="fieldset-title">Información adicional</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <label class="arcade-label md:col-span-2">
                    Origen mitológico
                    <input type="text" name="origen_mitologico" value="<?php echo htmlspecialchars($oldData['origen_mitologico'] ?? ''); ?>" class="arcade-input mt-2" placeholder="Bosque de Lumnos, Cráter Ix...">
                </label>
                <label class="arcade-label md:col-span-2">
                    Recomendado para
                    <textarea name="recomendado_para" rows="3" class="arcade-textarea mt-2" placeholder="Coleccionistas, guardianes de portales, etc."><?php echo htmlspecialchars($oldData['recomendado_para'] ?? ''); ?></textarea>
                </label>
                <label class="arcade-label md:col-span-2">
                    Advertencias
                    <textarea name="advertencias" rows="3" class="arcade-textarea mt-2" placeholder="Manipular con guantes anti-maldad."><?php echo htmlspecialchars($oldData['advertencias'] ?? ''); ?></textarea>
                </label>
                <label class="arcade-label">
                    Imagen (JPG, PNG, GIF o WEBP)
                    <input type="file" name="imagen" accept="image/*" class="mt-2 text-sm text-slate-300">
                </label>
                <label class="arcade-label">
                    URL de imagen
                    <input type="text" name="imagen_url" value="<?php echo htmlspecialchars($oldData['imagen_url'] ?? ''); ?>" class="arcade-input mt-2" placeholder="https://">
                </label>
                <label class="arcade-label md:col-span-2">
                    Descripción
                    <textarea name="descripcion" rows="5" class="arcade-textarea mt-2" placeholder="Relatá la historia completa del duende."><?php echo htmlspecialchars($oldData['descripcion'] ?? ''); ?></textarea>
                </label>
            </div>
        </section>

        <div class="flex flex-wrap items-center gap-4">
            <button type="submit" class="button-arcade">Crear duende</button>
            <a href="<?php echo admin_url('duendes'); ?>" class="button-ghost">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


