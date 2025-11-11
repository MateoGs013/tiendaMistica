<?php
// admin/actions/duende_borrar_acc.php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../classes/Duende.php';
require_once __DIR__ . '/../includes/url.php';
require_admin();

if (!empty($_GET['id']) && isset($_GET['confirmar'])) {
    $id = (int)$_GET['id'];
    if (Duende::delete($id)) {
        header('Location: ' . admin_url('duendes', ['msg' => 'eliminado']));
    } else {
        header('Location: ' . admin_url('duendes', ['error' => 'no_eliminar']));
    }
    exit;
}

header('Location: ' . admin_url('duendes'));
exit;
