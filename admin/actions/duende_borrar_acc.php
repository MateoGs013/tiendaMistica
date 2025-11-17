<?php
// admin/actions/duende_borrar_acc.php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../classes/Duende.php';
require_once __DIR__ . '/../../classes/Imagen.php';
require_once __DIR__ . '/../includes/url.php';
require_admin();

if (!empty($_GET['id']) && isset($_GET['confirmar'])) {
    $id = (int)$_GET['id'];
    $duende = Duende::find($id);
    if ($duende && Duende::delete($id)) {
        Imagen::borrar($duende['imagen_url'] ?? null);
        header('Location: ' . '../index.php?sec=duendes&msg=eliminado');
    } else {
        header('Location: ' . '../index.php?sec=duendes&error=no_eliminar');
    }
    exit;
}

header('Location: ' . '../index.php?sec=duendes');
exit;
