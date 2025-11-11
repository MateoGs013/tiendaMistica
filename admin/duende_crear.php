<?php
require_once __DIR__ . '/includes/header.php';

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$oldData = $_SESSION['old_data'] ?? [];

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_data']);
?>
<h1>Crear Nuevo Duende</h1>
<?php if ($success): ?>
    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="/tienda_mistica/admin/actions/duende_crear_acc.php" enctype="multipart/form-data" style="max-width: 800px;">
    <fieldset>
        <legend>Información Básica</legend>
        
        <label>Nombre: *<br>
            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($oldData['nombre'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Tipo:<br>
            <input type="text" name="tipo" value="<?php echo htmlspecialchars($oldData['tipo'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Color Principal:<br>
            <input type="text" name="color_principal" value="<?php echo htmlspecialchars($oldData['color_principal'] ?? ''); ?>">
        </label><br><br>
        
        <label>Altura (cm):<br>
            <input type="number" name="altura_cm" value="<?php echo $oldData['altura_cm'] ?? 30; ?>" min="1" max="500">
        </label><br><br>
        
        <label>Personalidad:<br>
            <textarea name="personalidad" rows="3" style="width: 100%;"><?php echo htmlspecialchars($oldData['personalidad'] ?? ''); ?></textarea>
        </label><br><br>
    </fieldset>
    
    <fieldset>
        <legend>Características Mágicas</legend>
        
        <label>ID Rareza:<br>
            <select name="id_rareza">
                <option value="1">1 - Común</option>
                <option value="2">2 - Poco Común</option>
                <option value="3">3 - Raro</option>
                <option value="4">4 - Épico</option>
                <option value="5">5 - Legendario</option>
            </select>
        </label><br><br>
        
        <label>ID Elemento:<br>
            <select name="id_elemento">
                <option value="1">1 - Fuego</option>
                <option value="2">2 - Agua</option>
                <option value="3">3 - Tierra</option>
                <option value="4">4 - Aire</option>
                <option value="5">5 - Luz</option>
                <option value="6">6 - Oscuridad</option>
            </select>
        </label><br><br>
        
        <label>ID Material:<br>
            <select name="id_material">
                <option value="1">1 - Arcilla</option>
                <option value="2">2 - Madera</option>
                <option value="3">3 - Piedra</option>
                <option value="4">4 - Metal</option>
                <option value="5">5 - Cristal</option>
            </select>
        </label><br><br>
        
        <label>Efecto Mágico:<br>
            <textarea name="efecto_magico" rows="3" style="width: 100%;"><?php echo htmlspecialchars($oldData['efecto_magico'] ?? ''); ?></textarea>
        </label><br><br>
        
        <label>Nivel de Maldad (1-10):<br>
            <input type="number" name="nivel_maldad" value="<?php echo $oldData['nivel_maldad'] ?? 1; ?>" min="1" max="10">
        </label><br><br>
        
        <label>Nivel de Suerte (1-10):<br>
            <input type="number" name="nivel_suerte" value="<?php echo $oldData['nivel_suerte'] ?? 5; ?>" min="1" max="10">
        </label><br><br>
    </fieldset>
    
    <fieldset>
        <legend>Detalles Comerciales</legend>
        
        <label>Precio en Oro:<br>
            <input type="number" step="0.01" name="precio_en_oro" value="<?php echo $oldData['precio_en_oro'] ?? 0; ?>" min="0">
        </label><br><br>
        
        <label>Popularidad (0-100):<br>
            <input type="number" name="popularidad" value="<?php echo $oldData['popularidad'] ?? 50; ?>" min="0" max="100">
        </label><br><br>
        
        <label>
            <input type="checkbox" name="disponible" value="1" <?php echo isset($oldData['disponible']) || !$oldData ? 'checked' : ''; ?>>
            Disponible para la venta
        </label><br><br>
        
        <label>Fecha de Creación:<br>
            <input type="date" name="fecha_creacion" value="<?php echo $oldData['fecha_creacion'] ?? date('Y-m-d'); ?>">
        </label><br><br>
    </fieldset>
    
    <fieldset>
        <legend>Información Adicional</legend>
        
        <label>Origen Mitológico:<br>
            <input type="text" name="origen_mitologico" value="<?php echo htmlspecialchars($oldData['origen_mitologico'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Recomendado Para:<br>
            <textarea name="recomendado_para" rows="3" style="width: 100%;"><?php echo htmlspecialchars($oldData['recomendado_para'] ?? ''); ?></textarea>
        </label><br><br>
        
        <label>Advertencias:<br>
            <textarea name="advertencias" rows="3" style="width: 100%;"><?php echo htmlspecialchars($oldData['advertencias'] ?? ''); ?></textarea>
        </label><br><br>
        
        <label>Imagen (JPG, PNG, GIF o WEBP):<br>
            <input type="file" name="imagen" accept="image/*">
        </label><br><br>

        <label>URL de Imagen:<br>
            <input type="text" name="imagen_url" value="<?php echo htmlspecialchars($oldData['imagen_url'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Descripción:<br>
            <textarea name="descripcion" rows="5" style="width: 100%;"><?php echo htmlspecialchars($oldData['descripcion'] ?? ''); ?></textarea>
        </label><br><br>
    </fieldset>
    
    <button type="submit" style="padding: 10px 20px; font-size: 16px;">Crear Duende</button>
    <a href="duendes.php" style="margin-left: 10px;">Cancelar</a>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


