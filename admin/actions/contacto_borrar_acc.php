<?php
// admin/actions/contacto_borrar_acc.php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../classes/Contacto.php';
require_once __DIR__ . '/../includes/url.php';
require_admin();

if (!empty($_GET['id']) && isset($_GET['confirmar'])) {
    $id = (int)$_GET['id'];
    if (Contacto::delete($id)) {
        header('Location: ' . 'admin/index.php?sec=contactos&msg=eliminado');
    } else {
        header('Location: ' . 'admin/index.php?sec=contactos&error=no_eliminar');
    }
    exit;
}

header('Location: ' . 'admin/index.php?sec=contactos');
exit;
