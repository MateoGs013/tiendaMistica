<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../classes/Duende.php';

$id = (int)($_GET['id'] ?? 0);
$duende = Duende::find($id);

if (!$duende) {
    echo "<p>Duende no encontrado</p>";
    echo "<a href='" . admin_url('duendes') . "'>Volver al listado</a>";
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
<h1>Editar Duende: <?php echo htmlspecialchars($duende['nombre']); ?></h1>
<?php if ($success): ?>
    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="/tienda_mistica/admin/actions/duende_editar_acc.php" style="max-width: 800px;">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <fieldset>
        <legend>Información Básica</legend>
        
        <label>Nombre: *<br>
            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Tipo:<br>
            <input type="text" name="tipo" value="<?php echo htmlspecialchars($_POST['tipo'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Color Principal:<br>
            <input type="text" name="color_principal" value="<?php echo htmlspecialchars($_POST['color_principal'] ?? ''); ?>">
        </label><br><br>
        
        <label>Altura (cm):<br>
            <input type="number" name="altura_cm" value="<?php echo $_POST['altura_cm'] ?? 30; ?>" min="1" max="500">
        </label><br><br>
        
        <label>Personalidad:<br>
            <textarea name="personalidad" rows="3" style="width: 100%;"><?php echo htmlspecialchars($_POST['personalidad'] ?? ''); ?></textarea>
        </label><br><br>
    </fieldset>
    
    <fieldset>
        <legend>Características Mágicas</legend>
        
        <label>ID Rareza:<br>
            <select name="id_rareza">
                <?php for($i=1; $i<=5; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($_POST['id_rareza'] ?? 1) == $i ? 'selected' : ''; ?>>
                        <?php echo $i; ?> - <?php echo ['','Común','Poco Común','Raro','Épico','Legendario'][$i]; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </label><br><br>
        
        <label>ID Elemento:<br>
            <select name="id_elemento">
                <?php 
                $elementos = ['','Fuego','Agua','Tierra','Aire','Luz','Oscuridad'];
                for($i=1; $i<=6; $i++): 
                ?>
                    <option value="<?php echo $i; ?>" <?php echo ($_POST['id_elemento'] ?? 1) == $i ? 'selected' : ''; ?>>
                        <?php echo $i; ?> - <?php echo $elementos[$i]; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </label><br><br>
        
        <label>ID Material:<br>
            <select name="id_material">
                <?php 
                $materiales = ['','Arcilla','Madera','Piedra','Metal','Cristal'];
                for($i=1; $i<=5; $i++): 
                ?>
                    <option value="<?php echo $i; ?>" <?php echo ($_POST['id_material'] ?? 1) == $i ? 'selected' : ''; ?>>
                        <?php echo $i; ?> - <?php echo $materiales[$i]; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </label><br><br>
        
        <label>Efecto Mágico:<br>
            <textarea name="efecto_magico" rows="3" style="width: 100%;"><?php echo htmlspecialchars($_POST['efecto_magico'] ?? ''); ?></textarea>
        </label><br><br>
        
        <label>Nivel de Maldad (1-10):<br>
            <input type="number" name="nivel_maldad" value="<?php echo $_POST['nivel_maldad'] ?? 1; ?>" min="1" max="10">
        </label><br><br>
        
        <label>Nivel de Suerte (1-10):<br>
            <input type="number" name="nivel_suerte" value="<?php echo $_POST['nivel_suerte'] ?? 5; ?>" min="1" max="10">
        </label><br><br>
    </fieldset>
    
    <fieldset>
        <legend>Detalles Comerciales</legend>
        
        <label>Precio en Oro:<br>
            <input type="number" step="0.01" name="precio_en_oro" value="<?php echo $_POST['precio_en_oro'] ?? 0; ?>" min="0">
        </label><br><br>
        
        <label>Popularidad (0-100):<br>
            <input type="number" name="popularidad" value="<?php echo $_POST['popularidad'] ?? 50; ?>" min="0" max="100">
        </label><br><br>
        
        <label>
            <input type="checkbox" name="disponible" value="1" <?php echo ($_POST['disponible'] ?? 1) ? 'checked' : ''; ?>>
            Disponible para la venta
        </label><br><br>
        
        <label>Fecha de Creación:<br>
            <input type="date" name="fecha_creacion" value="<?php echo $_POST['fecha_creacion'] ?? date('Y-m-d'); ?>">
        </label><br><br>
    </fieldset>
    
    <fieldset>
        <legend>Información Adicional</legend>
        
        <label>Origen Mitológico:<br>
            <input type="text" name="origen_mitologico" value="<?php echo htmlspecialchars($_POST['origen_mitologico'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Recomendado Para:<br>
            <textarea name="recomendado_para" rows="3" style="width: 100%;"><?php echo htmlspecialchars($_POST['recomendado_para'] ?? ''); ?></textarea>
        </label><br><br>
        
        <label>Advertencias:<br>
            <textarea name="advertencias" rows="3" style="width: 100%;"><?php echo htmlspecialchars($_POST['advertencias'] ?? ''); ?></textarea>
        </label><br><br>
        
        <label>URL de Imagen:<br>
            <input type="text" name="imagen_url" value="<?php echo htmlspecialchars($_POST['imagen_url'] ?? ''); ?>" style="width: 100%;">
        </label><br><br>
        
        <label>Descripción:<br>
            <textarea name="descripcion" rows="5" style="width: 100%;"><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
        </label><br><br>
    </fieldset>
    
    <button type="submit" style="padding: 10px 20px; font-size: 16px;">Guardar Cambios</button>
    <a href="duendes.php" style="margin-left: 10px;">Cancelar</a>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
