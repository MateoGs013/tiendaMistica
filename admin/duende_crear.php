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
        <h1 class="admin-section-title">Crear Duende</h1>
        <p class="admin-section-subtitle">Configurá todos los parámetros del duende antes de abrir el portal de venta</p>
    </div>
    <a href="<?php echo admin_url('duendes'); ?>" class="btn-arc btn-arc--secondary">
        <span>← Volver</span>
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

<!-- Form -->
<form method="post" action="/tienda_mistica/admin/actions/duende_crear_acc.php" enctype="multipart/form-data" class="admin-form">
    <!-- Basic Info -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Información Básica</h2>
        <div class="admin-form-grid">
            <div class="admin-form-grid--full">
                <label for="nombre" class="form-label">Nombre*</label>
                <input type="text" name="nombre" id="nombre" required value="<?php echo htmlspecialchars($oldData['nombre'] ?? ''); ?>" class="form-input" placeholder="Ej: Hexa, guardián del portal">
            </div>
            
            <div class="form-group">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" name="tipo" id="tipo" value="<?php echo htmlspecialchars($oldData['tipo'] ?? ''); ?>" class="form-input" placeholder="Guardián, artesano, etc.">
            </div>
            
            <div class="form-group">
                <label for="color_principal" class="form-label">Color Principal</label>
                <input type="text" name="color_principal" id="color_principal" value="<?php echo htmlspecialchars($oldData['color_principal'] ?? ''); ?>" class="form-input" placeholder="#8B5CF6">
            </div>
            
            <div class="form-group">
                <label for="altura_cm" class="form-label">Altura (cm)</label>
                <input type="number" name="altura_cm" id="altura_cm" value="<?php echo $oldData['altura_cm'] ?? 30; ?>" min="1" max="500" class="form-input">
            </div>
            
            <div class="admin-form-grid--full">
                <label for="personalidad" class="form-label">Personalidad</label>
                <textarea name="personalidad" id="personalidad" rows="3" class="form-input form-textarea" placeholder="Describe los rasgos clave del duende"><?php echo htmlspecialchars($oldData['personalidad'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>

    <!-- Magic Features -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Características Mágicas</h2>
        <div class="admin-form-grid">
            <div class="form-group">
                <label for="id_rareza" class="form-label">Rareza</label>
                <select name="id_rareza" id="id_rareza" class="form-input">
                    <option value="1" <?php echo (($oldData['id_rareza'] ?? '') == 1) ? 'selected' : ''; ?>>1 - Común</option>
                    <option value="2" <?php echo (($oldData['id_rareza'] ?? '') == 2) ? 'selected' : ''; ?>>2 - Poco Común</option>
                    <option value="3" <?php echo (($oldData['id_rareza'] ?? '') == 3) ? 'selected' : ''; ?>>3 - Raro</option>
                    <option value="4" <?php echo (($oldData['id_rareza'] ?? '') == 4) ? 'selected' : ''; ?>>4 - Épico</option>
                    <option value="5" <?php echo (($oldData['id_rareza'] ?? '') == 5) ? 'selected' : ''; ?>>5 - Legendario</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="id_elemento" class="form-label">Elemento</label>
                <select name="id_elemento" id="id_elemento" class="form-input">
                    <option value="1" <?php echo (($oldData['id_elemento'] ?? '') == 1) ? 'selected' : ''; ?>>1 - Fuego</option>
                    <option value="2" <?php echo (($oldData['id_elemento'] ?? '') == 2) ? 'selected' : ''; ?>>2 - Agua</option>
                    <option value="3" <?php echo (($oldData['id_elemento'] ?? '') == 3) ? 'selected' : ''; ?>>3 - Tierra</option>
                    <option value="4" <?php echo (($oldData['id_elemento'] ?? '') == 4) ? 'selected' : ''; ?>>4 - Aire</option>
                    <option value="5" <?php echo (($oldData['id_elemento'] ?? '') == 5) ? 'selected' : ''; ?>>5 - Luz</option>
                    <option value="6" <?php echo (($oldData['id_elemento'] ?? '') == 6) ? 'selected' : ''; ?>>6 - Oscuridad</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="id_material" class="form-label">Material Base</label>
                <select name="id_material" id="id_material" class="form-input">
                    <option value="1" <?php echo (($oldData['id_material'] ?? '') == 1) ? 'selected' : ''; ?>>1 - Arcilla</option>
                    <option value="2" <?php echo (($oldData['id_material'] ?? '') == 2) ? 'selected' : ''; ?>>2 - Madera</option>
                    <option value="3" <?php echo (($oldData['id_material'] ?? '') == 3) ? 'selected' : ''; ?>>3 - Piedra</option>
                    <option value="4" <?php echo (($oldData['id_material'] ?? '') == 4) ? 'selected' : ''; ?>>4 - Metal</option>
                    <option value="5" <?php echo (($oldData['id_material'] ?? '') == 5) ? 'selected' : ''; ?>>5 - Cristal</option>
                </select>
            </div>
            
            <div class="admin-form-grid--full">
                <label for="efecto_magico" class="form-label">Efecto Mágico</label>
                <textarea name="efecto_magico" id="efecto_magico" rows="3" class="form-input form-textarea" placeholder="Describe el efecto especial que otorga"><?php echo htmlspecialchars($oldData['efecto_magico'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="nivel_maldad" class="form-label">Nivel de Maldad (1-10)</label>
                <input type="number" name="nivel_maldad" id="nivel_maldad" value="<?php echo $oldData['nivel_maldad'] ?? 1; ?>" min="1" max="10" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="nivel_suerte" class="form-label">Nivel de Suerte (1-10)</label>
                <input type="number" name="nivel_suerte" id="nivel_suerte" value="<?php echo $oldData['nivel_suerte'] ?? 5; ?>" min="1" max="10" class="form-input">
            </div>
        </div>
    </div>

    <!-- Commercial Details -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Detalles Comerciales</h2>
        <div class="admin-form-grid">
            <div class="form-group">
                <label for="precio_en_oro" class="form-label">Precio en Oro</label>
                <input type="number" step="0.01" name="precio_en_oro" id="precio_en_oro" value="<?php echo $oldData['precio_en_oro'] ?? 0; ?>" min="0" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="popularidad" class="form-label">Popularidad (0-100)</label>
                <input type="number" name="popularidad" id="popularidad" value="<?php echo $oldData['popularidad'] ?? 50; ?>" min="0" max="100" class="form-input">
            </div>
            
            <div class="form-group">
                <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
                <input type="date" name="fecha_creacion" id="fecha_creacion" value="<?php echo $oldData['fecha_creacion'] ?? date('Y-m-d'); ?>" class="form-input">
            </div>
            
            <div class="form-group">
                <label class="admin-checkbox">
                    <input type="checkbox" name="disponible" value="1" <?php echo isset($oldData['disponible']) || !$oldData ? 'checked' : ''; ?>>
                    <span>Disponible para la venta</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="admin-form-section">
        <h2 class="admin-form-section__title">Información Adicional</h2>
        <div class="admin-form-grid">
            <div class="admin-form-grid--full">
                <label for="origen_mitologico" class="form-label">Origen Mitológico</label>
                <input type="text" name="origen_mitologico" id="origen_mitologico" value="<?php echo htmlspecialchars($oldData['origen_mitologico'] ?? ''); ?>" class="form-input" placeholder="Bosque de Lumnos, Cráter Ix...">
            </div>
            
            <div class="admin-form-grid--full">
                <label for="recomendado_para" class="form-label">Recomendado Para</label>
                <textarea name="recomendado_para" id="recomendado_para" rows="3" class="form-input form-textarea" placeholder="Coleccionistas, guardianes de portales, etc."><?php echo htmlspecialchars($oldData['recomendado_para'] ?? ''); ?></textarea>
            </div>
            
            <div class="admin-form-grid--full">
                <label for="advertencias" class="form-label">Advertencias</label>
                <textarea name="advertencias" id="advertencias" rows="3" class="form-input form-textarea" placeholder="Manipular con guantes anti-maldad"><?php echo htmlspecialchars($oldData['advertencias'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="imagen" class="form-label">Imagen (JPG, PNG, GIF o WEBP)</label>
                <input type="file" name="imagen" id="imagen" accept="image/*" class="admin-file-input">
            </div>
            
            <div class="form-group">
                <label for="imagen_url" class="form-label">URL de Imagen</label>
                <input type="text" name="imagen_url" id="imagen_url" value="<?php echo htmlspecialchars($oldData['imagen_url'] ?? ''); ?>" class="form-input" placeholder="https://">
            </div>
            
            <div class="admin-form-grid--full">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="5" class="form-input form-textarea" placeholder="Relatá la historia completa del duende"><?php echo htmlspecialchars($oldData['descripcion'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="admin-form-actions">
        <button type="submit" class="btn-arc btn-arc--primary btn-arc--lg">
            <span>Crear Duende</span>
        </button>
        <a href="<?php echo admin_url('duendes'); ?>" class="btn-arc btn-arc--secondary btn-arc--lg">
            <span>Cancelar</span>
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

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


